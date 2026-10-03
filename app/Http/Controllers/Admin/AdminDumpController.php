<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dump;
use App\Models\Request as WasteRequest;
use Illuminate\Http\Request;

class AdminDumpController extends Controller
{
    /**
     * Display listing of Pickup List and Dump List.
     */
    public function index(Request $request)
    {
        // 1. Pickup List: Requests strictly with status 'picked_up'
        $pickupRequests = WasteRequest::forUserJurisdiction()
            ->with(['ward', 'constituency', 'corporation', 'vehicle.owner', 'updates'])
            ->where('status', 'picked_up')
            ->latest('picked_up_at')
            ->latest('id')
            ->get();

        // 2. Dump List: Requests strictly with status 'dumped'
        $dumpRequests = WasteRequest::forUserJurisdiction()
            ->with(['ward', 'constituency', 'corporation', 'vehicle.owner', 'dump', 'dumpRecord.vehicle.owner', 'updates'])
            ->where('status', 'dumped')
            ->latest('updated_at')
            ->latest('id')
            ->get();

        return view('admin.dump.index', compact('pickupRequests', 'dumpRequests'));
    }

    /**
     * Display details for a specific pickup / dump event.
     */
    public function show($id)
    {
        // Find by Request ID / request_number first
        $wasteRequest = WasteRequest::with(['ward.constituency.corporation', 'vehicle.owner', 'dump', 'dumpRecord.vehicle', 'updates'])
            ->where('id', $id)
            ->orWhere('request_number', $id)
            ->first();

        $dumpObj = null;

        if ($wasteRequest) {
            $dumpObj = $wasteRequest->dumpRecord ?: $wasteRequest->dump;
        } else {
            // Check if ID belongs to a Dump record
            $dumpObj = Dump::with(['vehicle.owner', 'request.ward.constituency.corporation', 'request.vehicle.owner', 'request.updates'])->find($id);
            if ($dumpObj && $dumpObj->request) {
                $wasteRequest = $dumpObj->request;
            } elseif ($dumpObj) {
                // If orphan dump, redirect or abort
                abort(404, 'Associated waste request not found.');
            } else {
                abort(404, 'Request details not found.');
            }
        }

        // Photos resolution
        $userPhotos = is_array($wasteRequest->waste_images) ? $wasteRequest->waste_images : ($wasteRequest->waste_images ? [$wasteRequest->waste_images] : []);
        $beforePhotos = $wasteRequest->before_pickup_images ?: [];
        $afterPhotos = $wasteRequest->picked_up_images ?: [];
        $dumpPhotos = ($dumpObj && is_array($dumpObj->dump_images)) ? $dumpObj->dump_images : ($dumpObj && $dumpObj->dump_images ? [$dumpObj->dump_images] : []);

        return view('admin.dump.show', compact('wasteRequest', 'dumpObj', 'userPhotos', 'beforePhotos', 'afterPhotos', 'dumpPhotos'));
    }
}
