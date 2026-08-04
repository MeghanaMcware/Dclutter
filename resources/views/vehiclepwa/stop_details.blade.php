@extends('vehiclepwa.layout.app')

@section('title') Stop Details @endsection
@section('heading') Stop Details @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .stop-nav-header { display: flex; align-items: center; justify-content: space-between; background: #fff; padding: 10px 16px; border-radius: 12px; border: 1px solid #f1f5f9; font-weight: 700; font-size: 14px; color: #0f172a; margin-bottom: 16px; }
        .stop-nav-header a { color: #64748b; text-decoration: none; font-size: 16px; }

        .stop-card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 16px; }
        .stop-card h2 { font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 6px; }
        .stop-card .address { font-size: 13px; color: #64748b; margin-bottom: 12px; line-height: 1.4; }
        .badge-waste-cat { background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 5px 12px; border-radius: 20px; display: inline-block; margin-bottom: 16px; }

        .info-group { margin-bottom: 16px; }
        .info-group label { font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 4px; letter-spacing: 0.5px; }
        .info-group p { font-size: 14px; font-weight: 600; color: #1e293b; margin: 0; }
        .instructions-list { margin: 0; padding-left: 18px; color: #334155; font-size: 13px; line-height: 1.6; font-weight: 500; }

        .contact-box { display: flex; align-items: center; justify-content: space-between; background: #f8fafc; padding: 12px 14px; border-radius: 12px; border: 1px solid #e2e8f0; }
        .contact-box .name { font-weight: 700; font-size: 14px; color: #0f172a; }
        .contact-box .phone { font-size: 12px; color: #64748b; }
        .btn-call { width: 40px; height: 40px; background: #dcfce7; color: #15803d; border-radius: 50%; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 16px; }

        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- Pagination -->
        <!-- <div class="stop-nav-header">
            <a href="#"><i class="fa-solid fa-arrow-left"></i></a>
            <span>Stop 7 of 35</span>
            <a href="#"><i class="fa-solid fa-arrow-right"></i></a>
        </div> -->

        <!-- Stop Card -->
        <div class="stop-card">
            <h2>RWA Green Heights</h2>
            <div class="address">12th Cross, BTM Layout 2nd Stage, Bengaluru - 560076</div>
            <span class="badge-waste-cat">C&D Waste</span>

            <div class="info-group">
                <label>Instructions</label>
                <ul class="instructions-list">
                    <li>Collect waste and update photo</li>
                    <li>Ensure safe loading</li>
                </ul>
            </div>

            <div class="info-group">
                <label>Waste Type</label>
                <p>Furniture</p>
            </div>

            <div class="info-group" style="margin-bottom: 0;">
                <label>Contact Person</label>
                <div class="contact-box">
                    <div>
                        <div class="name">Ramesh Babu</div>
                        <div class="phone">98765 12345</div>
                    </div>
                    <a href="tel:9876512345" class="btn-call"><i class="fa-solid fa-phone"></i></a>
                </div>
            </div>

            <!-- Action Button -->
            <a href="{{ route('driver.update_status') }}" class="btn-end-trip mt-5">
                <span>Arrived at Location</span>
            </a>
        </div>

    </div>
@endsection
