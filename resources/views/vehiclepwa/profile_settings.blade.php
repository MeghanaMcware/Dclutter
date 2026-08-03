<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Profile & Settings - DCLUTTER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; --bg: #f8fafc; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); margin: 0; padding-bottom: 75px; }
        .app-header { background: var(--primary-green); color: #fff; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; font-weight: 700; }
        .app-header h1 { font-size: 18px; margin: 0; color: #fff; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .app-header h1 a { color: #fff; text-decoration: none; }
        .app-container { max-width: 420px; margin: 0 auto; padding: 16px; }

        /* Profile Header Box */
        .profile-main-card { background: #fff; border-radius: 16px; padding: 20px; text-align: center; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .profile-avatar-lg { width: 70px; height: 70px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 32px; color: var(--primary-green); border: 3px solid #e6f4ea; margin: 0 auto 12px; }
        .profile-main-card h2 { font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 2px; }
        .profile-main-card .sub { font-size: 13px; color: #64748b; margin: 0; }
        .status-badge { background: #dcfce7; color: #15803d; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-top: 10px; }

        /* Navigation List */
        .menu-list { background: #fff; border-radius: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); overflow: hidden; }
        .menu-item { display: flex; align-items: center; justify-content: space-between; padding: 16px 18px; border-bottom: 1px solid #f1f5f9; text-decoration: none; color: #334155; font-size: 14px; font-weight: 600; transition: background 0.15s; }
        .menu-item:last-child { border-bottom: none; }
        .menu-item:hover { background: #f8fafc; }
        .menu-item .left { display: flex; align-items: center; gap: 14px; }
        .menu-item .left i { font-size: 16px; width: 20px; text-align: center; color: #64748b; }
        .menu-item .val { font-size: 12px; color: #64748b; font-weight: 500; margin-right: 6px; }
        .menu-item.logout { color: #dc2626; }
        .menu-item.logout .left i { color: #dc2626; }

        /* Bottom Nav */
        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: #fff; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-around; padding: 8px 0; max-width: 420px; margin: 0 auto; z-index: 100; }
        .bottom-nav a { text-align: center; color: #94a3b8; text-decoration: none; font-size: 10px; font-weight: 600; }
        .bottom-nav a i { font-size: 18px; display: block; margin-bottom: 2px; }
        .bottom-nav a.active { color: var(--primary-green); }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="app-header">
        <h1>
            <a href="{{ route('driver.dashboard') }}"><i class="fa-solid fa-arrow-left"></i></a>
            Profile
        </h1>
        <i class="fa-solid fa-ellipsis-vertical font-16"></i>
    </div>

    <div class="app-container">

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
        <div class="menu-list">
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

    <!-- Bottom Nav -->
    <div class="bottom-nav">
        <a href="{{ route('driver.dashboard') }}"><i class="fa-solid fa-house"></i>Home</a>
        <a href="{{ route('driver.trip_progress') }}"><i class="fa-solid fa-truck"></i>Trips</a>
        <a href="{{ route('driver.route') }}"><i class="fa-solid fa-map-location-dot"></i>Map</a>
        <a href="{{ route('driver.profile_settings') }}" class="active"><i class="fa-solid fa-user"></i>Profile</a>
    </div>

</body>
</html>
