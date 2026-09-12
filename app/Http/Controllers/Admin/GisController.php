<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ward;
use App\Models\Corporation;
use App\Models\Constituency;
use App\Models\Request as WasteRequest;
use Illuminate\Http\Request;

class GisController extends Controller
{
    /**
     * Display GIS Overview Map page with filter options.
     */
    public function index()
    {
        $corporations = Corporation::with('constituencies')->orderBy('name')->get();
        $constituencies = Constituency::orderBy('name')->get();
        return view('admin.gis.index', compact('corporations', 'constituencies'));
    }

    /**
     * Ultra-fast API: Get Ward Boundaries GeoJSON with Corporation Colors and Filters.
     */
    public function getWardsGeoJson(Request $request)
    {
        $corpColors = [
            1 => '#2563eb', // Central (Blue)
            2 => '#10b981', // East (Green)
            3 => '#f59e0b', // North (Orange)
            4 => '#8b5cf6', // West (Purple)
            5 => '#ec4899', // South (Pink)
        ];

        $query = Ward::with(['constituency.corporation'])
            ->select('id', 'name', 'ward_number', 'constituency_id', 'boundry')
            ->whereNotNull('boundry');

        if ($request->filled('constituency_id') && $request->constituency_id !== 'all') {
            $constId = (int) $request->constituency_id;
            $query->where('constituency_id', $constId);
        } elseif ($request->filled('corporation_id') && $request->corporation_id !== 'all') {
            $corpId = (int) $request->corporation_id;
            $query->whereHas('constituency', function ($q) use ($corpId) {
                $q->where('corporation_id', $corpId);
            });
        }

        $wards = $query->get();

        $features = [];
        foreach ($wards as $w) {
            if (empty($w->boundry)) continue;

            $corpId = $w->constituency?->corporation_id;
            $color = $corpColors[$corpId] ?? '#64748b';
            $name = addcslashes((string) $w->name, '"\\');
            $wardNo = addcslashes((string) ($w->ward_number ?? ''), '"\\');
            $constName = addcslashes((string) ($w->constituency?->name ?? 'N/A'), '"\\');
            $corpName = addcslashes((string) ($w->constituency?->corporation?->name ?? 'N/A'), '"\\');

            $features[] = '{"type":"Feature","properties":{"id":' . $w->id 
                . ',"name":"' . $name . '"'
                . ',"ward_number":"' . $wardNo . '"'
                . ',"constituency":"' . $constName . '"'
                . ',"corporation":"' . $corpName . '"'
                . ',"corporation_id":' . ($corpId ?: 'null')
                . ',"color":"' . $color . '"}'
                . ',"geometry":' . $w->boundry . '}';
        }

        $rawJson = '{"type":"FeatureCollection","features":[' . implode(',', $features) . ']}';

        return response($rawJson, 200, [
            'Content-Type' => 'application/json',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * API: Get Live Waste Request Pin Locations with Filters.
     */
    public function getRequestsGeoJson(Request $request)
    {
        $query = WasteRequest::with(['ward', 'constituency', 'corporation'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->forUserJurisdiction();

        if ($request->filled('constituency_id') && $request->constituency_id !== 'all') {
            $query->where('constituency_id', $request->constituency_id);
        } elseif ($request->filled('corporation_id') && $request->corporation_id !== 'all') {
            $query->where('corporation_id', $request->corporation_id);
        }

        $requests = $query->get();

        $points = [];
        foreach ($requests as $r) {
            $status = strtolower($r->status ?? 'pending');
            $statusGroup = match ($status) {
                'pending' => 'requested',
                'assigned', 'scheduled' => 'scheduled',
                'picked_up', 'dumped', 'completed' => 'completed',
                'rejected', 'cancelled', 'not_available' => 'cancelled',
                default => 'requested',
            };

            $category = is_array($r->category_ids) ? implode(', ', $r->category_ids) : ($r->category_ids ?: 'General Waste');
            $statusLabel = match ($status) {
                'pending' => 'Requested',
                'assigned', 'scheduled' => 'Scheduled',
                'picked_up', 'dumped', 'completed' => 'Completed',
                'rejected', 'cancelled', 'not_available' => 'Cancelled',
                default => ucfirst(str_replace('_', ' ', $status)),
            };

            $points[] = [
                'id' => $r->id,
                'request_number' => $r->request_number,
                'applicant_name' => $r->applicant_name ?: 'Citizen User',
                'mobile_number' => $r->mobile_number,
                'lat' => (float) $r->latitude,
                'lng' => (float) $r->longitude,
                'status' => $statusGroup,
                'status_label' => $statusLabel,
                'category' => $category,
                'house_no' => $r->house_no,
                'address' => $r->address,
                'ward_name' => $r->ward?->name,
                'ward_number' => $r->ward?->ward_number,
                'corporation_name' => $r->corporation?->name,
                'submitted_on' => $r->created_at ? $r->created_at->format('d M Y, h:i A') : 'N/A',
                'view_url' => route('admin.requests.show', $r->id),
            ];
        }

        return response()->json([
            'success' => true,
            'count' => count($points),
            'points' => $points,
        ]);
    }
}
