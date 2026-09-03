@extends('vehiclepwa.layout.app')

@section('title') Vehicle & Owner Details @endsection
@section('heading') Profile @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .profile-main-card { background: #fff; border-radius: 16px; padding: 20px; text-align: center; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .profile-avatar-lg { width: 70px; height: 70px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 32px; color: var(--primary-green); border: 3px solid #e6f4ea; margin: 0 auto 12px; }
        .profile-main-card h2 { font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 2px; }
        .profile-main-card .sub { font-size: 13px; color: #64748b; margin: 0; }
        .status-badge { background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; }

        .menu-list { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden; margin-bottom: 20px; }
        .menu-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: #334155; font-size: 14px; font-weight: 600; }
        .menu-item:last-child { border-bottom: none; }
        .menu-item .left { display: flex; align-items: center; gap: 14px; }
        .menu-item .left i { font-size: 16px; width: 20px; text-align: center; color: var(--primary-green); }
        .menu-item .val { font-size: 13px; color: #1e293b; font-weight: 700; }
        .btn-logout { width: 100%; height: 48px; background: #fee2e2; color: #dc2626; border: 1px solid #fca5a5; border-radius: 14px; font-size: 15px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        @php
            $ownerName = $user?->name ?? 'Vehicle Owner';
            $ownerMobile = $user?->mobile_number ?? 'N/A';
        @endphp

        <!-- Owner Header -->
        <div class="profile-main-card">
            <div class="profile-avatar-lg">
                <i class="fa-solid fa-user-gear"></i>
            </div>
            <h2>{{ $ownerName }}</h2>
            <div class="sub">Registered Vehicle Owner</div>
            <div class="sub" style="margin-top:2px; font-weight:700; color:#0e7a43;">{{ $ownerMobile }}</div>
            <div class="status-badge">
                <i class="fa-solid fa-circle font-8"></i> Active Account
            </div>
        </div>

        <!-- Owner & Vehicle Details Card -->
        <h6 class="fw-bold text-dark px-1 mb-2">Registered Owner & Vehicle Info</h6>
        <div class="menu-list">
            <div class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-user"></i>
                    <span>Owner Name</span>
                </div>
                <span class="val">{{ $ownerName }}</span>
            </div>

            <div class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-phone"></i>
                    <span>Owner Mobile</span>
                </div>
                <span class="val">{{ $ownerMobile }}</span>
            </div>

            <div class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-truck-front"></i>
                    <span>Vehicle Number</span>
                </div>
                <span class="val">{{ $vehicle?->vehicle_number ?? 'KA07S7242' }}</span>
            </div>

            <div class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-truck-ramp-box"></i>
                    <span>Vehicle Type</span>
                </div>
                <span class="val">{{ ucfirst($vehicle?->vehicle_type ?? 'Truck') }}</span>
            </div>

            <div class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-weight-hanging"></i>
                    <span>Capacity</span>
                </div>
                <span class="val">{{ $vehicle?->capacity_tons ?? '25' }} Tons</span>
            </div>

            <div class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-id-badge"></i>
                    <span>License Number</span>
                </div>
                <span class="val">{{ $vehicle?->license_number ?? 'N/A' }}</span>
            </div>
        </div>

        <!-- Logout Action -->
        <form action="{{ route('vehicle.logout') }}" method="POST" id="driverLogoutForm" style="display: none;">
            @csrf
        </form>
        <button type="button" onclick="document.getElementById('driverLogoutForm').submit();" class="btn-logout mb-4">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout Account</span>
        </button>

    </div>
@endsection
