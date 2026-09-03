<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'password',
        'corporation_ids',
        'constituency_ids',
        'ward_ids',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'corporation_ids' => 'array',
            'constituency_ids' => 'array',
            'ward_ids' => 'array',
        ];
    }

    /**
     * Mutator to ensure mobile_number contains positive digits only.
     */
    protected function mobileNumber(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => preg_replace('/[^0-9]/', '', (string)$value)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Jurisdiction Model Accessors
    |--------------------------------------------------------------------------
    */

    /**
     * Get assigned Ward models as an Eloquent collection.
     */
    public function getAssignedWardsAttribute()
    {
        if (empty($this->ward_ids)) {
            return collect();
        }
        return Ward::whereIn('id', (array)$this->ward_ids)->get();
    }

    /**
     * Get assigned Constituency models as an Eloquent collection.
     */
    public function getAssignedConstituenciesAttribute()
    {
        if (empty($this->constituency_ids)) {
            return collect();
        }
        return Constituency::whereIn('id', (array)$this->constituency_ids)->get();
    }

    /**
     * Get assigned Corporation models as an Eloquent collection.
     */
    public function getAssignedCorporationsAttribute()
    {
        if (empty($this->corporation_ids)) {
            return collect();
        }
        return Corporation::whereIn('id', (array)$this->corporation_ids)->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Jurisdiction Helper Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if user is assigned to a specific ward ID.
     */
    public function isInWard($wardId): bool
    {
        return !empty($this->ward_ids) && in_array((int)$wardId, array_map('intval', (array)$this->ward_ids));
    }

    /**
     * Check if user is assigned to a specific constituency ID.
     */
    public function isInConstituency($constituencyId): bool
    {
        return !empty($this->constituency_ids) && in_array((int)$constituencyId, array_map('intval', (array)$this->constituency_ids));
    }

    /**
     * Check if user is assigned to a specific corporation ID.
     */
    public function isInCorporation($corporationId): bool
    {
        return !empty($this->corporation_ids) && in_array((int)$corporationId, array_map('intval', (array)$this->corporation_ids));
    }
}
