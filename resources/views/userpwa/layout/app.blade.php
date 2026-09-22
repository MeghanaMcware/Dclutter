<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>@yield('title') - {{env('APP_NAME')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" /> 
    @yield('style')
    <style>
        :root {
            --user-header-height: 64px;
            --user-bottom-nav-height: 68px;
        }
        *, *::before, *::after {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        .page-content {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-height: 100dvh;
            padding-top: calc(var(--user-header-height) + 12px);
            padding-bottom: calc(var(--user-bottom-nav-height) + 16px);
            max-width: 420px;
            margin: 0 auto;
        }
        .bg-primary {
            background-color: #0e7a43 !important;
        }
        .btn-primary {
            background-color: #0e7a43;
            border-color: #0e7a43;
        }
        .btn-primary:hover {
            background-color: #095930;
            border-color: #095930;
        }
        .text-primary {
            color: #0e7a43 !important;
        }
    </style>
</head>
<body>
    @include('userpwa.layout.top-navigation')
    @include('userpwa.layout.bottom-navigation')

    <div class="page-content">
        @yield('content')

        <div class="footer">
            @include('userpwa.layout.footer')
        </div>
    </div>
 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        @php
            $reqNum = session('request_number');
        @endphp
        Swal.fire({
            icon: 'success',
            title: '{{ $reqNum ? "Request Submitted Successfully!" : "Success" }}',
            html: `
                <div style="font-size: 14px; color: #334155; margin-bottom: 12px;">
                    {{ session('success') }}
                </div>
                @if($reqNum)
                <div style="background: #f0fdf4; border: 1.5px dashed #86efac; border-radius: 10px; padding: 14px 16px; margin: 14px 0; text-align: center;">
                    <div style="font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #166534; font-weight: 700; margin-bottom: 4px;">Request ID</div>
                    <div style="font-size: 22px; font-weight: 800; color: #15803d; letter-spacing: 0.5px; font-family: monospace;">{{ $reqNum }}</div>
                </div>
                <div style="font-size: 12px; color: #64748b;">
                    Please save this Request ID to track your request status.
                </div>
                @endif
            `,
            confirmButtonColor: '#0e7a43',
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
            confirmButtonColor: '#dc3545'
        });
    </script>
    @endif
    @yield('script')
</body>
</html>
