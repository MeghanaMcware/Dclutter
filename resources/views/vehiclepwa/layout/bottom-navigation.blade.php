<div id="footer-bar" class="footer-bar-5 vehicle-footer-bar d-flex flex-row align-items-end justify-content-around">
  


   

    {{-- <a href="{{ route('vehicle.requests.index') }}" class="{{ request()->routeIs('vehicle.requests*') ? 'active-nav' : '' }}">
        <i class="bi bi-bell-fill fs-4"></i>
        <span>Requests</span>
    </a> --}}
 <a href="" class="{{ request()->routeIs('vehicle.pickup*') ? 'active-nav' : '' }}">
        <i class="bi bi-truck fs-4"></i>
        <span>Pickup</span>
    </a>
 <a href="" class="{{ request()->routeIs('vehicle.pickup*') ? 'active-nav' : '' }}">
        <i class="bi bi-shield-check fs-4"></i>
        <span>Permit</span>
    </a>

    <a href="" class="{{ request()->routeIs('vehicle.dashboard') ? 'active-nav' : '' }}">
        <i class="bi bi-house-door-fill fs-4"></i>
        <span>Home</span>
    </a>
    

    <a href="" class="{{ request()->routeIs('vehicle.history*') ? 'active-nav' : '' }}">
        <i class="bi bi-clock-history fs-4"></i>
        <span>History</span>
    </a>

</div>

<style>
    .vehicle-footer-bar {
        background: #ffffff;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.08);
        border-top: 1px solid #e9ecef;
    }
    .vehicle-footer-bar a {
        display: flex;
        flex: 1 1 25%;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        position: relative;
        padding: 10px 4px 6px;
        text-align: center;
        color: #6c757d;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .vehicle-footer-bar a i {
        font-size: 22px !important;
    }
    .vehicle-footer-bar a span {
        font-size: 11px;
        line-height: 1.2;
        font-weight: 500;
    }
    .vehicle-footer-bar a.active-nav {
        color: #1f4e79 !important;
        font-weight: 700;
    }
    .vehicle-footer-bar a.active-nav i {
        color: #1f4e79 !important;
        transform: translateY(-2px);
    }
</style>
