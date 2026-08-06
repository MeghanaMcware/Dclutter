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
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
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
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
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
        font-size: 13px;
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
    .trend-up { color: #10b981; }
    .trend-down { color: #ef4444; }
    .trend-text { color: #64748b; font-weight: 500; margin-left: 4px; }

    /* Colors matching the image exactly */
    .val-blue { color: #2563eb; }
    .val-orange { color: #f97316; }
    .val-green { color: #10b981; }
    .val-red { color: #ef4444; }
    .val-purple { color: #8b5cf6; }

    /* Custom 5 Col */
    @media (min-width: 1200px) {
        .col-5th { width: 20%; flex: 0 0 auto; }
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
    .status-badge.in-progress { color: #ea580c; background: #ffedd5; }
    .status-badge.assigned { color: #2563eb; background: #dbeafe; }
    .status-badge.completed { color: #16a34a; background: #dcfce7; }
    .status-badge.pending { color: #dc2626; background: #fee2e2; }

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
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
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
        color: #94a3b8;
        font-size: 16px;
        text-decoration: none;
        transition: color 0.2s;
    }
    .action-link:hover { color: #2563eb; }

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

</style>
@endsection

@section('content')
<div class="container-fluid pt-4 pb-4">
    <!-- Top Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3 ">
            <div class="dash-card">
                <div class="stat-box">
                    <div class="stat-title">Total Requests <i class="fa fa-info-circle text-primary" style="font-size: 13px;"></i></div>
                    <div class="stat-value val-blue">12,568</div>
                  
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 ">
            <div class="dash-card">
                <div class="stat-box">
                    <div class="stat-title">In Progress <i class="fa fa-spinner text-warning" style="font-size: 13px;"></i></div>
                    <div class="stat-value val-orange">1,256</div>
                     </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="dash-card">
                <div class="stat-box">
                    <div class="stat-title">Completed <i class="fa fa-check-circle text-success" style="font-size: 13px;"></i></div>
                    <div class="stat-value val-green">9,245</div>
                    </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 ">
            <div class="dash-card">
                <div class="stat-box">
                    <div class="stat-title">Pending <i class="fa fa-clock text-danger" style="font-size: 13px;"></i></div>
                    <div class="stat-value val-red">256</div>
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
                    <select class="form-select select-sm w-auto">
                        <option>This Week</option>
                        <option>This Month</option>
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
                    <a href="#" class="view-all">View All</a>
                </div>
                <div class="dash-card-body d-flex align-items-center justify-content-center">
                    <div id="categoryChart"></div>
                </div>
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
                        <table class=" table table-bordered table-striped  text-center align-middle" id="data-source-1">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Submitted On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="color: #64748b; font-size: 12px; font-weight:600;">#DCL-1256</td>
                                    <td style="font-weight: 600;">Unmanned Debris</td>
                                    <td>BTM Layout</td>
                                    <td><span class="status-badge in-progress">In Progress</span></td>
                                    <td style="color: #64748b; font-size: 12px;">23 May, 10:30 AM</td>
                                    <td class="text-center"><a href="#" class="action-link"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-size: 12px; font-weight:600;">#DCL-1255</td>
                                    <td style="font-weight: 600;">C&D Waste</td>
                                    <td>HSR Layout</td>
                                    <td><span class="status-badge assigned">Assigned</span></td>
                                    <td style="color: #64748b; font-size: 12px;">23 May, 10:15 AM</td>
                                    <td class="text-center"><a href="#" class="action-link"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-size: 12px; font-weight:600;">#DCL-1254</td>
                                    <td style="font-weight: 600;">Bulk Waste</td>
                                    <td>Indiranagar</td>
                                    <td><span class="status-badge in-progress">In Progress</span></td>
                                    <td style="color: #64748b; font-size: 12px;">23 May, 09:45 AM</td>
                                    <td class="text-center"><a href="#" class="action-link"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-size: 12px; font-weight:600;">#DCL-1253</td>
                                    <td style="font-weight: 600;">Overflowing Bin</td>
                                    <td>Jayanagar</td>
                                    <td><span class="status-badge completed">Completed</span></td>
                                    <td style="color: #64748b; font-size: 12px;">23 May, 09:30 AM</td>
                                    <td class="text-center"><a href="#" class="action-link"><i class="fa fa-eye"></i></a></td>
                                </tr>
                                <tr>
                                    <td style="color: #64748b; font-size: 12px; font-weight:600;">#DCL-1252</td>
                                    <td style="font-weight: 600;">Dead Animal</td>
                                    <td>Koramangala</td>
                                    <td><span class="status-badge pending">Pending</span></td>
                                    <td style="color: #64748b; font-size: 12px;">23 May, 09:20 AM</td>
                                    <td class="text-center"><a href="#" class="action-link"><i class="fa fa-eye"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>

      

        <!-- Live Map -->
        <!-- <div class="col-xl-12">
            <div class="dash-card h-100">
                <div class="dash-card-header">
                    <h5 class="dash-card-title">Live Map</h5>
                    <span class="badge bg-success rounded-pill" style="font-size: 10px;">24 Active</span>
                </div>
                <div class="dash-card-body p-0">
                    <div id="liveMap"></div>
                </div>
            </div>
        </div> -->
    </div>
</div>
@endsection

@section('script')
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // 1. Line Chart: Requests Trend
        var trendOptions = {
            series: [{
                name: 'Received',
                data: [31, 40, 28, 51, 42, 109, 100]
            }, {
                name: 'Completed',
                data: [11, 32, 45, 32, 34, 52, 41]
            }],
            chart: {
                height: 250,
                type: 'area',
                toolbar: { show: false }
            },
            colors: ['#3b82f6', '#10b981'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                categories: ["23 May", "24 May", "25 May", "26 May", "27 May", "28 May", "29 May"],
                labels: { style: { colors: '#64748b' } }
            },
            yaxis: {
                labels: { style: { colors: '#64748b' } }
            },
            legend: { position: 'top', horizontalAlign: 'left' }
        };
        var trendChart = new ApexCharts(document.querySelector("#trendChart"), trendOptions);
        trendChart.render();

        // 2. Donut Chart: Requests by Category
        var catOptions = {
            series: [25, 15, 12, 10, 15, 8, 5, 10],
            labels: ['Furniture', 'Mattresses & Cushions', 'Clothes & Shoes', 'Appliances', 'Electronics', 'Books & Magazines', 'Toys & Games', 'Other Items'],
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
                            name: { show: false },
                            value: {
                                show: true,
                                fontSize: '24px',
                                fontWeight: 700,
                                color: '#0f172a',
                                formatter: function (val) { return val + "%" }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total',
                                fontSize: '12px',
                                color: '#64748b',
                                formatter: function (w) { return "12,568" }
                            }
                        }
                    }
                }
            },
            dataLabels: { enabled: false },
            legend: { show: false }
        };
        var catChart = new ApexCharts(document.querySelector("#categoryChart"), catOptions);
        catChart.render();

        // 3. Leaflet Map
        var map = L.map('liveMap').setView([12.9716, 77.5946], 12); // Bengaluru coordinates
        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; <a href="https://carto.com/">CARTO</a>'
        }).addTo(map);

        // Add some dummy markers
        var markers = [
            [12.9716, 77.5946, 'Vehicle #1 (On Route)'],
            [12.9352, 77.6245, 'Vehicle #2 (Collecting)'],
            [12.9121, 77.6446, 'Vehicle #3 (Idle)']
        ];

        markers.forEach(function(m) {
            L.circleMarker([m[0], m[1]], {
                color: '#10b981',
                fillColor: '#10b981',
                fillOpacity: 0.8,
                radius: 6
            }).addTo(map).bindPopup(m[2]);
        });
    });
</script>
@endsection
