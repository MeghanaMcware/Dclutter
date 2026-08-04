@extends('vehiclepwa.layout.app')

@section('title') Today's Route @endsection
@section('heading') Today's Route @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .trip-info-card { background: #fff; border-radius: 16px; padding: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 14px; }
        .trip-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; }
        .trip-header-row h3 { font-size: 15px; font-weight: 800; color: #0f172a; margin: 0; }
        .trip-header-row p { font-size: 12px; color: #64748b; margin: 2px 0 0; }
        .badge-in-progress { background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; }
        .stats-summary-row { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; margin-top: 12px; padding-top: 10px; }
        .stats-summary-row span { font-size: 13px; font-weight: 700; color: #334155; }
        .stats-summary-row a { font-size: 12px; color: var(--primary-green); font-weight: 600; text-decoration: none; }

        .map-box { background: #e2e8f0; border-radius: 16px; height: 280px; position: relative; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: inset 0 2px 6px rgba(0,0,0,0.05); }
        .map-box svg { width: 100%; height: 100%; }

        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- Trip Details Card -->
        <div class="trip-info-card">
            <div class="trip-header-row">
                <div>
                    <span style="font-size: 11px; color:#64748b; font-weight:600;">Trip ID</span>
                    <h3>TRP-2025-05-24-01</h3>
                    <p>6:00 AM - 11:00 AM</p>
                </div>
                <span class="badge-in-progress">In Progress</span>
            </div>

            <div class="stats-summary-row">
                <span>35 Stops • 8.7 km</span>
                <a href="{{ route('driver.stop_details') }}">View List</a>
            </div>
        </div>

        <!-- Interactive Map Graphic -->
        <div class="map-box mb-4">
            <svg viewBox="0 0 400 280" xmlns="http://www.w3.org/2000/svg">
                <!-- Map Roads Background -->
                <path d="M0 60 H400 M0 140 H400 M0 220 H400" stroke="#cbd5e1" stroke-width="8"/>
                <path d="M80 0 V280 M180 0 V280 M280 0 V280 M340 0 V280" stroke="#cbd5e1" stroke-width="8"/>
                
                <!-- Green Route Trajectory Line -->
                <path d="M 80 220 L 180 220 L 180 140 L 280 140 L 280 60 L 340 60" 
                      stroke="#0e7a43" stroke-width="5" fill="none" stroke-dasharray="6 2" stroke-linecap="round"/>

                <!-- Waypoint Pins -->
                <circle cx="80" cy="220" r="14" fill="#2563eb"/>
                <circle cx="80" cy="220" r="6" fill="#ffffff"/>

                <circle cx="180" cy="220" r="12" fill="#0e7a43"/>
                <text x="180" y="224" font-size="11" font-weight="bold" fill="#ffffff" text-anchor="middle">2</text>

                <circle cx="180" cy="140" r="14" fill="#0e7a43"/>
                <circle cx="180" cy="140" r="18" stroke="#0e7a43" stroke-width="2" fill="none" opacity="0.6"/>
                <text x="180" y="144" font-size="12" font-weight="bold" fill="#ffffff" text-anchor="middle">3</text>

                <circle cx="280" cy="140" r="12" fill="#0e7a43"/>
                <text x="280" y="144" font-size="11" font-weight="bold" fill="#ffffff" text-anchor="middle">4</text>

                <circle cx="280" cy="60" r="12" fill="#0e7a43"/>
                <text x="280" y="64" font-size="11" font-weight="bold" fill="#ffffff" text-anchor="middle">5</text>
            </svg>
        </div>

        <!-- Start Navigation Button -->
        <a href="{{ route('driver.stop_details') }}" class="btn-end-trip">
            <i class="fa-solid fa-location-arrow"></i>
            <span>Start Navigation</span>
        </a>

    </div>
@endsection
