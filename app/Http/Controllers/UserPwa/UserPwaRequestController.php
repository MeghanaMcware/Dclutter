<?php

namespace App\Http\Controllers\UserPwa;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Request as WasteRequest;
use App\Models\Ward;
use App\Services\OtpService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserPwaRequestController extends Controller
{
    protected OtpService $otpService;
    protected WhatsAppService $whatsappService;

    public function __construct(OtpService $otpService, WhatsAppService $whatsappService)
    {
        $this->otpService = $otpService;
        $this->whatsappService = $whatsappService;
    }

    /**
     * Show Report Request Form for User PWA
     */
    public function report()
    {
        $categories = Category::with(['subcategories' => function ($q) {
            $q->where('status', true);
        }])->where('status', true)->get();

        $wards = Ward::with('constituency.corporation')->orderBy('name')->get();

        return view('userpwa.report_request', compact('categories', 'wards'));
    }

    /**
     * Lookup Ward, Constituency, and Corporation by coordinates
     */
    public function lookupWard(Request $request)
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        $ward = null;
        if ($lat && $lng) {
            $ward = Ward::findWardByLatLng((float) $lat, (float) $lng);
        }

        if (!$ward) {
            $ward = Ward::with('constituency.corporation')->first();
        }

        return response()->json([
            'success' => true,
            'ward_id' => $ward?->id,
            'ward_number' => $ward?->ward_number,
            'ward_name' => $ward ? ($ward->ward_number ? "Ward {$ward->ward_number} - {$ward->name}" : $ward->name) : 'Kempegowda Ward',
            'constituency' => $ward?->constituency?->name ?? 'Yelahanka',
            'corporation' => $ward?->constituency?->corporation?->name ?? 'BBMP',
        ]);
    }

    /**
     * Send WhatsApp OTP for Report Request Verification
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|digits:10',
        ]);

        $mobile = $request->input('mobile_number');
        $name = Auth::user()?->name ?: 'User';

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
            Log::error('UserPWA Send OTP Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Error sending OTP. Please try again.',
            ], 422);
        }
    }

    /**
     * Verify WhatsApp OTP for Report Request
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

        // Store OTP verified status in session for this mobile
        session()->put('verified_report_mobile', $mobile);

        return response()->json([
            'success' => true,
            'message' => 'Mobile number verified successfully.',
        ]);
    }

    /**
     * Store a newly submitted waste pickup request for User PWA
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pickup_items' => 'required|array|min:1',
            'pickup_subitems' => 'nullable|array',
            'applicant_name' => 'nullable|string|max:255',
            'mobile_number' => 'required|string',
            'house_no' => 'required|string|max:255',
            'floor_no' => 'nullable|string|max:100',
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
            'source' => 'userpwa',
            'user_id' => Auth::id(),
            'applicant_name' => $request->input('applicant_name') ?: (Auth::user()?->name ?: 'User'),
            'mobile_number' => $request->input('mobile_number') ?: Auth::user()?->mobile_number,
            'category_ids' => $request->input('pickup_items'),
            'subcategory_ids' => $request->input('pickup_subitems', []),
            'waste_images' => $uploadedImagePaths,
            'house_no' => $request->input('house_no'),
            'floor_no' => $request->input('floor_no'),
            'address' => $request->input('address'),
            'landmark' => $request->input('landmark'),
            'pincode' => $request->input('pincode'),
            'latitude' => $request->input('latitude') ?: 12.9716,
            'longitude' => $request->input('longitude') ?: 77.5946,
            'corporation_id' => $corporationId,
            'constituency_id' => $constituencyId,
            'ward_id' => $wardId,
            'preferred_pickup_date' => $request->input('preferred_pickup_date'),
            'terms_accepted' => 1,
            'status' => 'pending',
        ]);

        // Trigger WhatsApp Notification
        try {
            $this->whatsappService->sendRegistrationConfirmation(
                $wasteRequest->mobile_number,
                $wasteRequest->applicant_name,
                $wasteRequest->request_number
            );
        } catch (\Throwable $e) {
            Log::error('WhatsApp Confirmation Exception: ' . $e->getMessage());
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your D-Clutter pickup request has been received successfully. You can now track its status.',
                'request_number' => $wasteRequest->request_number,
                'redirect_url' => route('user.track'),
            ]);
        }

        return redirect()->route('user.track')->with('success', 'Pickup request #' . $wasteRequest->request_number . ' submitted successfully!');
    }

    /**
     * Show Track Requests List for User PWA
     */
    public function track(Request $request)
    {
        $user = Auth::user();
        $mobile = $user ? $user->mobile_number : null;
        $userId = $user ? $user->id : null;

        $query = WasteRequest::with(['ward.constituency.corporation', 'vehicle']);

        if ($mobile || $userId) {
            $query->where(function($q) use ($mobile, $userId) {
                if ($mobile) {
                    $q->where('mobile_number', $mobile);
                }
                if ($userId) {
                    $q->orWhere('user_id', $userId);
                }
            });
        }

        if ($request->filled('query') || $request->filled('id') || $request->filled('search')) {
            $term = trim($request->input('query') ?: ($request->input('id') ?: $request->input('search')));
            $query->where(function($q) use ($term) {
                $q->where('request_number', 'like', "%{$term}%")
                  ->orWhere('applicant_name', 'like', "%{$term}%")
                  ->orWhere('mobile_number', 'like', "%{$term}%")
                  ->orWhere('address', 'like', "%{$term}%");
            });
        }

        $requests = $query->latest()->get();

        return view('userpwa.track.index', compact('requests'));
    }

    /**
     * Show Request Details for User PWA
     */
    public function show($id = null)
    {
        $id = $id ?: request('id');
        if (!$id) {
            return redirect()->route('user.track');
        }

        $wasteRequest = WasteRequest::with(['ward.constituency.corporation', 'vehicle', 'dump'])
            ->where(function($q) use ($id) {
                $q->where('id', $id)->orWhere('request_number', $id);
            })->firstOrFail();

        return view('userpwa.track.show', compact('wasteRequest'));
    }

    /**
     * Edit Request Form for User PWA
     */
    public function edit($id = null)
    {
        $id = $id ?: request('id');
        $wasteRequest = WasteRequest::where(function($q) use ($id) {
            $q->where('id', $id)->orWhere('request_number', $id);
        })->firstOrFail();

        return view('userpwa.track.edit', compact('wasteRequest'));
    }
}
