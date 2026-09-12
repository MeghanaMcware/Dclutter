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

        // 1. Top KPI Metrics based on filtered query
        $totalRequests = (clone $baseQuery)->count();
        $completedPickups = (clone $baseQuery)->whereIn('status', ['picked_up', 'dumped', 'completed'])->count();
        $scheduledPickups = (clone $baseQuery)->whereIn('status', ['assigned', 'scheduled'])->count();
        $totalUsers = User::role('citizen')->count();
        if ($totalUsers === 0) {
            $totalUsers = User::count();
        }
        $cancelledPickups = (clone $baseQuery)->whereIn('status', ['rejected', 'cancelled', 'not_available'])->count();

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

            // Count requests completed on this date
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

        // 4. Pickup Status Breakdown Donut matching exact labels: Requested, Scheduled, Completed, Cancelled
        $statusRequested = (clone $baseQuery)->where('status', 'pending')->count();
        $statusScheduled = (clone $baseQuery)->whereIn('status', ['assigned', 'scheduled'])->count();
        $statusCompleted = (clone $baseQuery)->whereIn('status', ['picked_up', 'dumped', 'completed'])->count();
        $statusCancelled = (clone $baseQuery)->whereIn('status', ['rejected', 'cancelled', 'not_available'])->count();

        $statusLabels = ['Requested', 'Scheduled', 'Completed', 'Cancelled'];
        $statusSeries = [$statusRequested, $statusScheduled, $statusCompleted, $statusCancelled];

        // 5. Recent 10 Requests
        $recentRequests = (clone $baseQuery)
            ->with(['corporation', 'constituency', 'ward', 'vehicle'])
            ->latest('id')
            ->take(10)
            ->get();

        // 6. Corporations list for filter dropdown
        $corporations = Corporation::orderBy('name')->get();

        // If AJAX request, return formatted JSON response
        if ($request->ajax()) {
            $tableRows = [];
            foreach ($recentRequests as $req) {
                $category = is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?: 'N/A');
                $subcategory = is_array($req->subcategory_ids) ? implode(', ', $req->subcategory_ids) : ($req->subcategory_ids ?: 'N/A');
                $status = strtolower($req->status ?? 'pending');
                $statusClass = match($status) {
                    'assigned', 'scheduled' => 'assigned',
                    'picked_up', 'dumped', 'completed' => 'completed',
                    'rejected', 'cancelled', 'not_available' => 'pending',
                    default => 'pending',
                };
                $statusLabel = match($status) {
                    'pending' => 'Requested',
                    'assigned', 'scheduled' => 'Scheduled',
                    'picked_up', 'dumped', 'completed' => 'Completed',
                    'rejected', 'cancelled', 'not_available' => 'Cancelled',
                    default => ucfirst(str_replace('_', ' ', $status)),
                };
                $submittedOn = $req->created_at ? $req->created_at->format('d M, h:i A') : 'N/A';
                $viewUrl = route('admin.requests.show', $req->id);

                $tableRows[] = '<tr>'
                    . '<td style="color: #202935dc; font-size: 12px; font-weight:600;">' . e($req->request_number) . '</td>'
                    . '<td style="color: #202935dc;font-weight:600;">' . e($req->applicant_name ?: 'Citizen User') . '</td>'
                    . '<td style="color: #202935dc;font-weight:600;">' . e($category) . '</td>'
                    . '<td style="color: #202935dc;font-weight:600;">' . e($subcategory) . '</td>'
                    . '<td><span class="status-badge ' . $statusClass . '">' . e($statusLabel) . '</span></td>'
                    . '<td style="color: #202935dc; font-weight:600;">' . e($submittedOn) . '</td>'
                    . '<td class="text-center"><a href="' . e($viewUrl) . '" class="action-link btn btn-primary">View</a></td>'
                    . '</tr>';
            }
            $tableHtml = !empty($tableRows) 
                ? implode('', $tableRows) 
                : '<tr><td colspan="7" class="text-center text-muted py-4">No waste requests found.</td></tr>';

            return response()->json([
                'success' => true,
                'stats' => [
                    'totalRequests' => number_format($totalRequests),
                    'completedPickups' => number_format($completedPickups),
                    'scheduledPickups' => number_format($scheduledPickups),
                    'totalUsers' => number_format($totalUsers),
                    'cancelledPickups' => number_format($cancelledPickups),
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
            'completedPickups',
            'scheduledPickups',
            'totalUsers',
            'cancelledPickups',
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
