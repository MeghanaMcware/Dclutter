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
}
