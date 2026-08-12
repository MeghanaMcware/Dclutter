@extends('vehiclepwa.layout.app')

@section('title') Notifications @endsection
@section('heading') Notifications @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .filter-pills { display: flex; gap: 8px; margin-bottom: 16px; overflow-x: auto; padding-bottom: 4px; }
        .pill-item { background: #fff; color: #475569; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; text-decoration: none; white-space: nowrap; }
        .pill-item.active { background: var(--primary-green); color: #fff; border-color: var(--primary-green); }

        .group-label { font-size: 13px; font-weight: 700; color: #94a3b8; margin: 16px 0 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .notif-card { background: #fff; border-radius: 14px; padding: 14px; border: 1px solid #f1f5f9; box-shadow: 0 2px 8px rgba(0,0,0,0.03); margin-bottom: 10px; display: flex; gap: 12px; }
        .notif-icon { width: 40px; height: 40px; border-radius: 10px; background: #e6f4ea; color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
        .notif-icon.warn { background: #ffedd5; color: #ea580c; }
        .notif-icon.route { background: #e0f2fe; color: #0284c7; }

        .notif-content { flex: 1; }
        .notif-title-row { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px; }
        .notif-title-row h4 { font-size: 14px; font-weight: 800; color: #0f172a; margin: 0; }
        .notif-title-row span { font-size: 11px; color: #94a3b8; font-weight: 500; }
        .notif-desc { font-size: 12px; color: #64748b; margin: 0; line-height: 1.4; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- Filter Pills -->
        <div class="filter-pills">
            <a href="#" class="pill-item active">All</a>
            <a href="#" class="pill-item">Trips</a>
            <a href="#" class="pill-item">Alerts</a>
        </div>

        <!-- Today Section -->
        <div class="group-label">Assigned Pickups & Alerts</div>

        @php
            $assignedNotifs = \App\Models\Request::whereIn('status', ['assigned', 'picked_up'])->latest()->get();
        @endphp

        @forelse($assignedNotifs as $req)
            <div class="notif-card">
                <div class="notif-icon {{ $req->status == 'picked_up' ? '' : 'route' }}">
                    <i class="fa-solid {{ $req->status == 'picked_up' ? 'fa-circle-check' : 'fa-truck-fast' }}"></i>
                </div>
                <div class="notif-content">
                    <div class="notif-title-row">
                        <h4>{{ $req->status == 'picked_up' ? 'Pickup Completed' : 'Pickup Assigned' }}</h4>
                        <span>{{ $req->updated_at->format('h:i A') }}</span>
                    </div>
                    <p class="notif-desc">Request {{ $req->request_number }} ({{ $req->applicant_name }}) at {{ $req->house_no }}, {{ Str::limit($req->address, 25) }}.</p>
                </div>
            </div>
        @empty
            <div class="notif-card justify-content-center text-center py-3">
                <p class="notif-desc">No new notifications for your vehicle today.</p>
            </div>
        @endforelse

    </div>
@endsection
