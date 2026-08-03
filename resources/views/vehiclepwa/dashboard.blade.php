<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Driver Dashboard - DCLUTTER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; --bg: #f8fafc; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); margin: 0; padding-bottom: 75px; }
        .app-header { background: var(--primary-green); color: #fff; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; font-weight: 700; }
        .app-header h1 { font-size: 18px; margin: 0; color: #fff; font-weight: 700; }
        .app-container { max-width: 420px; margin: 0 auto; padding: 16px; }
        
        /* Profile Header Card */
        .profile-card { background: #fff; border-radius: 16px; padding: 16px; display: flex; align-items: center; justify-content: space-between; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px; }
        .profile-info { display: flex; align-items: center; gap: 12px; }
        .profile-avatar { width: 50px; height: 50px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 20px; color: var(--primary-green); border: 2px solid #e6f4ea; }
        .profile-text h3 { font-size: 16px; font-weight: 800; margin: 0; color: #0f172a; }
        .profile-text p { font-size: 12px; color: #64748b; margin: 2px 0 0; }
        .status-badge { background: #dcfce7; color: #15803d; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; display: flex; align-items: center; gap: 5px; }

        /* Stats Grid */
        .stats-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .stat-card { background: #fff; border-radius: 14px; padding: 16px; text-align: center; border: 1px solid #f1f5f9; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
        .stat-card .num { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
        .stat-card .label { font-size: 12px; color: #64748b; font-weight: 500; }

        /* Schedule Section */
        .section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px; }
        .section-header h4 { font-size: 15px; font-weight: 700; margin: 0; color: #1e293b; }
        .section-header a { font-size: 12px; color: var(--primary-green); font-weight: 600; text-decoration: none; }

        .schedule-item { background: #fff; border-radius: 14px; padding: 14px 16px; border: 1px solid #f1f5f9; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; }
        .schedule-item .trip-code { font-size: 13px; font-weight: 700; color: #0f172a; }
        .schedule-item .trip-time { font-size: 11px; color: #64748b; margin-top: 2px; }
        .badge-in-progress { background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px; }
        .badge-upcoming { background: #e2e8f0; color: #475569; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 6px; }

        /* Bottom Nav */
        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; background: #fff; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-around; padding: 8px 0; max-width: 420px; margin: 0 auto; z-index: 100; }
        .bottom-nav a { text-align: center; color: #94a3b8; text-decoration: none; font-size: 10px; font-weight: 600; }
        .bottom-nav a i { font-size: 18px; display: block; margin-bottom: 2px; }
        .bottom-nav a.active { color: var(--primary-green); }

        
        /* End Trip Button */
        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }

    </style>
</head>
<body>

    <!-- App Header -->
    <div class="app-header">
        <h1>Dashboard</h1>
        <a href="{{ route('driver.notifications') }}" style="color: #fff;"><i class="fa-solid fa-bell font-16"></i></a>
    </div>

    <div class="app-container">

        <!-- Profile Card -->
        <div class="profile-card">
            <div class="profile-info">
                <div class="profile-avatar">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
                <div class="profile-text">
                    <h3>Mahesh Kumar</h3>
                    <p>Driver ID: DRV1024</p>
                </div>
            </div>
            <div class="status-badge">
                <i class="fa-solid fa-circle font-8"></i> Online
            </div>
        </div>

        <!-- 4 Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="num">12</div>
                <div class="label">Trips Today</div>
            </div>
            <div class="stat-card">
                <div class="num">35</div>
                <div class="label">Stops Today</div>
            </div>
            <div class="stat-card">
                <div class="num">8.7 km</div>
                <div class="label">Distance</div>
            </div>
            <div class="stat-card">
                <div class="num">1.2 Ton</div>
                <div class="label">Waste Collected</div>
            </div>
        </div>

        <!-- Today's Schedule -->
        <div class="section-header">
            <h4>Today's Schedule</h4>
            <a href="#">View All</a>
        </div>

        <div class="schedule-item">
            <div>
                <div class="trip-code"><i class="fa-regular fa-clock me-1 text-success"></i> Trip ID: TRP-2025-05-24-01</div>
                <div class="trip-time">6:00 AM - 11:00 AM</div>
            </div>
            <span class="badge-in-progress">In Progress</span>
        </div>

        <div class="schedule-item">
            <div>
                <div class="trip-code"><i class="fa-regular fa-clock me-1 text-muted"></i> Trip ID: TRP-2025-05-24-02</div>
                <div class="trip-time">11:30 AM - 4:00 PM</div>
            </div>
            <span class="badge-upcoming">Upcoming</span>
        </div>

        <!-- Start Next Trip Action -->
        <a href="{{ route('driver.route') }}" class="btn-end-trip">
            <span>Start Next Trip</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>

    </div>

    <!-- Bottom Nav -->
    <div class="bottom-nav">
        <a href="{{ route('driver.dashboard') }}" class="active"><i class="fa-solid fa-house"></i>Home</a>
        <a href="{{ route('driver.trip_progress') }}"><i class="fa-solid fa-truck"></i>Trips</a>
        <a href="{{ route('driver.route') }}"><i class="fa-solid fa-map-location-dot"></i>Map</a>
        <a href="{{ route('driver.profile_settings') }}"><i class="fa-solid fa-user"></i>Profile</a>
    </div>

</body>
</html>
