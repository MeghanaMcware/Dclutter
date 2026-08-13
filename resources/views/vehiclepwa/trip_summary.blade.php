@extends('vehiclepwa.layout.app')

@section('title') Trip Summary @endsection
@section('heading') Trip Summary @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }
        .summary-card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 14px; }
        .stat-box { background: #f8fafc; border-radius: 12px; padding: 14px; text-align: center; border: 1px solid #cbd5e1; }
        .stat-num { font-size: 20px; font-weight: 800; color: var(--primary-green); }
        .stat-label { font-size: 12px; color: #64748b; font-weight: 600; margin-top: 2px; }
        .btn-home { width: 100%; height: 48px; background: var(--primary-green); color: #fff; border: none; border-radius: 12px; font-size: 15px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- Shift Working Date Filter -->
        <div class="mb-3">
            <form method="GET" action="{{ route('vehicle.trip_summary') }}" id="summaryDateFilterForm">
                <div class="d-flex align-items-center justify-content-between p-2 rounded-3 bg-white border shadow-sm">
                    <span class="small fw-bold text-muted ps-2"><i class="fa-regular fa-calendar-check text-success me-1"></i> Shift Date:</span>
                    <select name="date" class="form-select form-select-sm border-0 font-13 fw-bold w-auto" onchange="document.getElementById('summaryDateFilterForm').submit();">
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

        <div class="summary-card">
            <h5 class="fw-bold text-dark mb-1">Shift Collection Summary</h5>
            <p class="text-muted small mb-3">Overview of completed pickups for {{ \Carbon\Carbon::parse($selectedDate)->format('d M Y (l)') }}.</p>

            <div class="stat-grid">
                <div class="stat-box">
                    <div class="stat-num">{{ $completedRequests->count() }}</div>
                    <div class="stat-label">Total Pickups</div>
                </div>
                <div class="stat-box">
                    <div class="stat-num">{{ number_format($completedRequests->sum('approx_weight_kg'), 1) }} kg</div>
                    <div class="stat-label">Total Weight</div>
                </div>
            </div>
        </div>

        <div class="summary-card">
            <h6 class="fw-bold text-dark mb-3">Completed Requests</h6>
            @forelse($completedRequests as $req)
                <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                    <div>
                        <strong class="text-dark d-block small">{{ $req->request_number }}</strong>
                        <span class="text-muted" style="font-size: 11px;">{{ $req->house_no }}, {{ Str::limit($req->address, 20) }}</span>
                    </div>
                    <span class="badge bg-success small">{{ $req->picked_up_at ? $req->picked_up_at->format('H:i') : 'Done' }}</span>
                </div>
            @empty
                <p class="text-muted small text-center my-3">No pickups completed on this date.</p>
            @endforelse
        </div>

        <a href="{{ route('vehicle.requests') }}" class="btn-home">
            <i class="fa-solid fa-truck-fast"></i> Back to Requests
        </a>
    </div>
@endsection
