@extends('userpwa.layout.app')

@section('title', 'Track Request')
@section('heading', 'Track Request')

@section('style')
<style>
    .track-container {
        padding: 20px;
    }
    .search-box {
        background: #fff;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        margin-bottom: 24px;
    }
    .form-label {
        font-weight: 600;
        font-size: 14px;
        color: #334155;
        margin-bottom: 12px;
    }
    .form-control {
        border-radius: 12px;
        padding: 12px 16px;
        border: 1px solid #cbd5e1;
        font-size: 15px;
    }
    .form-control:focus {
        border-color: #0e7a43;
        box-shadow: 0 0 0 3px rgba(14, 122, 67, 0.1);
    }
    .btn-search {
        background: #0e7a43;
        color: #fff;
        border-radius: 12px;
        padding: 12px;
        font-weight: 600;
        width: 100%;
        border: none;
        margin-top: 16px;
    }
    
    .status-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.03);
        margin-bottom: 16px;
        border-left: 4px solid #f59e0b; /* Pending */
    }
    .status-card.assigned { border-left-color: #3b82f6; }
    .status-card.picked_up { border-left-color: #f59e0b; }
    .status-card.dumped { border-left-color: #10b981; }
    
    .req-id {
        font-size: 14px;
        color: #1e293b;
        font-weight: 800;
        margin-bottom: 4px;
    }
    .req-date {
        font-size: 12px;
        color: #64748b;
        margin-bottom: 12px;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-pending { background: #fef3c7; color: #b45309; }
    .badge-assigned { background: #e0f2fe; color: #0369a1; }
    .badge-picked_up { background: #fef3c7; color: #b45309; }
    .badge-dumped { background: #dcfce7; color: #15803d; }
    
    .driver-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 12px;
        margin-top: 16px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .driver-icon {
        width: 40px; height: 40px;
        background: #e0f2fe; color: #0369a1;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
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
    
    <form action="{{ route('user.track') }}" method="GET" class="search-box">
        <label class="form-label">Enter Request ID or Mobile No.</label>
        <div class="input-group mb-2">
            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-hashtag text-primary"></i></span>
            <input type="text" name="id" class="form-control border-start-0 ps-0" placeholder="#REQ-123456" value="{{ request('id') ?? request('query') ?? ($wasteRequest?->request_number ?? '') }}" required>
        </div>
        <button type="submit" class="btn-search">Track Status</button>
    </form>

    @if($wasteRequest)
        @php
            $status = $wasteRequest->status;
            $statusClass = $status == 'dumped' ? 'dumped' : ($status == 'assigned' ? 'assigned' : ($status == 'picked_up' ? 'picked_up' : 'pending'));
        @endphp
        <h4 style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: #1e293b;">Tracking Result</h4>
        
        <div class="status-card {{ $statusClass }}">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="req-id">{{ $wasteRequest->request_number }}</div>
                <span class="badge-status badge-{{ $statusClass }}">
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </span>
            </div>
            <div class="req-date">Requested on: {{ $wasteRequest->created_at->format('d M Y, h:i A') }}</div>
            
            <div class="timeline">
                <div class="timeline-item active">
                    <p>Request Submitted</p>
                    <small>{{ $wasteRequest->created_at->format('d M Y, h:i A') }}</small>
                </div>
                <div class="timeline-item {{ in_array($status, ['assigned', 'picked_up', 'dumped']) ? 'active' : '' }}">
                    <p>Assigned to Vehicle</p>
                    <small>{{ in_array($status, ['assigned', 'picked_up', 'dumped']) ? 'Vehicle has been assigned' : 'Pending Assignment' }}</small>
                </div>
                <div class="timeline-item {{ in_array($status, ['picked_up', 'dumped']) ? 'active' : '' }}">
                    <p>Picked Up</p>
                    <small>{{ in_array($status, ['picked_up', 'dumped']) ? 'Waste collected from location' : 'Pending Pickup' }}</small>
                </div>
                <div class="timeline-item {{ $status == 'dumped' ? 'active' : '' }}">
                    <p>Disposed & Dumped</p>
                    <small>{{ $status == 'dumped' ? 'Waste successfully disposed' : 'Pending completion' }}</small>
                </div>
            </div>

            @if(in_array($status, ['assigned', 'picked_up']) && $wasteRequest->vehicle)
            <div class="driver-box">
                <div class="driver-icon"><i class="fa-solid fa-truck"></i></div>
                <div class="driver-details">
                    <p>{{ $wasteRequest->vehicle->driver_name ?? $wasteRequest->vehicle->owner?->name ?? 'Driver Assigned' }}</p>
                    <small>{{ $wasteRequest->vehicle->vehicle_number }} | {{ $wasteRequest->vehicle->driver_phone ?? $wasteRequest->vehicle->owner?->mobile_number }}</small>
                </div>
            </div>
            @endif

            <a href="{{ route('user.details', ['id' => $wasteRequest->request_number]) }}" class="btn btn-outline-success w-100 mt-4" style="border-radius: 10px; font-weight: 600;">View More Details</a>
        </div>
    @elseif(request('id') || request('query'))
        <div class="text-center py-5">
            <i class="fa fa-search fa-3x text-muted mb-3"></i>
            <h6 class="fw-bold">No Request Found</h6>
            <p class="text-muted small">We couldn't find any request matching your search.</p>
        </div>
    @endif
</div>
@endsection
