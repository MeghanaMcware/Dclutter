<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>User Login - {{ env('APP_NAME', 'D-Clutter') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@700;800&display=swap"
        rel="stylesheet">

    <style>
    :root {
        --green: #00894d;
        --ink: #263238;
        --line: #e1e8e5;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        min-height: 100vh;
        min-height: 100dvh;
        padding: 3px;
        display: flex;
        justify-content: center;
        background: #edf7ef;
        color: var(--ink);
        font-family: 'DM Sans', sans-serif;
    }

    .login-wrapper {
        width: 100%;
        max-width: 430px;
        min-height: calc(100vh - 6px);
        min-height: calc(100dvh - 6px);
        overflow: hidden;
        border: 1px solid #dbeade;
        border-radius: 28px 28px 0 0;
        background: linear-gradient(180deg, #ffffff 0%, #fbfdfb 100%);
        box-shadow: 0 12px 35px rgba(24, 92, 54, .08);
    }

    .login-card {
        padding: 22px 34px 20px;
        text-align: center;
    }

    .brand {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: var(--green);
    }

    .brand-mark {
        width: 37px;
        height: 37px;
        display: grid;
        place-items: center;
        border: 2px solid var(--green);
        border-radius: 50%;
        font-size: 20px;
        transform: rotate(-12deg);
    }

    .brand-name {
        font: 800 23px/1 'Manrope', sans-serif;
        letter-spacing: .2px;
    }

    .brand-tagline {
        margin: 3px 0 0 46px;
        color: #66746c;
        font-size: 7px;
        font-weight: 700;
        letter-spacing: 1.7px;
    }

    .hero {
        position: relative;
        height: 150px;
        margin: 14px -34px 0;
        overflow: hidden;
        background: linear-gradient(180deg, #f4fbf5 0%, #e7f5e9 67%, #c9e8bf 68%, #f8fbf8 69%, #fff 100%);
    }

    .hero::before {
        content: '';
        position: absolute;
        inset: 0;
        opacity: .16;
        background: url('{{ asset('frontendwebsite/img/hero-truck-new.png') }}') center 63% / cover no-repeat;
        filter: saturate(.75) hue-rotate(20deg);
    }

    .hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, #f3fbf4 0%, transparent 35%, transparent 70%, #e4f4e6 100%);
    }

    .hero-city {
        position: absolute;
        z-index: 1;
        left: 0;
        right: 0;
        bottom: 45px;
        height: 42px;
        opacity: .22;
        background: repeating-linear-gradient(90deg, transparent 0 13px, #8fbd9c 13px 25px, transparent 25px 32px);
        clip-path: polygon(0 100%, 0 60%, 8% 60%, 8% 30%, 14% 30%, 14% 64%, 23% 64%, 23% 10%, 30% 10%, 30% 52%, 38% 52%, 38% 24%, 45% 24%, 45% 64%, 55% 64%, 55% 5%, 63% 5%, 63% 45%, 73% 45%, 73% 18%, 81% 18%, 81% 58%, 90% 58%, 90% 28%, 97% 28%, 97% 100%);
    }

    .hero-truck {
        position: absolute;
        z-index: 2;
        right: 9px;
        bottom: 16px;
        width: 145px;
        height: 85px;
        object-fit: cover;
        object-position: 78% 60%;
        border-radius: 45% 20% 10% 10%;
        mix-blend-mode: multiply;
        opacity: .88;
    }

    .welcome-header {
        position: relative;
        z-index: 3;
        margin-top: -7px;
    }

    .welcome-header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: #242927;
    }

    .welcome-header h2 strong {
        display: block;
        color: var(--green);
        font: 800 18px / 1.2 'Manrope', sans-serif;
    }

    .welcome-header p {
        margin: 5px 0 0;
        font-size: 11px;
        line-height: 1.45;
        color: #4d5953;
    }

    .welcome-header p strong {
        color: var(--green);
    }

    .form-panel {
        margin-top: 16px;
        padding: 13px 15px 14px;
        border: 1px solid #edf0ee;
        border-radius: 13px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(30, 71, 47, .09);
        text-align: left;
    }

    .field-label {
        display: block;
    margin-bottom: 2px;
    color: #131715;
    font-size: 14px;
    font-weight: 500;
    }

    .phone-field {
        display: flex;
        height: 36px;
        border: 1px solid #dfe6e2;
        border-radius: 9px;
        overflow: hidden;
        background: #fafcfa;
    }

    .country-code {
        display: flex;
        align-items: center;
        gap: 7px;
        padding: 0 10px;
        border-right: 1px solid #e3e9e5;
        color: #35413b;
        font-size: 11px;
    }

    .country-code i {
        color: #59645f;
        font-size: 9px;
    }

    .phone-field input {
        min-width: 0;
        flex: 1;
        border: 0;
        outline: 0;
        padding: 0 10px;
        background: transparent;
        color: #27322d;
        font-size: 11px;
    }

    .phone-field input::placeholder {
        color: #8a948f;
    }

    .phone-field:focus-within {
        border-color: var(--green);
        box-shadow: 0 0 0 3px rgba(0, 137, 77, .1);
    }

    .was-validated .phone-field:has(input:invalid) {
        border-color: #dc3545;
    }

    .was-validated .phone-field:has(input:valid) {
        border-color: #198754;
    }

    .was-validated .phone-field:has(input:invalid) + .helper {
        color: #dc3545;
    }

    .was-validated .phone-field + .helper + .invalid-feedback {
        display: block;
        font-size: 10px;
        margin-top: 5px;
    }

    .was-validated .phone-field:has(input:invalid) + .invalid-feedback {
        display: block;
        font-size: 10px;
        margin-top: 5px;
    }

    .helper {
        margin: 6px 0 0;
        color: #84908a;
        font-size: 9px;
    }

    .btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        height: 37px;
        margin-top: 14px;
        border: 0;
        border-radius: 9px;
        background: var(--green);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 5px 11px rgba(0, 137, 77, .2);
    }

    .btn-primary:hover {
        background: #006d3d;
    }

    .btn-primary i {
        font-size: 12px;
    }

    .btn-loading {
        pointer-events: none;
        opacity: .85;
    }

    .page-loader {
        position: fixed;
        z-index: 1055;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, .78);
        backdrop-filter: blur(3px);
    }

    .page-loader.show {
        display: flex;
    }

    .page-loader__content {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 18px;
        border: 1px solid #e1eae4;
        border-radius: 10px;
        background: #fff;
        color: var(--green);
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 8px 25px rgba(30, 71, 47, .14);
    }

    .or-divider {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 16px 0 12px;
        color: #828d88;
        font-size: 9px;
    }

    .or-divider::before,
    .or-divider::after {
        content: '';
        height: 1px;
        flex: 1;
        background: #e6ebe8;
    }

    .alt-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
    }

    .alt-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 36px;
        border: 1px solid #e1e7e4;
        border-radius: 9px;
        background: #fff;
        color: #303a35;
        font-size: 10px;
        font-weight: 600;
        box-shadow: 0 3px 7px rgba(23, 54, 35, .05);
    }

    .alt-button.google i {
        color: #4285f4;
        font-size: 15px;
    }

    .alt-button.phone i {
        color: var(--green);
        font-size: 13px;
    }

    .privacy {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin: 14px auto 0;
        max-width: 240px;
        color: #7c8781;
        font-size: 10px;
        line-height: 1.45;
        text-align: center;
        color:#242927;
    }

    .privacy i {
        margin-top: 1px;
        color: #69756f;
    }

    #otpSection {
        display: none;
    }

    #otpSection .form-panel {
        margin-top: 2px;
    }

    @media (max-width: 380px) {
        .login-card {
            padding-right: 22px;
            padding-left: 22px;
        }

        .hero {
            margin-right: -22px;
            margin-left: -22px;
        }

        .hero-truck {
            right: 1px;
        }
    }

    @media (min-width: 700px) {
        body {
            align-items: center;
            padding: 24px;
        }

        .login-wrapper {
            min-height: 0;
        }
    }

    /* OTP Section Hidden by Default */
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="brand"><span class="brand-mark"><i class="fa-solid fa-leaf"></i></span><span
                    class="brand-name">DCLUTTER</span></div>
            <div class="brand-tagline">BENGALURU'S CLEAN STREETS</div>

            <div class="hero" aria-hidden="true">
                <div class="hero-city"></div><img class="hero-truck"
                    src="{{ asset('frontendwebsite/img/hero-truck-new.png') }}" alt="">
            </div>

            <div id="phoneSection">

                <div class="form-panel">
                    <form id="phoneForm" class="needs-validation" novalidate onsubmit="showOtp(event)">
                        <label class="field-label" for="mobileNumber">Mobile Number</label>
                        <div class="phone-field">
                            <span class="country-code">+91 <i class="fa-solid fa-chevron-down"></i></span><input
                                id="mobileNumber" type="tel" placeholder="Enter your mobile number"
                                pattern="^[0-9]{10}$" minlength="10" maxlength="10" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <p class="helper">We'll send you an OTP to verify your number</p>
                        <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                        <button type="submit" class="btn btn-primary" data-loading-label="Sending OTP..."><i class="fa-solid fa-shield-halved"></i> Send
                            OTP</button>
                    </form>
                    <div class="or-divider">or continue with</div>
                    <div class="alt-actions"><button type="button" class="alt-button google"><i
                                class="fa-brands fa-google"></i> Continue with Google</button><button type="button"
                            class="alt-button phone"><i class="fa-brands fa-whatsapp"></i> Continue with Phone</button>
                    </div>
                    <div class="privacy"><i class="fa-solid fa-lock"></i><span>Your number is safe with us. We don't
                            share it<br>with anyone.</span></div>
                </div>
            </div>

            <div id="otpSection">
                <div class="welcome-header">
                    <h2>Verify <strong>OTP</strong></h2>
                    <p>Enter the 4-digit code sent to your number.</p>
                </div>
                <div class="form-panel">
                    <form action="{{ route('user.dashboard') }}" method="GET" class="needs-validation" novalidate>
                        <label class="field-label" for="otpCode">Verification code</label>
                        <div class="phone-field"><input id="otpCode" type="text" placeholder="Enter 4-digit OTP"
                                pattern="^[0-9]{4}$" minlength="4" maxlength="4" required
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div class="invalid-feedback">Please enter a valid 4-digit OTP.</div>
                        <button type="submit" class="btn btn-primary" data-loading-label="Verifying..."><i class="fa-solid fa-right-to-bracket"></i> Verify &amp; Login</button>
                        <p class="mt-3 text-primary text-center" style="font-size: 14px; cursor: pointer;" onclick="showPhone()">
                            Change
                            Mobile Number</p>
                    </form>
                </div>
            </div>
        </div>
        @include('userpwa.layout.footer')
    </div>

    <div id="pageLoader" class="page-loader" role="status" aria-live="polite" aria-hidden="true">
        <div class="page-loader__content">
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span>Signing you in...</span>
        </div>
    </div>



    <script>
    (function() {
        'use strict';

        const forms = document.querySelectorAll('.needs-validation');

        function setButtonLoading(button, loading) {
            if (!button) return;

            if (loading) {
                button.dataset.originalContent = button.innerHTML;
                button.innerHTML = '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> ' +
                    button.dataset.loadingLabel;
                button.classList.add('btn-loading');
                button.setAttribute('aria-disabled', 'true');
            } else {
                button.innerHTML = button.dataset.originalContent || button.innerHTML;
                button.classList.remove('btn-loading');
                button.removeAttribute('aria-disabled');
            }
        }

        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');

                if (!form.checkValidity()) return;

                const submitButton = form.querySelector('button[type="submit"]');

                if (form.id === 'phoneForm') {
                    setButtonLoading(submitButton, true);
                    window.setTimeout(function() {
                        setButtonLoading(submitButton, false);
                        document.getElementById('phoneSection').style.display = 'none';
                        document.getElementById('otpSection').style.display = 'block';
                        document.getElementById('otpCode').focus();
                    }, 450);
                    return;
                }

                setButtonLoading(submitButton, true);
                document.getElementById('pageLoader').classList.add('show');
                document.getElementById('pageLoader').setAttribute('aria-hidden', 'false');
                window.setTimeout(function() {
                    form.submit();
                }, 350);
            }, false);
        });
    })();

    function showOtp(e) {
        e.preventDefault();
    }

    function showPhone() {
        document.getElementById('otpSection').style.display = 'none';
        document.getElementById('phoneSection').style.display = 'block';
    }
    </script>
</body>

</html>