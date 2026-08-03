<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>CLEARIT</title>
  <meta name="description" content="CLEARIT">
  <meta name="keywords" content="CLEARIT">

  <!-- Favicons -->
  <link href="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}" rel="icon">
  <link href="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{asset('frontendwebsite/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('frontendwebsite/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('frontendwebsite/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('frontendwebsite/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
  <link href="{{asset('frontendwebsite/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('frontendwebsite/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

  <!-- Main CSS File -->
  <link href="{{asset('frontendwebsite/css/main.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />

  <style>
       h1,
        .h1,
        h2,
        .h2,
        h3,
        .h3,
        h4,
        .h4,
        h5,
        .h5,
        h6,
        .h6,
        p,
        span,li,div,button,
        a {
            font-family:
                @if (app()->getLocale() === 'en')
                'Inter'@else 'Anek Kannada'@endif !important;

            letter-spacing: 0.5px !important;

        }
    #pageLoader {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(8, 125, 69, 0.94);
      z-index: 99999;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 18px;
    }
    #pageLoader.active {
      display: flex;
    }
    #pageLoader .loader-spinner {
      width: 56px;
      height: 56px;
      border: 5px solid rgba(255,255,255,0.25);
      border-top-color: #ffffff;
      border-radius: 50%;
      animation: loaderSpin 0.8s linear infinite;
    }
    #pageLoader .loader-title {
      color: #ffffff;
      font-size: 17px;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      letter-spacing: 0.3px;
    }
    #pageLoader .loader-subtitle {
      color: rgba(255,255,255,0.7);
      font-size: 13px;
      font-family: 'Inter', sans-serif;
    }
    @keyframes loaderSpin {
      to { transform: rotate(360deg); }
    }
           .whatsapp-float {
    position: fixed;
    width: 60px;
    height: 60px;
    bottom: 25px;
    right: 20px;
    background-color: #25D366;
    color: #fff;
    border-radius: 50%;
    text-align: center;
    font-size: 32px;
    box-shadow: 2px 2px 10px rgba(0,0,0,0.3);
    z-index: 9999;

    display: flex;
    align-items: center;
    justify-content: center;

    transition: 0.3s ease;
}

.whatsapp-float:hover {
    background-color: #1ebe5d;
    transform: scale(1.1);
    color: #fff;
    text-decoration: none;
}

.language-switcher {
    position: fixed;
    bottom: 95px;
    right: 5px;
    background-color: #e0e0e0;
    border-radius: 25px;
    padding: 5px;
    display: flex;
    gap: 5px;
    z-index: 9999;
    box-shadow: 2px 2px 10px rgba(0,0,0,0.2);
}

.lang-link {
    padding: 8px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.3s ease;
    color: #333;
}

.lang-link.active {
    background-color: #2a5780;
    color: #fff;
}

.lang-link:hover {
    background-color: #2a5780;
    color: #fff;
}

.how-it-works{
    background:#fff;
    border-top:1px solid #eef0ed;
}

.how-it-works-title{
    color:#17221c;
    font-size:20px;
    font-weight:900;
    line-height:1.2;
    margin:0 0 16px;
}

.how-it-works-steps{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    text-align:center;
}

.step{
    position:relative;
    flex:0 1 170px;
    min-width:0;
    padding:0 7px;
}

.step:not(:last-child)::after{
    content:"➜";
    position:absolute;
    top:5px;
    left:calc(100% - 7px);
    width:auto;
    height:auto;
    background:transparent;
    color:#abb4bd;
    font-size:17px;
    font-weight:400;
    line-height:1;
    z-index:0;
}

.step-circle{
    width:29px;
    height:29px;
    background:#16834d;
    color:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:11px;
    font-weight:700;
    margin:auto;
    border:3px solid #e8f5ee;
    position:relative;
    z-index:2;
    box-shadow:0 2px 6px rgba(22,131,77,.2);
}

.step h6{
    color:#17221c;
    font-size:10px;
    line-height:1.2;
    font-weight:700;
    margin:8px 0 3px;
}

.step p{
    color:#536058;
    font-size:8px;
    line-height:1.35;
    margin:0;
}

@media (max-width:991px){

    .how-it-works-steps{
        flex-wrap:wrap;
        justify-content:center;
    }

    .step{
        flex:0 0 33.333%;
        margin-bottom:24px;
    }

    .step::after{
        display:none;
    }
}

@media (max-width:575px){
    .step{flex-basis:50%;}
}
  </style>
</head>

<body class="index-page">

  <!-- ======= Page Loader ======= -->
  <div id="pageLoader">
    <div class="loader-spinner"></div>
    <div class="loader-title" id="loaderTitle">D-Clutter Portal</div>
    <div class="loader-subtitle">Loading, please wait...</div>
  </div>
  <!-- End Page Loader -->

  <!-- ======= Header ======= -->
  @include('layouts.header')
  <!-- End Header -->

  @yield('content')

  <!-- ======= Footer ======= -->
  @include('layouts.footer')
  <!-- End Footer -->
<div>
    <a href="https://wa.me/9448197197"
   class="whatsapp-float text-decoration-none"
   target="_blank">
    <i class="fab fa-whatsapp"></i>
</a>
</div>

{{-- <div class="language-switcher">
    <a href="{{ route('locale.switch', 'en') }}" class="lang-link {{ app()->getLocale() === 'en' ? 'active' : '' }}">
        EN
    </a>
    <a href="{{ route('locale.switch', 'kn') }}" class="lang-link {{ app()->getLocale() === 'kn' ? 'active' : '' }}">
        ಕನ್ನಡ
    </a>
</div> --}}
  <!-- Preloader -->
  <div id="preloader"></div>

  @yield('script')

  <!-- Vendor JS Files -->
  <script src="{{asset('frontendwebsite/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('frontendwebsite/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('frontendwebsite/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('frontendwebsite/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('frontendwebsite/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('frontendwebsite/vendor/php-email-form/validate.js')}}"></script>
  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Main JS File -->
  <script src="{{asset('frontendwebsite/js/main.js')}}"></script>
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

  <script>
    function setLang(lang) {
      window.location.href = "{{ url('/local') }}/" + lang;
    }

    // ── Global page loader helpers ──────────────────────────────────────────
    const pageLoader    = document.getElementById('pageLoader');
    const loaderTitle   = document.getElementById('loaderTitle');

    function showLoader(msg) {
      loaderTitle.textContent = msg || 'Please wait…';
      pageLoader.classList.add('active');
    }

    function hideLoader() {
      pageLoader.classList.remove('active');
    }

    // Show on every form submit (unless the form has data-no-loader)
    document.addEventListener('submit', function (e) {
      const form = e.target;
      if (form.hasAttribute('data-no-loader')) return;
      if (!form.checkValidity()) return; // let browser/custom validation handle it
      showLoader(form.dataset.loaderMsg || 'Please wait…');
    });

    // Show on every internal link click (skip anchors, external, target=_blank)
    document.addEventListener('click', function (e) {
      const a = e.target.closest('a[href]');
      if (!a) return;
      const href = a.getAttribute('href');
      if (
        !href ||
        href.startsWith('#') ||
        href.startsWith('mailto:') ||
        href.startsWith('tel:') ||
        href.startsWith('javascript:') ||
        a.target === '_blank' ||
        a.hasAttribute('data-no-loader') ||
        href.startsWith('http') && !href.startsWith(window.location.origin)
      ) return;
      showLoader('Loading…');
    });

    // Hide loader if browser navigates back (bfcache restore)
    window.addEventListener('pageshow', function (e) {
      if (e.persisted) hideLoader();
    });
  </script>



<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "Select Constituency",
        allowClear: true,
        width: '100%'
    });
});
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

  @stack('scripts')
</body>
</html>
