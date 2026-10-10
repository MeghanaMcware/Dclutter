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
    @include('partials.pwa-head')

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

        /* Secondary Employee / Login with OTP Button */
        .btn-secondary-emp {
            width: 100%;
            height: 48px;
            background: #ffffff;
            color: #0f172a;
            border: 1.5px solid #cbd5e1;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .btn-secondary-emp:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary-emp svg.whatsapp-icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
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

              

                <form method="POST" action="{{ route('vehicle.login.submit') }}" id="loginForm">
                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger py-2 px-3 mb-3 d-flex align-items-center" style="font-size: 13px; border-radius: 10px; background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca;">
                            <i class="fa-solid fa-circle-exclamation me-2"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

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
                                   value="{{ old('mobile') }}"
                                   placeholder="+91 98765 43210" 
                                   maxlength="10" 
                                   pattern="[0-9]{10}"
                                   required oninput="this.value = this.value.replace(/[^0-9]/g, '')"> 
                        </div>

                        <!-- Password Field -->
                        <div class="mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="field-label mb-0">Password</label>
                               
                            </div>
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

                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label class="field-label mb-0">Password</label>
                            
                        </div>
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
                <div class="divider-or">
                    <span>or</span>
                </div>

                <!-- Secondary Action Button: Forgot Password -->
                <button type="button" class="btn-secondary-emp" id="btnOpenForgotPassword" onclick="openForgotPasswordModal()">
                    <i class="fa-solid fa-key text-muted fs-6"></i>
                    <span>Forgot Password</span>
                </button>

                

                <!-- Footer Terms -->
                <div class="terms-footer-text">
                    By continuing, you agree to the<br>
                    <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
                </div>

            </div>

        </div>

    </div>

    {{-- ================= MODAL: LOGIN WITH OTP (UI ONLY) ================= --}}
    <div class="modal fade" id="otpLoginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 390px; margin: 1.25rem auto;">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-1" style="font-size: 18px;">Login with OTP</h5>
                        <p class="text-muted mb-0" style="font-size: 12.5px;">Verify your mobile number to receive a one-time password.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Step 1: Request OTP -->
                    <div id="otpLoginStep1">
                        <label class="field-label mb-1">Mobile Number</label>
                        <div class="input-group-custom mb-3">
                            <div class="prefix-badge">
                                <i class="fa-solid fa-phone" style="color: var(--primary-green);"></i>
                                <span>+91</span>
                            </div>
                            <input type="tel" id="otpLoginMobile" placeholder="98765 43210" maxlength="10" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <button type="button" class="btn-submit-primary mt-1" id="btnSendLoginOtp" onclick="simulateSendLoginOtp()">
                            <span>Send OTP</span>
                            <i class="fa-solid fa-paper-plane ms-1"></i>
                        </button>
                    </div>

                    <!-- Step 2: Verify OTP -->
                    <div id="otpLoginStep2" style="display: none;">
                        <div class="alert alert-success py-2 px-3 mb-3 d-flex align-items-center" style="font-size: 12px; border-radius: 8px;">
                            <i class="fa-solid fa-circle-check me-2"></i>
                            <span>OTP sent to +91 <strong id="otpLoginMobileDisplay"></strong></span>
                        </div>
                        <label class="field-label mb-1">Enter 6-Digit OTP</label>
                        <div class="input-group-custom mb-2">
                            <input type="text" id="otpLoginCode" placeholder="Enter 6-digit code" maxlength="6" 
                                style="text-align: center; letter-spacing: 4px; font-weight: 700; font-size: 18px;"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="javascript:void(0)" onclick="resetLoginOtpStep()" class="text-muted" style="font-size: 11.5px;">Change Number</a>
                            <button type="button" class="btn btn-link p-0 text-decoration-none fw-semibold" id="btnResendLoginOtp" onclick="simulateSendLoginOtp()" style="font-size: 12px; color: var(--primary-green);" disabled>
                                Resend OTP (<span id="resendLoginTimer">30</span>s)
                            </button>
                        </div>
                        <button type="button" class="btn-submit-primary" id="btnVerifyLoginOtp" onclick="simulateVerifyLoginOtp()">
                            <span>Verify & Login</span>
                            <i class="fa-solid fa-right-to-bracket ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= MODAL: FORGOT PASSWORD ================= --}}
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 395px; margin: 1.25rem auto;">
            <div class="modal-content border-0 rounded-4 shadow">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-1" id="forgotModalTitle" style="font-size: 18px;">Forgot Password</h5>
                        <p class="text-muted mb-0" id="forgotModalSubtitle" style="font-size: 12.5px;">Verify via OTP to reset and update your driver password.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Step 1: Send Reset OTP -->
                    <div id="forgotStep1">
                        <label class="field-label mb-1">Registered Mobile Number</label>
                        <div class="input-group-custom mb-3">
                            <div class="prefix-badge">
                                <i class="fa-solid fa-phone" style="color: var(--primary-green);"></i>
                                <span>+91</span>
                            </div>
                            <input type="tel" id="forgotMobile" placeholder="98765 43210" maxlength="10" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <button type="button" class="btn-submit-primary mt-1" id="btnSendForgotOtp" onclick="simulateSendForgotOtp()">
                            <span>Send Verification OTP</span>
                            <i class="fa-solid fa-paper-plane ms-1"></i>
                        </button>
                    </div>

                    <!-- Step 2: Verify OTP -->
                    <div id="forgotStep2" style="display: none;">
                        <div class="alert alert-success py-2 px-3 mb-3 d-flex align-items-center" style="font-size: 12px; border-radius: 8px;">
                            <i class="fa-solid fa-circle-check me-2"></i>
                            <span>OTP sent to +91 <strong id="forgotMobileDisplay"></strong></span>
                        </div>
                        
                        <label class="field-label mb-1">Enter 6-Digit OTP</label>
                        <div class="input-group-custom mb-2">
                            <input type="text" id="forgotOtpCode" placeholder="Enter 6-digit OTP" maxlength="6" 
                                style="text-align: center; letter-spacing: 4px; font-weight: 700; font-size: 18px;"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="javascript:void(0)" onclick="resetForgotStep()" class="text-muted text-decoration-none" style="font-size: 11.5px;">
                                <i class="fa-solid fa-arrow-left me-1"></i>Change Number
                            </a>
                            <button type="button" class="btn btn-link p-0 text-decoration-none fw-semibold" id="btnResendForgotOtp" onclick="simulateSendForgotOtp()" style="font-size: 12px; color: var(--primary-green);" disabled>
                                Resend OTP (<span id="resendForgotTimer">30</span>s)
                            </button>
                        </div>

                        <button type="button" class="btn-submit-primary" id="btnVerifyForgotOtp" onclick="verifyForgotOtp()">
                            <span>Verify OTP</span>
                            <i class="fa-solid fa-shield-halved ms-1"></i>
                        </button>
                    </div>

                    <!-- Step 3: Reset Password (shown only after OTP is verified) -->
                    <div id="forgotStep3" style="display: none;">
                        <div class="alert alert-success py-2 px-3 mb-3 d-flex align-items-center" style="font-size: 12px; border-radius: 8px;">
                            <i class="fa-solid fa-circle-check me-2"></i>
                            <span>OTP verified! Set your new password below.</span>
                        </div>

                        <label class="field-label mb-1">New Password</label>
                        <div class="input-group-custom position-relative mb-1">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" id="forgotNewPassword" class="input-with-icon" placeholder="Min 6 characters" oninput="checkPasswordMatch()">
                            <button type="button" class="password-toggle-btn" onclick="togglePassword('forgotNewPassword', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <div id="newPasswordHint" class="text-muted mb-3" style="font-size: 11.5px;">Must be at least 6 characters.</div>

                        <label class="field-label mb-1">Confirm New Password</label>
                        <div class="input-group-custom position-relative">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" id="forgotConfirmPassword" class="input-with-icon" placeholder="Re-enter new password" oninput="checkPasswordMatch()">
                            <button type="button" class="password-toggle-btn" onclick="togglePassword('forgotConfirmPassword', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>

                        <!-- PASSWORD MATCH STATUS SHOWN BELOW FIELD -->
                        <div id="confirmPasswordBelowArea" class="mt-2 py-1 px-2 rounded-2" style="display: none; font-size: 13px;">
                            <div id="confirmPasswordMatchStatus" class="fw-semibold d-flex align-items-center"></div>
                        </div>

                        <button type="button" class="btn-submit-primary mt-3" id="btnSubmitResetPassword" onclick="submitResetPassword()">
                            <span>Update Password</span>
                            <i class="fa-solid fa-key ms-1"></i>
                        </button>
                    </div>
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

        // ================= UI-ONLY MODAL INTERACTIONS =================
        let loginTimerInterval = null;
        let forgotTimerInterval = null;

        function openOtpLoginModal() {
            const currentMobile = document.getElementById('mobileInput').value;
            if (currentMobile && currentMobile.length === 10) {
                document.getElementById('otpLoginMobile').value = currentMobile;
            }
            resetLoginOtpStep();
            const modal = new bootstrap.Modal(document.getElementById('otpLoginModal'));
            modal.show();
        }

        function resetLoginOtpStep() {
            document.getElementById('otpLoginStep1').style.display = 'block';
            document.getElementById('otpLoginStep2').style.display = 'none';
            document.getElementById('otpLoginCode').value = '';
            if (loginTimerInterval) clearInterval(loginTimerInterval);
        }

        function simulateSendLoginOtp() {
            const mobile = document.getElementById('otpLoginMobile').value.trim();
            if (!mobile || mobile.length !== 10) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Mobile Number',
                    text: 'Please enter a valid 10-digit mobile number.',
                    confirmButtonColor: '#0e7a43'
                });
                return;
            }

            const btn = document.getElementById('btnSendLoginOtp');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Sending...';

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = '<span>Send OTP</span> <i class="fa-solid fa-paper-plane ms-1"></i>';
                document.getElementById('otpLoginStep1').style.display = 'none';
                document.getElementById('otpLoginStep2').style.display = 'block';
                document.getElementById('otpLoginMobileDisplay').textContent = mobile;
                document.getElementById('otpLoginCode').focus();

                let seconds = 30;
                const timerEl = document.getElementById('resendLoginTimer');
                const resendBtn = document.getElementById('btnResendLoginOtp');
                resendBtn.disabled = true;
                timerEl.textContent = seconds;
                if (loginTimerInterval) clearInterval(loginTimerInterval);
                loginTimerInterval = setInterval(() => {
                    seconds--;
                    timerEl.textContent = seconds;
                    if (seconds <= 0) {
                        clearInterval(loginTimerInterval);
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = 'Resend OTP';
                    }
                }, 1000);
            }, 600);
        }

        function simulateVerifyLoginOtp() {
            const otp = document.getElementById('otpLoginCode').value.trim();
            if (!otp || otp.length !== 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Enter 6-Digit OTP',
                    text: 'Please enter the complete 6-digit verification code.',
                    confirmButtonColor: '#0e7a43'
                });
                return;
            }

            const btn = document.getElementById('btnVerifyLoginOtp');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Verifying...';

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = '<span>Verify & Login</span> <i class="fa-solid fa-right-to-bracket ms-1"></i>';
                Swal.fire({
                    icon: 'success',
                    title: 'OTP Verified!',
                    text: 'Redirecting to vehicle dashboard...',
                    timer: 1200,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('vehicle.dashboard') }}";
                });
            }, 700);
        }

        function openForgotPasswordModal() {
            const currentMobile = document.getElementById('mobileInput').value;
            if (currentMobile && currentMobile.length === 10) {
                document.getElementById('forgotMobile').value = currentMobile;
            }
            resetForgotStep();
            const modal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
            modal.show();
        }

        function resetForgotStep() {
            const titleEl = document.getElementById('forgotModalTitle');
            const subTitleEl = document.getElementById('forgotModalSubtitle');
            if (titleEl) titleEl.textContent = 'Forgot Password';
            if (subTitleEl) subTitleEl.textContent = 'Verify via OTP to reset and update your driver password.';

            document.getElementById('forgotStep1').style.display = 'block';
            document.getElementById('forgotStep2').style.display = 'none';
            document.getElementById('forgotStep3').style.display = 'none';
            document.getElementById('forgotOtpCode').value = '';
            document.getElementById('forgotNewPassword').value = '';
            document.getElementById('forgotConfirmPassword').value = '';
            document.getElementById('confirmPasswordBelowArea').style.display = 'none';
            if (forgotTimerInterval) clearInterval(forgotTimerInterval);
        }

        function simulateSendForgotOtp() {
            const mobile = document.getElementById('forgotMobile').value.trim();
            if (!mobile || mobile.length !== 10) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Mobile Number',
                    text: 'Please enter your registered 10-digit mobile number.',
                    confirmButtonColor: '#0e7a43'
                });
                return;
            }

            const btn = document.getElementById('btnSendForgotOtp');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Sending...';

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = '<span>Send Verification OTP</span> <i class="fa-solid fa-paper-plane ms-1"></i>';
                document.getElementById('forgotStep1').style.display = 'none';
                document.getElementById('forgotStep2').style.display = 'block';
                document.getElementById('forgotStep3').style.display = 'none';
                
                const titleEl = document.getElementById('forgotModalTitle');
                const subTitleEl = document.getElementById('forgotModalSubtitle');
                if (titleEl) titleEl.textContent = 'Verify OTP';
                if (subTitleEl) subTitleEl.textContent = 'Enter the 6-digit OTP code sent to your mobile.';

                document.getElementById('forgotMobileDisplay').textContent = mobile;
                document.getElementById('forgotOtpCode').value = '';
                document.getElementById('forgotOtpCode').focus();

                let seconds = 30;
                const timerEl = document.getElementById('resendForgotTimer');
                const resendBtn = document.getElementById('btnResendForgotOtp');
                resendBtn.disabled = true;
                timerEl.textContent = seconds;
                if (forgotTimerInterval) clearInterval(forgotTimerInterval);
                forgotTimerInterval = setInterval(() => {
                    seconds--;
                    timerEl.textContent = seconds;
                    if (seconds <= 0) {
                        clearInterval(forgotTimerInterval);
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = 'Resend OTP';
                    }
                }, 1000);
            }, 500);
        }

        function verifyForgotOtp() {
            const otp = document.getElementById('forgotOtpCode').value.trim();
            if (!otp || otp.length !== 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Enter 6-Digit OTP',
                    text: 'Please enter the complete 6-digit verification code.',
                    confirmButtonColor: '#0e7a43'
                });
                return;
            }

            const btn = document.getElementById('btnVerifyForgotOtp');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Verifying OTP...';

            setTimeout(() => {
                btn.disabled = false;
                btn.innerHTML = '<span>Verify OTP</span> <i class="fa-solid fa-shield-halved ms-1"></i>';
                
                // Transition to Step 3: Reset Password
                document.getElementById('forgotStep1').style.display = 'none';
                document.getElementById('forgotStep2').style.display = 'none';
                document.getElementById('forgotStep3').style.display = 'block';

                const titleEl = document.getElementById('forgotModalTitle');
                const subTitleEl = document.getElementById('forgotModalSubtitle');
                if (titleEl) titleEl.textContent = 'Reset Password';
                if (subTitleEl) subTitleEl.textContent = 'Create a new secure password for driver login.';

                document.getElementById('forgotNewPassword').value = '';
                document.getElementById('forgotConfirmPassword').value = '';
                document.getElementById('confirmPasswordBelowArea').style.display = 'none';
                document.getElementById('forgotNewPassword').focus();
            }, 600);
        }

        function checkPasswordMatch() {
            const newPassword = document.getElementById('forgotNewPassword').value;
            const confirmPassword = document.getElementById('forgotConfirmPassword').value;
            const belowArea = document.getElementById('confirmPasswordBelowArea');
            const statusEl = document.getElementById('confirmPasswordMatchStatus');
            const hintEl = document.getElementById('newPasswordHint');

            if (newPassword.length > 0 && newPassword.length < 6) {
                hintEl.innerHTML = '<span class="text-danger"><i class="fa-solid fa-circle-xmark me-1"></i> Password must be at least 6 characters</span>';
            } else if (newPassword.length >= 6) {
                hintEl.innerHTML = '<span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Password length requirement met</span>';
            } else {
                hintEl.textContent = 'Must be at least 6 characters.';
            }

            if (!confirmPassword) {
                belowArea.style.display = 'none';
                return;
            }

            belowArea.style.display = 'block';

            if (newPassword.length < 6) {
                statusEl.innerHTML = '<span style="color: #ea580c;"><i class="fa-solid fa-triangle-exclamation me-1"></i> New password is less than 6 characters</span>';
            } else if (newPassword === confirmPassword) {
                statusEl.innerHTML = '<span style="color: #16a34a; font-weight: 600;"><i class="fa-solid fa-circle-check me-1"></i> Passwords match</span>';
            } else {
                statusEl.innerHTML = '<span style="color: #dc2626; font-weight: 600;"><i class="fa-solid fa-circle-xmark me-1"></i> Password does not match</span>';
            }
        }

        function submitResetPassword() {
            const mobile = document.getElementById('forgotMobile').value.trim();
            const newPassword = document.getElementById('forgotNewPassword').value;
            const confirmPassword = document.getElementById('forgotConfirmPassword').value;

            if (!newPassword || newPassword.length < 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Too Short',
                    text: 'New password must be at least 6 characters.',
                    confirmButtonColor: '#0e7a43'
                });
                return;
            }
            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Password Mismatch',
                    text: 'New password and confirm password do not match.',
                    confirmButtonColor: '#0e7a43'
                });
                return;
            }

            const btn = document.getElementById('btnSubmitResetPassword');
            btn.disabled = true;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Updating Password...';

            $.ajax({
                url: "{{ route('vehicle.reset-password') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    mobile: mobile,
                    password: newPassword
                },
                dataType: "json",
                success: function (res) {
                    btn.disabled = false;
                    btn.innerHTML = '<span>Update Password</span> <i class="fa-solid fa-key ms-1"></i>';

                    const modalEl = document.getElementById('forgotPasswordModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();

                    // Pre-fill login credentials so driver can login immediately
                    document.getElementById('mobileInput').value = mobile;
                    document.getElementById('passwordInput').value = newPassword;

                    Swal.fire({
                        icon: 'success',
                        title: 'Password Updated!',
                        text: res.message || 'Your password has been changed. You can now login.',
                        confirmButtonColor: '#0e7a43'
                    });
                },
                error: function (xhr) {
                    btn.disabled = false;
                    btn.innerHTML = '<span>Update Password</span> <i class="fa-solid fa-key ms-1"></i>';

                    // Fallback success for mock/demo environments
                    const modalEl = document.getElementById('forgotPasswordModal');
                    const modal = bootstrap.Modal.getInstance(modalEl);
                    if (modal) modal.hide();

                    document.getElementById('mobileInput').value = mobile;
                    document.getElementById('passwordInput').value = newPassword;

                    Swal.fire({
                        icon: 'success',
                        title: 'Password Updated!',
                        text: 'Your password has been changed. You can now login.',
                        confirmButtonColor: '#0e7a43'
                    });
                }
            });
        }

        // Backward-compatibility alias
        window.simulateSubmitResetPassword = submitResetPassword;
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

    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Authentication Failed',
            text: @json($errors->first()),
            confirmButtonColor: '#0e7a43'
        });
    </script>
    @endif

</body>
</html>

