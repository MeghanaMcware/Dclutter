<?php

namespace App\Http\Controllers\Citizen;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Request as WasteRequest;
use App\Models\Ward;
use App\Services\OtpService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CitizenRequestController extends Controller
{
    protected OtpService $otpService;
    protected WhatsAppService $whatsappService;

    public function __construct(OtpService $otpService, WhatsAppService $whatsappService)
    {
        $this->otpService = $otpService;
        $this->whatsappService = $whatsappService;
    }

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
     * Send WhatsApp OTP for Citizen Report Request
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10',
        ]);

        $mobile = $request->input('mobile_number');
        $name = $request->input('applicant_name') ?: 'Citizen';

        try {
            $result = $this->otpService->sendOtp(
                $mobile,
                $name,
                $request->ip(),
                $request->userAgent()
            );

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Failed to send OTP.',
                    'code' => $result['code'] ?? 'ERROR',
                ], 422);
            }

            return response()->json([
                'success' => true,
                'message' => 'A 6-digit verification code has been sent to your WhatsApp number.',
            ]);
        } catch (\Exception $e) {
            Log::error('Citizen Send OTP Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Error sending OTP. Please try again.',
            ], 422);
        }
    }

    /**
     * Verify WhatsApp OTP for Citizen Report Request
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);

        $mobile = $request->input('mobile_number');
        $otp = $request->input('otp');

        $result = $this->otpService->verifyOtp($mobile, $otp);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
            ], 422);
        }

        session()->put('verified_citizen_mobile', $mobile);

        return response()->json([
            'success' => true,
            'message' => 'Mobile number verified successfully.',
        ]);
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
            'floor' => 'nullable|string|max:100',
            'floor_no' => 'nullable|string|max:100',
            'address' => 'required|string',
            'landmark' => 'nullable|string|max:255',
            'pincode' => 'required|string|size:6',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'ward_id' => 'nullable|exists:wards,id',
            'preferred_pickup_date' => 'required|date',
            'terms_accepted' => 'nullable',
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
            'floor_no' => $request->input('floor_no') ?? $request->input('floor'),
            'address' => $request->input('address'),
            'landmark' => $request->input('landmark'),
            'pincode' => $request->input('pincode'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'corporation_id' => $corporationId,
            'constituency_id' => $constituencyId,
            'ward_id' => $wardId,
            'preferred_pickup_date' => $request->input('preferred_pickup_date'),
            'terms_accepted' => ($request->has('terms_accepted') || $request->input('terms_accepted') == 1 || $request->input('terms_accepted') === 'on') ? 1 : 0,
            'status' => 'pending',
        ]);

        // Trigger WhatsApp Notification
        try {
            app(\App\Services\WhatsAppService::class)->sendRegistrationConfirmation(
                $wasteRequest->mobile_number,
                $wasteRequest->applicant_name,
                $wasteRequest->request_number
            );
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('WhatsApp Registration Notification Exception: ' . $e->getMessage());
        }

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
        }

        return view('frontend.track.track_request', compact('wasteRequest', 'searchId'));
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

        return view('frontend.track.show', compact('wasteRequest', 'reqId'));
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
