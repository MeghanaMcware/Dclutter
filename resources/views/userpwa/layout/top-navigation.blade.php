<header class="app-header">
    <a href="{{ route('user.dashboard') }}" class="header-logo text-decoration-none">
        <img src="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}" alt="Logo" class="logo-img">
        <div class="logo-text">
            <strong>DCLUTTER</strong>
            <span>Building a Cleaner Bengaluru, Together</span>
        </div>
    </a>

    <!-- Hamburger Menu Toggle Button (for both Mobile & Desktop) -->
    <button type="button" class="menu-btn" aria-label="Open menu" aria-controls="user-menu" aria-expanded="false">
        <i class="fa-solid fa-bars" aria-hidden="true"></i>
    </button>
</header>

<div class="menu-backdrop" data-menu-close></div>
<aside id="user-menu" class="user-menu" aria-hidden="true" aria-label="User menu">
    <div class="user-menu__header">
        <strong class="text-center">{{ auth()->user()?->name ?? 'User Portal' }}</strong>
    </div>

    <nav class="user-menu__links" aria-label="Menu links">
        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high" aria-hidden="true"></i><span>Home</span>
        </a>
        <a href="{{ route('user.report') }}" class="{{ request()->routeIs('user.report*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-circle-plus" aria-hidden="true"></i><span>Raise Request</span>
        </a>
        <a href="{{ route('user.track') }}" class="{{ request()->routeIs('user.track*') ? 'active' : '' }}">
            <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i><span>Track</span>
        </a>
        <a href="{{ route('user.history') }}" class="{{ request()->routeIs('user.history*') ? 'active' : '' }}">
            <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i><span>History</span>
        </a>
        <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile*') ? 'active' : '' }}">
            <i class="fa-solid fa-user" aria-hidden="true"></i><span>Profile</span>
        </a>
        <a href="{{ route('user.logout') }}">
            <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i><span>Logout</span>
        </a>
        <button type="button" class="user-menu__close" data-menu-close>
            <i class="fa-solid fa-xmark" aria-hidden="true"></i><span>Close</span>
        </button>
    </nav>
</aside>

<style>
    .app-header {
        position: fixed;
        inset: 0 0 auto;
        z-index: 1000;
        min-height: var(--user-header-height, 64px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border-bottom: 1px solid #eef2f6;
        left: 0;
        right: 0;
        width: 100%;
    }

    .header-logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo-img {
        height: 36px;
        width: auto;
    }

    .logo-text {
        display: flex;
        flex-direction: column;
        line-height: 1.15;
    }

    .logo-text strong {
        color: #0e7a43;
        font-size: 18px;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .logo-text span {
        color: #64748b;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .menu-btn {
        border: 0;
        background: transparent;
        color: #1e293b !important;
        font-size: 22px;
        display: grid;
        width: 42px;
        height: 42px;
        place-items: center;
        cursor: pointer;
        border-radius: 8px;
        transition: background 0.2s;
    }

    .menu-btn:hover {
        background: #f1f5f9;
    }

    .menu-backdrop {
        position: fixed;
        inset: 0;
        z-index: 1100;
        background: rgba(15, 23, 42, 0.4);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }

    .user-menu {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 1101;
        width: min(300px, calc(100vw - 40px));
        padding: 0;
        background: #ffffff;
        box-shadow: -8px 0 28px rgba(15, 23, 42, 0.16);
        transform: translateX(110%);
        transition: transform 0.28s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.28s;
        visibility: hidden;
        pointer-events: none;
        display: flex;
        flex-direction: column;
    }

    .menu-backdrop.is-open {
        opacity: 1;
        pointer-events: auto;
    }

    .user-menu.is-open {
        transform: translateX(0);
        visibility: visible;
        pointer-events: auto;
    }

    .user-menu__header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 22px 16px 18px;
        background: #045b3f;
        color: #ffffff;
    }

    .user-menu__header strong {
        font-size: 18px;
        line-height: 1.2;
    }

    .user-menu__close {
        display: grid;
        grid-template-columns: 28px 1fr 8px;
        align-items: center;
        gap: 10px;
        width: 100%;
        min-height: 52px;
        padding: 0 16px;
        border: 0;
        border-bottom: 1px solid #e2e8f0;
        border-radius: 0;
        color: #ef4444;
        background: #ffffff;
        font: inherit;
        font-size: 14px;
        font-weight: 600;
        text-align: left;
        cursor: pointer;
    }

    .user-menu__links {
        display: grid;
        gap: 0;
        padding-top: 0;
    }

    .user-menu__links a,
    .user-menu__links button {
        display: grid;
        grid-template-columns: 28px 1fr 8px;
        align-items: center;
        gap: 10px;
        min-height: 52px;
        padding: 0 16px;
        border-bottom: 1px solid #e2e8f0;
        border-radius: 0;
        color: #252525;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .user-menu__links a i:first-child,
    .user-menu__links button i:first-child {
        width: 28px;
        color: #0e7a43;
        text-align: center;
    }

    .user-menu__links .user-menu__close i:first-child {
        color: #ef476f;
    }

    .user-menu__links a:hover,
    .user-menu__links a.active,
    .user-menu__links button:hover {
        color: #0e7a43;
        background: #f8fafc;
    }

    body.menu-open {
        overflow: hidden;
    }

    @media (prefers-reduced-motion: reduce) {
        .menu-backdrop,
        .user-menu {
            transition: none;
        }
    }
</style>

<script>
    (() => {
        const menuButton = document.querySelector('.menu-btn');
        const menu = document.querySelector('#user-menu');
        const backdrop = document.querySelector('.menu-backdrop');

        if (!menuButton || !menu || !backdrop) return;

        const setMenuState = (isOpen) => {
            menu.classList.toggle('is-open', isOpen);
            backdrop.classList.toggle('is-open', isOpen);
            menuButton.setAttribute('aria-expanded', String(isOpen));
            menu.setAttribute('aria-hidden', String(!isOpen));
            document.body.classList.toggle('menu-open', isOpen);
        };

        menuButton.addEventListener('click', () => setMenuState(true));
        document.querySelectorAll('[data-menu-close]').forEach((element) => {
            element.addEventListener('click', () => setMenuState(false));
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') setMenuState(false);
        });
    })();
</script>
