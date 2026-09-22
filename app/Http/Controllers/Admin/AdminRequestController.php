<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as WasteRequest;
use App\Models\Corporation;
use App\Models\Constituency;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminRequestController extends Controller
{
    /**
     * Display a listing of all waste requests with AJAX filters.
     */
    public function index(Request $request)
    {
        $query = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle.owner'])
            ->forUserJurisdiction();

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', strtolower(str_replace(' ', '_', $request->status)));
        }

        // Corporation Filter
        if ($request->filled('corporation')) {
            $corpName = $request->corporation;
            $query->whereHas('corporation', function($q) use ($corpName) {
                $q->where('name', $corpName);
            });
        } elseif ($request->filled('corporation_id')) {
            $query->where('corporation_id', $request->corporation_id);
        }

        // Constituency Filter
        if ($request->filled('constituency')) {
            $constName = $request->constituency;
            $query->whereHas('constituency', function($q) use ($constName) {
                $q->where('name', $constName);
            });
        } elseif ($request->filled('constituency_id')) {
            $query->where('constituency_id', $request->constituency_id);
        }

        // Date Range Filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $requests = $query->latest()->get();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'requests' => $requests->map(function($req) {
                    return [
                        'id' => $req->id,
                        'request_number' => $req->request_number,
                        'category' => is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?? 'N/A'),
                        'subcategory' => is_array($req->subcategory_ids) ? implode(', ', $req->subcategory_ids) : ($req->subcategory_ids ?? 'N/A'),
                        'pickup_location' => $req->house_no . (($req->floor_no ?? $req->floor) ? ' (Floor: ' . ($req->floor_no ?? $req->floor) . ')' : '') . ', ' . Str::limit($req->address, 30),
                        'constituency_id' => $req->constituency_id,
                        'constituency' => $req->constituency?->name ?? 'N/A',
                        'applicant_name' => $req->applicant_name,
                        'mobile_number' => $req->mobile_number,
                        'vehicle_number' => $req->vehicle?->vehicle_number ?? 'N/A',
                        'driver_number' => $req->vehicle?->driver_phone ?? $req->vehicle?->owner?->mobile_number ?? 'N/A',
                        'status' => $req->status,
                        'status_label' => $req->status == 'not_available' ? 'Rescheduled' : ucfirst(str_replace('_', ' ', $req->status)),
                        'created_at' => $req->created_at->format('d M Y'),
                        'created_at_order' => $req->created_at->format('Y-m-d'),
                        'show_url' => route('admin.requests.show', $req->id),
                    ];
                })
            ]);
        }

        $corporations = Corporation::with('constituencies')->orderBy('name')->get();
        $constituencies = Constituency::orderBy('name')->get();
        $vehicles = Vehicle::with(['owner', 'constituency'])->where('status', 1)->get();

        return view('admin.requests.index', compact('requests', 'corporations', 'constituencies', 'vehicles'));
    }

    /**
     * Display the specified request details.
     */
    public function show($id)
    {
        $wasteRequest = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle', 'dump'])
            ->where('id', $id)
            ->orWhere('request_number', $id)
            ->firstOrFail();

        $vehicleQuery = Vehicle::with(['owner', 'constituency'])->where('status', 1);
        if ($wasteRequest->constituency_id) {
            $vehicleQuery->where('constituency_id', $wasteRequest->constituency_id);
        }
        $vehicles = $vehicleQuery->get();

        return view('admin.requests.show', compact('wasteRequest', 'vehicles'));
    }

    /**
     * Export waste requests to CSV format with UTF-8 BOM for Excel.
     */
    public function export(Request $request)
    {
        $query = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle.owner'])
            ->forUserJurisdiction();

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', strtolower(str_replace(' ', '_', $request->status)));
        }

        // Corporation Filter
        if ($request->filled('corporation')) {
            $corpName = $request->corporation;
            $query->whereHas('corporation', function($q) use ($corpName) {
                $q->where('name', $corpName);
            });
        } elseif ($request->filled('corporation_id')) {
            $query->where('corporation_id', $request->corporation_id);
        }

        // Constituency Filter
        if ($request->filled('constituency')) {
            $constName = $request->constituency;
            $query->whereHas('constituency', function($q) use ($constName) {
                $q->where('name', $constName);
            });
        } elseif ($request->filled('constituency_id')) {
            $query->where('constituency_id', $request->constituency_id);
        }

        // Date Range Filter
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $requests = $query->latest()->get();

        $filename = 'waste_requests_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function() use ($requests) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, [
                'Request ID',
                'Category',
                'Sub-Category',
                'Pickup Location',
                'Constituency',
                'Requested By',
                'Mobile Number',
                'Vehicle No.',
                'Driver Number',
                'Status',
                'Created At'
            ]);

            foreach ($requests as $req) {
                $categories = is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?? 'N/A');
                $subcategories = is_array($req->subcategory_ids) ? implode(', ', $req->subcategory_ids) : ($req->subcategory_ids ?? 'N/A');
                $location = $req->house_no . (($req->floor_no ?? $req->floor) ? ' (Floor: ' . ($req->floor_no ?? $req->floor) . ')' : '') . ', ' . $req->address;
                $statusLabel = $req->status == 'not_available' ? 'Rescheduled' : ucfirst(str_replace('_', ' ', $req->status));

                fputcsv($file, [
                    $req->request_number,
                    $categories,
                    $subcategories,
                    $location,
                    $req->constituency?->name ?? 'N/A',
                    $req->applicant_name,
                    $req->mobile_number,
                    $req->vehicle?->vehicle_number ?? 'N/A',
                    $req->vehicle?->driver_phone ?? $req->vehicle?->owner?->mobile_number ?? 'N/A',
                    $statusLabel,
                    $req->created_at->format('d M Y h:i A')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Assign or re-assign a vehicle to a waste request.
     */
    public function assignVehicle(Request $request, $id)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $wasteRequest = WasteRequest::with('constituency')->findOrFail($id);

        if ($wasteRequest->constituency_id) {
            $vehicle = Vehicle::with('constituency')->findOrFail($request->vehicle_id);
            if ($vehicle->constituency_id && $vehicle->constituency_id != $wasteRequest->constituency_id) {
                $errorMsg = 'Vehicle ' . $vehicle->vehicle_number . ' belongs to ' . ($vehicle->constituency?->name ?? 'another constituency') . ' and cannot be assigned to this request (' . ($wasteRequest->constituency?->name ?? 'Constituency #' . $wasteRequest->constituency_id) . ').';
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => $errorMsg,
                    ], 422);
                }
                return redirect()->back()->with('error', $errorMsg);
            }
        }

        $wasteRequest->vehicle_id = $request->vehicle_id;
        if ($request->filled('remarks')) {
            $wasteRequest->remarks = $request->remarks;
        }
        $wasteRequest->assigned_at = now();
        if ($wasteRequest->status === 'pending') {
            $wasteRequest->status = 'assigned';
        }
        $wasteRequest->save();

        $wasteRequest->load('vehicle.owner');
        if ($wasteRequest->vehicle) {
            $driverName = $wasteRequest->vehicle->driver_name ?? $wasteRequest->vehicle->owner?->name ?? 'Driver';
            $driverPhone = $wasteRequest->vehicle->driver_phone ?? $wasteRequest->vehicle->owner?->mobile_number ?? '9999999999';
            $vehicleNo = $wasteRequest->vehicle->vehicle_number;

            try {
                $wa = app(\App\Services\WhatsAppService::class);
                // 1. Notify Driver
                $wa->sendVehicleAssignmentToDriver(
                    $driverPhone,
                    $driverName,
                    $vehicleNo,
                    $wasteRequest->request_number,
                    $wasteRequest->address
                );
                // 2. Notify Citizen User
                $wa->sendVehicleAssignmentToUser(
                    $wasteRequest->mobile_number,
                    $wasteRequest->applicant_name,
                    $wasteRequest->request_number,
                    $vehicleNo,
                    $driverName,
                    $driverPhone
                );
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('WhatsApp Assignment Notification Exception: ' . $e->getMessage());
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Vehicle assigned successfully to request #' . $wasteRequest->request_number,
                'vehicle_number' => $wasteRequest->vehicle?->vehicle_number ?? '',
                'driver_number' => $wasteRequest->vehicle?->driver_phone ?? $wasteRequest->vehicle?->owner?->mobile_number ?? '',
            ]);
        }

        return redirect()->back()->with('success', 'Vehicle assigned successfully to request #' . $wasteRequest->request_number);
    }
}
