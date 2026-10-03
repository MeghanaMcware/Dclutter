<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegacyPickupRequest;
use App\Models\Corporation;
use App\Models\Constituency;
use Illuminate\Http\Request;

class AdminImportedRequestController extends Controller
{
    /**
     * Display listing of imported legacy pickup requests.
     */
    public function index(Request $request)
    {
        $corporations = Corporation::forUserJurisdiction()->orderBy('name')->get();
        $constituencies = Constituency::forUserJurisdiction()->orderBy('name')->get();

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

        return view('admin.requests.imported.index', compact('importedRequests', 'corporations', 'constituencies', 'totalCount'));
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
