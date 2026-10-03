<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait HasStatusCounts
 *
 * Provides reusable, high-performance status aggregation methods that can be
 * seamlessly composed with geographic scopes (HasGeoScope), date filters, and custom scopes.
 */
trait HasStatusCounts
{
    /**
     * Single aggregated status counts for the current query builder.
     * Runs in a single optimized SQL pass.
     *
     * Example usage:
     * - WasteRequest::statusCounts()
     * - WasteRequest::forUserJurisdiction()->statusCounts()
     * - WasteRequest::forCorporation($corpId)->statusCounts()
     * - WasteRequest::forConstituency($constId)->statusCounts()
     * - WasteRequest::forWard($wardId)->statusCounts()
     *
     * @param Builder $query
     * @return array
     */
    public function scopeStatusCounts(Builder $query): array
    {
        $table = $this->getTable();
        $statusCol = $table . '.status';

        $row = (clone $query)->selectRaw("
            COUNT(*) as total,
            COUNT(CASE WHEN {$statusCol} = 'pending' THEN 1 END) as pending,
            COUNT(CASE WHEN {$statusCol} IN ('assigned', 'scheduled') THEN 1 END) as assigned,
            COUNT(CASE WHEN {$statusCol} IN ('not_available', 'rescheduled') THEN 1 END) as rescheduled,
            COUNT(CASE WHEN {$statusCol} = 'picked_up' THEN 1 END) as picked_up,
            COUNT(CASE WHEN {$statusCol} IN ('dumped', 'completed') THEN 1 END) as dumped,
            COUNT(CASE WHEN {$statusCol} IN ('rejected', 'cancelled') THEN 1 END) as cancelled
        ")->first();

        return [
            'total' => (int) ($row->total ?? 0),
            'pending' => (int) ($row->pending ?? 0),
            'assigned' => (int) ($row->assigned ?? 0),
            'rescheduled' => (int) ($row->rescheduled ?? 0),
            'picked_up' => (int) ($row->picked_up ?? 0),
            'dumped' => (int) ($row->dumped ?? 0),
            'cancelled' => (int) ($row->cancelled ?? 0),
            // Legacy aliases for backward compatibility
            'scheduled' => (int) ($row->assigned ?? 0),
            'completed' => (int) ($row->dumped ?? 0),
            'completed_pickups' => (int) ($row->picked_up ?? 0),
        ];
    }

    /**
     * Get status counts grouped by Corporation.
     *
     * @param Builder $query
     * @return \Illuminate\Support\Collection
     */
    public function scopeStatusBreakdownByCorporation(Builder $query)
    {
        $table = $this->getTable();
        return (clone $query)
            ->join('corporations', 'corporations.id', '=', "{$table}.corporation_id")
            ->selectRaw("
                corporations.id as corporation_id,
                corporations.name as corporation_name,
                COUNT(*) as total,
                COUNT(CASE WHEN {$table}.status = 'pending' THEN 1 END) as pending,
                COUNT(CASE WHEN {$table}.status IN ('assigned', 'scheduled') THEN 1 END) as assigned,
                COUNT(CASE WHEN {$table}.status IN ('not_available', 'rescheduled') THEN 1 END) as rescheduled,
                COUNT(CASE WHEN {$table}.status = 'picked_up' THEN 1 END) as picked_up,
                COUNT(CASE WHEN {$table}.status IN ('dumped', 'completed') THEN 1 END) as dumped,
                COUNT(CASE WHEN {$table}.status IN ('rejected', 'cancelled') THEN 1 END) as cancelled
            ")
            ->groupBy('corporations.id', 'corporations.name')
            ->orderBy('corporations.name')
            ->get();
    }

    /**
     * Get status counts grouped by Constituency.
     *
     * @param Builder $query
     * @param int|null $corporationId
     * @return \Illuminate\Support\Collection
     */
    public function scopeStatusBreakdownByConstituency(Builder $query, ?int $corporationId = null)
    {
        $table = $this->getTable();
        $q = (clone $query)->join('constituencies', 'constituencies.id', '=', "{$table}.constituency_id");

        if ($corporationId) {
            $q->where('constituencies.corporation_id', $corporationId);
        }

        return $q->selectRaw("
                constituencies.id as constituency_id,
                constituencies.name as constituency_name,
                constituencies.corporation_id,
                COUNT(*) as total,
                COUNT(CASE WHEN {$table}.status = 'pending' THEN 1 END) as pending,
                COUNT(CASE WHEN {$table}.status IN ('assigned', 'scheduled') THEN 1 END) as assigned,
                COUNT(CASE WHEN {$table}.status IN ('not_available', 'rescheduled') THEN 1 END) as rescheduled,
                COUNT(CASE WHEN {$table}.status = 'picked_up' THEN 1 END) as picked_up,
                COUNT(CASE WHEN {$table}.status IN ('dumped', 'completed') THEN 1 END) as dumped,
                COUNT(CASE WHEN {$table}.status IN ('rejected', 'cancelled') THEN 1 END) as cancelled
            ")
            ->groupBy('constituencies.id', 'constituencies.name', 'constituencies.corporation_id')
            ->orderBy('constituencies.name')
            ->get();
    }

    /**
     * Get status counts grouped by Ward.
     *
     * @param Builder $query
     * @param int|null $constituencyId
     * @return \Illuminate\Support\Collection
     */
    public function scopeStatusBreakdownByWard(Builder $query, ?int $constituencyId = null)
    {
        $table = $this->getTable();
        $q = (clone $query)->join('wards', 'wards.id', '=', "{$table}.ward_id");

        if ($constituencyId) {
            $q->where('wards.constituency_id', $constituencyId);
        }

        return $q->selectRaw("
                wards.id as ward_id,
                wards.name as ward_name,
                wards.ward_number,
                wards.constituency_id,
                COUNT(*) as total,
                COUNT(CASE WHEN {$table}.status = 'pending' THEN 1 END) as pending,
                COUNT(CASE WHEN {$table}.status IN ('assigned', 'scheduled') THEN 1 END) as assigned,
                COUNT(CASE WHEN {$table}.status IN ('not_available', 'rescheduled') THEN 1 END) as rescheduled,
                COUNT(CASE WHEN {$table}.status = 'picked_up' THEN 1 END) as picked_up,
                COUNT(CASE WHEN {$table}.status IN ('dumped', 'completed') THEN 1 END) as dumped,
                COUNT(CASE WHEN {$table}.status IN ('rejected', 'cancelled') THEN 1 END) as cancelled
            ")
            ->groupBy('wards.id', 'wards.name', 'wards.ward_number', 'wards.constituency_id')
            ->orderBy('wards.ward_number')
            ->get();
    }
}
