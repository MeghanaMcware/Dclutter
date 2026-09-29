@extends('userpwa.layout.app')

@section('title', 'Request Details - #DCL-2026-000023')
@section('heading', 'Request Details')

@section('style')
<style>
    .details-container { padding: 16px; display: flex; flex-direction: column; gap: 16px; padding-bottom: 30px; }
    
    .card-ui {
        background: #fff; border-radius: 16px; padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03); border: 1px solid #e2e8f0;
    }
    
    .ref-header {
        display: flex; justify-content: space-between; align-items: flex-start;
        border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 16px;
    }
    .ref-id { font-size: 18px; font-weight: 800; color: #0e7a43; }
    .ref-date { font-size: 12px; color: #64748b; margin-top: 2px; }
    .badge-status {
        padding: 6px 14px; font-size: 12px; font-weight: 700; border-radius: 8px;
        display: inline-flex; align-items: center; gap: 6px;
    }
    
    .timeline { position: relative; padding-left: 12px; margin-top: 20px; }
    .timeline::before {
        content: ''; position: absolute; left: 16.5px; top: 10px; bottom: 10px;
        width: 2px; background: #e2e8f0;
    }
    .timeline-item { position: relative; padding-left: 28px; margin-bottom: 24px; }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-item::before {
        content: ''; position: absolute; left: 0; top: 2px;
        width: 11px; height: 11px; border-radius: 50%;
        background: #e2e8f0; border: 2px solid #fff; box-shadow: 0 0 0 1px #cbd5e1;
        z-index: 1; transition: all 0.2s;
    }
    .timeline-item.active::before {
        background: #0e7a43; border-color: #fff; box-shadow: 0 0 0 1.5px #0e7a43;
    }
    .timeline-item p { margin: 0; font-size: 14px; font-weight: 600; color: #334155; }
    .timeline-item small { color: #64748b; font-size: 12px; display: block; margin-top: 3px; line-height: 1.4; }
    
    .driver-card {
        display: flex; align-items: center; gap: 12px; background: #f8fafc;
        padding: 12px; border-radius: 12px; border: 1px solid #e2e8f0;
        margin-top: 10px;
    }
    .driver-avatar {
        width: 40px; height: 40px; border-radius: 50%;
        background: #e1edd6; color: #0e7a43; display: flex; align-items: center; justify-content: center;
        font-size: 16px;
    }
    
    .facts-list { display: flex; flex-direction: column; gap: 16px; }
    .fact-item { display: flex; flex-direction: column; gap: 4px; }
    .fact-item small { color: #64748b; font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.5px; }
    .fact-item b { color: #334155; font-size: 14px; font-weight: 600; line-height: 1.4; }

    .photos-gallery { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 12px; }
    .photos-gallery img, .photos-gallery .dummy-photo { width: calc(33.33% - 7px); height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0; }
    
    .btn-back {
        background: #ffffff; color: #0e7a43; display: flex; align-items: center; justify-content: center; gap: 8px;
        border-radius: 12px; padding: 14px; font-weight: 700; text-decoration: none; width: 100%;
        border: 1.5px solid #0e7a43;
    }
    .btn-back:hover { background: #0e7a43; color: #ffffff !important; }
</style>
@endsection

@section('content')
<div class="details-container">
    <!-- Header Card (Completed State) -->
    <div class="card-ui">
        <div class="ref-header">
            <div>
                <div class="ref-id">#DCL-2026-000023</div>
                <div class="ref-date">Submitted: 30 Sep 2026, 09:15 AM</div>
            </div>
            <span class="badge-status" style="background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;">
                <i class="fa-solid fa-check-circle"></i> Completed
            </span>
        </div>

        <div class="timeline">
            <div class="timeline-item active">
                <p>Request Submitted</p>
                <small>30 Sep 2026, 09:15 AM</small>
            </div>
            <div class="timeline-item active">
                <p>Vehicle Assigned</p>
                <small>30 Sep 2026, 11:30 AM</small>
            </div>
            <div class="timeline-item active">
                <p>Waste Picked Up</p>
                <small>01 Oct 2026, 02:45 PM</small>
            </div>
            <div class="timeline-item active">
                <p>Disposed &amp; Completed</p>
                <small>Waste safely recycled/disposed at the facility</small>
            </div>
        </div>
    </div>

    <!-- Assigned Vehicle Details -->
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 14px; color: #1e293b; margin-bottom: 2px;">Assigned Collection Vehicle</h6>
        <div class="driver-card">
            <div class="driver-avatar"><i class="fa-solid fa-truck"></i></div>
            <div style="flex: 1;">
                <b style="color: #1e293b; font-size: 14px;">Ramesh Kumar (BBMP Driver)</b>
                <div style="font-size: 12px; color: #475569; margin-top: 2px;">
                    Vehicle: <strong>KA-02-AB-1234</strong>
                    | Tel: <a href="tel:9876543210" style="color: #0e7a43; font-weight: 700;">+91 9876543210</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Pickup Details Card -->
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 15px; color: #1e293b; margin-bottom: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
            Pickup Summary
        </h6>
        
        <div class="facts-list">
            <div class="fact-item">
                <small>Items Requested</small>
                <b>Electronic Waste</b>
                <span style="font-size: 13px; color: #0e7a43;font-weight: 600;">TV, Computers, Wiring</span>
            </div>

            <div class="fact-item">
                <small>Pickup Address</small>
                <b>
                    House No: 14B, Floor: Ground,
                    #13, Millers Tank Bund Road, Kaverappa Layout
                    <br><span style="color: #64748b; font-size: 12px;">Landmark: Near Mount Carmel College</span>
                    (PIN: 560052)
                </b>
            </div>

            <div class="fact-item">
                <small>Ward / Administrative Zone</small>
                <b>
                    Ward 93 - Vasanth Nagar | Shivajinagar (BBMP East)
                </b>
            </div>

            <div class="fact-item">
                <small>Scheduled Pickup Date</small>
                <b style="color: #0e7a43;">
                    Thursday, 01 October 2026
                </b>
            </div>

            <div class="fact-item">
                <small>Applicant Contact</small>
                <b>John Doe (+91 9876543210)</b>
            </div>
        </div>
    </div>
    
    <!-- Uploaded Photos Placeholder -->
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 15px; color: #1e293b; margin-bottom: 4px;">Uploaded Waste Photos</h6>
        <p style="font-size: 12px; color: #64748b; margin-bottom: 12px;">Evidence from your request submission:</p>
        
        <div class="photos-gallery">
            <div class="dummy-photo" style="background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                <i class="fa fa-image fa-2x"></i>
            </div>
            <div class="dummy-photo" style="background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                <i class="fa fa-image fa-2x"></i>
            </div>
        </div>
    </div>
    
    <a href="{{ route('user.history') }}" class="btn-back">
        <i class="fa fa-arrow-left"></i> Back to History
    </a>
</div>
@endsection
