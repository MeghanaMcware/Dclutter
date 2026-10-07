<?php

namespace App\Models;

use App\Traits\HasGeoScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LegacyPickupRequest extends Model
{
    use HasFactory, HasGeoScope;

    protected $table = 'legacy_pickup_requests';

    protected $fillable = [
        'excel_id',
        'applicant_name',
        'mobile_number',
        'address',
        'floor_no',
        'corporation_name',
        'division_name',
        'ward_name_no',
        'corporation_id',
        'constituency_id',
        'ward_id',
        'preferred_pickup_date',
        'items_text',
        'category_ids',
        'status',
        'created_at_text',
    ];

    protected $casts = [
        'category_ids' => 'array',
        'preferred_pickup_date' => 'datetime',
    ];

    public function getStatusLabelAttribute(): string
    {
        $st = strtolower($this->status ?? 'pending');
        return match($st) {
            'pending', 'requested' => 'Pending',
            'assigned', 'scheduled' => 'Assigned',
            'rescheduled', 'not_available' => 'Rescheduled',
            'picked_up' => 'Picked Up',
            'dumped', 'completed' => 'Dumped',
            'rejected' => 'Rejected',
            'closed', 'door_closed', 'call_not_attended', 'not_ready_today', 'cancelled' => 'Closed',
            default => ucfirst(str_replace('_', ' ', $st)),
        };
    }

    public function corporation(): BelongsTo
    {
        return $this->belongsTo(Corporation::class);
    }

    public function constituency(): BelongsTo
    {
        return $this->belongsTo(Constituency::class);
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }
}
