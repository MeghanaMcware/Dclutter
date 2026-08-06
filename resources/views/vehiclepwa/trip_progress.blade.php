@extends('vehiclepwa.layout.app')

@section('title') Trip Progress @endsection
@section('heading') Trip Progress @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .trip-card { background: #fff; border-radius: 16px; padding: 16px; border: 1px solid #0e7a43; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px; }
        .trip-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .trip-header-row h3 { font-size: 15px; font-weight: 800; color: #0f172a; margin: 0; }
        .badge-in-progress { background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; }

        .progress-label-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .progress-label-row .pct { color: var(--primary-green); font-weight: 800; }
        .progress-bar-bg { width: 100%; height: 10px; background: #e2e8f0; border-radius: 10px; overflow: hidden; }
        .progress-bar-fill { width: 48%; height: 100%; background: var(--primary-green); border-radius: 10px; }

        .metrics-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .metric-card { background: #0e7a430f; border-radius: 14px; padding: 16px; text-align: center; border: 1px solid #0e7a43; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
        .metric-card .num { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
        .metric-card .label { font-size: 12px; color: #64748b; font-weight: 500; }

        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- Trip Info & Progress -->
        <div class="trip-card">
            <div class="trip-header-row">
                <div>
                    <span style="font-size: 11px; color:#64748b; font-weight:600;">Trip ID</span>
                    <h3>TRP-2025-05-24-01</h3>
                    <div style="font-size: 12px; color:#64748b; margin-top:2px;">6:00 AM - 11:00 AM</div>
                </div>
                <span class="badge-in-progress">In Progress</span>
            </div>

            <div class="progress-label-row">
                <span>17 / 35 Stops Completed</span>
                <span class="pct">48%</span>
            </div>

            <div class="progress-bar-bg">
                <div class="progress-bar-fill"></div>
            </div>
        </div>

        <!-- 4 Metrics -->
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="num" style="color: var(--primary-green);">17</div>
                <div class="label">Completed</div>
            </div>
            <div class="metric-card">
                <div class="num" style="color: #ea580c;">12</div>
                <div class="label">Remaining</div>
            </div>
            <div class="metric-card">
                <div class="num">1.1 Ton</div>
                <div class="label">Waste Collected</div>
            </div>
            <div class="metric-card">
                <div class="num">6.2 km</div>
                <div class="label">Distance Covered</div>
            </div>
        </div>

        <!-- End Trip Action -->
        <a href="{{ route('driver.trip_summary') }}" class="btn-end-trip">
            <span>End Trip</span>
        </a>

    </div>
@endsection
