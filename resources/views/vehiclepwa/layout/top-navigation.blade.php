<div class="app-header">
    <h1>
        <a href="javascript:history.back()"><i class="fa-solid fa-arrow-left"></i></a>
        @yield('heading', 'DCLUTTER Driver')
    </h1>
    <a href="{{ route('driver.notifications') }}" style="color: #fff;"><i class="fa-solid fa-bell font-16"></i></a>
</div>

<style>
    .app-header {
        position: fixed;
        inset: 0 0 auto;
        z-index: 1000;
        min-height: var(--driver-header-height, 64px);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 0 max(18px, calc((100vw - 440px) / 2 + 18px));
        background: #0e7a43;
        border-bottom: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.06);
    }

    .app-header h1 {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0;
        color: #fff;
        font-size: 24px;
        font-weight: 700;
        line-height: 1.2;
    }

    .app-header h1 a,
    .app-header > a {
        color: #fff !important;
        text-decoration: none;
    }

    .app-header > a {
        display: grid;
        width: 36px;
        height: 36px;
        place-items: center;
        border-radius: 50%;
    }
</style>
