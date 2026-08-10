<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Request as WasteRequest;
use App\Models\Ward;
use Illuminate\Http\Request;

class CitizenRequestController extends Controller
{
    /**
     * Display the report waste request wizard form.
     */
    public function create()
    {
        $categories = Category::with(['subcategories' => function ($q) {
            $q->where('status', true);
        }])->where('status', true)->get();

        $wards = Ward::with('constituency.corporation')->orderBy('name')->get();

        return view('frontend.report_request', compact('categories', 'wards'));
    }

    /**
     * Store a newly created waste request in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pickup_items' => 'required|array|min:1',
            'pickup_subitems' => 'nullable|array',
            'applicant_name' => 'nullable|string|max:255',
            'mobile_number' => 'required|string|regex:/^[0-9]{10}$/',
            'house_no' => 'required|string|max:255',
            'address' => 'required|string',
            'landmark' => 'nullable|string|max:255',
            'pincode' => 'required|string|size:6',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'ward_id' => 'nullable|exists:wards,id',
            'preferred_pickup_date' => 'required|date',
            'waste_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        // Process uploaded waste photos
        $uploadedImagePaths = [];
        if ($request->hasFile('waste_images')) {
            foreach ($request->file('waste_images') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('waste_images', 'public');
                    $uploadedImagePaths[] = $path;
                }
            }
        }

        // Determine Ward, Constituency, Corporation hierarchy
        $wardId = $request->input('ward_id');
        $constituencyId = null;
        $corporationId = null;

        if ($wardId) {
            $ward = Ward::with('constituency.corporation')->find($wardId);
            if ($ward) {
                $constituencyId = $ward->constituency_id;
                $corporationId = $ward->constituency?->corporation_id;
            }
        } elseif ($request->filled('latitude') && $request->filled('longitude')) {
            $ward = Ward::findWardByLatLng($request->latitude, $request->longitude);
            if ($ward) {
                $wardId = $ward->id;
                $constituencyId = $ward->constituency_id;
                $corporationId = $ward->constituency?->corporation_id;
            }
        }

        // Generate unique request tracking number
        $requestNumber = WasteRequest::generateRequestNumber();

        // Create waste request
        $wasteRequest = WasteRequest::create([
            'request_number' => $requestNumber,
            'source' => 'citizen',
            'user_id' => auth()->check() ? auth()->id() : null,
            'applicant_name' => $request->input('applicant_name') ?: 'Citizen User',
            'mobile_number' => $request->input('mobile_number'),
            'category_ids' => $request->input('pickup_items'),
            'subcategory_ids' => $request->input('pickup_subitems', []),
            'waste_images' => $uploadedImagePaths,
            'house_no' => $request->input('house_no'),
            'address' => $request->input('address'),
            'landmark' => $request->input('landmark'),
            'pincode' => $request->input('pincode'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'corporation_id' => $corporationId,
            'constituency_id' => $constituencyId,
            'ward_id' => $wardId,
            'preferred_pickup_date' => $request->input('preferred_pickup_date'),
            'status' => 'pending',
        ]);

        return redirect()->route('citizen.success', ['id' => $wasteRequest->request_number]);
    }

    /**
     * Display submission success summary page.
     */
    public function success(Request $request)
    {
        $reqId = $request->query('id');
        $requestRecord = null;

        if ($reqId) {
            $requestRecord = WasteRequest::with(['ward', 'constituency', 'corporation'])
                ->where('request_number', $reqId)
                ->first();
        }

        return view('frontend.request_submitted', compact('requestRecord', 'reqId'));
    }

    /**
     * Track a waste request dynamically by request number or mobile number.
     */
    public function trackRequest(Request $request)
    {
        $searchId = $request->query('id') ?? $request->query('query');
        $wasteRequest = null;

        if ($searchId) {
            $cleanSearch = trim($searchId);
            $wasteRequest = WasteRequest::with(['ward.constituency.corporation', 'vehicle.driver', 'dump'])
                ->where('request_number', $cleanSearch)
                ->orWhere('request_number', '#' . $cleanSearch)
                ->orWhere('id', $cleanSearch)
                ->orWhere('mobile_number', $cleanSearch)
                ->latest()
                ->first();
        } else {
            // Default: Load latest request if available
            $wasteRequest = WasteRequest::with(['ward.constituency.corporation', 'vehicle.driver', 'dump'])
                ->latest()
                ->first();
        }

        return view('frontend.track_request', compact('wasteRequest', 'searchId'));
    }

    /**
     * Display full request details page dynamically.
     */
    public function requestDetails(Request $request)
    {
        $reqId = $request->query('id');
        $wasteRequest = null;

        if ($reqId) {
            $cleanId = trim($reqId);
            $wasteRequest = WasteRequest::with(['ward.constituency.corporation', 'vehicle.driver', 'dump'])
                ->where('request_number', $cleanId)
                ->orWhere('request_number', '#' . $cleanId)
                ->orWhere('id', $cleanId)
                ->first();
        }

        if (!$wasteRequest) {
            $wasteRequest = WasteRequest::with(['ward.constituency.corporation', 'vehicle.driver', 'dump'])
                ->latest()
                ->first();
        }

        return view('frontend.request_details', compact('wasteRequest', 'reqId'));
    }

    /**
     * Spatial lookup helper endpoint for map clicks.
     */
    public function lookupWardByCoords(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        if (!$lat || !$lng) {
            return response()->json(['success' => false, 'message' => 'Coordinates missing']);
        }

        $ward = Ward::findWardByLatLng($lat, $lng);

        if ($ward) {
            return response()->json([
                'success' => true,
                'ward' => [
                    'id' => $ward->id,
                    'name' => $ward->name,
                    'ward_number' => $ward->ward_number,
                    'constituency_name' => $ward->constituency?->name,
                    'corporation_name' => $ward->constituency?->corporation?->name,
                ]
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Ward not found for coordinates']);
    }
}
