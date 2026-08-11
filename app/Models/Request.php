<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    use HasFactory;

    protected $table = 'requests';

    protected $fillable = [
        'request_number',
        'source',
        'user_id',
        'applicant_name',
        'mobile_number',
        'category_ids',
        'subcategory_ids',
        'waste_images',
        'picked_up_images',
        'house_no',
        'address',
        'landmark',
        'pincode',
        'latitude',
        'longitude',
        'picked_up_latitude',
        'picked_up_longitude',
        'corporation_id',
        'constituency_id',
        'ward_id',
        'preferred_pickup_date',
        'status',
        'vehicle_id',
        'assigned_at',
        'picked_up_at',
        'dump_id',
        'remarks',
    ];

    protected $casts = [
        'category_ids' => 'array',
        'subcategory_ids' => 'array',
        'waste_images' => 'array',
        'picked_up_images' => 'array',
        'preferred_pickup_date' => 'date',
        'assigned_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'picked_up_latitude' => 'decimal:8',
        'picked_up_longitude' => 'decimal:8',
    ];

    /**
     * Auto-generate unique tracking reference number (#DCL-2026-XXXXXX).
     */
    public static function generateRequestNumber(): string
    {
        $year = date('Y');
        $lastRequest = self::whereYear('created_at', $year)->latest('id')->first();
        $nextNumber = $lastRequest ? ((int) substr($lastRequest->request_number, -6)) + 1 : 1;
        return '#DCL-' . $year . '-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class, 'corporation_id');
    }

    public function constituency(): BelongsTo
    {
        return $this->belongsTo(Constituency::class, 'constituency_id');
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function dump(): BelongsTo
    {
        return $this->belongsTo(Dump::class, 'dump_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    public function scopePickedUp($query)
    {
        return $query->where('status', 'picked_up');
    }

    public function scopeDumped($query)
    {
        return $query->where('status', 'dumped');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Scope to filter requests within a user's assigned jurisdiction (DGM Corporation / AGM Constituency / Ward).
     */
    public function scopeForUserJurisdiction($query, ?User $user = null)
    {
        $user = $user ?? auth()->user();

        if (!$user) {
            return $query;
        }

        // DGM Scoping: Filter by assigned Corporations
        if ($user->hasRole('dgm') || (!empty($user->corporation_ids) && is_array($user->corporation_ids))) {
            $corpIds = array_filter(array_map('intval', (array)$user->corporation_ids));
            if (!empty($corpIds)) {
                return $query->whereIn('corporation_id', $corpIds);
            }
        }

        // AGM Scoping: Filter by assigned Constituencies
        if ($user->hasRole('agm') || (!empty($user->constituency_ids) && is_array($user->constituency_ids))) {
            $constIds = array_filter(array_map('intval', (array)$user->constituency_ids));
            if (!empty($constIds)) {
                return $query->whereIn('constituency_id', $constIds);
            }
        }

        // Ward Scoping
        if (!empty($user->ward_ids) && is_array($user->ward_ids)) {
            $wardIds = array_filter(array_map('intval', (array)$user->ward_ids));
            if (!empty($wardIds)) {
                return $query->whereIn('ward_id', $wardIds);
            }
        }

        return $query;
    }
}
