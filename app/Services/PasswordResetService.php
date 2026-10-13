<?php

namespace App\Services;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PasswordResetService
{
    protected OtpService $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Resolve User by identifier (mobile, email, vehicle number, or driver phone).
     *
     * @param string $identifier
     * @param string|null $scope 'vehicle' or null for generic
     * @return User|null
     */
    public function resolveUser(string $identifier, ?string $scope = null): ?User
    {
        $cleanIdentifier = trim($identifier);
        $cleanMobile = $this->otpService->normalizeMobile($cleanIdentifier);

        // 1. Check user table directly by mobile_number or email
        $user = User::where(function ($q) use ($cleanIdentifier, $cleanMobile) {
            if (strlen($cleanMobile) === 10) {
                $q->where('mobile_number', $cleanMobile);
            } else {
                $q->where('mobile_number', $cleanIdentifier);
            }
            $q->orWhere('email', $cleanIdentifier);
        })->first();

        // 2. If not found and scope is vehicle (or not restricted), check Vehicle records
        if (!$user) {
            $vehicle = Vehicle::where(function ($q) use ($cleanIdentifier, $cleanMobile) {
                $q->where('vehicle_number', $cleanIdentifier);
                if (strlen($cleanMobile) === 10) {
                    $q->orWhere('driver_phone', $cleanMobile);
                } else {
                    $q->orWhere('driver_phone', $cleanIdentifier);
                }
            })->first();

            if ($vehicle) {
                // Try driver phone on users table
                if ($vehicle->driver_phone) {
                    $cleanDriverPhone = $this->otpService->normalizeMobile($vehicle->driver_phone);
                    $user = User::where('mobile_number', $cleanDriverPhone)
                        ->orWhere('mobile_number', $vehicle->driver_phone)
                        ->first();
                }

                // Try vehicle owner/user_id
                if (!$user && $vehicle->user_id) {
                    $user = User::find($vehicle->user_id);
                }
            }
        }

        return $user;
    }

    /**
     * Send password reset OTP to user's mobile number.
     *
     * @param string $identifier
     * @param string|null $scope
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @return array
     */
    public function sendResetOtp(string $identifier, ?string $scope = null, ?string $ipAddress = null, ?string $userAgent = null): array
    {
        $cleanIdentifier = trim($identifier);

        if (empty($cleanIdentifier)) {
            return [
                'success' => false,
                'message' => 'Please provide a valid registered mobile number.',
            ];
        }

        $user = $this->resolveUser($cleanIdentifier, $scope);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'No registered user found with the provided details.',
            ];
        }

        $targetMobile = $user->mobile_number;

        if (empty($targetMobile)) {
            return [
                'success' => false,
                'message' => 'User does not have a registered mobile number associated with this account.',
            ];
        }

        $firstName = $user->name ? explode(' ', trim($user->name))[0] : 'Driver';

        $otpResult = $this->otpService->sendOtp(
            mobile: $targetMobile,
            firstName: $firstName,
            ipAddress: $ipAddress,
            userAgent: $userAgent
        );

        if (!$otpResult['success']) {
            return $otpResult;
        }

        return [
            'success' => true,
            'message' => "Verification OTP sent successfully to +91 {$otpResult['mobile']}.",
            'mobile' => $otpResult['mobile'],
            'user_id' => $user->id,
            'whatsapp_sent' => $otpResult['whatsapp_sent'] ?? false,
            'otp' => $otpResult['otp'] ?? null,
        ];
    }

    /**
     * Verify the reset OTP.
     *
     * @param string $mobile
     * @param string $otp
     * @return array
     */
    public function verifyResetOtp(string $mobile, string $otp): array
    {
        $result = $this->otpService->verifyOtp($mobile, $otp);

        if (!$result['success']) {
            return $result;
        }

        $cleanMobile = $result['mobile'] ?? $this->otpService->normalizeMobile($mobile);

        // Store reset verification in session
        session([
            'password_reset_verified_mobile' => $cleanMobile,
            'password_reset_verified_at' => now()->timestamp,
        ]);

        return [
            'success' => true,
            'message' => 'OTP verified successfully.',
            'mobile' => $cleanMobile,
        ];
    }

    /**
     * Reset password for the user.
     *
     * @param string $identifier
     * @param string $newPassword
     * @param string|null $otp If provided, will verify before resetting (if not already verified)
     * @param string|null $scope
     * @return array
     */
    public function resetPassword(string $identifier, string $newPassword, ?string $otp = null, ?string $scope = null): array
    {
        $user = $this->resolveUser($identifier, $scope);

        if (!$user) {
            return [
                'success' => false,
                'message' => 'Unable to locate user account to reset password.',
            ];
        }

        $cleanMobile = $user->mobile_number ? $this->otpService->normalizeMobile($user->mobile_number) : null;

        // Check if session has verified this mobile within the last 15 minutes
        $sessionMobile = session('password_reset_verified_mobile');
        $sessionVerifiedAt = session('password_reset_verified_at');
        $isSessionVerified = $sessionMobile && $cleanMobile && $sessionMobile === $cleanMobile && ($sessionVerifiedAt && (now()->timestamp - $sessionVerifiedAt) < 900);

        if ($otp !== null && !$isSessionVerified) {
            $verifyResult = $this->verifyResetOtp($user->mobile_number, $otp);
            if (!$verifyResult['success']) {
                // If it was already used within the last 10 minutes, allow it
                $recentVerified = \App\Models\Otp::where('mobile_number', $cleanMobile)
                    ->where('otp', trim($otp))
                    ->where('is_used', true)
                    ->where('verified_at', '>=', now()->subMinutes(10))
                    ->latest('id')
                    ->first();

                if (!$recentVerified) {
                    return $verifyResult;
                }
            }
        }

        $user->password = Hash::make($newPassword);
        $user->save();

        // Clear session verification flag
        session()->forget(['password_reset_verified_mobile', 'password_reset_verified_at']);

        Log::info("Password reset successfully for user ID {$user->id} ({$user->mobile_number})");

        return [
            'success' => true,
            'message' => "Password updated successfully for {$user->name}.",
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'mobile_number' => $user->mobile_number,
            ],
        ];
    }
}
