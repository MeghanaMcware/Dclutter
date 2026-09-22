<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as WasteRequest;
use App\Models\Corporation;
use App\Models\Constituency;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    /**
     * Valid backend statuses for waste requests.
     */
    public const STATUS_OPTIONS = [
        'pending' => 'Pending',
        'assigned' => 'Assigned',
        'picked_up' => 'In Progress / Picked Up',
        'dumped' => 'Completed / Dumped',
        'rejected' => 'Rejected',
        'not_available' => 'Rescheduled',
    ];

    /**
     * Display a listing of the reports with dynamic filtering.
     */
    public function index(Request $request)
    {
        $query = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle.owner', 'dump', 'dumpRecord'])
            ->forUserJurisdiction();

        // Filter by Request Number / ID
        if ($request->filled('request_id') && $request->request_id !== 'all' && $request->request_id !== 'RequestId') {
            $reqNum = trim($request->request_id);
            $query->where('request_number', 'LIKE', "%{$reqNum}%");
        }

        // Filter by Corporation
        if ($request->filled('corporation') && $request->corporation !== 'all' && $request->corporation !== 'Corporation') {
            $corpVal = $request->corporation;
            if (is_numeric($corpVal)) {
                $query->where('corporation_id', $corpVal);
            } else {
                $query->whereHas('corporation', function ($q) use ($corpVal) {
                    $q->where('name', $corpVal);
                });
            }
        } elseif ($request->filled('corporation_id')) {
            $query->where('corporation_id', $request->corporation_id);
        }

        // Filter by Constituency
        if ($request->filled('constituency') && $request->constituency !== 'all' && $request->constituency !== 'Constituency') {
            $constVal = $request->constituency;
            if (is_numeric($constVal)) {
                $query->where('constituency_id', $constVal);
            } else {
                $query->whereHas('constituency', function ($q) use ($constVal) {
                    $q->where('name', $constVal);
                });
            }
        } elseif ($request->filled('constituency_id')) {
            $query->where('constituency_id', $request->constituency_id);
        }

        // Filter by Category
        if ($request->filled('category') && $request->category !== 'all' && $request->category !== 'SelectCategory') {
            $category = $request->category;
            $query->where(function ($q) use ($category) {
                $q->whereJsonContains('category_ids', $category)
                  ->orWhere('category_ids', 'LIKE', "%{$category}%");
            });
        }

        // Filter by Status (Strict matching on valid DB statuses)
        if ($request->filled('status') && $request->status !== 'all' && $request->status !== 'Status') {
            $status = strtolower(str_replace(' ', '_', $request->status));
            $query->where('status', $status);
        }

        // Filter by Date Range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $requests = $query->latest()->get();

        // AJAX response for live filter refresh if requested
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $requests->map(function ($req) {
                    $dumpDate = ($req->dump?->dumped_at ?? $req->dump?->created_at ?? $req->dumpRecord?->dumped_at ?? $req->dumpRecord?->created_at)?->format('d-m-Y') ?? 'N/A';
                    $pickupDate = $req->picked_up_at ? $req->picked_up_at->format('d-m-Y') : ($req->preferred_pickup_date ? $req->preferred_pickup_date->format('d-m-Y') : 'N/A');
                    
                    return [
                        'id' => $req->id,
                        'request_number' => $req->request_number,
                        'corporation' => $req->corporation?->name ?? 'N/A',
                        'constituency' => $req->constituency?->name ?? 'N/A',
                        'category' => is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?? 'N/A'),
                        'status' => $req->status,
                        'status_label' => self::STATUS_OPTIONS[$req->status] ?? ucfirst(str_replace('_', ' ', $req->status)),
                        'pickup_date' => $pickupDate,
                        'dump_date' => $dumpDate,
                        'show_url' => route('admin.reports.show', $req->id),
                    ];
                }),
            ]);
        }

        $corporations = Corporation::orderBy('name')->get();
        $constituencies = Constituency::orderBy('name')->get();
        $categories = Category::where('status', 1)->orderBy('name')->get();
        $requestNumbers = WasteRequest::forUserJurisdiction()->orderBy('id', 'desc')->pluck('request_number')->unique();
        $statuses = self::STATUS_OPTIONS;

        return view('admin.reports.index', compact(
            'requests',
            'corporations',
            'constituencies',
            'categories',
            'requestNumbers',
            'statuses'
        ));
    }

    /**
     * Display the specified report details.
     */
    public function show($id)
    {
        $wasteRequest = WasteRequest::with([
            'ward',
            'constituency',
            'corporation',
            'vehicle.owner',
            'dump',
            'dumpRecord'
        ])
        ->forUserJurisdiction()
        ->where(function ($q) use ($id) {
            $q->where('id', $id)
              ->orWhere('request_number', $id)
              ->orWhere('request_number', '#' . ltrim($id, '#'));
        })
        ->firstOrFail();

        return view('admin.reports.show', compact('wasteRequest'));
    }

    /**
     * Export reports to CSV for Excel.
     */
    public function export(Request $request)
    {
        $query = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle.owner', 'dump', 'dumpRecord'])
            ->forUserJurisdiction();

        // Filter by Request Number / ID
        if ($request->filled('request_id') && $request->request_id !== 'all' && $request->request_id !== 'RequestId') {
            $reqNum = trim($request->request_id);
            $query->where('request_number', 'LIKE', "%{$reqNum}%");
        }

        // Filter by Corporation
        if ($request->filled('corporation') && $request->corporation !== 'all' && $request->corporation !== 'Corporation') {
            $corpVal = $request->corporation;
            if (is_numeric($corpVal)) {
                $query->where('corporation_id', $corpVal);
            } else {
                $query->whereHas('corporation', function ($q) use ($corpVal) {
                    $q->where('name', $corpVal);
                });
            }
        } elseif ($request->filled('corporation_id')) {
            $query->where('corporation_id', $request->corporation_id);
        }

        // Filter by Constituency
        if ($request->filled('constituency') && $request->constituency !== 'all' && $request->constituency !== 'Constituency') {
            $constVal = $request->constituency;
            if (is_numeric($constVal)) {
                $query->where('constituency_id', $constVal);
            } else {
                $query->whereHas('constituency', function ($q) use ($constVal) {
                    $q->where('name', $constVal);
                });
            }
        } elseif ($request->filled('constituency_id')) {
            $query->where('constituency_id', $request->constituency_id);
        }

        // Filter by Category
        if ($request->filled('category') && $request->category !== 'all' && $request->category !== 'SelectCategory') {
            $category = $request->category;
            $query->where(function ($q) use ($category) {
                $q->whereJsonContains('category_ids', $category)
                  ->orWhere('category_ids', 'LIKE', "%{$category}%");
            });
        }

        // Filter by Status
        if ($request->filled('status') && $request->status !== 'all' && $request->status !== 'Status') {
            $status = strtolower(str_replace(' ', '_', $request->status));
            $query->where('status', $status);
        }

        // Filter by Date Range
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $requests = $query->latest()->get();

        $filename = 'waste_reports_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($requests) {
            $file = fopen('php://output', 'w');
            // UTF-8 BOM for Excel compatibility
            fputs($file, "\xEF\xBB\xBF");

            // Header row
            fputcsv($file, [
                'Request ID',
                'Corporation',
                'Constituency',
                'Ward',
                'Category',
                'Sub-Category',
                'Applicant Name',
                'Mobile Number',
                'Vehicle No.',
                'Driver Phone',
                'Pickup Date',
                'Dump Date',
                'Dump Plant',
                'Status',
                'Created At'
            ]);

            foreach ($requests as $req) {
                $categories = is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?? 'N/A');
                $subcategories = is_array($req->subcategory_ids) ? implode(', ', $req->subcategory_ids) : ($req->subcategory_ids ?? 'N/A');
                $pickupDate = $req->picked_up_at ? $req->picked_up_at->format('d-m-Y') : ($req->preferred_pickup_date ? $req->preferred_pickup_date->format('d-m-Y') : 'N/A');
                $dumpDate = ($req->dump?->dumped_at ?? $req->dump?->created_at ?? $req->dumpRecord?->dumped_at ?? $req->dumpRecord?->created_at)?->format('d-m-Y') ?? 'N/A';
                $statusLabel = self::STATUS_OPTIONS[$req->status] ?? ucfirst(str_replace('_', ' ', $req->status));

                fputcsv($file, [
                    $req->request_number,
                    $req->corporation?->name ?? 'N/A',
                    $req->constituency?->name ?? 'N/A',
                    $req->ward?->ward_name ?? $req->ward?->name ?? 'N/A',
                    $categories,
                    $subcategories,
                    $req->applicant_name,
                    $req->mobile_number,
                    $req->vehicle?->vehicle_number ?? 'N/A',
                    $req->vehicle?->driver_phone ?? $req->vehicle?->owner?->mobile_number ?? 'N/A',
                    $pickupDate,
                    $dumpDate,
                    $req->dump?->plant_name ?? $req->dumpRecord?->plant_name ?? 'N/A',
                    $statusLabel,
                    $req->created_at->format('d M Y h:i A')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
