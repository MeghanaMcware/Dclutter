<header id="header" class="header">

    <!-- <div class="topbar d-flex align-items-baseline">
         <div class="container d-flex justify-content-center align-items-center justify-content-md-between mt-2">
             <div class="d-none d-md-flex align-items-baseline">
                 <i class="bi bi-phone me-1"></i> Call us now 8022221188
             </div>
             <div class="d-none d-md-flex align-items-baseline">
                 <i class="bi bi-envelope me-1"></i> Email :- example@gmail.com
             </div>
             <div class="d-flex align-items-center">
                 @if (App::getLocale() == 'en')
                    <a class="cta-btn" style="background-color: aquamarine;color:black" href="{{ url('/local/kn') }}">ಕ</a>
                 @else
                    <a class="cta-btn" style="background-color: aquamarine;color:black" href="{{ url('/local/en') }}">EN</a>
                 @endif
             </div>
         </div>
     </div> -->
    <!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

        <div class="container-fluid position-relative d-flex align-items-center justify-content-end">
            <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
                <img src="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}" alt="">
                <!-- Uncomment the line below if you also wish to use a text logo -->
                <h1 class="sitename text-success">D-Clutter</h1> 
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/') }}" class="nav-link-page {{ request()->is('/') ? 'bt-bottom' : '' }}">Home</a></li>
                    <li><a href="{{ route('citizen.report') }}" class="nav-link-page {{ request()->is('report-request') ? 'bt-bottom' : '' }}">Report Request</a></li>
                    <li><a href="{{ route('citizen.track') }}" class="nav-link-page {{ request()->is('track-request') ? 'bt-bottom' : '' }}">Track Request</a></li>
                    <li><a href="{{ url('/#processflow') }}" class="nav-link-section">Process Flow</a></li>
                    <li><a href="{{ route('citizen.report') }}" class="cta-btn" style="background:#007f4b !important; color:#fff !important;">Report D-Clutter Waste</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </div>

    <!-- Overlay behind the off-canvas mobile menu; needed for
         click-outside-to-close to work reliably -->
    <div class="mobile-nav-overlay"></div>

</header>

<div class="header-spacer"></div>

<style>
    .header .cta-btn {
        padding: 8px 15px 6px 15px !important;
        transition: all 0.3s ease;
        border-radius: 5px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
    }

    .bt-bottom{
    border-bottom: 2px solid #008150;
    }

    .header .cta-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Enhanced header responsiveness */
    .header {
        /* NOTE: backdrop-filter removed intentionally.
           backdrop-filter/filter on an ancestor creates a new
           "containing block" for any position:fixed descendant,
           so .mobile-nav-toggle and the off-canvas .navmenu were
           being positioned relative to .header instead of the
           real viewport - this was the root cause of the broken
           mobile menu. If you want the frosted-glass look back,
           apply backdrop-filter to a ::before pseudo-element on
           .header instead of the header itself, so it doesn't
           become a containing block for its children. */
        background: rgba(255, 255, 255, 0.95);
        transition: all 0.3s ease;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1030;
    }

    .header .branding {
        min-height: 70px;
        padding: 10px 0;
    }

    /* A fixed header is taken out of normal flow, so the page
       content right below it would otherwise sit underneath it.
       This spacer pushes the rest of the page down by exactly the
       header's rendered height (set dynamically below, since the
       header's height changes across breakpoints and on scroll). */
    .header-spacer {
        width: 100%;
    }

    /* Prevents the off-canvas panel (right: -100%) from ever
       creating a horizontal scrollbar on small screens */
    @media (max-width: 767px) {
        html, body {
            overflow-x: hidden;
        }
    }

    .logo img {
        transition: transform 0.3s ease;
        max-height: 50px;
        width: auto;
    }

    .logo:hover img {
        transform: scale(1.05);
    }

    .navmenu ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        align-items: center;
        gap: 2rem;
    }

    .navmenu ul li a {
        color: #2c3e50;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        padding: 0.5rem 0;
    }

    .navmenu ul li a::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: #667eea;
        transition: width 0.3s ease;
    }

    .navmenu ul li a:hover::after {
        width: 0px;
    }

    .navmenu ul li a:hover {
        color: #008150;
        transform: translateY(-1px);
    }

    .mobile-nav-toggle {
        display: none;
        font-size: 24px;
        cursor: pointer;
        color: #2c3e50;
        transition: all 0.3s ease;
        padding: 5px;
        border-radius: 5px;
    }

    .mobile-nav-toggle:hover {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    /* Dark overlay behind the off-canvas mobile menu */
    .mobile-nav-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 9998;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .mobile-nav-overlay.active {
        display: block;
        opacity: 1;
    }

    /* Hide the mobile-only "apply" link on desktop widths by default */
    .navmenu ul li.mobile-cta {
        display: none;
    }

    /* Mobile Devices (320px - 575px) */
    @media (max-width: 575px) {
        .branding {
            padding: 10px 0;
        }

        .container {
            padding: 0 15px;
        }

        .logo img {
            max-height: 40px;
        }

        .navmenu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            transition: right 0.3s ease;
            z-index: 9999;
            padding: 20px;
            overflow-y: auto;
        }

        .navmenu.navmenu-active {
            right: 0;
        }

        .navmenu ul {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
            padding-top: 60px;
        }

        .navmenu ul li {
            width: 100%;
        }

        .navmenu ul li a {
            display: block;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 16px;
            width: 100%;
        }

        .navmenu ul li a:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: none;
        }

        .navmenu ul li a::after {
            display: none;
        }

        .mobile-nav-toggle {
            display: block !important;
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 10000;
            background: white;
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .mobile-nav-toggle.mobile-nav-active {
            position: fixed;
        }

        .header .cta-btn {
            display: none !important;
        }

        /* Mobile CTA shown inside the off-canvas menu */
        .navmenu ul li.mobile-cta {
            display: block;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .navmenu ul li.mobile-cta a {
            background: #667eea;
            color: white !important;
            text-align: center;
            padding: 12px 20px !important;
            border-radius: 25px;
            font-weight: 600;
        }

        .navmenu ul li.mobile-cta a:hover {
            background: #5a67d8 !important;
        }
    }

    /* Small Tablets (576px - 767px) */
    @media (min-width: 576px) and (max-width: 767px) {
        .branding {
            padding: 12px 0;
        }

        .logo img {
            max-height: 45px;
        }

        .navmenu ul li a {
            font-size: 14px;
        }

        .header .cta-btn {
            padding: 6px 12px 5px 12px !important;
            font-size: 13px;
        }

        .mobile-nav-toggle {
            display: block !important;
        }

        .navmenu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 70%;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            transition: right 0.3s ease;
            z-index: 9999;
            padding: 20px;
            overflow-y: auto;
        }

        .navmenu.navmenu-active {
            right: 0;
        }

        .navmenu ul {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
            padding-top: 60px;
        }

        .navmenu ul li {
            width: 100%;
        }

        .navmenu ul li a {
            display: block;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 15px;
            width: 100%;
        }

        .navmenu ul li a:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: none;
        }

        .navmenu ul li a::after {
            display: none;
        }

        .mobile-nav-toggle {
            position: fixed;
            top: 15px;
            right: 15px;
            z-index: 10000;
            background: white;
            border-radius: 8px;
            padding: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header .cta-btn {
            display: none !important;
        }

        .navmenu ul li.mobile-cta {
            display: block;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .navmenu ul li.mobile-cta a {
            background: #667eea;
            color: white !important;
            text-align: center;
            padding: 12px 20px !important;
            border-radius: 25px;
            font-weight: 600;
        }

        .navmenu ul li.mobile-cta a:hover {
            background: #5a67d8 !important;
        }
    }

    /* Tablets (768px - 991px) */
    @media (min-width: 768px) and (max-width: 991px) {
        .branding {
            padding: 15px 0;
        }

        .logo img {
            max-height: 48px;
        }

        .navmenu ul {
            gap: 1.2rem;
        }

        .navmenu ul li a {
            font-size: 14px;
        }

        .header .cta-btn {
            padding: 7px 14px 6px 14px !important;
            font-size: 13px;
        }

        .mobile-nav-toggle {
            display: none;
        }
    }

    /* Small Laptops (992px - 1199px) */
    @media (min-width: 992px) and (max-width: 1199px) {
        .branding {
            padding: 18px 0;
        }

        .logo img {
            max-height: 52px;
        }

        .navmenu ul {
            gap: 1.6rem;
        }

        .navmenu ul li a {
            font-size: 15px;
        }

        .header .cta-btn {
            padding: 8px 16px 7px 16px !important;
            font-size: 15px;
        }

        .mobile-nav-toggle {
            display: none;
        }
    }

    /* Large Laptops and Desktops (1200px and up) */
    @media (min-width: 1200px) {
        .branding {
            padding: 20px 0;
        }

        .logo img {
            max-height: 55px;
        }

        .navmenu ul li a {
            font-size: 15px;
            padding: 0.75rem 0;
        }

        .header .cta-btn {
            padding: 10px 20px 8px 20px !important;
            font-size: 15px;
        }

        .mobile-nav-toggle {
            display: none;
        }

        .container {
            max-width: 1200px;
        }
    }

    /* Extra Large Screens (1400px and up) */
    @media (min-width: 1400px) {
        .branding {
            padding: 22px 0;
        }

        .logo img {
            max-height: 60px;
        }

        .navmenu ul li a {
            font-size: 17px;
        }

        .header .cta-btn {
            padding: 12px 24px 10px 24px !important;
            font-size: 17px;
        }

        .container {
            max-width: 1400px;
        }
    }

    /* Ultra-wide screens (1600px and up) */
    @media (min-width: 1600px) {
        .container {
            max-width: 1500px;
        }

        .navmenu ul li a {
            font-size: 15px;
            font-weight: bold;
        }

        .header .cta-btn {
            font-size: 16px;
            font-weight: bold;
        }
    }

    /* Header scroll effect */
    .header.scrolled {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    }

    .header.scrolled .logo img {
        max-height: 45px;
    }

    @media (max-width: 575px) {
        .header.scrolled .logo img {
            max-height: 35px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const mobileNavToggle = document.querySelector('.mobile-nav-toggle');
    const navmenu = document.querySelector('.navmenu');
    const overlay = document.querySelector('.mobile-nav-overlay');

    function closeMenu() {
        navmenu.classList.remove('navmenu-active');
        mobileNavToggle.classList.remove('mobile-nav-active');
        mobileNavToggle.classList.remove('bi-x');
        mobileNavToggle.classList.add('bi-list');
        if (overlay) overlay.classList.remove('active');
        document.body.style.overflow = '';
    }

    function openMenu() {
        navmenu.classList.add('navmenu-active');
        mobileNavToggle.classList.add('mobile-nav-active');
        mobileNavToggle.classList.remove('bi-list');
        mobileNavToggle.classList.add('bi-x');
        if (overlay) overlay.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    if (mobileNavToggle && navmenu) {
        mobileNavToggle.addEventListener('click', function() {
            if (navmenu.classList.contains('navmenu-active')) {
                closeMenu();
            } else {
                openMenu();
            }
        });

        // Close menu when clicking the overlay
        if (overlay) {
            overlay.addEventListener('click', closeMenu);
        }

        // Close menu when clicking outside (fallback for browsers without overlay support)
        document.addEventListener('click', function(e) {
            if (navmenu.classList.contains('navmenu-active') &&
                !navmenu.contains(e.target) && !mobileNavToggle.contains(e.target)) {
                closeMenu();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && navmenu.classList.contains('navmenu-active')) {
                closeMenu();
            }
        });

        // Close menu when clicking on a link
        const navLinks = navmenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', closeMenu);
        });

        // Reset menu state if the viewport is resized past the mobile breakpoint
        window.addEventListener('resize', function() {
            if (window.innerWidth > 767 && navmenu.classList.contains('navmenu-active')) {
                closeMenu();
            }
        });
    }

    // Header scroll effect
    const header = document.querySelector('.header');
    const headerSpacer = document.querySelector('.header-spacer');

    function syncHeaderSpacer() {
        if (header && headerSpacer) {
            headerSpacer.style.height = header.offsetHeight + 'px';
        }
    }

    if (header) {
        // Set initial spacer height, then keep it in sync since the
        // header's height changes across breakpoints and when '.scrolled'
        // shrinks the logo.
        syncHeaderSpacer();
        window.addEventListener('resize', syncHeaderSpacer);

        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            syncHeaderSpacer();
        });

        // Recheck after fonts/images finish loading, since that can
        // change the header's rendered height too.
        window.addEventListener('load', syncHeaderSpacer);
    }

    // Handle section navigation
    const sectionLinks = document.querySelectorAll('.nav-link-section');
    sectionLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href').substring(1);
            const targetSection = document.getElementById(targetId);

            if (targetSection) {
                // Section exists on current page - smooth scroll
                e.preventDefault();
                const headerHeight = document.querySelector('.header')?.offsetHeight || 0;
                const targetPosition = targetSection.offsetTop - headerHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

                // Close mobile menu if open
                if (navmenu.classList.contains('navmenu-active')) {
                    closeMenu();
                }
            }
        });
    });
});
</script>
