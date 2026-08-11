<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';
    protected $fillable = [
        'vehicle_number',
        'user_id',
        'vehicle_type',
        'capacity_tons',
        'vehicle_photo',
        'rc_document',
        'fitness_document',
        'insurance_document',
        'driver_name',
        'driver_phone',
        'license_number',
        'license_photo',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'capacity_tons' => 'decimal:2',
    ];

    /**
     * Owner/Driver user account linked to this vehicle for login.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Owner user alias relationship.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Requests assigned to this vehicle.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class, 'vehicle_id');
    }

    /**
     * Dumps performed by this vehicle.
     */
    public function dumps(): HasMany
    {
        return $this->hasMany(Dump::class, 'vehicle_id');
    }
}
