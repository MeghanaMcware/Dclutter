<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Stop Details - DCLUTTER</title>
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

        /* Stop Pagination Header */
        .stop-nav-header { display: flex; align-items: center; justify-content: space-between; background: #fff; padding: 10px 16px; border-radius: 12px; border: 1px solid #f1f5f9; font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 16px; }
        .stop-nav-header a { color: #64748b; text-decoration: none; font-size: 16px; }

        /* Main Info Card */
        .stop-card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px; }
        .stop-card h2 { font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 6px; }
        .stop-card .address { font-size: 13px; color: #64748b; margin-bottom: 12px; line-height: 1.4; }
        .badge-waste-cat { background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-block; margin-bottom: 16px; }

        .info-group { margin-bottom: 16px; }
        .info-group label { font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 4px; letter-spacing: 0.5px; }
        .info-group p { font-size: 14px; font-weight: 600; color: #1e293b; margin: 0; }
        .instructions-list { margin: 0; padding-left: 18px; color: #334155; font-size: 13px; line-height: 1.6; font-weight: 500; }

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

        /* End Trip Button */
        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }

    </style>
</head>
<body>

    <!-- Header -->
    <div class="app-header">
        <h1>
            <a href="{{ route('driver.route') }}"><i class="fa-solid fa-arrow-left"></i></a>
            Stop Details
        </h1>
        <i class="fa-solid fa-bars font-16"></i>
    </div>

    <div class="app-container">

        <!-- Pagination -->
        <div class="stop-nav-header">
            <a href="#"><i class="fa-solid fa-arrow-left"></i></a>
            <span>Stop 7 of 35</span>
            <a href="#"><i class="fa-solid fa-arrow-right"></i></a>
        </div>

        <!-- Stop Card -->
        <div class="stop-card">
            <h2>RWA Green Heights</h2>
            <div class="address">12th Cross, BTM Layout 2nd Stage, Bengaluru - 560076</div>
            <span class="badge-waste-cat">C&D Waste</span>

            <div class="info-group">
                <label>Instructions</label>
                <ul class="instructions-list">
                    <li>Collect waste and update photo</li>
                    <li>Ensure safe loading</li>
                </ul>
            </div>

            <div class="info-group">
                <label>Waste Type</label>
                <p>C&D Debris</p>
            </div>

            <div class="info-group" style="margin-bottom: 0;">
                <label>Contact Person</label>
                <div class="contact-box">
                    <div>
                        <div class="name">Ramesh Babu</div>
                        <div class="phone">98765 12345</div>
                    </div>
                    <a href="tel:9876512345" class="btn-call"><i class="fa-solid fa-phone"></i></a>
                </div>
            </div>

            <!-- Action Button -->
            <a href="{{ route('driver.collect_waste') }}" class="btn-end-trip mt-5">
                <span>Arrived at Location</span>
            </a>
        </div>

    </div>

    <!-- Bottom Nav -->
    <div class="bottom-nav">
        <a href="{{ route('driver.dashboard') }}"><i class="fa-solid fa-house"></i>Home</a>
        <a href="{{ route('driver.trip_progress') }}"><i class="fa-solid fa-truck"></i>Trips</a>
        <a href="{{ route('driver.route') }}" class="active"><i class="fa-solid fa-map-location-dot"></i>Map</a>
        <a href="{{ route('driver.profile_settings') }}"><i class="fa-solid fa-user"></i>Profile</a>
    </div>

</body>
</html>
