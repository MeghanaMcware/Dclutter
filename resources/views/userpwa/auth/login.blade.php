<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>User Login - {{ env('APP_NAME', 'D-Clutter') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1f2937;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            max-width: 420px;
            width: 100%;
            padding: 16px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
            overflow: hidden;
            padding: 32px 24px;
            text-align: center;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            background: #e6f4ea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .login-logo i {
            font-size: 36px;
            color: #0e7a43;
        }

        .welcome-header h2 {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .welcome-header p {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 30px;
        }

        .form-control-lg {
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 20px;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            letter-spacing: 2px;
        }
        
        .form-control-lg:focus {
            border-color: #0e7a43;
            box-shadow: 0 0 0 3px rgba(14, 122, 67, 0.15);
        }

        .btn-primary {
            background-color: #0e7a43;
            border-color: #0e7a43;
            border-radius: 12px;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #095930;
            border-color: #095930;
        }

        /* OTP Section Hidden by Default */
        #otpSection {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-logo">
                <i class="fa-solid fa-mobile-screen"></i>
            </div>
            
            <div id="phoneSection">
                <div class="welcome-header">
                    <h2>Welcome to D-Clutter</h2>
                    <p>Enter your mobile number to get started.</p>
                </div>
                <form id="phoneForm" class="needs-validation" novalidate onsubmit="showOtp(event)">
                    <div class="position-relative mb-3">
                        <input type="tel" class="form-control form-control-lg" placeholder="Enter Mobile Number" pattern="^[0-9]{10}$" minlength="10" maxlength="10" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <div class="invalid-feedback text-start mt-2">
                            Please enter a valid 10-digit mobile number.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Send OTP</button>
                </form>
            </div>

            <div id="otpSection">
                <div class="welcome-header">
                    <h2>Verify OTP</h2>
                    <p>Enter the 4-digit code sent to your number.</p>
                </div>
                <form action="{{ route('user.dashboard') }}" method="GET" class="needs-validation" novalidate>
                    <div class="position-relative mb-3">
                        <input type="text" class="form-control form-control-lg" placeholder="----" pattern="^[0-9]{4}$" minlength="4" maxlength="4" required oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <div class="invalid-feedback text-start mt-2">
                            Please enter a valid 4-digit OTP.
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Verify & Login</button>
                    <p class="mt-3 text-muted" style="font-size: 13px; cursor: pointer;" onclick="showPhone()">Change Mobile Number</p>
                </form>
            </div>
        </div>

        <div class="app-footer-clean text-center py-3 my-2 border-top" style="max-width: 440px; margin: 0 auto;">
    <div class="fw-bold text-dark mb-1" style="font-size: 14px;">DCLUTTER Driver Portal</div>
    <div class="small text-muted mb-1" style="font-size: 12px;">Copyright &copy; 2026 DCLUTTER. All rights reserved.</div>
    <div class="text-secondary" style="font-size: 11px;">
        <span>Version 1.0.0</span> | Designed & Developed by <a href="https://mcwaretechnologies.com/" target="_blank" style="color: #0e7a43; text-decoration: none; font-weight: 700;">McWare Technologies</a>
    </div>
</div>
    </div>

    

    <script>
        // Bootstrap validation script
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        function showOtp(e) {
            e.preventDefault();
            const form = e.target;
            if (form.checkValidity()) {
                document.getElementById('phoneSection').style.display = 'none';
                document.getElementById('otpSection').style.display = 'block';
            }
        }
        function showPhone() {
            document.getElementById('otpSection').style.display = 'none';
            document.getElementById('phoneSection').style.display = 'block';
        }
    </script>
</body>
</html>
