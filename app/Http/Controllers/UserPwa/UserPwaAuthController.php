<?php

namespace App\Http\Controllers\UserPwa;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserPwaAuthController extends Controller
{
    /**
     * Show User PWA Login Page
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }

        return view('userpwa.auth.login');
    }

    /**
     * Send 6-Digit OTP to Mobile Number via WhatsApp using OtpService
     */
    public function sendOtp(Request $request, OtpService $otpService)
    {
        $request->validate([
            'mobile_number' => 'required|string',
        ]);

        $mobile = $request->input('mobile_number');
        $result = $otpService->sendOtp(
            mobile: $mobile,
            firstName: 'user',
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        if (!$result['success']) {
            $status = ($result['code'] === 'COOLDOWN_ACTIVE') ? 429 : 422;
            return response()->json($result, $status);
        }

        // Keep mobile in session for convenient form correlation
        session(['userpwa_mobile' => $result['mobile']]);

        return response()->json($result);
    }

    /**
     * Verify OTP & Login / Auto-register User once with role 'user'
     */
    public function verifyOtp(Request $request, OtpService $otpService)
    {
        $mobile = $request->input('mobile_number') ?: session('userpwa_mobile');
        $request->merge(['mobile_number' => $mobile]);

        $request->validate([
            'mobile_number' => 'required|string',
            'otp' => 'required|string',
        ]);

        $mobile = $request->input('mobile_number');
        $otp = $request->input('otp');

        // Verify via OtpService against otps database table with edge cases
        $verifyResult = $otpService->verifyOtp($mobile, $otp);

        if (!$verifyResult['success']) {
            $status = in_array($verifyResult['code'] ?? '', ['MAX_ATTEMPTS_EXCEEDED', 'ALREADY_USED', 'EXPIRED']) ? 403 : 422;
            return response()->json($verifyResult, $status);
        }

        $cleanMobile = $verifyResult['mobile'] ?? $otpService->normalizeMobile($mobile);

        // Check if User account already exists for this mobile number
        $user = User::where('mobile_number', $cleanMobile)->first();

        if (!$user) {
            // Create user account ONCE on first OTP verification (email is nullable)
            $user = User::create([
                'name' => 'User ' . substr($cleanMobile, -4),
                'mobile_number' => $cleanMobile,
                'email' => null,
                'password' => bcrypt(Str::random(16)),
            ]);

            // Assign role 'citizen'
            $citizenRole = Role::firstOrCreate(['name' => 'citizen', 'guard_name' => 'web']);
            $user->assignRole($citizenRole);
        } else {
            if (!$user->hasRole('citizen')) {
                $user->assignRole(Role::firstOrCreate(['name' => 'citizen', 'guard_name' => 'web']));
            }
        }

        // Authenticate user session
        Auth::login($user, true);

        // Clear temporary OTP session data
        session()->forget(['userpwa_mobile', 'userpwa_otp']);

        return response()->json([
            'success' => true,
            'message' => 'Login successful.',
            'redirect_url' => route('user.dashboard'),
        ]);
    }

    /**
     * Log out User PWA Session
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login')->with('success', 'You have been logged out successfully.');
    }
}
