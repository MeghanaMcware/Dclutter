<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'mobile_number',
        'otp',
        'attempts',
        'max_attempts',
        'is_used',
        'expires_at',
        'verified_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'attempts' => 'integer',
        'max_attempts' => 'integer',
        'is_used' => 'boolean',
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Scope query to active, unexpired, and unused OTPs
     */
    public function scopeActive($query)
    {
        return $query->where('is_used', false)
            ->where('expires_at', '>', now());
    }

    /**
     * Check if OTP is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if max attempts reached
     */
    public function hasExceededMaxAttempts(): bool
    {
        return $this->attempts >= $this->max_attempts;
    }

    /**
     * Mark OTP as successfully verified and used
     */
    public function markAsUsed(): bool
    {
        $this->is_used = true;
        $this->verified_at = now();
        return $this->save();
    }
}
