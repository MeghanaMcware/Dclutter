<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Request as WasteRequest;
use App\Models\Vehicle;
use App\Services\WasteRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiclePwaController extends Controller
{
    public function __construct(
        protected WasteRequestService $wasteRequestService
    ) {}
    /**
     * Helper to get logged in driver's vehicle.
     */
    protected function getDriverVehicle()
    {
        if (!Auth::check()) {
            return null;
        }

        $user = Auth::user();
        $vehicle = Vehicle::where('user_id', $user->id)
            ->orWhere('driver_phone', $user->mobile_number)
            ->first();

        // If vehicle is found but marked inactive, log out immediately
        if ($vehicle && !$vehicle->status) {
            Auth::logout();
            return null;
        }

        return $vehicle;
    }

    /**
     * Helper to get logged in driver's vehicle ID.
     */
    protected function getDriverVehicleId()
    {
        $vehicle = $this->getDriverVehicle();
        return $vehicle?->id;
    }

    /**
     * Driver Dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $vehicle = $this->getDriverVehicle();

        if (!$user || (!$user->hasRole('vehicle') && !$vehicle)) {
            return redirect()->route('vehicle.login')->withErrors([
                'mobile' => 'Access denied. Vehicle role is required.',
            ]);
        }

        if (!$vehicle) {
            return redirect()->route('vehicle.login')->withErrors([
                'mobile' => 'No active vehicle registration found for your account.',
            ]);
        }

        if (!$vehicle) {
            Auth::logout();
            return redirect()->route('vehicle.login')->withErrors([
                'mobile' => 'No registered vehicle record found for this account.',
            ]);
        }

        if (!$vehicle->status) {
            Auth::logout();
            return redirect()->route('vehicle.login')->withErrors([
                'mobile' => "Vehicle ({$vehicle->vehicle_number}) is currently inactive. Please contact the administrator.",
            ]);
        }

        $vehicleId = $vehicle->id;

        $assignedQuery = WasteRequest::whereIn('status', ['assigned', 'not_available'])->where('vehicle_id', $vehicleId);
        $pickedUpQuery = WasteRequest::where('status', 'picked_up')->where('vehicle_id', $vehicleId);
        $recentQuery = WasteRequest::whereIn('status', ['assigned', 'picked_up', 'not_available'])->where('vehicle_id', $vehicleId);

        $assignedCount = $assignedQuery->count();
        $pickedUpCount = $pickedUpQuery->count();
        $recentRequests = $recentQuery->orderByRaw('COALESCE(assigned_at, updated_at, created_at) DESC')->take(5)->get();

        $driverName = !empty(trim($user?->name ?? '')) ? $user->name : ($vehicle?->driver_name ?: 'N/A');
        $driverMobile = !empty($user?->mobile_number) ? $user->mobile_number : ($vehicle?->driver_phone ?: 'N/A');

        return view('vehiclepwa.dashboard', compact(
            'assignedCount',
            'pickedUpCount',
            'recentRequests',
            'user',
            'vehicle',
            'driverName',
            'driverMobile'
        ));
    }

    /**
     * Assigned Waste Requests list & map (Only Assigned and Rescheduled).
     */
    public function requests(Request $request)
    {
        $query = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle'])
            ->whereIn('status', ['assigned', 'not_available', 'rescheduled']);

        if ($vehicleId = $this->getDriverVehicleId()) {
            $query->where('vehicle_id', $vehicleId);
        }

        $assignedRequests = $query->orderByRaw('COALESCE(assigned_at, updated_at, created_at) DESC')->paginate(10);

        return view('vehiclepwa.requests.index', compact('assignedRequests'));
    }

    /**
     * Route navigation map (Only Assigned and Rescheduled).
     */
    public function route()
    {
        $query = WasteRequest::whereIn('status', ['assigned', 'not_available', 'rescheduled']);
        if ($vehicleId = $this->getDriverVehicleId()) {
            $query->where('vehicle_id', $vehicleId);
        }

        $assignedRequests = $query->orderByRaw('COALESCE(assigned_at, updated_at, created_at) ASC')->get();

        return view('vehiclepwa.route', compact('assignedRequests'));
    }

    /**
     * Stop details on route.
     */
    public function stopDetails(Request $request, $id = null)
    {
        $reqId = $id ?? $request->query('id') ?? $request->query('request_id');
        $wasteRequest = $reqId ? WasteRequest::find($reqId) : WasteRequest::whereIn('status', ['assigned', 'picked_up', 'not_available'])->first();

        return view('vehiclepwa.stop_details', compact('wasteRequest'));
    }

    /**
     * Check if pickup is allowed today in Indian Standard Time (IST).
     */
    protected function checkPickupDayAllowed(): array
    {
        $nowIst = now()->timezone('Asia/Kolkata');
        $allowedDay = env('PICKUP_DAY', 'Sunday'); // Default Sunday, configurable via .env
        $enforce = env('ENFORCE_SUNDAY_PICKUP', false);

        $isAllowed = !$enforce || strcasecmp($nowIst->format('l'), $allowedDay) === 0;

        return [
            'allowed' => $isAllowed,
            'today_day' => $nowIst->format('l'),
            'allowed_day' => ucfirst($allowedDay),
            'current_time_ist' => $nowIst->format('d M Y, h:i A'),
        ];
    }

    /**
     * Step 1: Before Pickup screen.
     */
    public function beforePickup(Request $request, $id = null)
    {
        $reqId = $id ?? $request->query('id') ?? $request->query('request_id');
        $wasteRequest = $reqId ? WasteRequest::find($reqId) : WasteRequest::whereIn('status', ['assigned', 'picked_up', 'not_available'])->first();
        $dayInfo = $this->checkPickupDayAllowed();

        return view('vehiclepwa.updated.before_pickup', compact('wasteRequest', 'dayInfo'));
    }

    /**
     * Store Step 1: Before Pickup details.
     */
    public function storeBeforePickup(Request $request, $id)
    {
        $dayInfo = $this->checkPickupDayAllowed();
        if (!$dayInfo['allowed']) {
            return response()->json([
                'success' => false,
                'message' => "Pickups are only permitted on {$dayInfo['allowed_day']}s (IST). Today is {$dayInfo['today_day']}.",
            ], 422);
        }

        $wasteRequest = WasteRequest::findOrFail($id);

        $request->validate([
            'approx_weight_kg' => 'required|numeric|min:0.1',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'before_photos' => 'nullable|array',
            'before_photos.*' => 'image|max:10240',
        ]);

        try {
            $this->wasteRequestService->recordBeforePickup(
                $wasteRequest,
                $request->only(['approx_weight_kg', 'latitude', 'longitude']),
                $request->file('before_photos', [])
            );

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Before pickup details saved successfully.',
                    'next_url' => route('vehicle.after_pickup', ['id' => $wasteRequest->id]),
                ]);
            }

            return redirect()->route('vehicle.after_pickup', ['id' => $wasteRequest->id])
                ->with('success', 'Before pickup details saved successfully.');
        } catch (\InvalidArgumentException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Store Not Available status for a pickup request (Reason & Next Sunday Date or Closure).
     */
    public function storeNotAvailable(Request $request, $id)
    {
        $wasteRequest = WasteRequest::findOrFail($id);

        $request->validate([
            'reason' => 'required|string|max:1000',
            'next_date' => 'nullable|date',
            'next_pickup_date' => 'nullable|date',
        ]);

        $reasonInput = trim($request->reason);
        $closingReasons = ['door_closed', 'call_not_attended', 'not_ready_today', 'door_locked', 'door closed', 'call not attended', 'not ready today'];

        // If driver selected closure reasons (Door closed, Call not attended, Not ready today), close request
        if (in_array(strtolower($reasonInput), $closingReasons, true)) {
            try {
                $updatedRequest = $this->wasteRequestService->closeByDriver($wasteRequest, $reasonInput);
                $reasonLabels = [
                    'door_closed' => 'Door Closed',
                    'call_not_attended' => 'Call Not Attended',
                    'not_ready_today' => 'Not Ready Today',
                    'door closed' => 'Door Closed',
                    'call not attended' => 'Call Not Attended',
                    'not ready today' => 'Not Ready Today',
                ];
                $reasonText = $reasonLabels[strtolower($reasonInput)] ?? ucfirst(str_replace('_', ' ', $reasonInput));
                $msg = "Request #{$updatedRequest->request_number} has been closed ({$reasonText}).";

                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'status' => 'closed',
                        'message' => $msg,
                        'redirect_url' => route('vehicle.requests'),
                    ]);
                }

                return redirect()->route('vehicle.requests')->with('info', $msg);
            } catch (\InvalidArgumentException $e) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
                }
                return back()->withErrors(['reason' => $e->getMessage()]);
            }
        }

        // Reschedule for next Sunday
        $nextDate = $request->input('next_date') ?? $request->input('next_pickup_date');

        try {
            $updatedRequest = $this->wasteRequestService->reschedule(
                $wasteRequest,
                $request->reason,
                $nextDate
            );

            $nextPickupFormatted = $updatedRequest->next_pickup_date ? \Carbon\Carbon::parse($updatedRequest->next_pickup_date)->format('d M Y (l)') : 'Upcoming Sunday';
            $msg = "Request #{$updatedRequest->request_number} rescheduled for {$nextPickupFormatted} ({$request->reason}).";

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'status' => $updatedRequest->status,
                    'message' => $msg,
                    'redirect_url' => route('vehicle.requests'),
                ]);
            }

            return redirect()->route('vehicle.requests')->with('info', $msg);
        } catch (\InvalidArgumentException $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                    'errors' => ['next_date' => [$e->getMessage()]]
                ], 422);
            }
            return back()->withErrors(['next_date' => $e->getMessage()]);
        }
    }

    /**
     * Step 2: After Pickup screen.
     */
    public function afterPickup(Request $request, $id = null)
    {
        $reqId = $id ?? $request->query('id') ?? $request->query('request_id');
        $wasteRequest = $reqId ? WasteRequest::find($reqId) : WasteRequest::whereIn('status', ['assigned', 'picked_up'])->first();
        $dayInfo = $this->checkPickupDayAllowed();

        return view('vehiclepwa.updated.after_pickup', compact('wasteRequest', 'dayInfo'));
    }

    /**
     * Store Step 2: After Pickup details.
     */
    public function storeAfterPickup(Request $request, $id)
    {
        $dayInfo = $this->checkPickupDayAllowed();
        if (!$dayInfo['allowed']) {
            return response()->json([
                'success' => false,
                'message' => "Pickups are only permitted on {$dayInfo['allowed_day']}s (IST). Today is {$dayInfo['today_day']}.",
            ], 422);
        }

        $wasteRequest = WasteRequest::findOrFail($id);

        $request->validate([
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'after_photos' => 'nullable|array',
            'after_photos.*' => 'image|max:10240',
        ]);

        try {
            $this->wasteRequestService->markPickedUp(
                $wasteRequest,
                $request->only(['latitude', 'longitude']),
                $request->file('after_photos', [])
            );

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pickup completed successfully.',
                ]);
            }

            return redirect()->route('vehicle.trip_summary')
                ->with('success', 'Pickup completed successfully.');
        } catch (\InvalidArgumentException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }

    /**
     * Trip Progress screen with working date filter.
     */
    public function tripProgress(Request $request)
    {
        $vehicleId = $this->getDriverVehicleId();

        // Get list of distinct dates where driver/vehicle worked
        $workingDates = WasteRequest::selectRaw('DATE(COALESCE(assigned_at, created_at)) as work_date')
            ->when($vehicleId, fn($q) => $q->where('vehicle_id', $vehicleId))
            ->whereIn('status', ['assigned', 'picked_up', 'not_available'])
            ->groupBy('work_date')
            ->orderByDesc('work_date')
            ->pluck('work_date');

        $selectedDate = $request->query('date', $workingDates->first() ?? now()->toDateString());

        $query = WasteRequest::whereIn('status', ['assigned', 'picked_up', 'not_available'])
            ->whereDate('assigned_at', $selectedDate);

        if ($vehicleId) {
            $query->where('vehicle_id', $vehicleId);
        }

        $assignedRequests = $query->orderByRaw('COALESCE(assigned_at, updated_at, created_at) DESC')->paginate(10);
        $completedCount = (clone $query)->where('status', 'picked_up')->count();
        $pendingCount = (clone $query)->whereIn('status', ['assigned', 'not_available'])->count();

        return view('vehiclepwa.trip_progress', compact('assignedRequests', 'completedCount', 'pendingCount', 'workingDates', 'selectedDate'));
    }

    /**
     * Trip Summary report with working date filter.
     */
    public function tripSummary(Request $request)
    {
        $vehicleId = $this->getDriverVehicleId();

        $workingDates = WasteRequest::selectRaw('DATE(COALESCE(picked_up_at, assigned_at, created_at)) as work_date')
            ->when($vehicleId, fn($q) => $q->where('vehicle_id', $vehicleId))
            ->where('status', 'picked_up')
            ->groupBy('work_date')
            ->orderByDesc('work_date')
            ->pluck('work_date');

        $selectedDate = $request->query('date', $workingDates->first() ?? now()->toDateString());

        $query = WasteRequest::where('status', 'picked_up')
            ->whereDate('picked_up_at', $selectedDate);

        if ($vehicleId) {
            $query->where('vehicle_id', $vehicleId);
        }

        $completedRequests = $query->latest('picked_up_at')->get();

        return view('vehiclepwa.trip_summary', compact('completedRequests', 'workingDates', 'selectedDate'));
    }

    /**
     * Driver & Vehicle Owner Profile details.
     */
    public function profile()
    {
        $user = Auth::user();
        $vehicle = $this->getDriverVehicle();

        if (!$user || (!$user->hasRole('vehicle') && !$vehicle)) {
            return redirect()->route('vehicle.login')->withErrors([
                'mobile' => 'Access denied. Vehicle role is required.',
            ]);
        }

        if ($vehicle && $vehicle->owner) {
            $user = $vehicle->owner;
        }

        return view('vehiclepwa.profile_settings', compact('user', 'vehicle'));
    }

    /**
     * Driver Notifications.
     */
    public function notifications()
    {
        return view('vehiclepwa.notifications');
    }

    /**
     * Dump List Index for Driver PWA (Only picked_up items ready for dumping).
     */
    public function dumpList(Request $request)
    {
        $vehicleId = $this->getDriverVehicleId();

        $query = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle', 'dumpRecord'])
            ->where('status', 'picked_up');

        if ($vehicleId) {
            $query->where('vehicle_id', $vehicleId);
        }

        $dumpRequests = $query->orderBy('picked_up_at', 'desc')->paginate(10);

        return view('vehiclepwa.dump_list', compact('dumpRequests'));
    }

    /**
     * Dump Form for Driver PWA.
     */
    public function dumpForm(Request $request)
    {
        $reqId = $request->query('id') ?? $request->query('request_id');
        $pickupId = $request->query('pickup_id');

        $wasteRequest = null;
        if ($reqId) {
            $wasteRequest = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle'])->find($reqId);
        } elseif ($pickupId) {
            $wasteRequest = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle'])->where('request_number', $pickupId)->first();
        }

        if (!$wasteRequest) {
            $wasteRequest = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle'])->where('status', 'picked_up')->first();
        }

        // If request is already dumped or completed, block access and redirect back
        if ($wasteRequest && in_array(strtolower($wasteRequest->status), ['completed', 'dumped'])) {
            return redirect()->route('vehicle.dump')->with('warning', 'This waste request has already been dumped.');
        }

        // Get driver's vehicle details and assigned constituencies
        $vehicleId = $this->getDriverVehicleId();
        $user = Auth::user();
        $vehicle = null;

        if ($vehicleId) {
            $vehicle = Vehicle::find($vehicleId);
        }
        if (!$vehicle && $user) {
            $vehicle = Vehicle::where('user_id', $user->id)
                ->orWhere('driver_phone', $user->mobile_number)
                ->first();
        }
        if (!$vehicle && $wasteRequest?->vehicle) {
            $vehicle = $wasteRequest->vehicle;
        }

        // Extract vehicle belonging constituency IDs
        $constituencyIds = [];
        if ($vehicle && !empty($vehicle->constituency_ids)) {
            $rawIds = is_array($vehicle->constituency_ids) ? $vehicle->constituency_ids : json_decode($vehicle->constituency_ids, true);
            if (is_array($rawIds)) {
                $constituencyIds = array_values(array_filter(array_map('intval', $rawIds)));
            }
        }

        // Fallback: If vehicle has no constituency IDs configured, use request's constituency if available
        if (empty($constituencyIds) && $wasteRequest?->constituency_id) {
            $constituencyIds = [(int) $wasteRequest->constituency_id];
        }

        // Query dump yard / plant locations strictly belonging to vehicle's constituencies AND active status
        $plantsQuery = \App\Models\Plant::active()->with(['constituency', 'corporation']);

        if (!empty($constituencyIds)) {
            $plantsQuery->whereIn('constituency_id', $constituencyIds);
        } else {
            $plantsQuery->whereRaw('1 = 0');
        }

        $plants = $plantsQuery->orderBy('name')->get();

        return view('vehiclepwa.dumpform', compact('wasteRequest', 'plants', 'vehicle'));
    }

    /**
     * Store Dump Form submission into dumps table.
     */
    public function storeDump(Request $request)
    {
        $request->validate([
            'dump_location' => 'required|string',
            'pickup_id' => 'nullable|string',
            'request_id' => 'nullable|exists:requests,id',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'dump_photos' => 'nullable|array',
            'dump_photos.*' => 'image|max:1024',
        ]);

        // Validate that selected plant is not inactive
        $submittedPlant = \App\Models\Plant::where('name', $request->dump_location)->first();
        if ($submittedPlant && !$submittedPlant->status) {
            $msg = "The dump location '{$request->dump_location}' is currently inactive and cannot accept waste.";
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 422);
            }
            return back()->withInput()->withErrors(['dump_location' => $msg]);
        }

        // Match request by request_id OR pickup_id (request_number)
        $wasteRequest = null;
        if ($request->filled('request_id')) {
            $wasteRequest = WasteRequest::find($request->request_id);
        } elseif ($request->filled('pickup_id')) {
            $wasteRequest = WasteRequest::where('request_number', $request->pickup_id)->first();
        }

        $vehicleId = $this->getDriverVehicleId();
        if (!$vehicleId && $wasteRequest) {
            $vehicleId = $wasteRequest->vehicle_id;
        }
        if (!$vehicleId) {
            $vehicleId = \App\Models\Vehicle::first()?->id ?? 1;
        }

        $dumpImages = [];
        if ($request->hasFile('dump_photos')) {
            foreach ($request->file('dump_photos') as $file) {
                $path = $file->store('dumps', 'public');
                $dumpImages[] = $path;
            }
        }

        if ($wasteRequest) {
            if (in_array(strtolower($wasteRequest->status), ['completed', 'dumped'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'This waste request has already been dumped.',
                ], 422);
            }
            $wasteRequest->status = 'dumped';
            $wasteRequest->save();
        }

        $dump = \App\Models\Dump::create([
            'vehicle_id' => $vehicleId,
            'request_id' => $wasteRequest?->id ?? $request->request_id,
            'pickup_number' => $request->pickup_id ?? $wasteRequest?->request_number,
            'plant_name' => $request->dump_location,
            'dump_images' => $dumpImages,
            'dump_latitude' => $request->latitude,
            'dump_longitude' => $request->longitude,
            'dumped_at' => now(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Dump submitted successfully.',
                'redirect_url' => route('vehicle.dump'),
            ]);
        }

        return redirect()->route('vehicle.dump')->with('success', 'Dump submitted successfully.');
    }


    /**
     * Vehicle Request History List (Strictly Dumped Requests).
     */
    public function history(Request $request)
    {
        $vehicleId = $this->getDriverVehicleId();
        
        $query = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle.owner', 'dumpRecord', 'dump'])
            ->whereIn('status', ['dumped', 'completed']);
            
        if ($vehicleId) {
            $query->where('vehicle_id', $vehicleId);
        }
        
        // Search Term Filter
        if ($request->filled('search')) {
            $term = trim($request->search);
            $query->where(function($q) use ($term) {
                $q->where('request_number', 'like', "%{$term}%")
                  ->orWhere('applicant_name', 'like', "%{$term}%")
                  ->orWhere('mobile_number', 'like', "%{$term}%")
                  ->orWhere('address', 'like', "%{$term}%")
                  ->orWhere('house_no', 'like', "%{$term}%");
            });
        }
        
        $requests = $query->orderByRaw('COALESCE(picked_up_at, assigned_at, updated_at, created_at) DESC')->paginate(10);
        
        return view('vehiclepwa.history.index', compact('requests'));
    }

    /**
     * Vehicle Request History Full Details View.
     */
    public function historyShow($id)
    {
        $vehicleId = $this->getDriverVehicleId();
        
        $wasteRequest = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle.owner', 'dumpRecord', 'dump', 'user'])
            ->where('id', $id);
            
        if ($vehicleId) {
            $wasteRequest->where('vehicle_id', $vehicleId);
        }
        
        $wasteRequest = $wasteRequest->firstOrFail();
        
        return view('vehiclepwa.history.show', compact('wasteRequest'));
    }

}
