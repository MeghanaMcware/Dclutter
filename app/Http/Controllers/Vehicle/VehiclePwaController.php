<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\Request as WasteRequest;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiclePwaController extends Controller
{
    /**
     * Helper to get logged in driver's vehicle ID.
     */
    protected function getDriverVehicleId()
    {
        if (!Auth::check()) {
            return null;
        }

        $user = Auth::user();
        $vehicle = Vehicle::where('user_id', $user->id)
            ->orWhere('driver_phone', $user->mobile_number)
            ->first();

        return $vehicle?->id;
    }

    /**
     * Driver Dashboard.
     */
    public function dashboard()
    {
        $vehicleId = $this->getDriverVehicleId();

        $assignedQuery = WasteRequest::where('status', 'assigned');
        $pickedUpQuery = WasteRequest::where('status', 'picked_up');
        $recentQuery = WasteRequest::whereIn('status', ['assigned', 'picked_up']);

        if ($vehicleId) {
            $assignedQuery->where('vehicle_id', $vehicleId);
            $pickedUpQuery->where('vehicle_id', $vehicleId);
            $recentQuery->where('vehicle_id', $vehicleId);
        }

        $assignedCount = $assignedQuery->count();
        $pickedUpCount = $pickedUpQuery->count();
        $recentRequests = $recentQuery->orderByRaw('COALESCE(assigned_at, updated_at, created_at) DESC')->take(5)->get();

        return view('vehiclepwa.dashboard', compact('assignedCount', 'pickedUpCount', 'recentRequests'));
    }

    /**
     * Assigned Waste Requests list & map.
     */
    public function requests(Request $request)
    {
        $query = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle'])
            ->whereIn('status', ['assigned', 'picked_up']);

        if ($vehicleId = $this->getDriverVehicleId()) {
            $query->where('vehicle_id', $vehicleId);
        }

        $assignedRequests = $query->orderByRaw('COALESCE(assigned_at, updated_at, created_at) DESC')->get();

        return view('vehiclepwa.requests.index', compact('assignedRequests'));
    }

    /**
     * Route navigation map.
     */
    public function route()
    {
        $query = WasteRequest::whereIn('status', ['assigned', 'picked_up']);
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
        $wasteRequest = $reqId ? WasteRequest::find($reqId) : WasteRequest::whereIn('status', ['assigned', 'picked_up'])->first();

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
        $wasteRequest = $reqId ? WasteRequest::find($reqId) : WasteRequest::whereIn('status', ['assigned', 'picked_up'])->first();
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

        $beforeImages = $wasteRequest->before_pickup_images ?? [];

        if ($request->hasFile('before_photos')) {
            foreach ($request->file('before_photos') as $file) {
                $path = $file->store('requests/before', 'public');
                $beforeImages[] = $path;
            }
        }

        $wasteRequest->before_pickup_images = $beforeImages;
        $wasteRequest->approx_weight_kg = $request->approx_weight_kg;
        if ($request->filled('latitude')) {
            $wasteRequest->before_pickup_latitude = $request->latitude;
        }
        if ($request->filled('longitude')) {
            $wasteRequest->before_pickup_longitude = $request->longitude;
        }
        $wasteRequest->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Before pickup details saved successfully.',
                'next_url' => route('vehicle.after_pickup', ['id' => $wasteRequest->id]),
            ]);
        }

        return redirect()->route('vehicle.after_pickup', ['id' => $wasteRequest->id])
            ->with('success', 'Before pickup details saved successfully.');
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

        $afterImages = $wasteRequest->picked_up_images ?? [];

        if ($request->hasFile('after_photos')) {
            foreach ($request->file('after_photos') as $file) {
                $path = $file->store('requests/after', 'public');
                $afterImages[] = $path;
            }
        }

        $wasteRequest->picked_up_images = $afterImages;
        if ($request->filled('latitude')) {
            $wasteRequest->after_pickup_latitude = $request->latitude;
        }
        if ($request->filled('longitude')) {
            $wasteRequest->after_pickup_longitude = $request->longitude;
        }
        $wasteRequest->picked_up_at = now();
        $wasteRequest->status = 'picked_up';
        $wasteRequest->save();

        // Trigger WhatsApp Collection Completed Notification to Citizen User
        try {
            app(\App\Services\WhatsAppService::class)->sendCollectionCompletedToUser(
                $wasteRequest->mobile_number,
                $wasteRequest->applicant_name,
                $wasteRequest->request_number
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('WhatsApp Pickup Completion Notification Exception: ' . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Pickup completed successfully.',
            ]);
        }

        return redirect()->route('vehicle.trip_summary')
            ->with('success', 'Pickup completed successfully.');
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
            ->whereIn('status', ['assigned', 'picked_up'])
            ->groupBy('work_date')
            ->orderByDesc('work_date')
            ->pluck('work_date');

        $selectedDate = $request->query('date', $workingDates->first() ?? now()->toDateString());

        $query = WasteRequest::whereIn('status', ['assigned', 'picked_up'])
            ->whereDate('assigned_at', $selectedDate);

        if ($vehicleId) {
            $query->where('vehicle_id', $vehicleId);
        }

        $assignedRequests = $query->orderByRaw('COALESCE(assigned_at, updated_at, created_at) DESC')->get();
        $completedCount = (clone $query)->where('status', 'picked_up')->count();
        $pendingCount = (clone $query)->where('status', 'assigned')->count();

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

        if ($user) {
            $vehicle = Vehicle::with('owner')
                ->where('user_id', $user->id)
                ->orWhere('driver_phone', $user->mobile_number)
                ->first();
            if ($vehicle && $vehicle->owner) {
                $user = $vehicle->owner;
            }
        } else {
            $vehicle = Vehicle::with('owner')->first();
            $user = $vehicle?->owner ?? \App\Models\User::first();
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
}
