<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Collect Waste - DCLUTTER</title>
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

        .photo-card { background: #fff; border-radius: 16px; padding: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px; }
        .photo-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .photo-header label { font-size: 14px; font-weight: 700; color: #0f172a; margin: 0; }
        .btn-cam { color: #64748b; font-size: 18px; background: none; border: none; cursor: pointer; }

        .img-preview-box { width: 100%; height: 160px; border-radius: 12px; overflow: hidden; background: #e2e8f0; position: relative; }
        .img-preview-box img { width: 100%; height: 100%; object-fit: cover; }

        /* Weight Input Group */
        .weight-card { background: #fff; border-radius: 16px; padding: 16px; border: 1px solid #f1f5f9; margin-bottom: 20px; }
        .weight-card label { font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; }
        .weight-input-row { display: flex; border: 1.5px solid #cbd5e1; border-radius: 12px; overflow: hidden; background: #fff; }
        .weight-input-row input { border: none; outline: none; padding: 12px 14px; font-size: 16px; font-weight: 700; color: #0f172a; width: 100%; }
        .weight-unit-select { background: #f8fafc; border: none; border-left: 1px solid #cbd5e1; padding: 0 16px; font-weight: 700; color: #475569; font-size: 14px; }

        /* Confirm Button */
        .btn-confirm { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-confirm:hover { background: var(--primary-dark); color: #fff; }

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
            <a href="{{ route('driver.stop_details') }}"><i class="fa-solid fa-arrow-left"></i></a>
            Collect Waste
        </h1>
        <i class="fa-solid fa-ellipsis-vertical font-16"></i>
    </div>

    <div class="app-container">

        <!-- Before Collection Photo -->
        <div class="photo-card">
            <div class="photo-header">
                <label>Before Collection</label>
                <button class="btn-cam"><i class="fa-solid fa-camera"></i></button>
            </div>
            <div class="img-preview-box">
                <img src="{{ asset('frontend/pwa/images/pictures/1.jpg') }}" alt="Garbage Before Collection">
            </div>
        </div>

        <!-- After Collection Photo -->
        <div class="photo-card">
            <div class="photo-header">
                <label>After Collection</label>
                <button class="btn-cam"><i class="fa-solid fa-camera"></i></button>
            </div>
            <div class="img-preview-box">
                <img src="{{ asset('frontend/pwa/images/pictures/10.jpg') }}" alt="Cleaned After Collection">
            </div>
        </div>

        <!-- Waste Weight Input -->
        <div class="weight-card">
            <label>Waste Weight (Approx.)</label>
            <div class="weight-input-row">
                <input type="number" value="850" placeholder="Enter weight">
                <select class="weight-unit-select">
                    <option value="kg" selected>kg</option>
                    <option value="ton">ton</option>
                </select>
            </div>
        </div>

        <!-- Confirm Collection Button -->
        <a href="{{ route('driver.update_status') }}" class="btn-confirm">
            <span>Confirm Collection</span>
        </a>

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
