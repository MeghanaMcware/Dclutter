<div class="app-header">
    <div class="header-logo">
        <img src="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}" alt="Logo" class="logo-img">
        <div class="logo-text">
            <strong>DCLUTTER</strong>
            <span>BENGALURU'S CLEAN STREETS</span>
        </div>
    </div>
    <a href="#" class="menu-btn"><i class="fa-solid fa-bars"></i></a>
</div>

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
        color: #333 !important;
        font-size: 20px;
        text-decoration: none;
        display: grid;
        width: 36px;
        height: 36px;
        place-items: center;
    }
</style>
