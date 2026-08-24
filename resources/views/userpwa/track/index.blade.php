@extends('userpwa.layout.app')

@section('title', 'Track Request')
@section('heading', 'Track Request')

@section('style')
<style>
    .track-container { padding: 20px; }
    .search-box {
        background: #fff; padding: 24px; border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03); margin-bottom: 24px;
    }
    .form-label { font-weight: 600; font-size: 14px; color: #334155; margin-bottom: 12px; }
    .form-control { border-radius: 12px; padding: 12px 16px; border: 1px solid #cbd5e1; font-size: 15px; }
    .form-control:focus { border-color: #0e7a43; box-shadow: 0 0 0 3px rgba(14, 122, 67, 0.1); }
    .btn-search {
        background: #0e7a43; color: #fff; border-radius: 12px; padding: 12px;
        font-weight: 600; width: 100%; border: none; margin-top: 16px;
    }
    .status-card {
        background: #fff; border-radius: 16px; padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03); margin-bottom: 16px;
        border-left: 4px solid #3b82f6;
    }
    .req-id { font-size: 14px; color: #1e293b; font-weight: 800; margin-bottom: 4px; }
    .req-date { font-size: 12px; color: #64748b; margin-bottom: 12px; }
    .badge-status {
        padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;
        background: #e0f2fe; color: #0369a1;
    }
    .driver-box {
        background: #f8fafc; border-radius: 12px; padding: 12px;
        margin-top: 16px; display: flex; align-items: center; gap: 12px;
    }
    .driver-icon {
        width: 40px; height: 40px; background: #e0f2fe; color: #0369a1;
        border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px;
    }
    .driver-details p { margin: 0; font-size: 13px; color: #1e293b; font-weight: 700; }
    .driver-details small { color: #64748b; font-size: 11px; }
    
    .timeline { margin-top: 16px; position: relative; padding-left: 20px; }
    .timeline::before {
        content: ''; position: absolute; left: 6px; top: 8px; bottom: 8px;
        width: 2px; background: #e2e8f0;
    }
    .timeline-item { position: relative; margin-bottom: 16px; }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-item::before {
        content: ''; position: absolute; left: -19px; top: 4px;
        width: 10px; height: 10px; border-radius: 50%;
        background: #cbd5e1; border: 2px solid #fff;
    }
    .timeline-item.active::before { background: #0e7a43; box-shadow: 0 0 0 3px rgba(14,122,67,0.2); }
    .timeline-item p { margin: 0; font-size: 13px; font-weight: 700; color: #1e293b; }
    .timeline-item small { color: #64748b; font-size: 11px; }
</style>
@endsection

@section('content')
<div class="track-container">
    <div class="search-box">
        <label class="form-label">Enter Request ID or Mobile No.</label>
        <div class="input-group mb-2">
            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-hashtag text-primary"></i></span>
            <input type="text" class="form-control border-start-0 ps-0" placeholder="#REQ-123456" value="REQ-2026-000018">
        </div>
        <button type="button" class="btn-search">Track Status</button>
    </div>

    <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: #1e293b;">Tracking Result</h4>
    
    <div class="status-card">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="req-id">#REQ-2026-000018</div>
            <span class="badge-status">Assigned</span>
        </div>
        <div class="req-date">Requested on: 19 Aug 2026, 04:03 AM</div>
        
        <div class="timeline">
            <div class="timeline-item active">
                <p>Request Submitted</p>
                <small>19 Aug 2026, 04:03 AM</small>
            </div>
            <div class="timeline-item active">
                <p>Verified</p>
                <small>Verified by BBMP Team</small>
            </div>
            <div class="timeline-item active">
                <p>Assigned to Vehicle</p>
                <small>Vehicle has been assigned</small>
            </div>
            <div class="timeline-item">
                <p>Picked Up</p>
                <small>Pending Pickup</small>
            </div>
            <div class="timeline-item">
                <p>Disposed & Dumped</p>
                <small>Pending completion</small>
            </div>
        </div>

        <div class="driver-box">
            <div class="driver-icon"><i class="fa-solid fa-truck"></i></div>
            <div class="driver-details">
                <p>suprith</p>
                <small>KA07S7242 | 9999999999</small>
            </div>
        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('user.details') }}" class="btn btn-outline-success flex-fill" style="border-radius: 10px; font-weight: 600;">View Details</a>
            <!-- <a href="{{ route('user.edit') }}" class="btn btn-outline-primary flex-fill" style="border-radius: 10px; font-weight: 600;">Edit Request</a> -->
        </div>
    </div>
</div>
@endsection
