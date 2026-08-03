@extends('layouts.app')

<style>
    /* Hero Section */
    #herosection {
        position: relative;
        width: 100%;
        min-height: 80vh;
        background: url('{{ asset('frontendwebsite/img/vidansoudhanew.jpg') }}') center center/cover no-repeat;
        color: #fff;
        text-align: center;
        padding: 2rem 1rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* heading centered, buttons at bottom */
        align-items: center;
    }

    /* Overlay for better text visibility */
    #herosection::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    #herosection h1 {
        position: relative;
        z-index: 2;
        font-size: 65px;
        font-weight: bold;
        margin: 0;
        margin-top: auto;
        /* vertical center effect */
        margin-bottom: auto;
    }

    #herosection .content {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 1200px;
        /* margin-bottom: 2rem; */
        /* push buttons above bottom */
    }

    #herosection .services {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.7rem;
    }

    #herosection .services .btn {
        font-size: 16px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        flex: 1 1 auto;
        /* max-width: 235px; */
    }

    .btn-width {
        max-width: 235px;
    }

    #herosection .services .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    /* Tablet / medium screens */
    @media (max-width: 768px) {
        #herosection h1 {
            font-size: 2rem;
        }

        #herosection {
            min-height: 300px;
        }

        #herosection .services .btn {
            font-size: 0.85rem;
            padding: 0.4rem 0.9rem;
            max-width: 120px;
        }
    }

    /* Mobile / small screens */
    @media (max-width: 480px) {
        #herosection h1 {
            font-size: 1.5rem;
        }

        #herosection .services .btn {
            flex: 0 0 48%;
            width: 48%;
            max-width: none;
            margin-bottom: 0.5rem;
        }

        .nav-pills .nav-link {
            padding: 7px 0px 4px 0px !important;
        }
    }

    .carousel-item {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .carousel-item .container {
        position: relative;
        z-index: 2;
        color: #fff;
    }

    .carousel-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Black opacity */
    .carousel-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        /* ðŸ‘ˆ change 0.5 to 0.6 or 0.7 if darker needed */
        z-index: 1;
    }

    .carousel-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        z-index: 2;
        text-align: center;
    }

    .carousel-item .container1 {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 2;
        color: #fff;
        width: 100%;
    }

    .carousel-item .container2 {
        position: absolute;
        top: 85%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        z-index: 2;
        color: #fff;
        width: 100%;
    }

    .hero h2 {
        font-size: 70px;
        font-weight: 800;
    }

    .service-font {
        font-size: 30px;
        font-weight: 600;
        color: #fff;
    }

    /* bWCC information css */
    /* Tabs */
    .nav-pills {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .nav-pills .nav-item {
        flex: 1 1 45%;
        /* two buttons per row on small screens */
        margin: 0.3rem;
    }

    .nav-pills .nav-link {
        width: 100%;
        text-align: center;
        border-radius: 50px !important;
        padding: 0.7rem 0;
        font-weight: 600;
        font-size: 18px;
        background-color: #e1e7f7;
        color: #1f3c88;
        transition: all 0.3s;
        position: relative;
    }

    .nav-pills .nav-link:hover {
        background-color: #d0d8f0;
        transform: translateY(-2px);
    }

    .nav-pills .nav-link.active {
        color: #fff;
        background: linear-gradient(45deg, #f8b500, #ff6f00);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        font-weight: 600;
    }

    .nav-pills .nav-link.active::after {
        content: "";
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 50%;
        height: 10px;
        border-radius: 5px;
        background-color: #3362a7;
    }

    /* On larger screens, 5 tabs in a row */
    @media(min-width: 768px) {
        .nav-pills .nav-item {
            flex: 1 1 auto;
            /* auto width on tablet/desktop */
            margin: 0.5rem;
        }

        .nav-pills .nav-link {
            padding: 0.7rem 1.6rem;
        }
    }

    /* News Cards */
    .news-card {
        transition: all 0.3s;
        border: none;
        border-radius: 15px;
        background: #fff;
        padding: 1.2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 6px rgb(0 0 0 / 25%);
    }

    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.15);
    }

    .news-card i {
        font-size: 2.2rem;
        color: #ff6f00;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .news-date {
        font-size: 17px;
        font-weight: 600;
        color: #888;
        /* margin-bottom: 0.5rem; */
    }

    @media (min-width: 768px) {
        .news-card {
            display: flex;
            align-items: flex-start;
        }

        .news-card i {
            margin-top: 0.2rem;
        }

        .hero h2 {
            font-size: 35px;
            font-weight: 800;
        }
    }

    p {
        margin-bottom: 0;
    }

    /* bWCC end information css */
    .textdarkget {
        font-size: 17px;
        font-weight: 600;
        color: #212529bd !important;
    }

    .featured-services .service-item:hover span a {
        color: white !important;
    }

    .section-title {
        padding-bottom: 5px !important
    }

    .section-title h2 {
        font-weight: 700;
        /* margin-bottom: 1rem; */
        color: #1f3c88;
        font-size: 35px !important;
        text-align: center;
    }

    .section-title p {
        font-size: 18px !important;
        margin-bottom: 10px !important
    }

    .bwccaboutfont {
        font-size: 20px;
        font-weight: 700;
        color: #555555;
    }



    /* Service buttons */
    .btn-service {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        font-size: 16px;
        text-align: center;
    }

    .btn-service-light {
        background-color: #eaedef;
        color: i #000;
    }

    .btn-service-dark {
        background-color: #d4e5fb;
        color: #000;
    }

    .btn-service:hover {
        transform: translateY(-3px);
        opacity: 0.85;
    }

    .bg-image {
        background-image: url(../images/Banner.png);
        background-repeat: no-repeat;
        background-size: cover;
    }

    .btn-light {
        background-color: #eaedef !important;
        color: #000 !important;
    }

    .btn-dark {
        background-color: #d4e5fb !important;
        color: #000 !important;
    }

    .cta-btn {
        color: var(--contrast-color);
        background: var(--accent-color);
        font-size: 18px;
        font-weight: 600;
        padding: 8px 20px;
        /* margin: 0 5px 0 30px; */
        border-radius: 4px;
        transition: 0.3s;
    }





    /* HERO */

    /* .hero {

        background: linear-gradient(#eef3f8, #f8fafc),
            url("https://img.freepik.com/premium-vector/excavator-loading-truck-with-stones_1308-118703.jpg");

        background-repeat: no-repeat;
        background-position: right bottom;
        background-size: 520px;
        padding: 80px 0;
        border-bottom: 1px solid #dfe6ee;

    } */

    .hero h1 {
        color: #1f4e79;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .hero p {
        font-size: 16px;
        color: #444;
        line-height: 1.8;
        max-width: 520px;
    }

    .highlight {
        font-weight: 700;
    }

    .green {
        color: #1ca66f;
        font-weight: 600;
    }

    .apply-btn {
        background: #2f8f4e;
        color: white;
        padding: 12px 28px;
        border-radius: 6px;
        font-weight: 600;
        margin-top: 15px;
    }

    .apply-btn:hover {
        background: #247540;
        color: white !important;
    }

    /* a:hover {
        color: black !important;
    } */

    /* GUIDELINES */

    .guideline-title {
        text-align: center;
        font-weight: 700;
        color: #1f4e79;
        margin: 50px 0 25px;
    }

    .guidelines {
        background: #eef2f6;
        border-radius: 10px;
        padding: 30px;
    }

    .step {
        display: flex;
        gap: 18px;
        padding: 25px;
        border-bottom: 1px dashed #d6dbe3;
    }

    .step:last-child {
        border-bottom: none;
    }

    .step img {
        width: 55px;
        height: 55px;
    }

    .step h5 {
        color: #1f4e79;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .step p {
        margin: 0;
        color: #000;
    }

    .divider {
        border-right: 1px dashed #d6dbe3;
    }
       .heropara {
        font-size: 18px !important;
    }

    @media(max-width:768px) {
   .section-title h2 {
        font-size: 20px !important;
    }
        .hero {
            background-size: 280px;
            background-position: center bottom;
            padding-bottom: 220px;
        }

        .divider {
            border-right: none;
        }

    }

    .herohead {
        color: #1f4e79;
        font-weight: 700;
        margin-bottom: 20px;
        text-align: center;
        font-size: 20px;
    }

    .heropara {
        font-size: 16px !important;
        color: #444;
        line-height: 1.8;
        text-align: justify;
    }

    .newbutton {
        background: #3362a7;
        color: white;
        padding: 12px 28px;
        border-radius: 6px;
        font-weight: 600;
        margin-top: 15px;
    }

    .main {
        background-color: #f5f8fb;
    }
    
    .newbuttonabsolute{
    position: absolute;
    top: 75%;
    left: 50%;
    z-index: 1;
    transform: translate(-50%, -50%);
    }
</style>

@section('content')
    <main class="main">

        <section id="herosection">
            <!-- Heading vertically centered -->
            <h1 class="text-white">{{ __('messages.udmshead') }}</h1>
            <div class="d-flex flex-row gap-3 newbuttonabsolute">
                <a href="" style="z-index: 1;    background: #00bec2;
    border: 1px solid #9085a7;white-space: nowrap;" class="btn btn-primary">Vehicle Registration</a>
                <a href="" style="z-index: 1;    background: #00bec2;
    border: 1px solid #00bec2;white-space: nowrap;" class="btn btn-primary">Citizen (Raise Request)</a>
            </div>
            

        </section>


        <div class="container-fluid py-5" id="aboutUDMS">
            <div class="container section-title">
                <h2>{{ __('messages.udmsabout') }}</h2>
            </div>
            <section class="" style="background-color: #f5f8fb;">

                <div class="container">

                    <div class="row align-items-center">

                        <div class="col-lg-6 mb-3">

                            <h1 class="herohead">{{ __('messages.udmshead1') }}</h1>

                            <p class="heropara">
                                {!! __('messages.udmsintro') !!}
                              
                            </p>

                           <!-- <a href="" target="_blank" class="cta-btn newbutton d-md-none d-flex text-center">
                                 {!! __('messages.applywasteapproval') !!}
                            </a>  -->

                        </div>
                        <div class="col-lg-6">

                            <img src="{{ asset('frontendwebsite/img/UDMS (Unified Debris Management System)-image.png') }}" width="100%" alt="UDMS" style="border-radius: 5px;" class="img-fluid">

                        </div>

                    </div>

                </div>

            </section>

        </div>

        <!-- Featured Services Section -->
        <section class="featured-services section" id="guidelines" style="background-color: #f5f8fb;">
            <div class="container section-title">
                <h2>{!! __('messages.guildlinestext') !!} <br></h2>
            </div><!-- End Section Title -->
            <div class="container-fluid">

<img src="{{ asset('frontendwebsite/img/newprocessflowwebsite.png') }}" width="100%" alt="Guidelines" style="border-radius: 5px;" class="img-fluid">

                {{-- <div class="guidelines pb-3">

                    <div class="row">

                        <!-- LEFT -->

                        <div class="col-md-6 divider">

                            <div class="step">
                                <img src="{{ asset('frontendwebsite/img/ApplyThroughUDMS.png') }}">
                                <div>
                                    <h5>{!! __('messages.applythroughudms') !!}</h5>
                                    <p>{!! __('messages.applythroughudmsdesc') !!}</p>
                                </div>
                            </div>

                            <div class="step">
                                <img src="{{ asset('frontendwebsite/img/challangeneration.png') }}">
                                <div>
                                    <h5>{!! __('messages.challangeneration') !!}</h5>
                                    <p>{!! __('messages.challangenerationdesc') !!}</p>
                                </div>
                            </div>

                            <div class="step">
                                <img src="{{ asset('frontendwebsite/img/notificationupdates.png') }}">
                                <div>
                                    <h5>{!! __('messages.notificationupdates') !!}</h5>
                                    <p>{!! __('messages.notificationupdatesdesc') !!}</p>
                                </div>
                            </div>

                        </div>


                        <!-- RIGHT -->

                        <div class="col-md-6">

                            <div class="step">
                                <img src="{{ asset('frontendwebsite/img/fillapplicationform.png') }}">
                                <div>
                                    <h5>{!! __('messages.fillapplicationform') !!}</h5>
                                    <p>{!! __('messages.fillapplicationformdesc') !!}</p>
                                </div>
                            </div>

                            <div class="step">
                                <img src="{{ asset('frontendwebsite/img/PlantAssignment.png') }}">
                                <div>
                                    <h5>{!! __('messages.plantassignment') !!}</h5>
                                    <p>{!! __('messages.plantassignmentdesc') !!}</p>
                                </div>
                            </div>

                            <div class="step">
                                <img src="{{ asset('frontendwebsite/img/RaiseDisposalTickets.png') }}">
                                <div>
                                    <h5>{!! __('messages.raisedisposaltickets') !!}</h5>
                                    <p>{!! __('messages.raisedisposalticketsdesc') !!}</p>
                                </div>
                            </div>

                        </div>

                    </div>

                </div> --}}

            </div>

        </section><!-- /Featured Services Section -->






    </main>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Application Submitted Successfully',
        text: @json(session('success')),
        confirmButtonColor: '#1f4e79'
    });
</script>
@endif
@endsection