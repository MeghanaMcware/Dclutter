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
            <a href="#" class="pill-item">System</a>
        </div>

        <!-- Today Section -->
        <div class="group-label">Today</div>

        <div class="notif-card">
            <div class="notif-icon">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div class="notif-content">
                <div class="notif-title-row">
                    <h4>New Trip Assigned</h4>
                    <span>11:15 AM</span>
                </div>
                <p class="notif-desc">Trip TRP-2025-05-24-02 has been assigned to you.</p>
            </div>
        </div>

        <div class="notif-card">
            <div class="notif-icon route">
                <i class="fa-solid fa-route"></i>
            </div>
            <div class="notif-content">
                <div class="notif-title-row">
                    <h4>Route Updated</h4>
                    <span>10:45 AM</span>
                </div>
                <p class="notif-desc">Route for Trip TRP-2025-05-24-02 has been updated.</p>
            </div>
        </div>

        <div class="notif-card">
            <div class="notif-icon warn">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="notif-content">
                <div class="notif-title-row">
                    <h4>Maintenance Alert</h4>
                    <span>09:30 AM</span>
                </div>
                <p class="notif-desc">Vehicle KA01AB1234 service is due on 26 May 2025.</p>
            </div>
        </div>

        <!-- Yesterday Section -->
        <div class="group-label">Yesterday</div>

        <div class="notif-card">
            <div class="notif-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="notif-content">
                <div class="notif-title-row">
                    <h4>Trip Completed</h4>
                    <span>06:25 PM</span>
                </div>
                <p class="notif-desc">Trip TRP-2025-05-23-02 has been completed.</p>
            </div>
        </div>

    </div>
@endsection
