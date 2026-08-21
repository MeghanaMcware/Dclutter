@extends('vehiclepwa.layout.app')

@section('title') Driver Dashboard @endsection
@section('heading') Dashboard @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .profile-card { background: #fff; border-radius: 16px; padding: 16px; display: flex; align-items: center; justify-content: space-between; border: 1px solid #0e7a43; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px; }
        .profile-info { display: flex; align-items: center; gap: 12px; }
        .profile-avatar { width: 50px; height: 50px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--primary-green); border: 2px solid #e6f4ea; }
        .profile-text h3 { font-size: 16px; font-weight: 800; margin: 0; color: #0f172a; }
        .profile-text p { font-size: 12px; color: #64748b; margin: 2px 0 0; }
        .status-badge { background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; display: flex; align-items: center; gap: 5px; }

        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #0e7a430f; border-radius: 14px; padding: 16px; text-align: center; border: 1px solid var(--primary-green); box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
        .stat-card .num { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
        .stat-card .label { font-size: 12px; color: #64748b; font-weight: 500; }

        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .section-header h4 { font-size: 15px; font-weight: 700; margin: 0; color: #1e293b; }
        .section-header a { font-size: 12px; color: var(--primary-green); font-weight: 600; text-decoration: none; }

        .schedule-item { background: #fff; border-radius: 14px; padding: 14px 16px; border: 1px solid #f1f5f9; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; }
        .schedule-item .trip-code { font-size: 13px; font-weight: 700; color: #0f172a; }
        .schedule-item .trip-time { font-size: 11px; color: #64748b; margin-top: 2px; }
        .badge-in-progress { background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px; }
        .badge-upcoming { background: #e2e8f0; color: #475569; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px; }

        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- Profile Card -->
        <div class="profile-card">
            <div class="profile-info">
                <div class="profile-avatar">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="profile-text">
                    <h3>{{ Auth::user()->name ?? 'Driver Account' }}</h3>
                    <p>Mobile: {{ Auth::user()->mobile_number ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="status-badge">
                <i class="fa-solid fa-circle font-8"></i> Online
            </div>
        </div>

        <!-- 4 Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="num">{{ $pickedUpCount }}</div>
                <div class="label">Total Pickups</div>
            </div>
            <div class="stat-card">
                <div class="num">{{ $assignedCount + $pickedUpCount }}</div>
                <div class="label">Today Assigned</div>
            </div>
            <div class="stat-card">
                <div class="num">{{ $assignedCount }}</div>
                <div class="label">Pending Pickups</div>
            </div>
            <div class="stat-card">
                <div class="num">{{ number_format(\App\Models\Request::where('status', 'picked_up')->sum('approx_weight_kg'), 1) }} kg</div>
                <div class="label">Waste Collected</div>
            </div>
        </div>

        <div class="text-center mb-3">
            <a href="{{ route('vehicle.requests') }}" class="btn btn-success btn-sm w-100 py-2 fw-bold" style="background-color: var(--primary-green); border: none; border-radius: 10px;">
                <i class="fas fa-route me-1"></i> View Route & Requests
            </a>
        </div>

        <!-- Today's Schedule -->
        <div class="section-header">
            <h4>Today's Assigned Pickups</h4>
            <a href="{{ route('vehicle.requests') }}">View All</a>
        </div>

        @forelse($recentRequests as $req)
            <div class="schedule-item">
                <div>
                    <div class="trip-code">
                        <i class="fa-regular fa-clock me-1 {{ $req->status == 'picked_up' ? 'text-success' : 'text-primary' }}"></i>
                        {{ $req->request_number }} - {{ $req->house_no }}
                    </div>
                    <div class="trip-time">{{ Str::limit($req->address, 30) }}</div>
                </div>
                <span class="{{ $req->status == 'picked_up' ? 'badge-in-progress' : 'badge-upcoming' }}">
                    {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                </span>
            </div>
        @empty
            <div class="schedule-item text-center py-3">
                <p class="text-muted small mb-0 w-100">No active assigned pickups for today.</p>
            </div>
        @endforelse

        <!-- Start Next Trip Action -->
        <a href="{{ route('vehicle.route') }}" class="btn-end-trip mt-3">
            <span>View Live Route Map</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>

    </div>
@endsection
