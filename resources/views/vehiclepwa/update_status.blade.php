<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <title>Update Status - DCLUTTER</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; --bg: #f8fafc; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg); margin: 0; padding-bottom: 75px; }
        .app-header { background: var(--primary-green); color: #fff; padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; font-weight: 700; }
        .app-header h1 { font-size: 18px; margin: 0; color: #fff; font-weight: 700; display: flex; align-items: center; gap: 10px; }
        .app-header h1 a { color: #fff; text-decoration: none; }
        .app-container { max-width: 420px; margin: 0 auto; padding: 24px 16px; text-align: center; }

        /* Success Check Circle */
        .check-circle { width: 90px; height: 90px; background: var(--primary-green); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 20px auto 24px; font-size: 42px; box-shadow: 0 10px 25px rgba(14,122,67,0.3); }

        .success-title { font-size: 22px; font-weight: 800; color: var(--primary-green); margin-bottom: 6px; }
        .success-sub { font-size: 14px; color: #64748b; margin-bottom: 28px; line-height: 1.5; }

        /* Remarks Textarea Box */
        .remarks-box { text-align: left; background: #fff; border-radius: 16px; padding: 16px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; }
        .remarks-box label { font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; }
        .remarks-box textarea { width: 100%; height: 90px; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif; resize: none; background: #f8fafc; }
        .remarks-box textarea:focus { border-color: var(--primary-green); background: #fff; }

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
            <a href="{{ route('driver.collect_waste') }}"><i class="fa-solid fa-arrow-left"></i></a>
            Update Status
        </h1>
        <i class="fa-solid fa-ellipsis-vertical font-16"></i>
    </div>

    <div class="app-container">

        <!-- Checkmark Circle -->
        <div class="check-circle">
            <i class="fa-solid fa-check"></i>
        </div>

        <h2 class="success-title">Collection Completed!</h2>
        <p class="success-sub">You have successfully completed<br>Stop 7 of 35.</p>

        <!-- Remarks Box -->
        <div class="remarks-box">
            <label>Remarks (Optional)</label>
            <textarea placeholder="Write remarks..."></textarea>
        </div>

        <!-- Action Button -->
        <a href="{{ route('driver.trip_progress') }}" class="btn-end-trip mt-5">
            <span>Next Stop</span>
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
