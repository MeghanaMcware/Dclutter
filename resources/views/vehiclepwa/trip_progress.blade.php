<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Trip Progress - DCLUTTER</title>
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

        .trip-card { background: #fff; border-radius: 16px; padding: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px; }
        .trip-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 14px; }
        .trip-header-row h3 { font-size: 15px; font-weight: 800; color: #0f172a; margin: 0; }
        .badge-in-progress { background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; }

        /* Progress Bar */
        .progress-label-row { display: flex; justify-content: space-between; align-items: center; font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; }
        .progress-label-row .pct { color: var(--primary-green); font-weight: 800; }
        .progress-bar-bg { width: 100%; height: 10px; background: #e2e8f0; border-radius: 10px; overflow: hidden; }
        .progress-bar-fill { width: 48%; height: 100%; background: var(--primary-green); border-radius: 10px; }

        /* Metrics Grid */
        .metrics-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
        .metric-card { background: #fff; border-radius: 14px; padding: 16px; text-align: center; border: 1px solid #f1f5f9; box-shadow: 0 2px 8px rgba(0,0,0,0.03); }
        .metric-card .num { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 2px; }
        .metric-card .label { font-size: 12px; color: #64748b; font-weight: 500; }

        /* End Trip Button */
        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }

         /* Contact Box */
        .contact-box { display: flex; align-items: center; justify-content: space-between; background: #f8fafc; padding: 12px 14px; border-radius: 12px; border: 1px solid #e2e8f0; }
        .contact-box .name { font-weight: 700; font-size: 14px; color: #0f172a; }
        .contact-box .phone { font-size: 12px; color: #64748b; }
        .btn-call { width: 40px; height: 40px; background: #dcfce7; color: #15803d; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 16px; }

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
            <a href="{{ route('driver.update_status') }}"><i class="fa-solid fa-arrow-left"></i></a>
            Trip Progress
        </h1>
        <i class="fa-solid fa-ellipsis-vertical font-16"></i>
    </div>

    <div class="app-container">

        <!-- Trip Info & Progress -->
        <div class="trip-card">
            <div class="trip-header-row">
                <div>
                    <span style="font-size: 11px; color:#64748b; font-weight:600;">Trip ID</span>
                    <h3>TRP-2025-05-24-01</h3>
                    <div style="font-size: 12px; color:#64748b; margin-top:2px;">6:00 AM - 11:00 AM</div>
                </div>
                <span class="badge-in-progress">In Progress</span>
            </div>

            <div class="progress-label-row">
                <span>17 / 35 Stops Completed</span>
                <span class="pct">48%</span>
            </div>

            <div class="progress-bar-bg">
                <div class="progress-bar-fill"></div>
            </div>
        </div>

        <!-- 4 Metrics -->
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="num" style="color: var(--primary-green);">17</div>
                <div class="label">Completed</div>
            </div>
            <div class="metric-card">
                <div class="num" style="color: #ea580c;">12</div>
                <div class="label">Remaining</div>
            </div>
            <div class="metric-card">
                <div class="num">1.1 Ton</div>
                <div class="label">Waste Collected</div>
            </div>
            <div class="metric-card">
                <div class="num">6.2 km</div>
                <div class="label">Distance Covered</div>
            </div>
        </div>

        <!-- End Trip Action -->
        <a href="{{ route('driver.trip_summary') }}" class="btn-end-trip">
            <span>End Trip</span>
        </a>

    </div>

    <!-- Bottom Nav -->
    <div class="bottom-nav">
        <a href="{{ route('driver.dashboard') }}"><i class="fa-solid fa-house"></i>Home</a>
        <a href="{{ route('driver.trip_progress') }}" class="active"><i class="fa-solid fa-truck"></i>Trips</a>
        <a href="{{ route('driver.route') }}"><i class="fa-solid fa-map-location-dot"></i>Map</a>
        <a href="{{ route('driver.profile_settings') }}"><i class="fa-solid fa-user"></i>Profile</a>
    </div>

</body>
</html>
