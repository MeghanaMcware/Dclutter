<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as WasteRequest;
use App\Models\Corporation;
use App\Models\Constituency;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminRequestController extends Controller
{
    /**
     * Display a listing of all waste requests with AJAX filters.
     */
    public function index(Request $request)
    {
        $query = WasteRequest::with(['ward', 'constituency', 'corporation', 'vehicle'])
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
                        'pickup_location' => $req->house_no . ', ' . Str::limit($req->address, 30),
                        'constituency' => $req->constituency?->name ?? 'N/A',
                        'applicant_name' => $req->applicant_name,
                        'mobile_number' => $req->mobile_number,
                        'status' => $req->status,
                        'status_label' => ucfirst(str_replace('_', ' ', $req->status)),
                        'created_at' => $req->created_at->format('d M Y'),
                        'created_at_order' => $req->created_at->format('Y-m-d'),
                        'show_url' => route('admin.requests.show', $req->id),
                    ];
                })
            ]);
        }

        $corporations = Corporation::with('constituencies')->orderBy('name')->get();
        $constituencies = Constituency::orderBy('name')->get();

        return view('admin.requests.index', compact('requests', 'corporations', 'constituencies'));
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

        return view('admin.requests.show', compact('wasteRequest'));
    }
}
