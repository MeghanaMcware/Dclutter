@extends('userpwa.layout.app')

@section('title', 'Request Details - #' . $wasteRequest->request_number)
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
@php
    $status = strtolower($wasteRequest->status ?? 'pending');
    $isSubmitted = true;
    $isAssigned = in_array($status, ['assigned', 'scheduled', 'picked_up', 'dumped', 'completed']) || !empty($wasteRequest->vehicle_id);
    $isPickedUp = in_array($status, ['picked_up', 'dumped', 'completed']) || !empty($wasteRequest->picked_up_at);
    $isCompleted = in_array($status, ['dumped', 'completed']);

    $badgeClass = match($status) {
        'dumped', 'completed' => 'background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;',
        'picked_up' => 'background: #ecfeff; color: #0891b2; border: 1px solid #a5f3fc;',
        'assigned', 'scheduled' => 'background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;',
        'not_available', 'rescheduled' => 'background: #f5f3ff; color: #7c3aed; border: 1px solid #ddd6fe;',
        'rejected' => 'background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;',
        'closed' => 'background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;',
        default => 'background: #fff7ed; color: #ea580c; border: 1px solid #ffedd5;'
    };
    $badgeIcon = match($status) {
        'dumped', 'completed' => 'fa-solid fa-check-circle',
        'picked_up' => 'fa-solid fa-box',
        'assigned', 'scheduled' => 'fa-solid fa-truck',
        'not_available', 'rescheduled' => 'fa-solid fa-calendar-alt',
        'rejected' => 'fa-solid fa-times-circle',
        'closed' => 'fa-solid fa-ban',
        default => 'fa-solid fa-clock'
    };
    $badgeLabel = match($status) {
        'pending' => 'Pending',
        'assigned', 'scheduled' => 'Assigned',
        'rescheduled', 'not_available' => 'Rescheduled',
        'picked_up' => 'Picked Up',
        'dumped', 'completed' => 'Dumped',
        'rejected' => 'Rejected',
        'closed' => 'Closed',
        default => ucfirst(str_replace('_', ' ', $status))
    };
    $categories = is_array($wasteRequest->category_ids) ? implode(', ', $wasteRequest->category_ids) : ($wasteRequest->category_ids ?: 'N/A');
    $subcategories = is_array($wasteRequest->subcategory_ids) ? implode(', ', $wasteRequest->subcategory_ids) : ($wasteRequest->subcategory_ids ?: '');
    $images = is_array($wasteRequest->waste_images) ? $wasteRequest->waste_images : [];
@endphp

<div class="details-container">
    <!-- Header Card -->
    <div class="card-ui">
        <div class="ref-header">
            <div>
                <div class="ref-id">#{{ $wasteRequest->request_number }}</div>
                <div class="ref-date">Submitted: {{ $wasteRequest->created_at ? $wasteRequest->created_at->format('d M Y, h:i A') : 'N/A' }}</div>
            </div>
            <span class="badge-status" style="{{ $badgeClass }}">
                <i class="{{ $badgeIcon }}"></i> {{ $badgeLabel }}
            </span>
        </div>

        <div class="timeline">
            <div class="timeline-item {{ $isSubmitted ? 'active' : '' }}">
                <p>Request Submitted</p>
                <small>{{ $wasteRequest->created_at ? $wasteRequest->created_at->format('d M Y, h:i A') : 'Recorded' }}</small>
            </div>
            <div class="timeline-item {{ $isAssigned ? 'active' : '' }}">
                <p>Vehicle Assigned</p>
                <small>{{ $wasteRequest->assigned_at ? $wasteRequest->assigned_at->format('d M Y, h:i A') : ($isAssigned ? 'Vehicle allocated' : 'Awaiting assignment') }}</small>
            </div>
            <div class="timeline-item {{ $isPickedUp ? 'active' : '' }}">
                <p>Waste Picked Up</p>
                <small>{{ $wasteRequest->picked_up_at ? $wasteRequest->picked_up_at->format('d M Y, h:i A') : ($isPickedUp ? 'Picked up' : 'Pending collection') }}</small>
            </div>
            <div class="timeline-item {{ $isCompleted ? 'active' : '' }}">
                <p>Disposed &amp; Completed</p>
                <small>{{ $isCompleted ? 'Waste safely recycled/disposed at the facility' : 'Pending disposal' }}</small>
            </div>
        </div>
    </div>

    @if($wasteRequest->vehicle)
    <!-- Assigned Vehicle Details -->
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 14px; color: #1e293b; margin-bottom: 2px;">Assigned Collection Vehicle</h6>
        <div class="driver-card">
            <div class="driver-avatar"><i class="fa-solid fa-truck"></i></div>
            <div style="flex: 1;">
                <b style="color: #1e293b; font-size: 14px;">{{ $wasteRequest->vehicle->driver_name ?? ($wasteRequest->vehicle->owner?->name ?? 'BBMP Driver') }}</b>
                <div style="font-size: 12px; color: #475569; margin-top: 2px;">
                    Vehicle: <strong>{{ $wasteRequest->vehicle->vehicle_number }}</strong>
                    @if(!empty($wasteRequest->vehicle->driver_phone) || !empty($wasteRequest->vehicle->owner?->mobile_number))
                        | Tel: <a href="tel:{{ $wasteRequest->vehicle->driver_phone ?? $wasteRequest->vehicle->owner?->mobile_number }}" style="color: #0e7a43; font-weight: 700;">+91 {{ $wasteRequest->vehicle->driver_phone ?? $wasteRequest->vehicle->owner?->mobile_number }}</a>
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
                <b>{{ $categories }}</b>
                @if($subcategories)
                    <span style="font-size: 13px; color: #0e7a43; font-weight: 600;">{{ $subcategories }}</span>
                @endif
            </div>

            <div class="fact-item">
                <small>Pickup Address</small>
                <b>
                    @if($wasteRequest->house_no) House No: {{ $wasteRequest->house_no }}, @endif
                    @if($wasteRequest->floor_no || $wasteRequest->floor) Floor: {{ $wasteRequest->floor_no ?: $wasteRequest->floor }}, @endif
                    {{ $wasteRequest->address }}
                    @if($wasteRequest->landmark)
                        <br><span style="color: #64748b; font-size: 12px;">Landmark: {{ $wasteRequest->landmark }}</span>
                    @endif
                    @if($wasteRequest->pincode)
                        (PIN: {{ $wasteRequest->pincode }})
                    @endif
                </b>
            </div>

            <div class="fact-item">
                <small>Ward / Administrative Zone</small>
                <b>
                    {{ $wasteRequest->ward?->name ?? 'Ward N/A' }} 
                    @if($wasteRequest->constituency) | {{ $wasteRequest->constituency->name }} @endif
                    @if($wasteRequest->corporation) ({{ $wasteRequest->corporation->name }}) @endif
                </b>
            </div>

            <div class="fact-item">
                <small>Scheduled Pickup Date</small>
                <b style="color: #0e7a43;">
                    {{ $wasteRequest->preferred_pickup_date ? \Carbon\Carbon::parse($wasteRequest->preferred_pickup_date)->format('l, d F Y') : ($wasteRequest->created_at ? $wasteRequest->created_at->format('l, d F Y') : 'N/A') }}
                </b>
            </div>

            <div class="fact-item">
                <small>Applicant Contact</small>
                <b>{{ $wasteRequest->applicant_name ?: 'Citizen' }} (+91 {{ $wasteRequest->mobile_number }})</b>
            </div>
        </div>
    </div>
    
    <!-- Uploaded Photos -->
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 15px; color: #1e293b; margin-bottom: 4px;">Uploaded Waste Photos</h6>
        <p style="font-size: 12px; color: #64748b; margin-bottom: 12px;">Evidence from your request submission:</p>
        
        <div class="photos-gallery">
            @forelse($images as $img)
                <a href="{{ asset('storage/' . $img) }}" target="_blank" style="display: contents;">
                    <img src="{{ asset('storage/' . $img) }}" alt="Waste Photo">
                </a>
            @empty
                <div class="dummy-photo" style="background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                    <i class="fa fa-image fa-2x"></i>
                </div>
            @endforelse
        </div>
    </div>
    
    @if(in_array($status, ['picked_up', 'in_transit', 'completed', 'dumped']))
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 15px; color: #1e293b; margin-bottom: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
            Pickup Summary / Driver Validation
        </h6>
        <div class="facts-list">
            <div class="fact-item">
                <small>Picked Up At</small>
                <b>{{ $wasteRequest->picked_up_at ? \Carbon\Carbon::parse($wasteRequest->picked_up_at)->format('d M Y, h:i A') : 'N/A' }}</b>
            </div>
            <div class="fact-item">
                <small>Approx Weight (Kg)</small>
                <b>{{ $wasteRequest->approx_weight_kg ?? 'N/A' }} Kg</b>
            </div>
        </div>
        
        @php
            $pickedUpImages = is_string($wasteRequest->picked_up_images) ? json_decode($wasteRequest->picked_up_images, true) : $wasteRequest->picked_up_images;
        @endphp
        @if(is_array($pickedUpImages) && count($pickedUpImages) > 0)
            <p style="font-size: 12px; color: #64748b; margin-bottom: 12px; margin-top: 15px;">Evidence photos taken during pickup:</p>
            <div class="photos-gallery">
                @foreach($pickedUpImages as $img)
                    <a href="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" target="_blank" style="display: contents;">
                        <img src="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" alt="Pickup Photo" onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'bg-light p-3 text-center text-muted\'>Image unavailable</div>';">
                    </a>
                @endforeach
            </div>
        @endif
    </div>
    @endif

    @if(in_array($status, ['completed', 'dumped']) && $wasteRequest->dump)
    <div class="card-ui">
        <h6 class="fw-bold" style="font-size: 15px; color: #1e293b; margin-bottom: 14px; border-bottom: 1px solid #f1f5f9; padding-bottom: 8px;">
            Disposal / Plant Processing Details
        </h6>
        <div class="facts-list">
            <div class="fact-item">
                <small>Disposed At</small>
                <b>{{ $wasteRequest->dump->dumped_at ? \Carbon\Carbon::parse($wasteRequest->dump->dumped_at)->format('d M Y, h:i A') : 'N/A' }}</b>
            </div>
            <div class="fact-item">
                <small>Disposal Plant</small>
                <b>{{ $wasteRequest->dump->plant_name ?? 'N/A' }}</b>
            </div>
            <div class="fact-item">
                <small>Dump Weight (Kg)</small>
                <b>{{ $wasteRequest->dump->dump_weight ?? 'N/A' }} Kg</b>
            </div>
            @if($wasteRequest->dump->remarks)
            <div class="fact-item">
                <small>Remarks</small>
                <b>{{ $wasteRequest->dump->remarks }}</b>
            </div>
            @endif
        </div>

        @php
            $dumpImages = is_string($wasteRequest->dump->dump_images) ? json_decode($wasteRequest->dump->dump_images, true) : $wasteRequest->dump->dump_images;
        @endphp
        @if(is_array($dumpImages) && count($dumpImages) > 0)
            <p style="font-size: 12px; color: #64748b; margin-bottom: 12px; margin-top: 15px;">Evidence photos at disposal site:</p>
            <div class="photos-gallery">
                @foreach($dumpImages as $img)
                    <a href="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" target="_blank" style="display: contents;">
                        <img src="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" alt="Dump Photo" onerror="this.onerror=null;this.parentElement.innerHTML='<div class=\'bg-light p-3 text-center text-muted\'>Image unavailable</div>';">
                    </a>
                @endforeach
            </div>
        @endif
    </div>
    @endif

    <a href="{{ route('user.history') }}" class="btn-back">

        <i class="fa fa-arrow-left"></i> Back to History
    </a>
</div>
@endsection
