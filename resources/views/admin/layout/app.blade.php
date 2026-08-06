<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description"
        content="CLEARIT">
    <meta name="keywords"
        content="CLEARIT">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}">
    <title>@yield('title') - Dclutter</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/vendors/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/vendors/icofont.css') }}">
    <!-- Feather icon-->
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/vendors/photoswipe.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/vendors/date-picker.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/vendors/select2.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/style.css') }}">
    <link id="color" rel="stylesheet" href="{{asset('/theme/css/color-1.css') }}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('/theme/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Inter', sans-serif;
        }
    .btn-close.white-close {
        filter: invert(1);
    }

    .select2-selection {
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
    }

    .select2-container .select2-selection--multiple {
        min-height: 38px !important;
    }

    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border: solid #00000026 1px !important;
    }

    /* Enhanced Violet Sidebar & Header Styling */
    .sidebar-wrapper {
        background: linear-gradient(135deg, #fff 0%, #fff 100%) !important;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
    }

    .sidebar-links {
        background: transparent !important;
    }

    .sidebar-list {
        margin: 4px 8px !important;
    }

    .sidebar-link {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 12px !important;
        color: #ffffff !important;
        padding: 12px 16px !important;
        transition: all 0.3s ease !important;
        backdrop-filter: blur(10px) !important;
        font-weight: 500 !important;
    }

    .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.25) !important;
        border-color: rgba(255, 255, 255, 0.4) !important;
        color: #ffffff !important;
        transform: translateX(4px) !important;
    }

   .sidebar-link.active {
        background: linear-gradient(135deg, #5f62e6 0%, #5f62e6 100%) !important;
        border-color: #5f62e6 !important;
        color: #ffffff !important;
        box-shadow: 0 5px 20px #5a63e559 !important;
    }

    .sidebar-link i, .sidebar-link span {
        color: #000 !important;
    }

    .sidebar-submenu {
        background: #eff2fc !important;
        border-radius: 8px !important;
        margin-top: 8px !important;
        padding: 8px !important;
        backdrop-filter: blur(5px) !important;
    }

    .sidebar-submenu li a {
        color: #000 !important;
        padding: 8px 12px !important;
        display: block;
        border-radius: 6px;
        text-decoration: none;
    }

    .sidebar-submenu li a:hover, .sidebar-submenu li a.active {
        color: #000 !important;
        background: rgba(255, 255, 255, 0.2) !important;
        font-weight: bold;
    }

    .logo-wrapper {
        background: rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(10px) !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
    }

    .logo-wrapper a {
        color: #ffffff !important;
        font-weight: 600 !important;
    }

    .page-header {
        background: linear-gradient(135deg, #764ba2 0%, #764ba2 100%) !important;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
        border-bottom: none !important;
    }

    .toggle-sidebar {
        background: rgba(255, 255, 255, 0.1) !important;
        backdrop-filter: blur(10px) !important;
        border-radius: 12px !important;
        padding: 8px !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
    }

    .toggle-sidebar svg path {
        stroke: #ffffff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #705dbb !important;
        border-color: #715cba !important;
        border-radius: 5px !important;
        color: white !important;
    }
    .page-wrapper.compact-wrapper .page-body-wrapper div.sidebar-wrapper .sidebar-main .sidebar-links .simplebar-wrapper .simplebar-mask .simplebar-content-wrapper .simplebar-content > li .sidebar-link.active span{
        color:#fff !important;
    }
    </style>
    @yield('style')
<style>
    /* DataTables Pagination Override */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #0d6efd !important;
        background: #fff !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 5px !important;
        padding: 5px 12px !important;
        margin: 0 2px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #198754 !important;
        border-color: #198754 !important;
        border-radius: 5px !important;
        color: white !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: #6c757d !important;
        background: #f8f9fa !important;
        border-color: #dee2e6 !important;
        cursor: not-allowed !important;
    }
    </style>
</head>

<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-ball"></div>
        </div>
    </div>
    <!-- Loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="fa-solid fa-arrow-up"></i></div>
    <!-- tap on tap ends-->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('admin.layout.header')
        <div class="page-body-wrapper">
            @include('admin.layout.sidebar')
            <div class="page-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    @include('admin.layout.footer')
    <!-- latest jquery-->
    <script src="{{asset('/theme/js/jquery-3.5.1.min.js') }}"></script>

    <script src="{{asset('/theme/js/select2/select2.full.min.js') }}"></script>
    <script src="{{asset('/theme/js/select2/select2-custom.js') }}"></script>
    <!-- Bootstrap js-->

    <script src="{{asset('/theme/js/bootstrap/bootstrap.bundle.min.js') }}"></script>

    <script src="{{asset('/theme/js/datepicker/daterange-picker/moment.min.js') }}"></script>
    <script src="{{asset('/theme/js/datepicker/daterange-picker/daterangepicker.js') }}"></script>
    <script src="{{asset('/theme/js/datepicker/daterange-picker/daterange-picker.custom.js') }}"></script>

    <!-- feather icon js-->
    <script src="{{asset('/theme/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{asset('/theme/js/datatable/datatables/datatable.custom.js') }}"></script>
    <!-- scrollbar js-->
    <script src="{{asset('/theme/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{asset('/theme/js/tooltip-init.js') }}"></script>
    <script src="{{asset('/theme/js/scrollbar/custom.js') }}"></script>







    <!-- Sidebar jquery-->
    <script src="{{asset('/theme/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{asset('/theme/js/sidebar-menu.js') }}"></script>
    <script src="{{asset('/theme/js/notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{asset('/theme/js/height-equal.js') }}"></script>

    <script src="{{asset('/theme/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{asset('/theme/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{asset('/theme/js/datepicker/date-picker/datepicker.custom.js') }}"></script>

        <script src="{{asset('/theme/js/chart/apex-chart/apex-chart.js') }}"></script>
    <script src="{{asset('/theme/js/chart/apex-chart/stock-prices.js') }}"></script>
    <script src="{{asset('/theme/js/chart/apex-chart/chart-custom.js') }}"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="{{asset('/theme/js/script.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: @json(session('success')),
            confirmButtonColor: '#1f4e79'
        });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: @json(session('error')),
            confirmButtonColor: '#c0392b'
        });
    </script>
    @endif
    <script>
        window.adminConfirmDelete = function (form, title = 'Delete this record?') {
            Swal.fire({
                icon: 'warning',
                title: title,
                text: 'This action cannot be undone.',
                showCancelButton: true,
                confirmButtonColor: '#c0392b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Delete',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

            return false;
        };
    @yield('script')
</body>

</html>
