<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Trip Summary - DCLUTTER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; --bg: #f8fafc; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); margin: 0; padding-bottom: 75px; }
        .app-header { background: var(--primary-green); color: #fff; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; font-weight: 700; }
        .app-header h1 { font-size: 18px; margin: 0; color: #fff; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .app-header h1 a { color: #fff; text-decoration: none; }
        .app-container { max-width: 420px; margin: 0 auto; padding: 20px 16px; text-align: center; }

        /* Success Badge */
        .check-circle { width: 80px; height: 80px; background: var(--primary-green); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 10px auto 16px; font-size: 38px; box-shadow: 0 10px 25px rgba(14,122,67,0.3); }

        .summary-title { font-size: 22px; font-weight: 800; color: var(--primary-green); margin-bottom: 6px; }
        .summary-sub { font-size: 13px; color: #64748b; margin-bottom: 24px; line-height: 1.5; }

        /* Summary Breakdown Card */
        .summary-card { background: #fff; border-radius: 16px; padding: 18px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); text-align: left; margin-bottom: 24px; }
        .summary-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid #f1f5f9; font-size: 14px; }
        .summary-row:last-child { border-bottom: none; }
        .summary-row .label { color: #64748b; font-weight: 500; }
        .summary-row .val { color: #0f172a; font-weight: 700; }

        /* Submit Button */
        .btn-submit-summary { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-submit-summary:hover { background: var(--primary-dark); color: #fff; }

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
            <a href="{{ route('driver.trip_progress') }}"><i class="fa-solid fa-arrow-left"></i></a>
            Trip Summary
        </h1>
        <i class="fa-solid fa-bars font-16"></i>
    </div>

    <div class="app-container">

        <!-- Checkmark Badge -->
        <div class="check-circle">
            <i class="fa-solid fa-check"></i>
        </div>

        <h2 class="summary-title">Trip Completed!</h2>
        <p class="summary-sub">Great job! You have completed all<br>stops for this trip.</p>

        <!-- Summary Data Breakdown -->
        <div class="summary-card">
            <div class="summary-row">
                <span class="label">Trip ID</span>
                <span class="val">TRP-2025-05-24-01</span>
            </div>
            <div class="summary-row">
                <span class="label">Total Stops</span>
                <span class="val">35</span>
            </div>
            <div class="summary-row">
                <span class="label">Completed</span>
                <span class="val">35</span>
            </div>
            <div class="summary-row">
                <span class="label">Waste Collected</span>
                <span class="val">2.4 Ton</span>
            </div>
            <div class="summary-row">
                <span class="label">Distance Covered</span>
                <span class="val">11.8 km</span>
            </div>
            <div class="summary-row">
                <span class="label">Time Taken</span>
                <span class="val">4h 15m</span>
            </div>
        </div>

        <!-- Submit Button -->
        <a href="{{ route('driver.notifications') }}" class="btn-submit-summary">
            <span>Submit Summary</span>
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
