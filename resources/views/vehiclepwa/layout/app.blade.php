<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title') - {{env('APP_NAME')}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" /> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Anek+Kannada:wght@100..800&family=Anek+Latin:wght@100..800&display=swap"
        rel="stylesheet">
    @yield('style')

    <style>
        .new-family {
          font-family:'Inter',sans-serif;
        }

        .bg-highlight{
            background-color: #1f4e79 !important;
        }

        /* Uniform #1f4e79 Theme Buttons & High-Contrast Typography */
        .btn-primary, .btn-primary *,
        .bg-primary, .bg-primary *,
        .card-header.bg-primary, .card-header.bg-primary *,
        .card-header.bg-dark, .card-header.bg-dark *,
        .bg-highlight, .bg-highlight *,
        .cta-card, .cta-card *,
        .badge-primary, .badge.bg-primary {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        h1.text-white, h2.text-white, h3.text-white, h4.text-white, h5.text-white, h6.text-white,
        .text-white, .text-white * {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        .btn-primary, .bg-primary {
            background-color: #1f4e79 !important;
            border-color: #1f4e79 !important;
            opacity: 1 !important;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: #163858 !important;
            border-color: #163858 !important;
            opacity: 1 !important;
        }
        .btn-outline-primary {
            color: #1f4e79 !important;
            border-color: #1f4e79 !important;
            background-color: #ffffff !important;
            font-weight: 600 !important;
            opacity: 1 !important;
        }
        .btn-outline-primary:hover, .btn-outline-primary:focus {
            background-color: #1f4e79 !important;
            color: #ffffff !important;
            opacity: 1 !important;
        }
        .text-primary {
            color: #1f4e79 !important;
        }
        .table-primary {
            background-color: #e8f0f8 !important;
            color: #1f4e79 !important;
        }

        .header-card.shape-rounded {
                height: 75px !important;
        }
        #pageLoader {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(31, 78, 121, 0.88);
            z-index: 99999;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }
        #pageLoader.active { display: flex; }
        #pageLoader .spin {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255,255,255,0.2);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        #pageLoader p { color: #fff; font-size: 15px; font-weight: 500; margin: 0; }
        @keyframes spin { to { transform: rotate(360deg); } }
        #pageLoader{
    display:none;
}

#pageLoader.active{
    display:flex;
}
    </style>
</head>

<body class="theme-light" data-highlight="blue2">


    <div id="preloader">
        <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">

        @include('vehiclepwa.layout.top-navigation')
        @include('vehiclepwa.layout.bottom-navigation')

        <div class="page-content">
            
            <!-- <div class="page-title page-title-large" style="margin: 20px 20px 12px 20px;">
                <div style="height:60px"></div>
                <h2>
                    <a href="#" data-back-button=""><i class="fa fa-arrow-left"></i></a> Dashboard
                </h2>
                <a href="#" data-menu="menu-main" class="bg-fade-highlight-light shadow-xl preload-img"
                    data-src="images/avatars/5s.png"></a>
            </div> -->
            <div class="page-title page-title-small">
                <h2>
                    <!-- <a href="#" data-back-button=""><i class="fa fa-arrow-left"></i></a> @yield('heading') -->
                    <a href="#" data-back-button="" style="padding-right: 5px;">
                        <i class="fa fa-arrow-left"></i>
                       
                    </a>
                    {{ \Illuminate\Support\Str::limit($__env->yieldContent('heading'), 18, '...') }}
                </h2>
                {{-- <div class="position-absolute" style="z-index: 10;right: 70px;top: 8px;">
                    <select class="form-control p-0 px-2 m-0" style="border-radius: 8px;"
                        onchange="window.location.href = '{{ url('/local') }}/' + this.value;">
                        <option value="en" {{ App::getLocale() == 'en' ? 'selected' : '' }}>EN</option>
                        <option value="kn" {{ App::getLocale() == 'kn' ? 'selected' : '' }}>KN</option>
                    </select>


                </div> --}}
                <a href="#" data-menu="menu-main" class="bg-fade-highlight-light shadow-xl preload-img entered loaded"
                    data-src="images/avatars/5s.png" data-ll-status="loaded"
                    style="background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTY6qtMj2fJlymAcGTWLvNtVSCULkLnWYCDcQ&s');"></a>
            </div>
            <div class="card header-card shape-rounded" data-card-height="210">
                <div class="card-overlay bg-highlight opacity-95"></div>
                <div class="card-overlay dark-mode-tint"></div>
                <div class="card-bg preload-img" data-src="images/pictures/20s.jpg"></div>
            </div>
            @yield('content')

            <div class="footer" >
                @include('vehiclepwa.layout.footer')
            </div>

        </div>

        <div id="menu-main" class="menu menu-box-right menu-box-detached rounded-m" data-menu-width="260"
             data-menu-effect="menu-over">
             @include('vehiclepwa.layout.sidebar')
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('layouts.image-compression-script')
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
    @yield('script')
    <script>
        function setLang(lang) {
            window.location.href = "{{ url('/local') }}/" + lang;
        }
    </script>
    <script>
        function showPageLoader() {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.classList.add('active');
            }
        }

        function hidePageLoader() {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.classList.remove('active');
            }
        }

        document.addEventListener('submit', function (event) {
            if (event.target instanceof HTMLFormElement && !event.target.hasAttribute('data-no-loader')) {
                showPageLoader();
            }
        }, true);
    </script>

    <!-- Client-Side Image Compression (AAMS Standard) -->
    <script>
        async function compressImage(file) {
            return new Promise((resolve, reject) => {
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = (e) => {
                    const img = new Image();
                    img.src = e.target.result;
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        const MAX_WIDTH = 1200;
                        let width = img.width;
                        let height = img.height;

                        if (width > MAX_WIDTH) {
                            height *= MAX_WIDTH / width;
                            width = MAX_WIDTH;
                        }

                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);

                        canvas.toBlob((blob) => {
                            if (!blob) return resolve(file);
                            resolve(new File([blob], file.name.replace(/\.[^/.]+$/, "") + ".jpg", {
                                type: 'image/jpeg',
                                lastModified: Date.now()
                            }));
                        }, 'image/jpeg', 0.7);
                    };
                    img.onerror = () => resolve(file);
                };
                reader.onerror = () => resolve(file);
            });
        }

        async function handleImageUpload(input) {
            if (!input.files || input.files.length === 0) return;

            const files = Array.from(input.files);
            const isAnyImage = files.some(f => f.type && f.type.startsWith('image/'));
            if (!isAnyImage || input.getAttribute('data-no-compress')) return;

            try {
                const compressedFiles = await Promise.all(files.map(async (file) => {
                    if (file.type && file.type.startsWith('image/') && file.size > 200 * 1024) {
                        return await compressImage(file);
                    }
                    return file;
                }));

                const dataTransfer = new DataTransfer();
                compressedFiles.forEach(f => dataTransfer.items.add(f));
                input.files = dataTransfer.files;

                input.dispatchEvent(new Event('change', { bubbles: true }));
            } catch (err) {
                console.error('Compression Error:', err);
            }
        }

        document.addEventListener('change', function(e) {
            if (e.target.tagName === 'INPUT' && e.target.type === 'file' && !e.target.hasAttribute('data-compressing')) {
                e.target.setAttribute('data-compressing', 'true');
                handleImageUpload(e.target).finally(() => {
                    e.target.removeAttribute('data-compressing');
                });
            }
        }, true);
    </script>

</body>
