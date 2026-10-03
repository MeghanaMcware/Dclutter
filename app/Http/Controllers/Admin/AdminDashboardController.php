<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Request as WasteRequest;
use App\Models\Corporation;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the Admin Dashboard with dynamic metrics, charts, and recent requests.
     */
    public function index(Request $request)
    {
        $selectedCorporationId = $request->input('corporation_id');
        $timeframe = $request->input('timeframe', 'week'); // 'week' or 'month'

        // Base scoped query honoring user role & jurisdiction
        $baseQuery = WasteRequest::query()->forUserJurisdiction();

        if ($selectedCorporationId && $selectedCorporationId !== 'all') {
            if (is_numeric($selectedCorporationId)) {
                $baseQuery->where('corporation_id', $selectedCorporationId);
            } else {
                $baseQuery->where(function($q) use ($selectedCorporationId) {
                    $q->whereHas('corporation', function($sub) use ($selectedCorporationId) {
                        $sub->where('name', 'LIKE', '%' . $selectedCorporationId . '%');
                    });
                });
            }
        }

        // 1. Top KPI Metrics based on filtered query using HasGeoScope trait statusCounts()
        $statusStats = (clone $baseQuery)->statusCounts();
        $totalRequests = $statusStats['total'];
        $pendingRequests = $statusStats['pending'];
        $assignedRequests = $statusStats['assigned'];
        $rescheduledRequests = $statusStats['rescheduled'];
        $pickedUpRequests = $statusStats['picked_up'];
        $dumpedRequests = $statusStats['dumped'];
        $cancelledRequests = $statusStats['cancelled'];
        
        $totalUsers = User::role('citizen')->count();
        if ($totalUsers === 0) {
            $totalUsers = User::count();
        }

        // 2. Trend Data Calculation (This Week = 7 days, This Month = 30 days)
        $daysCount = ($timeframe === 'month') ? 30 : 7;
        $trendDates = [];
        $receivedCounts = [];
        $completedCounts = [];

        for ($i = $daysCount - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateString = $date->toDateString();
            $label = $date->format('d M');
            $trendDates[] = $label;

            // Count requests received on this date
            $received = (clone $baseQuery)
                ->whereDate('created_at', $dateString)
                ->count();
            $receivedCounts[] = $received;

            // Count requests dumped/completed on this date
            $completed = (clone $baseQuery)
                ->where(function ($q) use ($dateString) {
                    $q->whereDate('picked_up_at', $dateString)
                      ->orWhere(function ($sub) use ($dateString) {
                          $sub->whereIn('status', ['picked_up', 'dumped', 'completed'])
                              ->whereDate('updated_at', $dateString);
                      });
                })
                ->count();
            $completedCounts[] = $completed;
        }

        // 3. Category Breakdown Data
        $allCategories = Category::where('status', true)->pluck('name')->toArray();
        $allRequests = (clone $baseQuery)->select('category_ids')->get();

        $categoryCounts = [];
        foreach ($allCategories as $catName) {
            $categoryCounts[$catName] = 0;
        }
        $categoryCounts['Other Items'] = 0;

        foreach ($allRequests as $reqItem) {
            $catIds = $reqItem->category_ids;
            if (is_array($catIds)) {
                foreach ($catIds as $c) {
                    $cTrim = trim((string) $c);
                    if (isset($categoryCounts[$cTrim])) {
                        $categoryCounts[$cTrim]++;
                    } else {
                        $categoryCounts['Other Items']++;
                    }
                }
            }
        }

        // Filter out categories with 0 count if there are multiple, or keep active ones
        $activeCatCounts = array_filter($categoryCounts, fn($cnt) => $cnt > 0);
        if (empty($activeCatCounts)) {
            $categoryLabels = array_keys(array_slice($categoryCounts, 0, 6));
            $categorySeries = array_fill(0, count($categoryLabels), 0);
        } else {
            $categoryLabels = array_keys($activeCatCounts);
            $categorySeries = array_values($activeCatCounts);
        }

        // 4. Request Status Breakdown Donut: Pending, Assigned, Rescheduled, Picked Up, Dumped, Cancelled
        $statusLabels = ['Pending', 'Assigned', 'Rescheduled', 'Picked Up', 'Dumped', 'Cancelled'];
        $statusSeries = [
            $statusStats['pending'],
            $statusStats['assigned'],
            $statusStats['rescheduled'],
            $statusStats['picked_up'],
            $statusStats['dumped'],
            $statusStats['cancelled'],
        ];

        // 5. Recent 10 Requests
        $recentRequests = (clone $baseQuery)
            ->with(['corporation', 'constituency', 'ward', 'vehicle'])
            ->latest('id')
            ->take(10)
            ->get();

        // 6. Corporations list for filter dropdown
        $corporations = Corporation::forUserJurisdiction()->orderBy('name')->get();

        // If AJAX request, return formatted JSON response
        if ($request->ajax()) {
            $tableHtml = view('admin.partials.dashboard_table_rows', compact('recentRequests'))->render();

            return response()->json([
                'success' => true,
                'stats' => [
                    'totalRequests' => number_format($totalRequests),
                    'pendingRequests' => number_format($pendingRequests),
                    'assignedRequests' => number_format($assignedRequests),
                    'rescheduledRequests' => number_format($rescheduledRequests),
                    'pickedUpRequests' => number_format($pickedUpRequests),
                    'dumpedRequests' => number_format($dumpedRequests),
                    'cancelledRequests' => number_format($cancelledRequests),
                    'totalUsers' => number_format($totalUsers),
                ],
                'trend' => [
                    'categories' => $trendDates,
                    'received' => $receivedCounts,
                    'completed' => $completedCounts,
                ],
                'categories' => [
                    'labels' => $categoryLabels,
                    'series' => $categorySeries,
                    'total' => number_format(array_sum($categorySeries)),
                ],
                'statusBreakdown' => [
                    'labels' => $statusLabels,
                    'series' => $statusSeries,
                ],
                'tableHtml' => $tableHtml,
            ]);
        }

        return view('admin.dashboard', compact(
            'totalRequests',
            'pendingRequests',
            'assignedRequests',
            'rescheduledRequests',
            'pickedUpRequests',
            'dumpedRequests',
            'cancelledRequests',
            'totalUsers',
            'trendDates',
            'receivedCounts',
            'completedCounts',
            'categoryLabels',
            'categorySeries',
            'statusLabels',
            'statusSeries',
            'recentRequests',
            'corporations',
            'selectedCorporationId',
            'timeframe'
        ));
    }
}
