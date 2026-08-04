@extends('vehiclepwa.layout.app')

@section('title') Profile & Settings @endsection
@section('heading') Profile @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .profile-main-card { background: #fff; border-radius: 16px; padding: 20px; text-align: center; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .profile-avatar-lg { width: 70px; height: 70px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 32px; color: var(--primary-green); border: 3px solid #e6f4ea; margin: 0 auto 12px; }
        .profile-main-card h2 { font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 2px; }
        .profile-main-card .sub { font-size: 13px; color: #64748b; margin: 0; }
        .status-badge { background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; }

        .menu-list { background: #fff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden; }
        .menu-item { display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: #334155; font-size: 14px; font-weight: 600; transition: background 0.15s; }
        .menu-item:last-child { border-bottom: none; }
        .menu-item:hover { background: #f8fafc; }
        .menu-item .left { display: flex; align-items: center; gap: 14px; }
        .menu-item .left i { font-size: 16px; width: 20px; text-align: center; color: #64748b; }
        .menu-item .val { font-size: 12px; color: #64748b; font-weight: 500; margin-right: 6px; }
        .menu-item.logout { color: #dc2626; }
        .menu-item.logout .left i { color: #dc2626; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- Profile Header -->
        <div class="profile-main-card">
            <div class="profile-avatar-lg">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <h2>Mahesh Kumar</h2>
            <div class="sub">Driver ID: DRV1024</div>
            <div class="sub" style="margin-top:2px;">98765 43210</div>
            <div class="status-badge">
                <i class="fa-solid fa-circle font-8"></i> Online
            </div>
        </div>

        <!-- Options Menu -->
        <div class="menu-list mb-4">
            <a href="#" class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-user"></i>
                    <span>My Profile</span>
                </div>
                <i class="fa-solid fa-chevron-right text-muted font-12"></i>
            </a>

            <a href="#" class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-truck"></i>
                    <span>Vehicle Details</span>
                </div>
                <div>
                    <span class="val">KA01AB1234</span>
                    <i class="fa-solid fa-chevron-right text-muted font-12"></i>
                </div>
            </a>

            <a href="#" class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-file-lines"></i>
                    <span>Documents</span>
                </div>
                <i class="fa-solid fa-chevron-right text-muted font-12"></i>
            </a>

            <a href="#" class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-headset"></i>
                    <span>Help & Support</span>
                </div>
                <i class="fa-solid fa-chevron-right text-muted font-12"></i>
            </a>

            <a href="#" class="menu-item">
                <div class="left">
                    <i class="fa-solid fa-gear"></i>
                    <span>Settings</span>
                </div>
                <i class="fa-solid fa-chevron-right text-muted font-12"></i>
            </a>

            <a href="{{ route('driver.login') }}" class="menu-item logout">
                <div class="left">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </div>
                <i class="fa-solid fa-chevron-right font-12"></i>
            </a>
        </div>

    </div>
@endsection
