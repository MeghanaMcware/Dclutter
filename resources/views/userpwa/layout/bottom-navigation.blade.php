<div class="bottom-nav">
    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>
        <span>Home</span>
    </a>
    <a href="{{ route('user.report') }}" class="{{ request()->routeIs('user.report*') ? 'active' : '' }}">
        <i class="fa-solid fa-camera"></i>
        <span>Raise</span>
    </a>
    <a href="{{ route('user.track') }}" class="{{ request()->routeIs('user.track*') ? 'active' : '' }}">
        <i class="fa-solid fa-map-location-dot"></i>
        <span>Track</span>
    </a>
    <a href="{{ route('user.history') }}" class="{{ request()->routeIs('user.history*') ? 'active' : '' }}">
        <i class="fa-solid fa-clock-rotate-left"></i>
        <span>History</span>
    </a>
    <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
        <i class="fa-solid fa-bars"></i>
        <span>Menu</span>
    </a>
</div>

<style>
    .bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        background: #ffffff;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-around;
        align-items: center;
        min-height: var(--user-bottom-nav-height, 68px);
        padding: 8px 16px calc(8px + env(safe-area-inset-bottom));
        margin: 0;
        z-index: 1000;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
    }

    .bottom-nav a {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #64748b;
        text-decoration: none;
        font-size: 11.5px;
        font-weight: 600;
        flex: 1;
        max-width: 180px;
        padding: 4px 0;
        transition: color 0.2s ease;
        gap: 4px;
    }

    .bottom-nav a i {
        font-size: 20px;
        line-height: 1;
        display: block;
    }

    .bottom-nav a:hover,
    .bottom-nav a.active {
        color: #0e7a43;
    }
</style>
