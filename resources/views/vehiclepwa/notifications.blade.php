<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Notifications - DCLUTTER</title>
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

        /* Filter Pills */
        .filter-pills { display: flex; gap: 8px; margin-bottom: 16px; overflow-x: auto; padding-bottom: 4px; }
        .pill-item { background: #fff; color: #475569; padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; border: 1px solid #e2e8f0; text-decoration: none; white-space: nowrap; }
        .pill-item.active { background: var(--primary-green); color: #fff; border-color: var(--primary-green); }

        /* Timeline Items */
        .group-label { font-size: 13px; font-weight: 700; color: #94a3b8; margin: 16px 0 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .notif-card { background: #fff; border-radius: 14px; padding: 14px; border: 1px solid #f1f5f9; box-shadow: 0 2px 8px rgba(0,0,0,0.03); margin-bottom: 10px; display: flex; gap: 12px; }
        .notif-icon { width: 40px; height: 40px; border-radius: 10px; background: #e6f4ea; color: var(--primary-green); display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
        .notif-icon.warn { background: #ffedd5; color: #ea580c; }
        .notif-icon.route { background: #e0f2fe; color: #0284c7; }

        .notif-content { flex: 1; }
        .notif-title-row { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 4px; }
        .notif-title-row h4 { font-size: 14px; font-weight: 800; color: #0f172a; margin: 0; }
        .notif-title-row span { font-size: 11px; color: #94a3b8; font-weight: 500; }
        .notif-desc { font-size: 12px; color: #64748b; margin: 0; line-height: 1.4; }

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
            Notifications
        </h1>
        <i class="fa-solid fa-ellipsis-vertical font-16"></i>
    </div>

    <div class="app-container">

        <!-- Filter Pills -->
        <div class="filter-pills">
            <a href="#" class="pill-item active">All</a>
            <a href="#" class="pill-item">Trips</a>
            <a href="#" class="pill-item">Alerts</a>
            <a href="#" class="pill-item">System</a>
        </div>

        <!-- Today Section -->
        <div class="group-label">Today</div>

        <div class="notif-card">
            <div class="notif-icon">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div class="notif-content">
                <div class="notif-title-row">
                    <h4>New Trip Assigned</h4>
                    <span>11:15 AM</span>
                </div>
                <p class="notif-desc">Trip TRP-2025-05-24-02 has been assigned to you.</p>
            </div>
        </div>

        <div class="notif-card">
            <div class="notif-icon route">
                <i class="fa-solid fa-route"></i>
            </div>
            <div class="notif-content">
                <div class="notif-title-row">
                    <h4>Route Updated</h4>
                    <span>10:45 AM</span>
                </div>
                <p class="notif-desc">Route for Trip TRP-2025-05-24-02 has been updated.</p>
            </div>
        </div>

        <div class="notif-card">
            <div class="notif-icon warn">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div class="notif-content">
                <div class="notif-title-row">
                    <h4>Maintenance Alert</h4>
                    <span>09:30 AM</span>
                </div>
                <p class="notif-desc">Vehicle KA01AB1234 service is due on 26 May 2025.</p>
            </div>
        </div>

        <!-- Yesterday Section -->
        <div class="group-label">Yesterday</div>

        <div class="notif-card">
            <div class="notif-icon">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div class="notif-content">
                <div class="notif-title-row">
                    <h4>Trip Completed</h4>
                    <span>06:25 PM</span>
                </div>
                <p class="notif-desc">Trip TRP-2025-05-23-02 has been completed.</p>
            </div>
        </div>

    </div>

    <!-- Bottom Nav -->
    <div class="bottom-nav">
        <a href="{{ route('driver.dashboard') }}"><i class="fa-solid fa-house"></i>Home</a>
        <a href="{{ route('driver.trip_progress') }}"><i class="fa-solid fa-truck"></i>Trips</a>
        <a href="{{ route('driver.route') }}"><i class="fa-solid fa-map-location-dot"></i>Map</a>
        <a href="{{ route('driver.profile_settings') }}"><i class="fa-solid fa-user"></i>Profile</a>
    </div>

</body>
</html>
