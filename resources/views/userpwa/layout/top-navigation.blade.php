<div class="app-header">
    <div class="header-logo">
        <img src="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}" alt="Logo" class="logo-img">
        <div class="logo-text">
            <strong>DCLUTTER</strong>
            <span>BENGALURU'S CLEAN STREETS</span>
        </div>
    </div>
    <button type="button" class="menu-btn" aria-label="Open menu" aria-controls="user-menu" aria-expanded="false">
        <i class="fa-solid fa-bars" aria-hidden="true"></i>
    </button>
</div>

<div class="menu-backdrop" data-menu-close></div>
<aside id="user-menu" class="user-menu" aria-hidden="true" aria-label="User menu">
    <div class="user-menu__header">
        <strong class="text-center">Sagar</strong>
    </div>

    <nav class="user-menu__links" aria-label="Menu links">
        <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high" aria-hidden="true"></i><span>Home</span>
        </a>
        <a href="{{ route('user.report') }}" class="{{ request()->routeIs('user.report*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-lines" aria-hidden="true"></i><span>Report</span>
        </a>
        <a href="{{ route('user.track') }}" class="{{ request()->routeIs('user.track*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-lines" aria-hidden="true"></i><span>Track</span>
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
        padding: 0 16px;
        background: #ffffff;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        max-width: 420px;
        margin: 0 auto;
        left: 0;
        right: 0;
    }

    .header-logo {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .logo-img {
        height: 32px;
        width: auto;
    }

    .logo-text {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .logo-text strong {
        color: #0e7a43;
        font-size: 16px;
        font-weight: 800;
        letter-spacing: 0.5px;
    }

    .logo-text span {
        color: #64748b;
        font-size: 9px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .menu-btn {
        border: 0;
        background: transparent;
        color: #333 !important;
        font-size: 20px;
        text-decoration: none;
        display: grid;
        width: 36px;
        height: 36px;
        place-items: center;
        cursor: pointer;
    }

    .menu-backdrop {
        position: fixed;
        inset: 0;
        z-index: 1100;
        background: rgba(15, 23, 42, 0.35);
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }

    .user-menu {
        position: fixed;
        top: 14px;
        right: max(0px, calc((100vw - 420px) / 2));
        bottom: 10px;
        z-index: 1101;
        width: min(260px, calc(100vw - 40px));
        padding: 0;
        background: #ffffff;
        border-radius: 20px 0 0 20px;
        box-shadow: -12px 12px 30px rgba(15, 23, 42, 0.16);
        transform: translateX(calc(100% + 24px));
        transition: transform 0.28s ease;
    }

    .menu-backdrop.is-open {
        opacity: 1;
        pointer-events: auto;
    }

    .user-menu.is-open {
        transform: translateX(0);
    }

    .user-menu__header {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding: 16px 16px 10px;
        background: #045b3f;
        color: #ffffff;
        border-radius: 20px 0 0 0;
    }

    .user-menu__header strong {
        font-size: 23px;
        line-height: 1.1;
    }

    .user-menu__header span {
        margin-bottom: 1px;
        font-size: 12px;
        font-weight: 800;
    }

    .user-menu__close {
        display: grid;
        grid-template-columns: 28px 1fr 8px;
        align-items: center;
        gap: 10px;
        width: 100%;
        min-height: 61px;
        padding: 0 16px;
        border: 0;
        border-bottom: 1px solid #e2e8f0;
        border-radius: 0;
        color: #252525;
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
        min-height: 61px;
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

    .user-menu__links .menu-dot {
        width: auto;
        color: #cbd0d3;
        font-size: 6px;
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
