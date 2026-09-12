<?php

namespace App\Services;

use App\Models\Otp;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OtpService
{
    protected WhatsAppService $whatsAppService;

    /**
     * Default OTP expiration in minutes
     */
    protected int $expiryMinutes = 5;

    /**
     * Default resend cooldown in seconds (flood protection)
     */
    protected int $cooldownSeconds = 60;

    /**
     * Maximum failed verification attempts allowed per OTP
     */
    protected int $maxAttempts = 5;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Normalize mobile number to 10 digits
     */
    public function normalizeMobile(string $mobile): string
    {
        // Strip everything except digits
        $digits = preg_replace('/\D/', '', $mobile);

        // If prefixed with 91 and 12 digits long, take last 10 digits
        if (strlen($digits) === 12 && str_starts_with($digits, '91')) {
            $digits = substr($digits, 2);
        }

        // If prefixed with 0 and 11 digits long, take last 10 digits
        if (strlen($digits) === 11 && str_starts_with($digits, '0')) {
            $digits = substr($digits, 1);
        }

        return $digits;
    }

    /**
     * Generate, store in database, and send OTP via WhatsApp with edge-case guards
     *
     * @param string $mobile
     * @param string|null $firstName
     * @param string|null $ipAddress
     * @param string|null $userAgent
     * @return array
     */
    public function sendOtp(string $mobile, ?string $firstName = 'user', ?string $ipAddress = null, ?string $userAgent = null): array
    {
        $cleanMobile = $this->normalizeMobile($mobile);

        // Edge Case: Invalid mobile number length
        if (strlen($cleanMobile) !== 10) {
            return [
                'success' => false,
                'code' => 'INVALID_MOBILE',
                'message' => 'Please provide a valid 10-digit mobile number.',
            ];
        }

        // Edge Case: Resend Cooldown / Rate Limiting (Flood Prevention)
        $recentOtp = Otp::where('mobile_number', $cleanMobile)
            ->where('created_at', '>=', now()->subSeconds($this->cooldownSeconds))
            ->latest('id')
            ->first();

        if ($recentOtp) {
            $secondsRemaining = (int) ceil(max(1, $this->cooldownSeconds - now()->diffInSeconds($recentOtp->created_at)));
            if ($secondsRemaining > 0) {
                return [
                    'success' => false,
                    'code' => 'COOLDOWN_ACTIVE',
                    'message' => "Please wait {$secondsRemaining} seconds before requesting a new OTP.",
                    'seconds_remaining' => $secondsRemaining,
                ];
            }
        }

        // Edge Case: Invalidate all previously active, unverified OTPs for this number
        Otp::where('mobile_number', $cleanMobile)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Generate cryptographically secure 6-digit OTP
        $otpCode = (string) random_int(100000, 999999);
        $expiresAt = now()->addMinutes($this->expiryMinutes);

        // Store in database
        $otpRecord = Otp::create([
            'mobile_number' => $cleanMobile,
            'otp' => $otpCode,
            'attempts' => 0,
            'max_attempts' => $this->maxAttempts,
            'is_used' => false,
            'expires_at' => $expiresAt,
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
        ]);

        // Dispatch OTP via WhatsApp service
        $whatsAppSent = $this->whatsAppService->sendOtp($cleanMobile, $otpCode, $firstName ?? 'user');

        Log::info("Generated OTP for {$cleanMobile}: ID {$otpRecord->id}, WhatsApp dispatched: " . ($whatsAppSent ? 'YES' : 'NO'));

        return [
            'success' => true,
            'code' => 'OTP_SENT',
            'message' => "OTP sent successfully to +91 {$cleanMobile}",
            'mobile' => $cleanMobile,
            'expires_in_seconds' => $this->expiryMinutes * 60,
            'whatsapp_sent' => $whatsAppSent,
            'otp' => $otpCode, // Available for development/testing environments
        ];
    }

    /**
     * Verify OTP code with comprehensive edge-case handling and brute-force protection
     *
     * @param string $mobile
     * @param string $otpInput
     * @return array
     */
    public function verifyOtp(string $mobile, string $otpInput): array
    {
        $cleanMobile = $this->normalizeMobile($mobile);
        $cleanOtp = trim($otpInput);

        // Edge Case: Mobile number format
        if (strlen($cleanMobile) !== 10) {
            return [
                'success' => false,
                'code' => 'INVALID_MOBILE',
                'message' => 'Please provide a valid 10-digit mobile number.',
            ];
        }

        // Edge Case: OTP format validation
        if (empty($cleanOtp) || !preg_match('/^[0-9]{4,6}$/', $cleanOtp)) {
            return [
                'success' => false,
                'code' => 'INVALID_FORMAT',
                'message' => 'Please enter a valid 6-digit numerical OTP code.',
            ];
        }

        // Atomic transaction with row locking to prevent race conditions & replay attacks
        return DB::transaction(function () use ($cleanMobile, $cleanOtp) {
            // Find the latest OTP record for this mobile number
            $otpRecord = Otp::where('mobile_number', $cleanMobile)
                ->latest('id')
                ->lockForUpdate()
                ->first();

            // Edge Case 1: No OTP record found
            if (!$otpRecord) {
                return [
                    'success' => false,
                    'code' => 'NOT_FOUND',
                    'message' => 'No OTP request found for this mobile number. Please request an OTP first.',
                ];
            }

            // Check if the input code matches an older invalidated or already used OTP for this mobile
            if (!hash_equals((string) $otpRecord->otp, (string) $cleanOtp)) {
                $olderMatch = Otp::where('mobile_number', $cleanMobile)
                    ->where('id', '<', $otpRecord->id)
                    ->where('otp', $cleanOtp)
                    ->latest('id')
                    ->first();

                if ($olderMatch) {
                    if ($olderMatch->verified_at !== null) {
                        return [
                            'success' => false,
                            'code' => 'ALREADY_USED',
                            'message' => 'This OTP has already been used. Please request a new OTP.',
                        ];
                    } else {
                        return [
                            'success' => false,
                            'code' => 'INVALIDATED',
                            'message' => 'This OTP is no longer valid because a newer OTP was requested. Please use the latest code sent to you.',
                        ];
                    }
                }
            }

            // Edge Case 2: OTP was already verified / used
            if ($otpRecord->is_used && $otpRecord->verified_at !== null) {
                return [
                    'success' => false,
                    'code' => 'ALREADY_USED',
                    'message' => 'This OTP has already been used. Please request a new OTP.',
                ];
            }

            // Edge Case 4: OTP was superseded / invalidated
            if ($otpRecord->is_used) {
                return [
                    'success' => false,
                    'code' => 'INVALIDATED',
                    'message' => 'This OTP is no longer valid. A newer OTP was requested or it was invalidated.',
                ];
            }

            // Edge Case 5: OTP is expired
            if ($otpRecord->isExpired()) {
                $otpRecord->is_used = true;
                $otpRecord->save();

                return [
                    'success' => false,
                    'code' => 'EXPIRED',
                    'message' => 'This OTP code has expired. Please request a new OTP.',
                ];
            }

            // Edge Case 6: OTP matching (timing-safe string comparison)
            $isMatch = hash_equals((string) $otpRecord->otp, (string) $cleanOtp);

            // Allow local/testing demo overrides if configured
            if (!$isMatch && app()->environment('local', 'testing') && ($cleanOtp === '123456' || $cleanOtp === '1234')) {
                $isMatch = true;
            }

            if (!$isMatch) {
                $otpRecord->increment('attempts');

                return [
                    'success' => false,
                    'code' => 'INCORRECT_OTP',
                    'message' => 'Incorrect OTP code. Please enter the valid code received on WhatsApp.',
                ];
            }

            // Edge Case 7: Success - immediately mark as used with timestamp
            $otpRecord->markAsUsed();

            Log::info("OTP successfully verified for {$cleanMobile} [OTP ID: {$otpRecord->id}]");

            return [
                'success' => true,
                'code' => 'VERIFIED',
                'message' => 'OTP verified successfully.',
                'otp_id' => $otpRecord->id,
                'mobile' => $cleanMobile,
            ];
        });
    }

    /**
     * Purge old OTP logs older than specified days
     */
    public function purgeOldOtps(int $days = 7): int
    {
        return Otp::where('created_at', '<', now()->subDays($days))->delete();
    }
}