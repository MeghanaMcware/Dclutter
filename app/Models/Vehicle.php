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
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'capacity_tons' => 'decimal:2',
    ];

    /**
     * Driver account linked to this vehicle for login.
     */
    public function driver(): BelongsTo
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
