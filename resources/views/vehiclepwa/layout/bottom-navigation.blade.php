<div class="bottom-nav">
    <a href="{{ route('vehicle.dashboard') }}" class="{{ request()->routeIs('vehicle.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>Home
    </a>
    <a href="{{ route('vehicle.requests') }}" class="{{ request()->routeIs('vehicle.requests*') ? 'active' : '' }}">
        <i class="fa-solid fa-list-check"></i>Requests
    </a>
    <a href="{{ route('vehicle.trip_progress') }}" class="{{ request()->routeIs('vehicle.trip_progress*') || request()->routeIs('vehicle.update_status') || request()->routeIs('vehicle.trip_summary') ? 'active' : '' }}">
        <i class="fa-solid fa-truck"></i>Trips
    </a>
<<<<<<< HEAD
    <a href="{{ route('driver.route') }}" class="{{ request()->routeIs('driver.route*') || request()->routeIs('driver.stop_details') || request()->routeIs('driver.collect_waste') ? 'active' : '' }}">
        <i class="fa-solid fa-dumpster"></i>Dump
=======
    <a href="{{ route('vehicle.route') }}" class="{{ request()->routeIs('vehicle.route*') || request()->routeIs('vehicle.stop_details') || request()->routeIs('vehicle.collect_waste') ? 'active' : '' }}">
        <i class="fa-solid fa-map-location-dot"></i>Map
>>>>>>> babb5b76a934b6036e746621f3d8b97585e98391
    </a>
    <a href="{{ route('vehicle.profile_settings') }}" class="{{ request()->routeIs('vehicle.profile_settings*') ? 'active' : '' }}">
        <i class="fa-solid fa-user"></i>Profile
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
        padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
        max-width: 420px;
        margin: 0 auto;
        z-index: 1000;
    }
    .bottom-nav a {
        text-align: center;
        color: #94a3b8;
        text-decoration: none;
        font-size: 10px;
        font-weight: 600;
        flex: 1;
    }
    .bottom-nav a i {
        font-size: 18px;
        display: block;
        margin-bottom: 2px;
    }
    .bottom-nav a.active {
        color: #1d4073;
    }
</style>
