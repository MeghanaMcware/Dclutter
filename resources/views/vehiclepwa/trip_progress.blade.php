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
        .progress-bar-fill { height: 100%; background: var(--primary-green); border-radius: 10px; transition: width 0.3s ease; }

        .metrics-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; margin-bottom: 20px; }
        .metric-card { background: #0e7a430f; border-radius: 14px; padding: 14px 8px; text-align: center; border: 1px solid #0e7a43; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
        .metric-card .num { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
        .metric-card .label { font-size: 11px; color: #64748b; font-weight: 600; }

        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        @php
            $totalStops = $assignedRequests->count();
            $progressPct = $totalStops > 0 ? round(($completedCount / $totalStops) * 100) : 0;
            $totalWeightKg = $assignedRequests->sum('approx_weight_kg');
        @endphp

        <!-- Working Date Filter -->
        <div class="mb-3">
            <form method="GET" action="{{ route('vehicle.trip_progress') }}" id="dateFilterForm">
                <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-white border shadow-sm">
                    <span class="small fw-bold text-muted ps-2"><i class="fa-regular fa-calendar-check text-success me-1"></i> Shift Date:</span>
                    <select name="date" class="form-select form-select-sm border-0 font-13 fw-bold w-auto" onchange="document.getElementById('dateFilterForm').submit();">
                        @forelse($workingDates as $date)
                            <option value="{{ $date }}" {{ $selectedDate == $date ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($date)->format('d M Y (l)') }}
                            </option>
                        @empty
                            <option value="{{ now()->toDateString() }}" selected>{{ now()->format('d M Y (l)') }}</option>
                        @endforelse
                    </select>
                </div>
            </form>
        </div>

        <!-- Trip Info & Progress -->
        <div class="trip-card">
            <div class="trip-header-row">
                <div>
                    <span style="font-size: 11px; color:#64748b; font-weight:600;">Trip ID</span>
                    <h3>TRP-{{ date('Y-m-d') }}-01</h3>
                    <div style="font-size: 12px; color:#64748b; margin-top:2px;">{{ date('h:i A') }} Active Collection Shift</div>
                </div>
                <span class="badge-in-progress">In Progress</span>
            </div>

            <div class="progress-label-row">
                <span>{{ $completedCount }} / {{ $totalStops }} Stops Completed</span>
                <span class="pct">{{ $progressPct }}%</span>
            </div>

            <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: {{ $progressPct }}%;"></div>
            </div>
        </div>

        <!-- 3 Metrics (Distance Covered Removed) -->
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="num" style="color: var(--primary-green);">{{ $completedCount }}</div>
                <div class="label">Completed</div>
            </div>
            <div class="metric-card">
                <div class="num" style="color: #ea580c;">{{ $pendingCount }}</div>
                <div class="label">Remaining</div>
            </div>
            <div class="metric-card">
                <div class="num" style="font-size: 16px;">{{ number_format($totalWeightKg, 1) }} kg</div>
                <div class="label">Waste Collected</div>
            </div>
        </div>

        <!-- End Trip Action -->
        <a href="{{ route('vehicle.trip_summary') }}" class="btn-end-trip">
            <i class="fa-solid fa-flag-checkered"></i>
            <span>End Trip & View Summary</span>
        </a>

    </div>
@endsection
