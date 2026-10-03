<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait HasGeoScope
{
    /**
     * Scope query to only include records within the user's jurisdiction / geoscope.
     *
     * Hierarchy / Role Scoping:
     * - Admin / SuperAdmin: Full access across all regions
     * - DGM (Deputy General Manager): Scoped to assigned Corporation(s)
     * - AGM (Additional General Manager): Scoped to assigned Constituency / Constituencies
     * - Ward Officer: Scoped to assigned Ward(s)
     * - Vehicle / Driver: Scoped to assigned Vehicle ID / Constituency
     * - Citizen: Scoped to user's own requests
     *
     * @param Builder $query
     * @param User|null $user
     * @return Builder
     */
    public function scopeForUserJurisdiction(Builder $query, ?User $user = null): Builder
    {
        $user = $user ?? Auth::user();

        if (!$user) {
            return $query;
        }

        // 1. SuperAdmin / Admin has unrestricted access
        if ($user->hasAnyRole(['admin', 'superadmin', 'super-admin'])) {
            return $query;
        }

        $table = $this->getTable();

        // 2. DGM Scoping: Filter by assigned Corporations
        if ($user->hasRole('dgm') || (!empty($user->corporation_ids) && is_array($user->corporation_ids))) {
            $corpIds = array_filter(array_map('intval', (array)$user->corporation_ids));
            if (!empty($corpIds)) {
                return $this->applyCorporationScope($query, $corpIds, $table);
            }
        }

        // 3. AGM Scoping: Filter by assigned Constituencies
        if ($user->hasRole('agm') || (!empty($user->constituency_ids) && is_array($user->constituency_ids))) {
            $constIds = array_filter(array_map('intval', (array)$user->constituency_ids));
            if (!empty($constIds)) {
                return $this->applyConstituencyScope($query, $constIds, $table);
            }
        }

        // 4. Ward Officer Scoping: Filter by assigned Wards
        if (!empty($user->ward_ids) && is_array($user->ward_ids)) {
            $wardIds = array_filter(array_map('intval', (array)$user->ward_ids));
            if (!empty($wardIds)) {
                return $this->applyWardScope($query, $wardIds, $table);
            }
        }

        // 5. Driver / Vehicle Scoping:
        if ($user->hasRole('vehicle')) {
            return $this->applyVehicleScope($query, $user, $table);
        }

        // 6. Citizen Scoping:
        if ($user->hasRole('citizen')) {
            if ($table === 'requests') {
                return $query->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhere('mobile_number', $user->mobile_number);
                });
            }
        }

        return $query;
    }

    /**
     * Apply corporation filter according to model structure.
     */
    protected function applyCorporationScope(Builder $query, array $corpIds, string $table): Builder
    {
        if ($table === 'corporations') {
            return $query->whereIn($table . '.id', $corpIds);
        }

        if ($table === 'constituencies') {
            return $query->whereIn($table . '.corporation_id', $corpIds);
        }

        if ($table === 'wards') {
            return $query->whereHas('constituency', fn($q) => $q->whereIn('corporation_id', $corpIds));
        }

        if ($table === 'vehicles') {
            return $query->where(function ($q) use ($corpIds) {
                $constituencyIds = \App\Models\Constituency::whereIn('corporation_id', $corpIds)->pluck('id')->toArray();
                foreach ($constituencyIds as $cId) {
                    $q->orWhereJsonContains('constituency_ids', (int)$cId)
                      ->orWhereJsonContains('constituency_ids', (string)$cId);
                }
            });
        }

        if ($table === 'dumps') {
            return $query->whereHas('vehicle', function ($q) use ($corpIds) {
                $constituencyIds = \App\Models\Constituency::whereIn('corporation_id', $corpIds)->pluck('id')->toArray();
                foreach ($constituencyIds as $cId) {
                    $q->orWhereJsonContains('constituency_ids', (int)$cId)
                      ->orWhereJsonContains('constituency_ids', (string)$cId);
                }
            });
        }

        if ($table === 'requests') {
            return $query->whereIn($table . '.corporation_id', $corpIds);
        }

        if ($table === 'plants') {
            return $query->whereIn($table . '.corporation_id', $corpIds);
        }

        if ($table === 'legacy_pickup_requests') {
            return $query->whereIn($table . '.corporation_id', $corpIds);
        }

        return $query;
    }

    /**
     * Apply constituency filter according to model structure.
     */
    protected function applyConstituencyScope(Builder $query, array $constIds, string $table): Builder
    {
        if ($table === 'constituencies') {
            return $query->whereIn($table . '.id', $constIds);
        }

        if ($table === 'corporations') {
            return $query->whereHas('constituencies', fn($q) => $q->whereIn('id', $constIds));
        }

        if ($table === 'wards') {
            return $query->whereIn($table . '.constituency_id', $constIds);
        }

        if ($table === 'plants') {
            return $query->whereIn($table . '.constituency_id', $constIds);
        }

        if ($table === 'vehicles') {
            return $query->where(function ($q) use ($constIds) {
                foreach ($constIds as $cId) {
                    $q->orWhereJsonContains('constituency_ids', (int)$cId)
                      ->orWhereJsonContains('constituency_ids', (string)$cId);
                }
            });
        }

        if ($table === 'dumps') {
            return $query->whereHas('vehicle', function ($q) use ($constIds) {
                foreach ($constIds as $cId) {
                    $q->orWhereJsonContains('constituency_ids', (int)$cId)
                      ->orWhereJsonContains('constituency_ids', (string)$cId);
                }
            });
        }

        if ($table === 'requests') {
            return $query->whereIn($table . '.constituency_id', $constIds);
        }

        if ($table === 'legacy_pickup_requests') {
            return $query->whereIn($table . '.constituency_id', $constIds);
        }

        return $query;
    }

    /**
     * Apply ward filter according to model structure.
     */
    protected function applyWardScope(Builder $query, array $wardIds, string $table): Builder
    {
        if ($table === 'wards') {
            return $query->whereIn($table . '.id', $wardIds);
        }

        if ($table === 'constituencies') {
            return $query->whereHas('wards', fn($q) => $q->whereIn('id', $wardIds));
        }

        if ($table === 'corporations') {
            return $query->whereHas('constituencies.wards', fn($q) => $q->whereIn('id', $wardIds));
        }

        if ($table === 'requests') {
            return $query->whereIn($table . '.ward_id', $wardIds);
        }

        if ($table === 'legacy_pickup_requests') {
            return $query->whereIn($table . '.ward_id', $wardIds);
        }

        return $query;
    }

    /**
     * Apply vehicle / driver scoping.
     */
    protected function applyVehicleScope(Builder $query, User $user, string $table): Builder
    {
        if ($table === 'requests') {
            return $query->where(function ($q) use ($user) {
                $q->whereHas('vehicle', function ($sub) use ($user) {
                    $sub->where('user_id', $user->id)
                        ->orWhere('driver_phone', $user->mobile_number);
                });
            });
        }

        if ($table === 'vehicles') {
            return $query->where(function ($q) use ($user, $table) {
                $q->where($table . '.user_id', $user->id)
                  ->orWhere($table . '.driver_phone', $user->mobile_number);
            });
        }

        if ($table === 'dumps') {
            return $query->whereHas('vehicle', function ($sub) use ($user) {
                $sub->where('user_id', $user->id)
                    ->orWhere('driver_phone', $user->mobile_number);
            });
        }

        if ($table === 'plants') {
            $vehicle = \App\Models\Vehicle::where('user_id', $user->id)
                ->orWhere('driver_phone', $user->mobile_number)
                ->first();
            $constIds = $vehicle?->constituency_ids;
            if (is_string($constIds)) {
                $constIds = json_decode($constIds, true);
            }
            $constIds = is_array($constIds) ? array_values(array_filter(array_map('intval', $constIds))) : [];
            if (!empty($constIds)) {
                return $query->where(function ($q) use ($constIds) {
                    $q->whereIn('plants.constituency_id', $constIds)
                      ->orWhereNull('plants.constituency_id');
                });
            }
        }

        return $query;
    }

    /**
     * Scope for a specific corporation ID.
     */
    public function scopeForCorporation(Builder $query, int $corporationId): Builder
    {
        return $this->applyCorporationScope($query, [$corporationId], $this->getTable());
    }

    /**
     * Scope for a specific constituency ID.
     */
    public function scopeForConstituency(Builder $query, int $constituencyId): Builder
    {
        return $this->applyConstituencyScope($query, [$constituencyId], $this->getTable());
    }

    /**
     * Scope for a specific ward ID.
     */
    public function scopeForWard(Builder $query, int $wardId): Builder
    {
        return $this->applyWardScope($query, [$wardId], $this->getTable());
    }

    /**
     * Check if a specific model instance is within a user's jurisdiction.
     */
    public function isWithinJurisdiction(?User $user = null): bool
    {
        $user = $user ?? Auth::user();
        if (!$user) {
            return false;
        }

        if ($user->hasAnyRole(['admin', 'superadmin', 'super-admin'])) {
            return true;
        }

        if ($user->hasRole('dgm') || !empty($user->corporation_ids)) {
            $corpIds = array_map('intval', (array)$user->corporation_ids);
            if (isset($this->corporation_id) && in_array((int)$this->corporation_id, $corpIds, true)) {
                return true;
            }
            if ($this instanceof \App\Models\Corporation && in_array((int)$this->id, $corpIds, true)) {
                return true;
            }
        }

        if ($user->hasRole('agm') || !empty($user->constituency_ids)) {
            $constIds = array_map('intval', (array)$user->constituency_ids);
            if (isset($this->constituency_id) && in_array((int)$this->constituency_id, $constIds, true)) {
                return true;
            }
            if ($this instanceof \App\Models\Constituency && in_array((int)$this->id, $constIds, true)) {
                return true;
            }
        }

        if (!empty($user->ward_ids)) {
            $wardIds = array_map('intval', (array)$user->ward_ids);
            if (isset($this->ward_id) && in_array((int)$this->ward_id, $wardIds, true)) {
                return true;
            }
            if ($this instanceof \App\Models\Ward && in_array((int)$this->id, $wardIds, true)) {
                return true;
            }
        }

        return false;
    }
}
