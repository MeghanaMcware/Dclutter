@extends('userpwa.layout.app')

@section('title', 'Request Details')
@section('heading', 'Request Details')

@section('style')
<style>
    .details-container { padding: 20px; }
    
    .card-ui {
        background: #fff; border-radius: 16px; padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03); margin-bottom: 20px;
    }
    
    .ref-header {
        display: flex; justify-content: space-between; align-items: flex-start;
        border-bottom: 1px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 16px;
    }
    .ref-id { font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 4px; }
    .ref-date { font-size: 12px; color: #64748b; }
    
    .badge-status {
        padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;
        background: #e0f2fe; color: #0369a1;
    }
    
    .facts-list { display: flex; flex-direction: column; gap: 16px; }
    .fact-item small { display: block; color: #64748b; font-size: 11px; margin-bottom: 4px; font-weight: 600; }
    .fact-item b { font-size: 14px; color: #1e293b; }
    
    .photos-gallery {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 12px;
    }
    .photos-gallery img {
        width: 100%; height: 120px; object-fit: cover; border-radius: 12px;
        border: 1px solid #e2e8f0;
    }
    
    .btn-back {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: #f1f5f9; color: #475569; border-radius: 12px;
        padding: 14px; font-weight: 700; text-decoration: none; width: 100%;
    }
</style>
@endsection

@section('content')
<div class="details-container">
    <div class="card-ui">
        <div class="ref-header">
            <div>
                <div class="ref-id">#REQ-2026-000018</div>
                <div class="ref-date">Requested on: 19 Aug 2026, 04:03 AM</div>
            </div>
            <span class="badge-status">Assigned</span>
        </div>
        
        <div class="facts-list">
            <div class="fact-item">
                <small>Pickup Address</small>
                <b>8888, Kaverappa Layout, Vasanth Nagar, Bengaluru...</b>
            </div>
            <div class="fact-item">
                <small>Waste Categories</small>
                <b>Other Items</b>
            </div>
            <div class="fact-item">
                <small>Ward / Zone</small>
                <b>Vasanth Nagar (Ward 3)</b>
            </div>
            <div class="fact-item">
                <small>Scheduled Pickup</small>
                <b>23 Aug 2026 (Sunday)</b>
            </div>
            <div class="fact-item">
                <small>Assigned Vehicle</small>
                <b>KA07S7242 (suprith)</b>
            </div>
        </div>
    </div>
    
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 15px; color: #1e293b; margin-bottom: 4px;">Uploaded Photos</h6>
        <p style="font-size: 12px; color: #64748b; margin-bottom: 12px;">Evidence from submission:</p>
        
        <div class="photos-gallery">
            <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 120px; border-radius: 12px; border: 1px dashed #cbd5e1;">
                Waste Image
            </div>
        </div>
    </div>
    
    <a href="{{ route('user.track') }}" class="btn-back">
        <i class="fa fa-arrow-left"></i> Back to Tracking
    </a>
</div>
@endsection
