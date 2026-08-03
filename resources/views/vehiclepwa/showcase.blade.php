<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DCLUTTER DRIVER APP - Design Showcase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #0e7a43;
            --primary-green-dark: #095930;
            --primary-green-light: #e8f5e9;
            --bg-canvas: #f4f7f6;
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            --phone-width: 290px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-canvas);
            color: #1e293b;
            margin: 0;
            padding: 24px;
            min-height: 100vh;
        }

        /* Top Header Banner */
        .showcase-header {
            background: #ffffff;
            border-radius: 16px;
            padding: 16px 28px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.04);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid #e2e8f0;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .brand-logo-icon {
            width: 52px;
            height: 52px;
            background: #e6f4ea;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-text h1 {
            font-size: 24px;
            font-weight: 900;
            color: var(--primary-green);
            margin: 0;
            letter-spacing: 0.5px;
        }

        .brand-text p {
            font-size: 13px;
            color: #64748b;
            margin: 2px 0 0;
            font-weight: 600;
        }

        .quick-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-view-app {
            background: var(--primary-green);
            color: #ffffff;
            font-weight: 700;
            font-size: 14px;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
        }

        .btn-view-app:hover {
            background: var(--primary-green-dark);
            color: #ffffff;
            transform: translateY(-1px);
        }

        /* 5-Column Showcase Grid Layout matching the 2-row design image */
        .showcase-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        @media (max-width: 1600px) {
            .showcase-grid { grid-template-columns: repeat(5, 1fr); gap: 16px; }
        }
        @media (max-width: 1400px) {
            .showcase-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 900px) {
            .showcase-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .showcase-grid { grid-template-columns: 1fr; }
        }

        /* Screen Item Container */
        .screen-card-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .screen-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 10px;
            align-self: flex-start;
            width: 100%;
        }

        .screen-badge {
            width: 22px;
            height: 22px;
            background: var(--primary-green);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            flex-shrink: 0;
        }

        /* Phone Frame */
        .phone-frame {
            width: 100%;
            background: #ffffff;
            border-radius: 28px;
            border: 6px solid #1e293b;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            position: relative;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            height: 560px;
            cursor: pointer;
        }

        .phone-frame:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 35px rgba(0, 0, 0, 0.15);
        }

        /* Simulated Mobile Status Bar */
        .phone-status-bar {
            background: var(--primary-green);
            color: #ffffff;
            padding: 8px 14px 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 10px;
            font-weight: 700;
        }

        .phone-status-bar.white-bar {
            background: #ffffff;
            color: #1e293b;
        }

        .phone-status-bar .icons {
            display: flex;
            gap: 4px;
            font-size: 10px;
        }

        /* Inner Phone Screen Content */
        .phone-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #f8fafc;
            overflow: hidden;
        }

        /* App Screen Header */
        .screen-header {
            background: var(--primary-green);
            color: #ffffff;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-weight: 700;
            font-size: 13px;
        }

        .screen-header h2 {
            font-size: 14px;
            margin: 0;
            color: #ffffff;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .screen-content {
            padding: 10px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            overflow-y: auto;
        }

        /* UI Micro Components */
        .ui-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 8px 10px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }

        .ui-badge-success {
            background: #dcfce7;
            color: #15803d;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 700;
        }

        .ui-badge-upcoming {
            background: #e2e8f0;
            color: #475569;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 700;
        }

        .ui-btn-primary {
            background: var(--primary-green);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 8px;
            width: 100%;
            font-weight: 700;
            font-size: 12px;
            text-align: center;
            text-decoration: none;
            display: block;
        }

        .ui-bottom-nav {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-around;
            padding: 6px 0;
            margin-top: auto;
        }

        .ui-bottom-nav div {
            text-align: center;
            color: #94a3b8;
            font-size: 8px;
            font-weight: 600;
        }

        .ui-bottom-nav div i {
            font-size: 14px;
            display: block;
            margin-bottom: 2px;
        }

        .ui-bottom-nav div.active {
            color: var(--primary-green);
        }

        /* Side Cards Container (Key Features & Benefits) */
        .info-sidebar-container {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 20px;
        }

        @media (max-width: 900px) {
            .info-sidebar-container { grid-template-columns: 1fr; }
        }

        /* Key Features Card */
        .features-card {
            background: #e8f5e9;
            border: 1px solid #c8e6c9;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .features-card h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary-green-dark);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .features-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media (max-width: 600px) {
            .features-list { grid-template-columns: 1fr; }
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            color: #1e293b;
        }

        .features-list li i {
            color: var(--primary-green);
            background: #ffffff;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        /* Benefits Card */
        .benefits-card {
            background: #fffbeb;
            border: 1px solid #fef3c7;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .benefits-card h3 {
            font-size: 18px;
            font-weight: 800;
            color: #92400e;
            margin-bottom: 16px;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .benefits-grid { grid-template-columns: repeat(2, 1fr); }
        }

        .benefit-item {
            background: #ffffff;
            border-radius: 14px;
            padding: 14px 8px;
            border: 1px solid #fde68a;
        }

        .benefit-item i {
            font-size: 24px;
            color: var(--primary-green);
            margin-bottom: 6px;
            display: block;
        }

        .benefit-item span {
            font-size: 11px;
            font-weight: 700;
            color: #334155;
            display: block;
            line-height: 1.2;
        }
    </style>
</head>
<body>

    <!-- Top Header Banner -->
    <div class="showcase-header">
        <div class="header-brand">
            <div class="brand-logo-icon">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" width="34" height="34">
                    <rect x="2" y="10" width="18" height="12" rx="2" fill="#0e7a43"/>
                    <path d="M20 13H26C27.1046 13 28 13.8954 28 15V19C28 20.1046 27.1046 21 26 21H20V13Z" fill="#095930"/>
                    <circle cx="7" cy="23" r="3" fill="#1e293b"/>
                    <circle cx="7" cy="23" r="1.2" fill="#ffffff"/>
                    <circle cx="23" cy="23" r="3" fill="#1e293b"/>
                    <circle cx="23" cy="23" r="1.2" fill="#ffffff"/>
                    <path d="M5 14H15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="brand-text">
                <h1>DCLUTTER DRIVER APP</h1>
                <p>Smart. Simple. Transparent.</p>
            </div>
        </div>
        <div class="quick-actions">
            <a href="{{ route('driver.login') }}" class="btn-view-app">
                <i class="fa-solid fa-mobile-screen"></i> Launch Driver PWA App
            </a>
        </div>
    </div>

    <!-- 10 Mobile Screens Showcase Grid (5x2 Matrix Layout) -->
    <div class="showcase-grid">

        <!-- Screen 1: Login / Mobile Verification -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">1</span>
                <span>Login / Mobile Verification</span>
            </div>
            <a href="{{ route('driver.login') }}" class="phone-frame">
                <div class="phone-status-bar white-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="phone-body" style="background:#ffffff; padding:10px; text-align:center;">
                    <div style="font-size:14px; font-weight:800; color:#0f172a; margin-top:4px;">Welcome Back!</div>
                    <div style="font-size:9px; color:#64748b; margin-bottom:8px;">Login to continue your collections</div>
                    
                    <!-- SVG Waste Collection Vector Illustration -->
                    <div style="background:linear-gradient(180deg, #e8f5e9 0%, #ffffff 100%); border-radius:10px; padding:6px 4px; margin-bottom:8px;">
                        <svg viewBox="0 0 200 90" width="100%" height="75">
                            <!-- City Background -->
                            <rect x="10" y="35" width="20" height="40" fill="#cbd5e1" opacity="0.4"/>
                            <rect x="35" y="20" width="25" height="55" fill="#cbd5e1" opacity="0.3"/>
                            <rect x="140" y="25" width="25" height="50" fill="#cbd5e1" opacity="0.4"/>
                            <rect x="170" y="38" width="20" height="37" fill="#cbd5e1" opacity="0.5"/>
                            
                            <!-- Green Garbage Truck -->
                            <rect x="50" y="42" width="70" height="32" rx="4" fill="#0e7a43"/>
                            <path d="M120 52H140C144 52 148 56 148 60V74H120V52Z" fill="#095930"/>
                            <rect x="126" y="56" width="14" height="8" fill="#bae6fd"/>
                            
                            <!-- Wheels -->
                            <circle cx="68" cy="74" r="7" fill="#1e293b"/>
                            <circle cx="68" cy="74" r="2.5" fill="#ffffff"/>
                            <circle cx="102" cy="74" r="7" fill="#1e293b"/>
                            <circle cx="102" cy="74" r="2.5" fill="#ffffff"/>
                            <circle cx="134" cy="74" r="7" fill="#1e293b"/>
                            <circle cx="134" cy="74" r="2.5" fill="#ffffff"/>

                            <!-- Collection Workers -->
                            <circle cx="36" cy="58" r="4" fill="#f87171"/>
                            <rect x="32" y="63" width="8" height="11" rx="2" fill="#0e7a43"/>
                            <circle cx="160" cy="58" r="4" fill="#f87171"/>
                            <rect x="156" y="63" width="8" height="11" rx="2" fill="#0e7a43"/>

                            <line x1="5" y1="76" x2="195" y2="76" stroke="#e2e8f0" stroke-width="2"/>
                        </svg>
                    </div>

                    <div style="text-align:left; font-size:9px; font-weight:700; color:#334155; margin-bottom:3px;">Mobile Number</div>
                    <div style="background:#f8fafc; border:1px solid #cbd5e1; border-radius:6px; padding:6px 8px; font-size:10px; font-weight:700; color:#0f172a; margin-bottom:10px; text-align:left;">
                        +91 98765 43210
                    </div>

                    <div class="ui-btn-primary" style="font-size:11px; padding:7px;">Send OTP</div>

                    <div style="font-size:9px; color:#94a3b8; margin:6px 0;">or</div>

                    <div style="border:1px solid #cbd5e1; border-radius:6px; padding:5px; font-size:9px; font-weight:700; color:#334155;">
                        <i class="fa-solid fa-id-badge" style="color:var(--primary-green);"></i> Login with Employee ID
                    </div>

                    <div style="font-size:7px; color:#64748b; margin-top:10px;">
                        By continuing, you agree to the<br>
                        <span style="color:var(--primary-green); font-weight:700;">Terms & Conditions</span> and <span style="color:var(--primary-green); font-weight:700;">Privacy Policy</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Screen 2: Dashboard -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">2</span>
                <span>Dashboard</span>
            </div>
            <a href="{{ route('driver.dashboard') }}" class="phone-frame">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="screen-header">
                    <h2>Dashboard</h2>
                    <i class="fa-solid fa-bell font-12" style="position:relative;">
                        <span style="position:absolute; top:-2px; right:-2px; width:6px; height:6px; background:#ef4444; border-radius:50%;"></span>
                    </i>
                </div>
                <div class="phone-body">
                    <div class="screen-content">
                        <!-- Profile Box -->
                        <div class="ui-card d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:28px; height:28px; border-radius:50%; background:#e6f4ea; display:flex; align-items:center; justify-content:center; color:var(--primary-green); font-size:12px;">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                                <div>
                                    <div style="font-size:10px; font-weight:800; color:#0f172a;">Mahesh Kumar</div>
                                    <div style="font-size:8px; color:#64748b;">Driver ID: DRV1024</div>
                                </div>
                            </div>
                            <span class="ui-badge-success">● Online</span>
                        </div>

                        <!-- Stats 2x2 -->
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px;">
                            <div class="ui-card text-center" style="padding:6px;">
                                <div style="font-size:13px; font-weight:800; color:#0f172a;">12</div>
                                <div style="font-size:8px; color:#64748b;">Trips Today</div>
                            </div>
                            <div class="ui-card text-center" style="padding:6px;">
                                <div style="font-size:13px; font-weight:800; color:#0f172a;">35</div>
                                <div style="font-size:8px; color:#64748b;">Stops Today</div>
                            </div>
                            <div class="ui-card text-center" style="padding:6px;">
                                <div style="font-size:13px; font-weight:800; color:#0f172a;">8.7 km</div>
                                <div style="font-size:8px; color:#64748b;">Distance</div>
                            </div>
                            <div class="ui-card text-center" style="padding:6px;">
                                <div style="font-size:13px; font-weight:800; color:#0f172a;">1.2 Ton</div>
                                <div style="font-size:8px; color:#64748b;">Waste Collected</div>
                            </div>
                        </div>

                        <!-- Today's Schedule -->
                        <div class="d-flex justify-content-between align-items-center mt-1" style="font-size:9px; font-weight:700;">
                            <span style="color:#1e293b;">Today's Schedule</span>
                            <span style="color:var(--primary-green);">View All</span>
                        </div>

                        <div class="ui-card" style="padding:6px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div style="font-size:9px; font-weight:800; color:#0f172a;">Trip ID: TRP-2025-05-24-01</div>
                                <span class="ui-badge-success">In Progress</span>
                            </div>
                            <div style="font-size:8px; color:#64748b; margin-top:2px;">6:00 AM - 11:00 AM</div>
                        </div>

                        <div class="ui-card" style="padding:6px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div style="font-size:9px; font-weight:800; color:#0f172a;">Trip ID: TRP-2025-05-24-02</div>
                                <span class="ui-badge-upcoming">Upcoming</span>
                            </div>
                            <div style="font-size:8px; color:#64748b; margin-top:2px;">11:30 AM - 4:00 PM</div>
                        </div>

                        <div class="ui-btn-primary" style="margin-top:auto; font-size:10px; padding:7px;">Start Next Trip</div>
                    </div>
                    <div class="ui-bottom-nav">
                        <div class="active"><i class="fa-solid fa-house"></i>Home</div>
                        <div><i class="fa-solid fa-truck"></i>Trips</div>
                        <div><i class="fa-solid fa-map-location-dot"></i>Map</div>
                        <div><i class="fa-solid fa-user"></i>Profile</div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Screen 3: Today's Route -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">3</span>
                <span>Today's Route</span>
            </div>
            <a href="{{ route('driver.route') }}" class="phone-frame">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="screen-header">
                    <h2><i class="fa-solid fa-arrow-left font-11"></i> Today's Route</h2>
                    <i class="fa-solid fa-ellipsis-vertical font-12"></i>
                </div>
                <div class="phone-body">
                    <div class="screen-content">
                        <div class="ui-card" style="padding:6px;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div style="font-size:8px; color:#64748b;">Trip ID</div>
                                    <div style="font-size:9px; font-weight:800;">TRP-2025-05-24-01</div>
                                    <div style="font-size:8px; color:#64748b;">6:00 AM - 11:00 AM</div>
                                </div>
                                <span class="ui-badge-success">In Progress</span>
                            </div>
                            <div class="d-flex justify-content-between border-top mt-1 pt-1" style="font-size:8px; font-weight:700;">
                                <span>35 Stops • 8.7 km</span>
                                <span style="color:var(--primary-green);">View List</span>
                            </div>
                        </div>

                        <!-- Stylized Map Vector -->
                        <div style="background:#e2e8f0; border-radius:10px; flex:1; position:relative; overflow:hidden; border:1px solid #cbd5e1; min-height:180px;">
                            <svg viewBox="0 0 200 180" width="100%" height="100%">
                                <path d="M0 40 H200 M0 90 H200 M0 140 H200" stroke="#cbd5e1" stroke-width="4"/>
                                <path d="M40 0 V180 M90 0 V180 M140 0 V180 M180 0 V180" stroke="#cbd5e1" stroke-width="4"/>
                                
                                <path d="M 40 140 L 90 140 L 90 90 L 140 90 L 140 40 L 180 40" 
                                      stroke="#0e7a43" stroke-width="3" fill="none" stroke-dasharray="4 2"/>

                                <circle cx="40" cy="140" r="8" fill="#2563eb"/>
                                <circle cx="40" cy="140" r="3" fill="#ffffff"/>

                                <circle cx="90" cy="140" r="7" fill="#0e7a43"/>
                                <text x="90" y="143" fill="#fff" font-size="7" text-anchor="middle" font-weight="bold">2</text>

                                <circle cx="90" cy="90" r="9" fill="#0e7a43"/>
                                <text x="90" y="93" fill="#fff" font-size="8" text-anchor="middle" font-weight="bold">3</text>

                                <circle cx="140" cy="90" r="7" fill="#0e7a43"/>
                                <text x="140" y="93" fill="#fff" font-size="7" text-anchor="middle" font-weight="bold">4</text>

                                <circle cx="140" cy="40" r="7" fill="#0e7a43"/>
                                <text x="140" y="43" fill="#fff" font-size="7" text-anchor="middle" font-weight="bold">5</text>
                            </svg>
                        </div>

                        <div class="ui-btn-primary" style="margin-top:auto; font-size:10px; padding:7px;">Start Navigation</div>
                    </div>
                    <div class="ui-bottom-nav">
                        <div><i class="fa-solid fa-house"></i>Home</div>
                        <div><i class="fa-solid fa-truck"></i>Trips</div>
                        <div class="active"><i class="fa-solid fa-map-location-dot"></i>Map</div>
                        <div><i class="fa-solid fa-user"></i>Profile</div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Screen 4: Stop Details -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">4</span>
                <span>Stop Details</span>
            </div>
            <a href="{{ route('driver.stop_details') }}" class="phone-frame">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="screen-header">
                    <h2><i class="fa-solid fa-arrow-left font-11"></i> Stop Details</h2>
                    <i class="fa-solid fa-bars font-12"></i>
                </div>
                <div class="phone-body">
                    <div class="screen-content">
                        <div style="display:flex; justify-content:space-between; background:#fff; padding:4px 8px; border-radius:6px; font-size:9px; font-weight:700; color:#334155; border:1px solid #f1f5f9;">
                            <span>←</span><span>Stop 7 of 35</span><span>→</span>
                        </div>

                        <div class="ui-card">
                            <div style="font-size:11px; font-weight:800; color:#0f172a;">RWA Green Heights</div>
                            <div style="font-size:8px; color:#64748b; margin-bottom:4px;">12th Cross, BTM Layout 2nd Stage, Bengaluru - 560076</div>
                            <span class="ui-badge-success">C&D Waste</span>

                            <div style="margin-top:6px; font-size:8px; color:#334155;">
                                <strong style="color:#0f172a;">Instructions:</strong>
                                <ul style="margin:2px 0 0 12px; padding:0; color:#475569;">
                                    <li>Collect waste and update photo</li>
                                    <li>Ensure safe loading</li>
                                </ul>
                            </div>

                            <div class="border-top mt-2 pt-1" style="font-size:8px;">
                                <div style="color:#64748b;">Waste Type</div>
                                <div style="font-weight:700; color:#0f172a;">C&D Debris</div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-2 pt-1 border-top">
                                <div>
                                    <div style="font-size:7px; color:#64748b;">Contact Person</div>
                                    <div style="font-size:9px; font-weight:700; color:#0f172a;">Ramesh Babu</div>
                                    <div style="font-size:8px; color:#64748b;">98765 12345</div>
                                </div>
                                <div style="width:24px; height:24px; background:#e6f4ea; color:var(--primary-green); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:10px;">
                                    <i class="fa-solid fa-phone"></i>
                                </div>
                            </div>
                        </div>

                        <div class="ui-btn-primary" style="margin-top:auto; font-size:10px; padding:7px;">Arrived at Location</div>
                    </div>
                    <div class="ui-bottom-nav">
                        <div><i class="fa-solid fa-house"></i>Home</div>
                        <div class="active"><i class="fa-solid fa-truck"></i>Trips</div>
                        <div><i class="fa-solid fa-map-location-dot"></i>Map</div>
                        <div><i class="fa-solid fa-user"></i>Profile</div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Screen 5: Collect Waste (Before/After Photo) -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">5</span>
                <span>Collect Waste (Photos)</span>
            </div>
            <a href="{{ route('driver.collect_waste') }}" class="phone-frame">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="screen-header">
                    <h2><i class="fa-solid fa-arrow-left font-11"></i> Collect Waste</h2>
                    <i class="fa-solid fa-ellipsis-vertical font-12"></i>
                </div>
                <div class="phone-body">
                    <div class="screen-content">
                        <!-- Before Collection Photo Box -->
                        <div class="ui-card" style="padding:6px;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div style="font-size:8px; font-weight:700; color:#0f172a;">Before Collection</div>
                                <i class="fa-solid fa-camera" style="font-size:10px; color:#64748b;"></i>
                            </div>
                            <div style="height:65px; border-radius:6px; overflow:hidden; background:#cbd5e1; position:relative;">
                                <svg viewBox="0 0 200 65" width="100%" height="100%">
                                    <rect width="200" height="65" fill="#64748b"/>
                                    <path d="M20 65 L60 30 L110 50 L160 20 L200 65 Z" fill="#475569"/>
                                    <text x="100" y="36" fill="#ffffff" font-size="8" font-weight="bold" text-anchor="middle">RUBBLE / DEBRIS PHOTO</text>
                                </svg>
                            </div>
                        </div>

                        <!-- After Collection Photo Box -->
                        <div class="ui-card" style="padding:6px;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div style="font-size:8px; font-weight:700; color:#0f172a;">After Collection</div>
                                <i class="fa-solid fa-camera" style="font-size:10px; color:#64748b;"></i>
                            </div>
                            <div style="height:65px; border-radius:6px; overflow:hidden; background:#e2e8f0; position:relative;">
                                <svg viewBox="0 0 200 65" width="100%" height="100%">
                                    <rect width="200" height="65" fill="#e2e8f0"/>
                                    <line x1="0" y1="45" x2="200" y2="45" stroke="#cbd5e1" stroke-width="3"/>
                                    <text x="100" y="32" fill="#0e7a43" font-size="8" font-weight="bold" text-anchor="middle">CLEAN SITE PHOTO</text>
                                </svg>
                            </div>
                        </div>

                        <!-- Waste Weight Field -->
                        <div class="ui-card" style="padding:6px;">
                            <div style="font-size:8px; font-weight:700; color:#334155; margin-bottom:2px;">Waste Weight (Approx.)</div>
                            <div style="display:flex; border:1px solid #cbd5e1; border-radius:6px; overflow:hidden; background:#ffffff;">
                                <div style="padding:4px 8px; font-size:10px; font-weight:800; color:#0f172a; flex:1;">850</div>
                                <div style="background:#f8fafc; border-left:1px solid #cbd5e1; padding:4px 8px; font-size:8px; font-weight:700; color:#475569;">kg v</div>
                            </div>
                        </div>

                        <div class="ui-btn-primary" style="margin-top:auto; font-size:10px; padding:7px;">Confirm Collection</div>
                    </div>
                    <div class="ui-bottom-nav">
                        <div><i class="fa-solid fa-house"></i>Home</div>
                        <div class="active"><i class="fa-solid fa-truck"></i>Trips</div>
                        <div><i class="fa-solid fa-map-location-dot"></i>Map</div>
                        <div><i class="fa-solid fa-user"></i>Profile</div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Screen 6: Update Status -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">6</span>
                <span>Update Status</span>
            </div>
            <a href="{{ route('driver.update_status') }}" class="phone-frame">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="screen-header">
                    <h2><i class="fa-solid fa-arrow-left font-11"></i> Update Status</h2>
                    <i class="fa-solid fa-ellipsis-vertical font-12"></i>
                </div>
                <div class="phone-body text-center" style="padding:10px;">
                    <div style="width:52px; height:52px; background:var(--primary-green); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:24px; margin:16px auto 8px; box-shadow:0 0 0 6px rgba(14,122,67,0.15);">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div style="font-size:12px; font-weight:800; color:var(--primary-green);">Collection Completed!</div>
                    <div style="font-size:8px; color:#64748b; margin-top:2px;">You have successfully completed Stop 7 of 35.</div>

                    <div style="text-align:left; margin-top:14px; font-size:9px; font-weight:700; color:#334155;">Remarks (Optional)</div>
                    <div style="height:45px; background:#ffffff; border:1px solid #cbd5e1; border-radius:6px; margin-top:3px; padding:4px 6px; font-size:8px; color:#94a3b8; text-align:left;">
                        Write remarks...
                    </div>

                    <div class="ui-btn-primary" style="margin-top:auto; font-size:10px; padding:7px;">Next Stop</div>
                </div>
            </a>
        </div>

        <!-- Screen 7: Trip Progress -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">7</span>
                <span>Trip Progress</span>
            </div>
            <a href="{{ route('driver.trip_progress') }}" class="phone-frame">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="screen-header">
                    <h2><i class="fa-solid fa-arrow-left font-11"></i> Trip Progress</h2>
                    <i class="fa-solid fa-ellipsis-vertical font-12"></i>
                </div>
                <div class="phone-body">
                    <div class="screen-content">
                        <div class="ui-card" style="padding:6px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div style="font-size:7px; color:#64748b;">Trip ID</div>
                                    <div style="font-size:9px; font-weight:800;">TRP-2025-05-24-01</div>
                                    <div style="font-size:7px; color:#64748b;">6:00 AM - 11:00 AM</div>
                                </div>
                                <span class="ui-badge-success">In Progress</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-2" style="font-size:8px; font-weight:700;">
                                <span>17 / 35 Stops Completed</span>
                                <span style="color:var(--primary-green);">48%</span>
                            </div>
                            <div style="background:#e2e8f0; height:5px; border-radius:4px; margin-top:3px; overflow:hidden;">
                                <div style="width:48%; background:var(--primary-green); height:100%;"></div>
                            </div>
                        </div>

                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:6px;">
                            <div class="ui-card text-center" style="padding:6px;">
                                <div style="font-size:14px; font-weight:800; color:#0f172a;">17</div>
                                <div style="font-size:8px; color:#64748b;">Completed</div>
                            </div>
                            <div class="ui-card text-center" style="padding:6px;">
                                <div style="font-size:14px; font-weight:800; color:#0f172a;">12</div>
                                <div style="font-size:8px; color:#64748b;">Remaining</div>
                            </div>
                            <div class="ui-card text-center" style="padding:6px;">
                                <div style="font-size:14px; font-weight:800; color:#0f172a;">1.1 Ton</div>
                                <div style="font-size:8px; color:#64748b;">Waste Collected</div>
                            </div>
                            <div class="ui-card text-center" style="padding:6px;">
                                <div style="font-size:14px; font-weight:800; color:#0f172a;">6.2 km</div>
                                <div style="font-size:8px; color:#64748b;">Distance Covered</div>
                            </div>
                        </div>

                        <div class="ui-btn-primary" style="margin-top:auto; font-size:10px; padding:7px;">End Trip</div>
                    </div>
                    <div class="ui-bottom-nav">
                        <div><i class="fa-solid fa-house"></i>Home</div>
                        <div class="active"><i class="fa-solid fa-truck"></i>Trips</div>
                        <div><i class="fa-solid fa-map-location-dot"></i>Map</div>
                        <div><i class="fa-solid fa-user"></i>Profile</div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Screen 8: End Trip Summary -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">8</span>
                <span>End Trip Summary</span>
            </div>
            <a href="{{ route('driver.trip_summary') }}" class="phone-frame">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="screen-header">
                    <h2><i class="fa-solid fa-arrow-left font-11"></i> Trip Summary</h2>
                    <i class="fa-solid fa-bars font-12"></i>
                </div>
                <div class="phone-body text-center" style="padding:10px;">
                    <div style="width:42px; height:42px; background:var(--primary-green); color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:20px; margin:8px auto 4px;">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <div style="font-size:12px; font-weight:800; color:var(--primary-green);">Trip Completed!</div>
                    <div style="font-size:8px; color:#64748b; margin-bottom:8px;">Great job! You have completed all stops for this trip.</div>

                    <div class="ui-card" style="text-align:left; font-size:8px; padding:6px;">
                        <div class="d-flex justify-content-between py-1 border-bottom"><span>Trip ID</span><strong>TRP-2025-05-24-01</strong></div>
                        <div class="d-flex justify-content-between py-1 border-bottom"><span>Total Stops</span><strong>35</strong></div>
                        <div class="d-flex justify-content-between py-1 border-bottom"><span>Completed</span><strong>35</strong></div>
                        <div class="d-flex justify-content-between py-1 border-bottom"><span>Waste Collected</span><strong>2.4 Ton</strong></div>
                        <div class="d-flex justify-content-between py-1 border-bottom"><span>Distance Covered</span><strong>11.8 km</strong></div>
                        <div class="d-flex justify-content-between py-1"><span>Time Taken</span><strong>4h 15m</strong></div>
                    </div>

                    <div class="ui-btn-primary" style="margin-top:auto; font-size:10px; padding:7px;">Submit Summary</div>
                </div>
            </a>
        </div>

        <!-- Screen 9: Live Updates / Notifications -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">9</span>
                <span>Live Updates / Alerts</span>
            </div>
            <a href="{{ route('driver.notifications') }}" class="phone-frame">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="screen-header">
                    <h2><i class="fa-solid fa-arrow-left font-11"></i> Notifications</h2>
                    <i class="fa-solid fa-ellipsis-vertical font-12"></i>
                </div>
                <div class="phone-body">
                    <div class="screen-content">
                        <div style="display:flex; gap:3px;">
                            <span class="ui-badge-success" style="font-size:8px;">All</span>
                            <span style="background:#e2e8f0; color:#475569; padding:2px 5px; border-radius:10px; font-size:8px; font-weight:600;">Trips</span>
                            <span style="background:#e2e8f0; color:#475569; padding:2px 5px; border-radius:10px; font-size:8px; font-weight:600;">Alerts</span>
                            <span style="background:#e2e8f0; color:#475569; padding:2px 5px; border-radius:10px; font-size:8px; font-weight:600;">System</span>
                        </div>

                        <div style="font-size:8px; font-weight:800; color:#94a3b8; margin-top:2px;">TODAY</div>

                        <div class="ui-card" style="padding:5px; display:flex; gap:6px; align-items:center;">
                            <div style="width:20px; height:20px; background:#e6f4ea; border-radius:4px; display:flex; align-items:center; justify-content:center; color:var(--primary-green); font-size:9px;">
                                <i class="fa-solid fa-truck"></i>
                            </div>
                            <div>
                                <div style="font-size:9px; font-weight:800; color:#0f172a;">New Trip Assigned</div>
                                <div style="font-size:7px; color:#64748b;">Trip TRP-2025-05-24-02 assigned</div>
                            </div>
                        </div>

                        <div class="ui-card" style="padding:5px; display:flex; gap:6px; align-items:center;">
                            <div style="width:20px; height:20px; background:#e0f2fe; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#0284c7; font-size:9px;">
                                <i class="fa-solid fa-map"></i>
                            </div>
                            <div>
                                <div style="font-size:9px; font-weight:800; color:#0f172a;">Route Updated</div>
                                <div style="font-size:7px; color:#64748b;">Route TRP-2025-05-24-02 updated</div>
                            </div>
                        </div>

                        <div class="ui-card" style="padding:5px; display:flex; gap:6px; align-items:center;">
                            <div style="width:20px; height:20px; background:#fef3c7; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#d97706; font-size:9px;">
                                <i class="fa-solid fa-wrench"></i>
                            </div>
                            <div>
                                <div style="font-size:9px; font-weight:800; color:#0f172a;">Maintenance Alert</div>
                                <div style="font-size:7px; color:#64748b;">Vehicle service due 26 May</div>
                            </div>
                        </div>

                        <div style="font-size:8px; font-weight:800; color:#94a3b8; margin-top:2px;">YESTERDAY</div>

                        <div class="ui-card" style="padding:5px; display:flex; gap:6px; align-items:center;">
                            <div style="width:20px; height:20px; background:#e6f4ea; border-radius:4px; display:flex; align-items:center; justify-content:center; color:var(--primary-green); font-size:9px;">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div>
                                <div style="font-size:9px; font-weight:800; color:#0f172a;">Trip Completed</div>
                                <div style="font-size:7px; color:#64748b;">Trip TRP-2025-05-23-02 completed</div>
                            </div>
                        </div>

                    </div>
                    <div class="ui-bottom-nav">
                        <div><i class="fa-solid fa-house"></i>Home</div>
                        <div><i class="fa-solid fa-truck"></i>Trips</div>
                        <div><i class="fa-solid fa-map-location-dot"></i>Map</div>
                        <div><i class="fa-solid fa-user"></i>Profile</div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Screen 10: Profile & Settings -->
        <div class="screen-card-wrapper">
            <div class="screen-label">
                <span class="screen-badge">10</span>
                <span>Profile & Settings</span>
            </div>
            <a href="{{ route('driver.profile_settings') }}" class="phone-frame">
                <div class="phone-status-bar">
                    <span>9:41</span>
                    <div class="icons"><i class="fa-solid fa-wifi"></i><i class="fa-solid fa-battery-full"></i></div>
                </div>
                <div class="screen-header">
                    <h2><i class="fa-solid fa-arrow-left font-11"></i> Profile</h2>
                    <i class="fa-solid fa-bars font-12"></i>
                </div>
                <div class="phone-body">
                    <div class="screen-content">
                        <div class="ui-card text-center" style="padding:8px;">
                            <div style="width:36px; height:36px; border-radius:50%; background:#e6f4ea; margin:0 auto 3px; display:flex; align-items:center; justify-content:center; color:var(--primary-green); font-size:14px;">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <div style="font-size:10px; font-weight:800; color:#0f172a;">Mahesh Kumar</div>
                            <div style="font-size:7px; color:#64748b;">Driver ID: DRV1024</div>
                            <div style="font-size:7px; color:#64748b;">98765 43210</div>
                            <span class="ui-badge-success mt-1 d-inline-block">● Online</span>
                        </div>

                        <div class="ui-card" style="padding:0; font-size:9px; font-weight:600;">
                            <div class="d-flex justify-content-between align-items-center" style="padding:6px 8px; border-bottom:1px solid #f1f5f9;">
                                <span><i class="fa-solid fa-user me-1 text-muted"></i> My Profile</span>
                                <i class="fa-solid fa-chevron-right text-muted font-8"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center" style="padding:6px 8px; border-bottom:1px solid #f1f5f9;">
                                <span><i class="fa-solid fa-truck me-1 text-muted"></i> Vehicle Details</span>
                                <span style="font-size:7px; color:#64748b;">KA01AB1234 ></span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center" style="padding:6px 8px; border-bottom:1px solid #f1f5f9;">
                                <span><i class="fa-solid fa-file-lines me-1 text-muted"></i> Documents</span>
                                <i class="fa-solid fa-chevron-right text-muted font-8"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center" style="padding:6px 8px; border-bottom:1px solid #f1f5f9;">
                                <span><i class="fa-solid fa-headset me-1 text-muted"></i> Help & Support</span>
                                <i class="fa-solid fa-chevron-right text-muted font-8"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center" style="padding:6px 8px; border-bottom:1px solid #f1f5f9;">
                                <span><i class="fa-solid fa-gear me-1 text-muted"></i> Settings</span>
                                <i class="fa-solid fa-chevron-right text-muted font-8"></i>
                            </div>
                            <div class="d-flex justify-content-between align-items-center" style="padding:6px 8px; color:#dc2626;">
                                <span><i class="fa-solid fa-right-from-bracket me-1"></i> Logout</span>
                                <i class="fa-solid fa-chevron-right font-8"></i>
                            </div>
                        </div>
                    </div>
                    <div class="ui-bottom-nav">
                        <div><i class="fa-solid fa-house"></i>Home</div>
                        <div><i class="fa-solid fa-truck"></i>Trips</div>
                        <div><i class="fa-solid fa-map-location-dot"></i>Map</div>
                        <div class="active"><i class="fa-solid fa-user"></i>Profile</div>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <!-- Side Information Section (Key Features & Benefits) matching prompt image bottom cards -->
    <div class="info-sidebar-container">

        <!-- Key Features Card -->
        <div class="features-card">
            <h3><i class="fa-solid fa-circle-check"></i> Key Features for Drivers</h3>
            <ul class="features-list">
                <li><i class="fa-solid fa-check"></i> Easy Login & Verification</li>
                <li><i class="fa-solid fa-check"></i> View Daily Trips & Routes</li>
                <li><i class="fa-solid fa-check"></i> Real-time Navigation</li>
                <li><i class="fa-solid fa-check"></i> Stop-wise Collection</li>
                <li><i class="fa-solid fa-check"></i> Photo Capture (Before/After)</li>
                <li><i class="fa-solid fa-check"></i> Update Collection Status</li>
                <li><i class="fa-solid fa-check"></i> Trip Summary & Reports</li>
                <li><i class="fa-solid fa-check"></i> Live Notifications</li>
                <li><i class="fa-solid fa-check"></i> Profile & Vehicle Management</li>
            </ul>
        </div>

        <!-- Benefits Card -->
        <div class="benefits-card">
            <h3>Benefits</h3>
            <div class="benefits-grid">
                <div class="benefit-item">
                    <i class="fa-solid fa-stopwatch"></i>
                    <span>Faster Collections</span>
                </div>
                <div class="benefit-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Real-time Tracking</span>
                </div>
                <div class="benefit-item">
                    <i class="fa-solid fa-file-invoice"></i>
                    <span>Transparent Process</span>
                </div>
                <div class="benefit-item">
                    <i class="fa-solid fa-leaf"></i>
                    <span>Clean Bengaluru</span>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
