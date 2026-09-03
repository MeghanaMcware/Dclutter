<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Driver Login - {{ env('APP_NAME', 'DCLUTTER') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('frontendwebsite/img/GBA-removebg-preview.png') }}">

    <style>
        :root {
            --primary-green: #0e7a43;
            --primary-green-dark: #095930;
            --primary-green-light: #e8f5e9;
            --accent-green: #10b981;
            --text-main: #1f2937;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
            --bg-canvas: #f8fafc;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-canvas);
            color: var(--text-main);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        /* Top App Header Banner */
        .brand-top-banner {
            background-color: #ffffff;
            border-bottom: 1px solid #edf2f7;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        .brand-logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon-box {
            width: 44px;
            height: 44px;
            background: #e6f4ea;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-icon-box svg {
            width: 28px;
            height: 28px;
        }

        .brand-title-text h1 {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary-green);
            margin: 0;
            line-height: 1.1;
            letter-spacing: 0.5px;
        }

        .brand-title-text p {
            font-size: 11px;
            color: #64748b;
            margin: 2px 0 0 0;
            font-weight: 500;
        }

        /* Main Container */
        .login-wrapper {
            max-width: 420px;
            margin: 0 auto;
            padding: 16px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.08), 0 4px 12px -2px rgba(0, 0, 0, 0.04);
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }

        /* Welcome Section */
        .welcome-header {
            text-align: center;
            padding: 12px 24px 8px;
        }

        .welcome-header h2 {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .welcome-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin: 0;
        }

        /* Hero Vector Graphic Container */
        .illustration-container {
            width: 100%;
            padding: 10px 20px;
            text-align: center;
            background: linear-gradient(180deg, rgba(232, 245, 233, 0.4) 0%, rgba(255,255,255,1) 100%);
        }

        .illustration-container svg {
            width: 100%;
            max-height: 155px;
            height: auto;
        }

        /* Form Area */
        .form-area {
            padding: 16px 24px 24px;
        }

        .field-label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .input-group-custom:focus-within {
            border-color: var(--primary-green);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(14, 122, 67, 0.15);
        }

        .prefix-badge {
            padding: 0 12px 0 14px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 6px;
            border-right: 1px solid #e2e8f0;
            height: 48px;
            background: #f1f5f9;
        }

        .input-group-custom input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            height: 48px;
            padding: 0 14px;
            font-size: 15px;
            font-weight: 500;
            color: #0f172a;
        }

        .input-group-custom input::placeholder {
            color: #94a3b8;
        }

        .input-icon-left {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 14px;
        }

        .input-with-icon {
            padding-left: 40px !important;
        }

        .password-toggle-btn {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px;
            font-size: 15px;
        }

        .password-toggle-btn:hover {
            color: var(--primary-green);
        }

        /* Buttons */
        .btn-submit-primary {
            width: 100%;
            height: 48px;
            background: var(--primary-green);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(14, 122, 67, 0.25);
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .btn-submit-primary:hover, .btn-submit-primary:focus {
            background: var(--primary-green-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(14, 122, 67, 0.35);
        }

        .btn-submit-primary:active {
            transform: translateY(0);
        }

        /* Divider */
        .divider-or {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 18px 0;
            color: #94a3b8;
            font-size: 12px;
            font-weight: 500;
        }

        .divider-or::before, .divider-or::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider-or span {
            padding: 0 12px;
        }

        /* Secondary Employee Button */
        .btn-secondary-emp {
            width: 100%;
            height: 46px;
            background: #ffffff;
            color: #334155;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-secondary-emp:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
        }

        /* Footer Terms */
        .terms-footer-text {
            margin-top: 22px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
        }

        .terms-footer-text a {
            color: var(--primary-green);
            text-decoration: none;
            font-weight: 600;
        }

        .terms-footer-text a:hover {
            text-decoration: underline;
        }

        /* Page Loader Overlay */
        #pageLoader {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(14, 122, 67, 0.92);
            z-index: 99999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            backdrop-filter: blur(4px);
        }

        #pageLoader.active {
            display: flex;
        }

        #pageLoader .spin {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(255, 255, 255, 0.25);
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        #pageLoader p {
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            margin: 0;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .mode-panel {
            display: block;
        }

        .mode-panel.hidden {
            display: none;
        }
    </style>
</head>

<body>

    <!-- Full Screen Loader -->
    <div id="pageLoader">
        <div class="spin"></div>
        <p>Logging into Driver Portal…</p>
    </div>

   

    <div class="login-wrapper">

        <div class="login-card">

            <!-- Header Welcome Title -->
            <div class="welcome-header">
                <h2>DCLUTTER - Driver Portal</h2>
                <p>Login to continue your Credentials</p>
            </div>

            <!-- Vector Graphic: Green Waste Truck & Collection Workers with City Skyline -->
            <div class="illustration-container">
                <svg viewBox="0 0 360 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- City Skyline Silhouette -->
                    <path d="M0 130H360V140H0V130Z" fill="#e2e8f0"/>
                    <path d="M20 130V90H35V130H20Z" fill="#cbd5e1" opacity="0.6"/>
                    <path d="M30 130V75H50V130H30Z" fill="#cbd5e1" opacity="0.4"/>
                    <path d="M55 130V100H70V130H55Z" fill="#cbd5e1" opacity="0.5"/>
                    <path d="M120 130V70H145V130H120Z" fill="#cbd5e1" opacity="0.5"/>
                    <path d="M140 130V50H170V130H140Z" fill="#cbd5e1" opacity="0.3"/>
                    <path d="M180 130V80H205V130H180Z" fill="#cbd5e1" opacity="0.4"/>
                    <path d="M290 130V65H320V130H290Z" fill="#cbd5e1" opacity="0.5"/>
                    <path d="M315 130V85H340V130H315Z" fill="#cbd5e1" opacity="0.6"/>

                    <!-- Clouds -->
                    <ellipse cx="60" cy="40" rx="20" ry="8" fill="#e2e8f0" opacity="0.6"/>
                    <ellipse cx="280" cy="35" rx="25" ry="10" fill="#e2e8f0" opacity="0.6"/>

                    <!-- Waste Bins / Containers on Left -->
                    <rect x="22" y="105" width="16" height="25" rx="3" fill="#0e7a43"/>
                    <path d="M20 103H40V107H20V103Z" fill="#095930"/>
                    <circle cx="30" cy="117" r="4" stroke="#ffffff" stroke-width="1.5" stroke-dasharray="2 2" fill="none"/>
                    
                    <rect x="42" y="110" width="14" height="20" rx="2" fill="#64748b"/>
                    <path d="M40 108H58V111H40V108Z" fill="#475569"/>

                    <!-- Worker 1 (Left of Truck) -->
                    <circle cx="80" cy="98" r="6" fill="#f87171"/> <!-- Head/Skin -->
                    <rect x="74" y="105" width="12" height="15" rx="3" fill="#0e7a43"/> <!-- Uniform -->
                    <path d="M74 108H86V112H74V108Z" fill="#facc15"/> <!-- Hi-Vis Vest Strip -->
                    <rect x="76" y="120" width="4" height="10" fill="#1e293b"/> <!-- Pants L -->
                    <rect x="80" y="120" width="4" height="10" fill="#1e293b"/> <!-- Pants R -->

                    <!-- Waste Collection Truck (Center Main) -->
                    <!-- Truck Body Rear / Compactor Box -->
                    <rect x="105" y="70" width="115" height="55" rx="6" fill="#0e7a43"/>
                    <path d="M105 70L125 55H210V70H105Z" fill="#0e7a43"/>
                    <!-- White Accent Stripes -->
                    <path d="M115 80H210" stroke="#ffffff" stroke-width="3" stroke-linecap="round" opacity="0.8"/>
                    <path d="M115 92H185" stroke="#ffffff" stroke-width="2" stroke-linecap="round" opacity="0.6"/>
                    <circle cx="160" cy="105" r="10" fill="#ffffff" opacity="0.2"/>

                    <!-- Truck Cab (Front Right) -->
                    <path d="M220 85H245C252 85 258 91 258 98V125H220V85Z" fill="#095930"/>
                    <path d="M230 92H252V105H230V92Z" fill="#bae6fd"/> <!-- Windshield Window -->
                    <rect x="220" y="112" width="12" height="4" fill="#facc15"/> <!-- Side Light -->

                    <!-- Wheels -->
                    <circle cx="130" cy="125" r="12" fill="#1e293b"/>
                    <circle cx="130" cy="125" r="5" fill="#94a3b8"/>
                    <circle cx="170" cy="125" r="12" fill="#1e293b"/>
                    <circle cx="170" cy="125" r="5" fill="#94a3b8"/>
                    <circle cx="238" cy="125" r="12" fill="#1e293b"/>
                    <circle cx="238" cy="125" r="5" fill="#94a3b8"/>

                    <!-- Worker 2 (Right of Truck) -->
                    <circle cx="275" cy="98" r="6" fill="#f87171"/>
                    <rect x="269" y="105" width="12" height="15" rx="3" fill="#0e7a43"/>
                    <path d="M269 108H281V112H269V108Z" fill="#facc15"/>
                    <rect x="271" y="120" width="4" height="10" fill="#1e293b"/>
                    <rect x="275" y="120" width="4" height="10" fill="#1e293b"/>

                    <!-- Worker 3 / Driver with Trash Bin -->
                    <circle cx="300" cy="100" r="6" fill="#f87171"/>
                    <rect x="294" y="107" width="12" height="13" rx="3" fill="#0e7a43"/>
                    <rect x="296" y="120" width="3" height="10" fill="#1e293b"/>
                    <rect x="301" y="120" width="3" height="10" fill="#1e293b"/>
                    <rect x="308" y="110" width="12" height="20" rx="2" fill="#0e7a43"/>

                    <!-- Ground Line -->
                    <line x1="10" y1="130" x2="350" y2="130" stroke="#cbd5e1" stroke-width="2"/>
                </svg>
            </div>

            <!-- Form Content -->
            <div class="form-area">

              

                <form method="POST" action="{{ route('vehicle.login.submit') }}" id="loginForm" onsubmit="event.preventDefault(); window.location.href='{{ route('vehicle.dashboard') }}';">
                

                    <!-- Mobile Login Mode -->
                    <div id="mobileModePanel" class="mode-panel">
                        <label class="field-label">Mobile Number</label>
                        <div class="input-group-custom">
                            <div class="prefix-badge">
                                <i class="fa-solid fa-phone color-green-dark" style="color: var(--primary-green);"></i>
                                <span>+91</span>
                            </div>
                            <input type="tel" 
                                   id="mobileInput" 
                                   name="mobile" 
                                   placeholder="+91 98765 43210" 
                                   maxlength="10" 
                                   pattern="[0-9]{10}"
                                   required>
                        </div>

                        <!-- Password Field -->
                        <div class="mt-3">
                            <label class="field-label">Password</label>
                            <div class="input-group-custom position-relative">
                                <i class="fa-solid fa-lock input-icon-left"></i>
                                <input type="password" 
                                       id="passwordInput" 
                                       name="password" 
                                       class="input-with-icon" 
                                       placeholder="Enter your password" 
                                       required>
                                <button type="button" class="password-toggle-btn" onclick="togglePassword('passwordInput', this)">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit-primary" id="btnSubmitMobile">
                            <span>Submit</span>
                            <i class="fa-solid fa-arrow-right font-12"></i>
                        </button>
                    </div>

                    <!-- Employee ID Login Mode (Toggled) -->
                    <div id="empModePanel" class="mode-panel hidden">
                        <label class="field-label">Employee / Driver ID</label>
                        <div class="input-group-custom position-relative mb-3">
                            <i class="fa-solid fa-id-card input-icon-left"></i>
                            <input type="text" 
                                   id="empIdInput" 
                                   name="employee_id" 
                                   class="input-with-icon" 
                                   placeholder="e.g. DRV1024">
                        </div>

                        <label class="field-label">Password</label>
                        <div class="input-group-custom position-relative">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" 
                                   id="empPasswordInput" 
                                   name="password_emp" 
                                   class="input-with-icon" 
                                   placeholder="Enter your password">
                            <button type="button" class="password-toggle-btn" onclick="togglePassword('empPasswordInput', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        <button type="submit" class="btn-submit-primary" id="btnSubmitEmp">
                            <span>Login with Employee ID</span>
                            <i class="fa-solid fa-right-to-bracket font-12"></i>
                        </button>
                    </div>

                </form>

                <!-- Divider -->
                <!-- <div class="divider-or">
                    <span>or</span>
                </div> -->

                <!-- Secondary Button Toggle -->
                <!-- <button type="button" class="btn-secondary-emp" id="btnToggleLoginMode" onclick="toggleLoginMode()">
                    <i class="fa-solid fa-id-badge" style="color: var(--primary-green);"></i>
                    <span id="toggleBtnText">Login with Employee ID</span>
                </button> -->

                <!-- Footer Terms -->
                <div class="terms-footer-text">
                    By continuing, you agree to the<br>
                    <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
                </div>

            </div>

        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let currentMode = 'mobile';

        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function toggleLoginMode() {
            const mobilePanel = document.getElementById('mobileModePanel');
            const empPanel = document.getElementById('empModePanel');
            const toggleText = document.getElementById('toggleBtnText');

            const mobileInput = document.getElementById('mobileInput');
            const passwordInput = document.getElementById('passwordInput');
            const empIdInput = document.getElementById('empIdInput');
            const empPasswordInput = document.getElementById('empPasswordInput');

            if (currentMode === 'mobile') {
                currentMode = 'emp';
                mobilePanel.classList.add('hidden');
                empPanel.classList.remove('hidden');

                // Update input requirements
                mobileInput.removeAttribute('required');
                passwordInput.removeAttribute('required');
                empIdInput.setAttribute('required', 'required');
                empPasswordInput.setAttribute('required', 'required');

                // Change name attributes so backend handles appropriately
                mobileInput.name = "mobile_disabled";
                passwordInput.name = "password_disabled";
                empIdInput.name = "mobile"; // Map employee ID or mobile to primary login field
                empPasswordInput.name = "password";

                toggleText.innerText = "Login with Mobile Number";
            } else {
                currentMode = 'mobile';
                empPanel.classList.add('hidden');
                mobilePanel.classList.remove('hidden');

                empIdInput.removeAttribute('required');
                empPasswordInput.removeAttribute('required');
                mobileInput.setAttribute('required', 'required');
                passwordInput.setAttribute('required', 'required');

                mobileInput.name = "mobile";
                passwordInput.name = "password";
                empIdInput.name = "employee_id_disabled";
                empPasswordInput.name = "password_emp_disabled";

                toggleText.innerText = "Login with Employee ID";
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function () {
            document.getElementById('pageLoader').classList.add('active');
        });
    </script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
            confirmButtonColor: '#0e7a43'
        });
    </script>
    @endif

</body>
</html>

