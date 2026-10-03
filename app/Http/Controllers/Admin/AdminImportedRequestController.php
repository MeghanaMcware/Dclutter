<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegacyPickupRequest;
use App\Models\Request as WasteRequest;
use App\Models\RequestUpdate;
use App\Models\Corporation;
use App\Models\Constituency;
use App\Models\Vehicle;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminImportedRequestController extends Controller
{
    /**
     * Display listing of imported legacy pickup requests.
     */
    public function index(Request $request)
    {
        $corporations = Corporation::forUserJurisdiction()->orderBy('name')->get();
        $constituencies = Constituency::forUserJurisdiction()->orderBy('name')->get();
        $vehicles = Vehicle::forUserJurisdiction()->with(['owner'])->where('status', 1)->get();

        $query = LegacyPickupRequest::with(['corporation', 'constituency', 'ward'])
            ->forUserJurisdiction();

        // Search by applicant name, mobile, address, or excel id
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('applicant_name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('excel_id', 'like', "%{$search}%")
                  ->orWhere('ward_name_no', 'like', "%{$search}%");
            });
        }

        // Filter by Corporation
        if ($request->filled('corporation_id')) {
            $query->where('corporation_id', $request->corporation_id);
        }

        // Filter by Constituency
        if ($request->filled('constituency_id')) {
            $query->where('constituency_id', $request->constituency_id);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', strtolower($request->status));
        }

        $totalCount = (clone $query)->count();
        $importedRequests = $query->orderBy('id', 'asc')->paginate(20);

        return view('admin.requests.imported.index', compact('importedRequests', 'corporations', 'constituencies', 'vehicles', 'totalCount'));
    }

    /**
     * Assign vehicle to a legacy imported request, promoting it into the unified requests table and request_updates log.
     */
    public function assignVehicle(Request $request, $id, WhatsAppService $whatsAppService)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $legacy = LegacyPickupRequest::forUserJurisdiction()->findOrFail($id);

        if (in_array($legacy->status, ['dumped', 'completed'], true)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot assign vehicle. This legacy request has already been completed.',
                ], 422);
            }
            return redirect()->back()->with('error', 'Cannot assign vehicle. This legacy request has already been completed.');
        }

        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        if (!$vehicle->status) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => "Vehicle {$vehicle->vehicle_number} is currently inactive.",
                ], 422);
            }
            return redirect()->back()->with('error', "Vehicle {$vehicle->vehicle_number} is currently inactive.");
        }

        // Promote into Unified requests table inside a safe Database transaction
        $unifiedRequest = DB::transaction(function () use ($legacy, $vehicle, $request) {
            // 1. Create in unified requests table
            $unified = WasteRequest::create([
                'request_number' => WasteRequest::generateRequestNumber(),
                'source' => 'imported',
                'user_id' => null,
                'applicant_name' => $legacy->applicant_name ?: 'Citizen',
                'mobile_number' => $legacy->mobile_number ?: '9999999999',
                'category_ids' => $legacy->category_ids ?? (!empty($legacy->items_text) ? [$legacy->items_text] : ['General Bulky Waste']),
                'address' => $legacy->address ?: 'N/A',
                'floor_no' => $legacy->floor_no,
                'house_no' => 'N/A',
                'pincode' => '560001',
                'corporation_id' => $legacy->corporation_id,
                'constituency_id' => $legacy->constituency_id,
                'ward_id' => $legacy->ward_id,
                'preferred_pickup_date' => $legacy->preferred_pickup_date ?? now(),
                'status' => 'assigned',
                'vehicle_id' => $vehicle->id,
                'assigned_at' => now(),
                'remarks' => $request->input('remarks') ?: ('Assigned from legacy import #' . $legacy->id),
                'terms_accepted' => true,
            ]);

            // 2. Create Audit Log in request_updates
            RequestUpdate::create([
                'request_id' => $unified->id,
                'user_id' => auth()->id(),
                'vehicle_id' => $vehicle->id,
                'action' => 'assigned',
                'status' => 'assigned',
                'remarks' => $request->input('remarks') ?: ('Promoted from legacy Excel import #' . ($legacy->excel_id ?? $legacy->id) . ' and assigned to vehicle ' . $vehicle->vehicle_number),
            ]);

            // 3. Mark legacy record status as assigned
            $legacy->status = 'assigned';
            $legacy->save();

            return $unified;
        });

        // WhatsApp notification to Driver
        try {
            $driverName = $vehicle->driver_name ?? $vehicle->owner?->name ?? 'Driver';
            $driverPhone = $vehicle->driver_phone ?? $vehicle->owner?->mobile_number;
            if ($driverPhone) {
                $whatsAppService->sendVehicleAssignmentToDriver(
                    $driverPhone,
                    $driverName,
                    $vehicle->vehicle_number,
                    $unifiedRequest->request_number,
                    $unifiedRequest->address
                );
            }
        } catch (\Throwable $e) {
            Log::error('Legacy assignment WhatsApp notification exception: ' . $e->getMessage());
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Legacy request #{$legacy->id} has been unified into #{$unifiedRequest->request_number} and assigned to vehicle {$vehicle->vehicle_number}.",
                'unified_request_id' => $unifiedRequest->id,
                'unified_request_number' => $unifiedRequest->request_number,
                'vehicle_number' => $vehicle->vehicle_number,
                'driver_number' => $vehicle->driver_phone ?? $vehicle->owner?->mobile_number ?? 'N/A',
            ]);
        }

        return redirect()->back()->with('success', "Legacy request #{$legacy->id} has been unified into active request #{$unifiedRequest->request_number} and assigned to vehicle {$vehicle->vehicle_number}.");
    }

    /**
     * Display details of a single imported legacy request.
     */
    public function show($id)
    {
        $requestData = LegacyPickupRequest::with(['corporation', 'constituency', 'ward'])
            ->forUserJurisdiction()
            ->findOrFail($id);

        return view('admin.requests.imported.show', compact('requestData'));
    }

    /**
     * Export imported legacy requests to CSV for Excel based on current filters.
     */
    public function export(Request $request)
    {
        $query = LegacyPickupRequest::with(['corporation', 'constituency', 'ward'])
            ->forUserJurisdiction();

        // Search by applicant name, mobile, address, or excel id
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->where('applicant_name', 'like', "%{$search}%")
                  ->orWhere('mobile_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('excel_id', 'like', "%{$search}%")
                  ->orWhere('ward_name_no', 'like', "%{$search}%");
            });
        }

        // Filter by Corporation
        if ($request->filled('corporation_id')) {
            $query->where('corporation_id', $request->corporation_id);
        }

        // Filter by Constituency
        if ($request->filled('constituency_id')) {
            $query->where('constituency_id', $request->constituency_id);
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', strtolower($request->status));
        }

        $filename = 'imported_requests_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($query) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM for Microsoft Excel compatibility
            fputs($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, [
                'ID',
                'Excel/Ref ID',
                'Applicant Name',
                'Mobile Number',
                'Corporation',
                'Constituency / Division',
                'Ward',
                'Address',
                'Floor No',
                'Waste Items',
                'Preferred Pickup Date',
                'Status',
                'Created Date'
            ]);

            // Stream chunked records to handle large datasets efficiently without memory issues
            $query->orderBy('id', 'asc')->chunk(500, function ($records) use ($file) {
                foreach ($records as $req) {
                    $items = '';
                    if (!empty($req->items_text)) {
                        $items = $req->items_text;
                    } elseif (is_array($req->category_ids)) {
                        $items = implode(', ', $req->category_ids);
                    } elseif (!empty($req->category_ids)) {
                        $items = $req->category_ids;
                    }

                    $pickupDate = $req->preferred_pickup_date ? $req->preferred_pickup_date->format('d-m-Y') : 'N/A';
                    $createdDate = $req->created_at ? $req->created_at->format('d-m-Y h:i A') : ($req->created_at_text ?? 'N/A');

                    fputcsv($file, [
                        $req->id,
                        $req->excel_id ?? ('#' . $req->id),
                        $req->applicant_name ?? 'N/A',
                        $req->mobile_number ?? 'N/A',
                        $req->corporation?->name ?? ($req->corporation_name ?? 'N/A'),
                        $req->constituency?->name ?? ($req->division_name ?? 'N/A'),
                        $req->ward?->name ?? ($req->ward_name_no ?? 'N/A'),
                        $req->address ?? 'N/A',
                        $req->floor_no ?? 'N/A',
                        $items,
                        $pickupDate,
                        ucfirst(str_replace('_', ' ', $req->status ?? 'requested')),
                        $createdDate
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
