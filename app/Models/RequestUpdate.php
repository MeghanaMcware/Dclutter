<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestUpdate extends Model
{
    use HasFactory;

    protected $table = 'request_updates';

    protected $fillable = [
        'request_id',
        'user_id',
        'vehicle_id',
        'dump_id',
        'action',
        'status',
        'approx_weight_kg',
        'before_pickup_images',
        'picked_up_images',
        'latitude',
        'longitude',
        'remarks',
        'not_available_reason',
        'next_pickup_date',
        'metadata',
    ];

    protected $casts = [
        'approx_weight_kg' => 'decimal:2',
        'before_pickup_images' => 'array',
        'picked_up_images' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'next_pickup_date' => 'date',
        'metadata' => 'array',
    ];

    public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function dump(): BelongsTo
    {
        return $this->belongsTo(Dump::class, 'dump_id');
    }
}
