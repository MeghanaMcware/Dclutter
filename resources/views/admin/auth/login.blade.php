{{-- resources/views/admin/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CLEARIT">
    <meta name="keywords" content="CLEARIT">
     <link rel="icon" href="{{asset('pwa/images/GBA-removebg-preview.png')}}">
    <title>Admin Login | CLEARIT</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('/theme/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/theme/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{ asset('/theme/css/color-1.css') }}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('/theme/css/responsive.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url("{{ asset('/assets/video/original-background.gif') }}") no-repeat center center fixed;
            background-size: cover;
            font-family: 'Inter', sans-serif;
        }

        @media (max-width: 1350px) {
            .login-form {
                width: auto !important;
            }
        }

        .newfont{
            font-size:16px;
        }
    </style>
</head>

<body>
    <div class="page-body-wrapper">
        <div class="container-fluid">
            <div class="row m-0">
                <div class="col-lg-12 col-sm-12">
                    <div class="login-card p-3" style="height: auto">
                        <div class="theme-form col-md-9 p-4 shadow"
                            style="background-color: white; border: 1px solid #00000047; border-radius: 10px;">
                            <div class="d-flex row align-items-center">

                                {{-- Left branding --}}
                                <div class="col-lg-6 col-12 mb-3">
                                    <div class="d-flex flex-column gap-1 align-items-center justify-content-center gap-2">
                                       <img src="{{ asset('frontend/pwa/images/clearitlogo.jpeg') }}" width="75%" alt="">
                                    </div>
                                </div>

                                {{-- Right form --}}
                                <div class="col-lg-6 col-12">
                                    <h4 class="text-center" style="color: #2a1570;">
                                        <b>Admin Login</b>
                                    </h4>

                                    {{-- Session errors --}}
                                    @if (session('error'))
                                        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
                                    @endif

                                    <form class="theme-form login-form mt-4" method="POST"
                                        action="{{ route('admin.login.submit') }}">
                                        @csrf

                                        {{-- Email --}}
                                        <div class="form-group">
                                            <label>Email Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-envelope"></i>
                                                </span>
                                                <input id="email" type="email" name="email"
                                                    placeholder="admin@example.com"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email') }}" required autofocus autocomplete="email">
                                                @error('email')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Password --}}
                                        <div class="form-group">
                                            <label>Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fa-solid fa-lock"></i>
                                                </span>
                                                <input id="password" type="password" name="password"
                                                    placeholder="*********"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    required autocomplete="current-password">
                                                <span class="input-group-text" onclick="togglePassword()"
                                                    style="cursor: pointer;">
                                                    <i id="toggleIcon" class="fa-solid fa-eye-slash"></i>
                                                </span>
                                                @error('password')
                                                    <span class="invalid-feedback">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Remember me --}}
                                        <div class="form-group d-flex align-items-center gap-2 justify-content-between mb-0">
                                            <div class="d-flex flex-row align-items-center gap-2">
                                                <input type="checkbox" id="remember" name="remember" class="form-check-input mt-0">
                                                <label for="remember" class="mb-0">Remember me</label>
                                            </div>
                                            {{-- Submit --}}
                                            <div class="form-group d-flex justify-content-center mb-0">
                                                <button type="submit" class="btn btn-primary px-4">
                                                    Log in
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById("password");
            const icon = document.getElementById("toggleIcon");
            if (password.type === "password") {
                password.type = "text";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            } else {
                password.type = "password";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            }
        }
    </script>

    <script src="{{ asset('/theme/js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('/theme/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/theme/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('/theme/js/icons/feather-icon/feather-icon.js') }}"></script>
    <script src="{{ asset('/theme/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('/theme/js/scrollbar/custom.js') }}"></script>
    <script src="{{ asset('/theme/js/config.js') }}"></script>
    <script src="{{ asset('/theme/js/script.js') }}"></script>
</body>

</html>