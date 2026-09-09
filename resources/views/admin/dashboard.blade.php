@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('style')
<!-- Leaflet CSS for Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>
body {
    background-color: #f4f7f6;
    font-family: 'Inter', sans-serif;
}

/* Cards */
.dash-card {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.dash-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dash-card-title {
    font-size: 20px;
    font-weight: 700;
    color: #0f172ac5;
    margin: 0;
}

.dash-card-body {
    padding: 20px;
    flex-grow: 1;
}

/* Top Stats */
.stat-box {
    padding: 20px;
    position: relative;
}

.stat-title {
    font-size: 15px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-value {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 8px;
    line-height: 1;
    letter-spacing: -1px;
}

.stat-trend {
    font-size: 12px;
    font-weight: 600;
}

.trend-up {
    color: #10b981;
}

.trend-down {
    color: #ef4444;
}

.trend-text {
    color: #64748b;
    font-weight: 500;
    margin-left: 4px;
}

/* Colors matching the image exactly */
.val-blue {
    color: #2563eb;
}

.val-orange {
    color: #f97316;
}

.val-green {
    color: #10b981;
}

.val-red {
    color: #ef4444;
}

.val-purple {
    color: #8b5cf6;
}

/* Custom 5 Col */
@media (min-width: 1200px) {
    .col-5th {
        width: 20%;
        flex: 0 0 auto;
    }
}

/* Tables */
.table-clean {
    margin: 0;
    width: 100%;
    border-collapse: collapse;
}

.table-clean thead th {
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    text-align: left;
}

.table-clean tbody td {
    font-size: 13px;
    font-weight: 500;
    color: #1e293b;
    padding: 14px 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.table-clean tbody tr:last-child td {
    border-bottom: none;
}

.table-clean tbody tr:hover {
    background-color: #f8fafc;
}

/* Badges exactly from image */
.status-badge {
    font-size: 11px;
    padding: 6px 10px;
    border-radius: 4px;
    font-weight: 600;
}

.status-badge.in-progress {
    color: #ea580c;
    background: #ffedd5;
}

.status-badge.assigned {
    color: #2563eb;
    background: #dbeafe;
}

.status-badge.completed {
    color: #16a34a;
    background: #dcfce7;
}

.status-badge.pending {
    color: #dc2626;
    background: #fee2e2;
}

/* Quick Actions */
.quick-action-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    height: 100%;
}

.quick-action-btn {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 16px 10px;
    text-decoration: none;
    color: #334155;
    background: #f8fafc;
    transition: all 0.2s;
}

.quick-action-btn:hover {
    border-color: #cbd5e1;
    background: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
}

.quick-action-icon {
    font-size: 20px;
    color: #475569;
    margin-bottom: 10px;
}

.quick-action-text {
    font-size: 12px;
    font-weight: 600;
    text-align: center;
}

/* Map Box */
#liveMap {
    height: 300px;
    width: 100%;
    border-radius: 0 0 8px 8px;
    z-index: 1;
}

.action-link {
    color: #fff;
    font-size: 16px;
    text-decoration: none;
    transition: color 0.2s;
}

.action-link:hover {
    color: #fff;
}

.view-all {
    font-size: 13px;
    color: #2563eb;
    text-decoration: none;
    font-weight: 600;
}

.select-sm {
    font-size: 12px;
    padding: 6px 28px 6px 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    color: #334155;
    font-weight: 500;
    background-color: #f8fafc;
}
.text-start1{
    color: black !important;
}
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 pb-4">

    <div class="d-flex row align-items-center justify-content-center">
        <div class="col-md-6 col-lg-6">
            <div class="mb-3">
                <label class="col-form-label mb-0"><b>Corporation</b></label>
                <select class="js-example-basic-single col-sm-12" id="corporationSelect">
                    <option value="all" {{ empty($selectedCorporationId) || $selectedCorporationId === 'all' ? 'selected' : '' }}>All Corporations</option>
                    @foreach($corporations as $corp)
                        <option value="{{ $corp->id }}" {{ $selectedCorporationId == $corp->id ? 'selected' : '' }}>
                            {{ $corp->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <!-- Top Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3 ">
            <div class="dash-card">
                <div class="stat-box">
                    <div class="stat-title">Total Requests <i class="fa fa-info-circle text-primary"
                            style="font-size: 15px;"></i></div>
                    <div class="stat-value val-blue" id="statTotalRequests">{{ number_format($totalRequests) }}</div>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 ">
            <div class="dash-card">
                <div class="stat-box">
                    <div class="stat-title">Completed Pickups <i class="fa fa-check-circle text-success"
                            style="font-size: 15px;"></i></div>
                    <div class="stat-value val-orange" id="statCompletedPickups">{{ number_format($completedPickups) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="dash-card">
                <div class="stat-box">
                    <div class="stat-title">Scheduled Pickups <i class="fa fa-calendar text-primary"
                            style="font-size: 15px;"></i></div>
                    <div class="stat-value val-green" id="statScheduledPickups">{{ number_format($scheduledPickups) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 ">
            <div class="dash-card">
                <div class="stat-box">
                    <div class="stat-title">Total Users <i class="fa fa-users text-info" style="font-size: 15px;"></i>
                    </div>
                    <div class="stat-value val-blue" id="statTotalUsers">{{ number_format($totalUsers) }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 ">
            <div class="dash-card">
                <div class="stat-box">
                    <div class="stat-title">Cancelled pickups <i class="fa fa-ban text-danger"
                            style="font-size: 15px;"></i></div>
                    <div class="stat-value val-red" id="statCancelledPickups">{{ number_format($cancelledPickups) }}</div>
                </div>
            </div>
        </div>

    </div>

    <!-- Middle Row: Charts and Top Wards -->
    <div class="row g-4 mb-4 d-flex align-items-stretch">
        <!-- Requests Trend -->
        <div class="col-xl-6">
            <div class="dash-card h-100">
                <div class="dash-card-header">
                    <h5 class="dash-card-title">Requests Trend</h5>
                    <select class="form-select select-sm w-auto" id="trendTimeframe">
                        <option value="week" {{ $timeframe === 'week' ? 'selected' : '' }}>This Week</option>
                        <option value="month" {{ $timeframe === 'month' ? 'selected' : '' }}>This Month</option>
                    </select>
                </div>
                <div class="dash-card-body">
                    <!-- Real ApexChart Placeholder -->
                    <div id="trendChart"></div>
                </div>
            </div>
        </div>

        <!-- Requests by Category -->
        <div class="col-xl-6">
            <div class="dash-card h-100">
                <div class="dash-card-header">
                    <h5 class="dash-card-title">Requests by Category</h5>
                    <a href="{{ route('admin.masters.categories.index') }}" class="view-all">View All</a>
                </div>
                <div class="dash-card-body d-flex align-items-center justify-content-center">
                    <div id="categoryChart"></div>
                </div>
            </div>
        </div>


    </div>


    <div class="col-sm-12 col-xl-12 box-col-6">
        <div class="card">
            <div class="card-header pb-0">
                <h5 class="dash-card-title">Pickup status breakdown</h5>
            </div>
            <div class="card-body apex-chart">
                <div id="donutchart"></div>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Recent Requests, Quick Actions, Live Map -->
    <div class="row">
        <!-- Recent Requests -->
        <div class="container-fluid ">
            <div class="card">
                <div class="card-body">


                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped text-center align-middle" id="data-source-1">
                            <thead>
                                <tr>
                                    <th>Display ID</th>
                                    <th>User Name</th>
                                    <th>Category</th>
                                    <th>sub-Category </th>
                                    <th>Status</th>
                                    <th>Submitted On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="recentRequestsBody">
                                @forelse($recentRequests as $req)
                                <tr>
                                    <td style="color: #202935dc; font-size: 12px; font-weight:600;">{{ $req->request_number }}</td>
                                    <td style="color: #202935dc;font-weight:600;">{{ $req->applicant_name ?: 'Citizen User' }}</td>
                                    <td style="color: #202935dc;font-weight:600;">
                                        @if(is_array($req->category_ids))
                                            {{ implode(', ', $req->category_ids) }}
                                        @else
                                            {{ $req->category_ids ?: 'N/A' }}
                                        @endif
                                    </td>
                                    <td style="color: #202935dc;font-weight:600;">
                                        @if(is_array($req->subcategory_ids))
                                            {{ implode(', ', $req->subcategory_ids) }}
                                        @else
                                            {{ $req->subcategory_ids ?: 'N/A' }}
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $st = strtolower($req->status ?? 'pending');
                                            $badgeClass = match($st) {
                                                'assigned', 'scheduled' => 'assigned',
                                                'picked_up', 'dumped', 'completed' => 'completed',
                                                'rejected', 'cancelled', 'not_available' => 'pending',
                                                default => 'pending',
                                            };
                                            $statusLabel = match($st) {
                                                'pending' => 'Requested',
                                                'assigned', 'scheduled' => 'Scheduled',
                                                'picked_up', 'dumped', 'completed' => 'Completed',
                                                'rejected', 'cancelled', 'not_available' => 'Cancelled',
                                                default => ucfirst(str_replace('_', ' ', $st)),
                                            };
                                        @endphp
                                        <span class="status-badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td style="color: #202935dc; font-weight:600;">{{ $req->created_at ? $req->created_at->format('d M, h:i A') : 'N/A' }}</td>
                                    <td class="text-center"><a href="{{ route('admin.requests.show', $req->id) }}" class="action-link btn btn-primary">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-muted py-4 text-center">No waste requests found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
(function() {
    function initDashboard() {
        if (typeof ApexCharts === 'undefined') {
            setTimeout(initDashboard, 50);
            return;
        }

        // 1. Initial Data from Backend
        var trendDates = @json($trendDates);
        var receivedCounts = @json($receivedCounts);
        var completedCounts = @json($completedCounts);

        var categoryLabels = @json($categoryLabels);
        var categorySeries = @json($categorySeries);

        var statusLabels = @json($statusLabels);
        var statusSeries = @json($statusSeries);

        // 2. Line Chart: Requests Trend
        var trendEl = document.querySelector("#trendChart");
        var trendChart = null;
        if (trendEl) {
            trendEl.innerHTML = '';
            var trendOptions = {
                series: [{
                    name: 'Received',
                    data: receivedCounts
                }, {
                    name: 'Completed',
                    data: completedCounts
                }],
                chart: {
                    height: 250,
                    type: 'area',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#3b82f6', '#10b981'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    categories: trendDates,
                    labels: {
                        style: {
                            colors: '#64748b'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: '#64748b'
                        },
                        formatter: function(val) {
                            return Math.round(val);
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left'
                }
            };
            trendChart = new ApexCharts(trendEl, trendOptions);
            trendChart.render();
        }

        // 3. Donut Chart: Requests by Category
        var catEl = document.querySelector("#categoryChart");
        var catChart = null;
        if (catEl) {
            catEl.innerHTML = '';
            var catS = categorySeries.length > 0 && Math.max.apply(Math, categorySeries) > 0 ? categorySeries : [1];
            var catL = categoryLabels.length > 0 ? categoryLabels : ['No Requests'];

            var catOptions = {
                series: catS,
                labels: catL,
                chart: {
                    type: 'donut',
                    height: 260
                },
                colors: ['#16a34a', '#2563eb', '#ea580c', '#9333ea', '#0d9488', '#d97706', '#dc2626', '#64748b'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                name: {
                                    show: false
                                },
                                value: {
                                    show: true,
                                    fontSize: '24px',
                                    fontWeight: 700,
                                    color: '#0f172a',
                                    formatter: function(val) {
                                        return val;
                                    }
                                },
                                total: {
                                    show: true,
                                    showAlways: true,
                                    label: 'Total',
                                    fontSize: '12px',
                                    color: '#64748b',
                                    formatter: function(w) {
                                        return categorySeries.reduce(function(a, b) { return a + b; }, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                }
            };
            catChart = new ApexCharts(catEl, catOptions);
            catChart.render();
        }

        // 4. Donut Chart: Pickup status breakdown (Exact Original Template Settings)
        var donutEl = document.querySelector("#donutchart");
        var donutChart = null;
        if (donutEl) {
            donutEl.innerHTML = '';
            var statS = statusSeries.length > 0 && Math.max.apply(Math, statusSeries) > 0 ? statusSeries : [1, 0, 0, 0];
            var donutchartOptions = {
                chart: {
                    width: 380,
                    type: 'donut',
                },
                series: statS,
                labels: statusLabels,
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                colors: ['#3489eb', '#eb9b34', '#51bb25', '#f41b35']
            };
            donutChart = new ApexCharts(donutEl, donutchartOptions);
            donutChart.render();
        }

        // 5. AJAX Update Function
        function updateDashboardAjax() {
            var corpSelect = document.getElementById('corporationSelect');
            var corpId = corpSelect ? corpSelect.value : 'all';
            var timeframeSelect = document.getElementById('trendTimeframe');
            var timeframe = timeframeSelect ? timeframeSelect.value : 'week';

            var url = new URL("{{ route('admin.dashboard') }}", window.location.origin);
            if (corpId && corpId !== 'all') {
                url.searchParams.set('corporation_id', corpId);
            }
            if (timeframe) {
                url.searchParams.set('timeframe', timeframe);
            }

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    // Update Top Stats
                    var elTotal = document.getElementById('statTotalRequests');
                    if (elTotal) elTotal.innerText = data.stats.totalRequests;

                    var elComp = document.getElementById('statCompletedPickups');
                    if (elComp) elComp.innerText = data.stats.completedPickups;

                    var elSched = document.getElementById('statScheduledPickups');
                    if (elSched) elSched.innerText = data.stats.scheduledPickups;

                    var elUsers = document.getElementById('statTotalUsers');
                    if (elUsers) elUsers.innerText = data.stats.totalUsers;

                    var elCanc = document.getElementById('statCancelledPickups');
                    if (elCanc) elCanc.innerText = data.stats.cancelledPickups;

                    // Update Trend Chart
                    if (trendChart) {
                        trendChart.updateOptions({
                            xaxis: {
                                categories: data.trend.categories
                            }
                        });
                        trendChart.updateSeries([{
                            name: 'Received',
                            data: data.trend.received
                        }, {
                            name: 'Completed',
                            data: data.trend.completed
                        }]);
                    }

                    // Update Category Chart
                    if (catChart) {
                        var updatedCatS = data.categories.series.length > 0 && Math.max.apply(Math, data.categories.series) > 0 
                            ? data.categories.series 
                            : [1];
                        var updatedCatL = data.categories.labels.length > 0 
                            ? data.categories.labels 
                            : ['No Requests'];

                        catChart.updateOptions({
                            labels: updatedCatL
                        });
                        catChart.updateSeries(updatedCatS);
                    }

                    // Update Status Breakdown Chart
                    if (donutChart) {
                        var updatedStatS = data.statusBreakdown.series.length > 0 && Math.max.apply(Math, data.statusBreakdown.series) > 0 
                            ? data.statusBreakdown.series 
                            : [1, 0, 0, 0];
                        donutChart.updateSeries(updatedStatS);
                    }

                    // Update Recent Requests Table via AJAX
                    var tbody = document.getElementById('recentRequestsBody');
                    if (tbody && data.tableHtml) {
                        tbody.innerHTML = data.tableHtml;
                    }
                }
            })
            .catch(function(err) {
                console.error('Dashboard AJAX error:', err);
            });
        }

        // Attach AJAX change events (handles both plain select and jQuery Select2)
        var corpSelectEl = document.getElementById('corporationSelect');
        if (corpSelectEl) {
            corpSelectEl.addEventListener('change', updateDashboardAjax);
        }
        if (window.jQuery) {
            $(document).on('change select2:select', '#corporationSelect', function() {
                updateDashboardAjax();
            });
            $(document).on('change', '#trendTimeframe', function() {
                updateDashboardAjax();
            });
        } else {
            var timeframeSelectEl = document.getElementById('trendTimeframe');
            if (timeframeSelectEl) {
                timeframeSelectEl.addEventListener('change', updateDashboardAjax);
            }
        }
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        initDashboard();
    } else {
        document.addEventListener("DOMContentLoaded", initDashboard);
    }
})();
</script>
@endsection