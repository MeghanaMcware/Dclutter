@extends('userpwa.layout.app')

@section('title', 'Request Details - ' . $wasteRequest->request_number)
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
        border-bottom: 1px solid #f1f5f9; padding-bottom: 14px; margin-bottom: 16px;
    }
    .ref-id { font-size: 16px; font-weight: 800; color: #0e7a43; margin-bottom: 4px; }
    .ref-date { font-size: 12px; color: #64748b; }
    
    .badge-status {
        padding: 6px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase;
        display: inline-flex; align-items: center; gap: 4px;
    }
    
    .facts-list { display: flex; flex-direction: column; gap: 14px; }
    .fact-item small { display: block; color: #64748b; font-size: 11px; margin-bottom: 4px; font-weight: 700; text-transform: uppercase; }
    .fact-item b { font-size: 14px; color: #1e293b; font-weight: 600; line-height: 1.4; display: block; }
    
    .timeline { position: relative; padding-left: 24px; margin-top: 10px; }
    .timeline::before {
        content: ''; position: absolute; left: 7px; top: 8px; bottom: 8px;
        width: 2px; background: #e2e8f0;
    }
    .timeline-item { position: relative; margin-bottom: 18px; }
    .timeline-item:last-child { margin-bottom: 0; }
    .timeline-item::before {
        content: ''; position: absolute; left: -24px; top: 3px;
        width: 16px; height: 16px; border-radius: 50%;
        background: #cbd5e1; border: 3px solid #fff;
    }
    .timeline-item.active::before { background: #0e7a43; box-shadow: 0 0 0 3px rgba(14,122,67,0.2); }
    .timeline-item p { margin: 0; font-size: 13px; font-weight: 700; color: #1e293b; }
    .timeline-item small { color: #64748b; font-size: 11px; }

    .photos-gallery {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; margin-top: 12px;
    }
    .photos-gallery img {
        width: 100%; height: 120px; object-fit: cover; border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .driver-card {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 12px;
        padding: 14px;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 12px;
    }
    .driver-avatar {
        width: 44px; height: 44px;
        background: #0e7a43; color: #fff;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px;
    }
    
    .btn-back {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        background: #ffffff; color: #0e7a43; border-radius: 12px;
        padding: 14px; font-weight: 700; text-decoration: none; width: 100%;
        border: 1.5px solid #0e7a43;
    }
    .btn-back:hover {
        background: #0e7a43; color: #ffffff !important;
    }
</style>
@endsection

@section('content')
@php
    $status = strtolower($wasteRequest->status ?? 'pending');
    
    if (in_array($status, ['completed', 'dumped'])) {
        $statusLabel = 'Completed';
        $badgeStyle = 'background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;';
        $icon = 'fa-check-circle';
    } elseif (in_array($status, ['rejected', 'cancelled', 'closed'])) {
        $statusLabel = 'Closed';
        $badgeStyle = 'background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;';
        $icon = 'fa-times-circle';
    } elseif ($status === 'assigned') {
        $statusLabel = 'Vehicle Assigned';
        $badgeStyle = 'background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;';
        $icon = 'fa-truck';
    } elseif (in_array($status, ['picked_up', 'in_transit'])) {
        $statusLabel = 'Picked Up';
        $badgeStyle = 'background: #fef3c7; color: #d97706; border: 1px solid #fde68a;';
        $icon = 'fa-box';
    } else {
        $statusLabel = 'Pending Pickup';
        $badgeStyle = 'background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;';
        $icon = 'fa-clock';
    }

    $categoriesText = is_array($wasteRequest->category_ids) ? implode(', ', $wasteRequest->category_ids) : ($wasteRequest->category_ids ?: 'Bulky Waste');
    $subcategoriesText = is_array($wasteRequest->subcategory_ids) ? implode(', ', $wasteRequest->subcategory_ids) : '';
    $wasteImages = is_array($wasteRequest->waste_images) ? $wasteRequest->waste_images : [];
@endphp

<div class="details-container">
    <!-- Header Card -->
    <div class="card-ui">
        <div class="ref-header">
            <div>
                <div class="ref-id">{{ $wasteRequest->request_number }}</div>
                <div class="ref-date">Submitted: {{ $wasteRequest->created_at->format('d M Y, h:i A') }}</div>
            </div>
            <span class="badge-status" style="{{ $badgeStyle }}">
                <i class="fa-solid {{ $icon }}"></i> {{ $statusLabel }}
            </span>
        </div>

        <div class="timeline">
            <div class="timeline-item active">
                <p>Request Submitted</p>
                <small>{{ $wasteRequest->created_at->format('d M Y, h:i A') }}</small>
            </div>
            <div class="timeline-item {{ in_array($status, ['assigned', 'picked_up', 'in_transit', 'completed', 'dumped']) ? 'active' : '' }}">
                <p>Vehicle Assigned</p>
                <small>{{ in_array($status, ['assigned', 'picked_up', 'in_transit', 'completed', 'dumped']) ? ($wasteRequest->assigned_at ? $wasteRequest->assigned_at->format('d M Y, h:i A') : 'Vehicle Assigned') : 'Pending Assignment' }}</small>
            </div>
            <div class="timeline-item {{ in_array($status, ['picked_up', 'in_transit', 'completed', 'dumped']) ? 'active' : '' }}">
                <p>Waste Picked Up</p>
                <small>{{ in_array($status, ['picked_up', 'in_transit', 'completed', 'dumped']) ? ($wasteRequest->picked_up_at ? $wasteRequest->picked_up_at->format('d M Y, h:i A') : 'Collected from doorstep') : 'Pending Pickup' }}</small>
            </div>
            <div class="timeline-item {{ in_array($status, ['completed', 'dumped']) ? 'active' : '' }}">
                <p>Disposed &amp; Completed</p>
                <small>{{ in_array($status, ['completed', 'dumped']) ? 'Waste safely recycled/disposed' : 'Pending Completion' }}</small>
            </div>
        </div>
    </div>

    <!-- Assigned Vehicle Details (if assigned) -->
    @if($wasteRequest->vehicle)
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 14px; color: #1e293b; margin-bottom: 2px;">Assigned Collection Vehicle</h6>
        <div class="driver-card">
            <div class="driver-avatar"><i class="fa-solid fa-truck"></i></div>
            <div style="flex: 1;">
                <b style="color: #1e293b; font-size: 14px;">{{ $wasteRequest->vehicle->driver_name ?? $wasteRequest->vehicle->owner?->name ?? 'BBMP Driver' }}</b>
                <div style="font-size: 12px; color: #475569; margin-top: 2px;">
                    Vehicle: <strong>{{ $wasteRequest->vehicle->vehicle_number }}</strong>
                    @if($wasteRequest->vehicle->driver_phone)
                        | Tel: <a href="tel:{{ $wasteRequest->vehicle->driver_phone }}" style="color: #0e7a43; font-weight: 700;">{{ $wasteRequest->vehicle->driver_phone }}</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <!-- Pickup Details Card -->
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 15px; color: #1e293b; margin-bottom: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
            Pickup Summary
        </h6>
        
        <div class="facts-list">
            <div class="fact-item">
                <small>Items Requested</small>
                <b>{{ $categoriesText }}</b>
                @if($subcategoriesText)
                    <span style="font-size: 12px; color: #64748b;">{{ $subcategoriesText }}</span>
                @endif
            </div>

            <div class="fact-item">
                <small>Pickup Address</small>
                <b>
                    @if($wasteRequest->house_no) House No: {{ $wasteRequest->house_no }}, @endif
                    @if($wasteRequest->floor_no) Floor: {{ $wasteRequest->floor_no }}, @endif
                    {{ $wasteRequest->address }}
                    @if($wasteRequest->landmark) <br><span style="color: #64748b; font-size: 12px;">Landmark: {{ $wasteRequest->landmark }}</span> @endif
                    @if($wasteRequest->pincode) (PIN: {{ $wasteRequest->pincode }}) @endif
                </b>
            </div>

            <div class="fact-item">
                <small>Ward / Administrative Zone</small>
                <b>
                    {{ $wasteRequest->ward ? "Ward {$wasteRequest->ward->ward_number} - {$wasteRequest->ward->name}" : 'BBMP Ward' }}
                    @if($wasteRequest->constituency) | {{ $wasteRequest->constituency->name }} @endif
                    @if($wasteRequest->corporation) ({{ $wasteRequest->corporation->name }}) @endif
                </b>
            </div>

            <div class="fact-item">
                <small>Scheduled Pickup Date</small>
                <b style="color: #0e7a43;">
                    {{ $wasteRequest->preferred_pickup_date ? $wasteRequest->preferred_pickup_date->format('l, d F Y') : '-' }}
                </b>
            </div>

            <div class="fact-item">
                <small>Applicant Contact</small>
                <b>{{ $wasteRequest->applicant_name ?: 'Applicant' }} ({{ $wasteRequest->mobile_number }})</b>
            </div>
        </div>
    </div>
    
    <!-- Uploaded Photos -->
    @if(count($wasteImages) > 0)
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 15px; color: #1e293b; margin-bottom: 4px;">Uploaded Waste Photos</h6>
        <p style="font-size: 12px; color: #64748b; margin-bottom: 12px;">Evidence from your request submission:</p>
        
        <div class="photos-gallery">
            @foreach($wasteImages as $img)
                <a href="{{ asset('storage/' . $img) }}" target="_blank">
                    <img src="{{ asset('storage/' . $img) }}" alt="Waste Photo" onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'bg-light p-3 text-center text-muted\'>Image unavailable</div>';">
                </a>
            @endforeach
        </div>
    </div>
    @endif
    
    <a href="{{ route('user.track') }}" class="btn-back">
        <i class="fa fa-arrow-left"></i> Back to Tracking List
    </a>
</div>
@endsection
