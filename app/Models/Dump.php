<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dump extends Model
{
    use HasFactory;

    protected $table = 'dumps';
    protected $fillable = [
        'vehicle_id',
        'plant_name',
        'dump_weight',
        'dump_images',
        'dump_latitude',
        'dump_longitude',
        'dumped_at',
        'remarks',
    ];

    protected $casts = [
        'dump_images' => 'array',
        'dump_weight' => 'decimal:2',
        'dump_latitude' => 'decimal:8',
        'dump_longitude' => 'decimal:8',
        'dumped_at' => 'datetime',
    ];

    /**
     * Vehicle that performed the dump.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    /**
     * Requests unloaded in this dump event.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class, 'dump_id');
    }
}
