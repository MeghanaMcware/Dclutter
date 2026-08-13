<div class="bottom-nav">
    <a href="{{ route('driver.dashboard') }}" class="{{ request()->routeIs('driver.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>Home
    </a>
    <a href="{{ route('driver.requests') }}" class="{{ request()->routeIs('driver.requests*') ? 'active' : '' }}">
        <i class="fa-solid fa-list-check"></i>Requests
    </a>
    <a href="{{ route('driver.trip_progress') }}" class="{{ request()->routeIs('driver.trip_progress*') || request()->routeIs('driver.update_status') || request()->routeIs('driver.trip_summary') ? 'active' : '' }}">
        <i class="fa-solid fa-truck"></i>Trips
    </a>
    <a href="{{ route('driver.route') }}" class="{{ request()->routeIs('driver.route*') || request()->routeIs('driver.stop_details') || request()->routeIs('driver.collect_waste') ? 'active' : '' }}">
        <i class="fa-solid fa-dumpster"></i>Dump
    </a>
    <a href="{{ route('driver.profile_settings') }}" class="{{ request()->routeIs('driver.profile_settings*') ? 'active' : '' }}">
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
