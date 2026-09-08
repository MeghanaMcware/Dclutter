<div class="bottom-nav">
    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house"></i>Home
    </a>
    <a href="{{ route('user.report') }}" class="{{ request()->routeIs('user.report*') ? 'active' : '' }}">
        <i class="fa-solid fa-camera"></i>Raise
    </a>
    <a href="{{ route('user.track') }}" class="{{ request()->routeIs('user.track*') ? 'active' : '' }}">
        <i class="fa-solid fa-map-location-dot"></i>Track
    </a>
    <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
        <i class="fa-solid fa-bars"></i>Menu
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
        min-height: var(--user-bottom-nav-height, 68px);
        padding: 8px 0 calc(8px + env(safe-area-inset-bottom));
        max-width: 420px;
        margin: 0 auto;
        z-index: 1000;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
    }
    .bottom-nav a {
        text-align: center;
        color: #94a3b8;
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
        flex: 1;
        transition: color 0.2s;
    }
    .bottom-nav a i {
        font-size: 20px;
        display: block;
        margin-bottom: 4px;
    }
    .bottom-nav a.active {
        color: #0e7a43;
    }
</style>
