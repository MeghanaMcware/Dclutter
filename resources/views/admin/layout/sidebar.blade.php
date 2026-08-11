<div class="sidebar-wrapper"> 
  <div>
    <div class="logo-wrapper">
      <a href="{{ route('admin.dashboard') }}" class="d-flex flex-row align-items-center gap-2 text-decoration-none">
        <img class="img-fluid for-light" src="/theme/images/logoicon2.png" alt="CLEARIT logo" style="max-height: 40px;">
        <img class="img-fluid for-dark" src="/theme/images/logoicon2.png" alt="CLEARIT logo" style="max-height: 40px;">
        <span class="fw-bold text-dark font-14">Admin - Dclutter</span>
      </a>
      <div class="back-btn"><i class="fa fa-angle-left"></i></div>
    </div>
    <div class="logo-icon-wrapper">
      <a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="/theme/images/logo-icon.png" alt="CLEARIT"></a>
    </div>
    <nav class="sidebar-main">
      <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
      <div id="sidebar-menu">
        <ul class="sidebar-links" id="simple-bar">
          <li class="back-btn">
            <a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="/theme/images/logo-icon.png" alt="CLEARIT"></a>
            <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
          </li>

          <li class="sidebar-list">
            <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
              <i data-feather="home"></i>
              <span>Dashboard</span>
            </a>
          </li>

          <li class="sidebar-list">
            <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.requests.*') ? 'active' : '' }}" href="{{ route('admin.requests.index') }}">
              <i data-feather="list"></i>
              <span>All Requests</span>
            </a>
          </li>

          <li class="sidebar-list">
            <a class="sidebar-link sidebar-title link-nav" href="#map">
              <i data-feather="map-pin"></i>
              <span>GIS Overview Map</span>
            </a>
          </li>

          <li class="sidebar-list">
            <a class="sidebar-link sidebar-title link-nav {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}" href="{{ route('admin.vehicles.index') }}">
              <i data-feather="truck"></i>
              <span>Vehicle Details</span>
            </a>
          </li>

          @if(!auth()->check() || !auth()->user()->hasAnyRole(['agm', 'dgm']))
          <li class="sidebar-list">
            <a class="sidebar-link sidebar-title {{ request()->routeIs('admin.masters.*') ? 'active' : '' }}" href="javascript:void(0);">
              <i data-feather="sliders"></i>
              <span>Masters</span>
            </a>
            <ul class="sidebar-submenu">
              <li>
                <a class="{{ request()->routeIs('admin.masters.categories.*') ? 'active' : '' }}" href="{{ route('admin.masters.categories.index') }}">
                  Category 
                </a>
              </li>
              <li>
                <a class="{{ request()->routeIs('admin.masters.subcategories.*') ? 'active' : '' }}" href="{{ route('admin.masters.subcategories.index') }}">
                  Sub Category
                </a>
              </li>
              <li>
                <a class="{{ request()->routeIs('admin.masters.users.*') ? 'active' : '' }}" href="{{ route('admin.masters.users.index') }}">
                  Users
                </a>
              </li>
            </ul>
          </li>
          @endif

        </ul>
      </div>
      <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
    </nav>
  </div>
</div>
