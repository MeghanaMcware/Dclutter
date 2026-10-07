<div class="bottom-nav">
    <a href="{{ route('vehicle.dashboard') }}" class="{{ request()->routeIs('vehicle.dashboard') ? 'active' : '' }}">
        <div class="nav-icon-wrap">
            <i class="fa-solid fa-house"></i>
        </div>
        <span>Home</span>
    </a>
    <a href="{{ route('vehicle.requests') }}" class="{{ request()->routeIs('vehicle.requests*') ? 'active' : '' }}">
        <div class="nav-icon-wrap">
            <i class="fa-solid fa-list-check"></i>
            @if(!empty($navVehicleRequestsCount) && $navVehicleRequestsCount > 0)
                <span class="nav-badge" title="{{ $navVehicleRequestsCount }} Pending Requests">{{ $navVehicleRequestsCount > 99 ? '99+' : $navVehicleRequestsCount }}</span>
            @endif
        </div>
        <span>Requests</span>
    </a>
    <a href="{{ route('vehicle.trip_progress') }}" class="{{ request()->routeIs('vehicle.trip_progress*') || request()->routeIs('vehicle.update_status') || request()->routeIs('vehicle.trip_summary') ? 'active' : '' }}">
        <div class="nav-icon-wrap">
            <i class="fa-solid fa-truck"></i>
        </div>
        <span>Trips</span>
    </a>
    <a href="{{ route('vehicle.dump') }}" class="{{ request()->routeIs('vehicle.dump*') || request()->routeIs('vehicle.dumpform*') ? 'active' : '' }}">
        <div class="nav-icon-wrap">
            <i class="fa-solid fa-dumpster"></i>
            @if(!empty($navVehiclePendingDumpsCount) && $navVehiclePendingDumpsCount > 0)
                <span class="nav-badge nav-badge-warning" title="{{ $navVehiclePendingDumpsCount }} Ready to Dump">{{ $navVehiclePendingDumpsCount > 99 ? '99+' : $navVehiclePendingDumpsCount }}</span>
            @endif
        </div>
        <span>Dump</span>
    </a>
    <a href="{{ route('vehicle.history') }}" class="{{ request()->routeIs('vehicle.history*') ? 'active' : '' }}">
        <div class="nav-icon-wrap">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
        <span>History</span>
    </a>
    <a href="{{ route('vehicle.profile_settings') }}" class="{{ request()->routeIs('vehicle.profile_settings*') ? 'active' : '' }}">
        <div class="nav-icon-wrap">
            <i class="fa-solid fa-user"></i>
        </div>
        <span>Profile</span>
    </a>
</div>

<style>
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-around;
        align-items: center;
        min-height: var(--driver-bottom-nav-height, 68px);
        padding: 6px 0 calc(6px + env(safe-area-inset-bottom));
        max-width: 420px;
        margin: 0 auto;
        z-index: 1000;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.04);
    }
    .bottom-nav a {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #0e7a43;
        text-decoration: none;
        font-size: 11px;
        font-weight: 700;
        flex: 1;
        min-width: 0;
        padding: 3px 1px;
        transition: color 0.15s ease;
    }
    .bottom-nav a .nav-icon-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 24px;
        margin-bottom: 2px;
    }
    .bottom-nav a i {
        font-size: 18px;
        line-height: 1;
        display: block;
    }
    .bottom-nav a span {
        font-size: 11px;
        line-height: 1.2;
        white-space: nowrap;
    }
    .bottom-nav a.active {
        color: #1d4073;
    }
    .nav-badge {
        position: absolute;
        top: -6px;
        right: -10px;
        background: #ef4444;
        color: #ffffff;
        font-size: 9.5px;
        font-weight: 800;
        min-width: 17px;
        height: 17px;
        line-height: 15px;
        padding: 0 4px;
        border-radius: 999px;
        border: 1.5px solid #ffffff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.18);
        display: flex;
        align-items: center;
        justify-content: center;
        pointer-events: none;
    }
    .nav-badge-warning {
        background: #f59e0b;
        color: #ffffff;
    }
    .nav-badge-success {
        background: #0e7a43;
        color: #ffffff;
    }
</style>

