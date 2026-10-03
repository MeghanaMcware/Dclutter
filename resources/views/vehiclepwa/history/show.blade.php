@extends('vehiclepwa.layout.app')

@section('title', 'Request Details - ' . $wasteRequest->request_number)
@section('heading', 'History Details')

@section('style')
<style>
    :root {
        --primary-green: #0e7a43;
        --primary-green-dark: #095930;
        --primary-green-light: #e6f4ea;
        --border-color: #e2e8f0;
    }

    .details-container {
        padding: 8px 0 30px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .card-ui {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        border: 1px solid var(--border-color);
    }

    .card-title-bar {
        font-size: 14.5px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-title-bar i {
        color: var(--primary-green);
    }

    .ref-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
        margin-bottom: 16px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .ref-id {
        font-size: 19px;
        font-weight: 800;
        color: var(--primary-green);
        letter-spacing: 0.3px;
    }

    .ref-date {
        font-size: 12px;
        color: #64748b;
        margin-top: 3px;
    }

    .badge-status {
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 700;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
    }

    /* Lifecycle Timeline */
    .timeline {
        position: relative;
        padding-left: 12px;
        margin-top: 14px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 17px;
        top: 8px;
        bottom: 8px;
        width: 2px;
        background: #e2e8f0;
    }

    .timeline-item {
        position: relative;
        padding-left: 28px;
        margin-bottom: 18px;
    }

    .timeline-item:last-child {
        margin-bottom: 0;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 3px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #e2e8f0;
        border: 2px solid #ffffff;
        box-shadow: 0 0 0 1px #cbd5e1;
        z-index: 1;
    }

    .timeline-item.active::before {
        background: var(--primary-green);
        box-shadow: 0 0 0 2px var(--primary-green);
    }

    .timeline-item p {
        margin: 0;
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
    }

    .timeline-item small {
        color: #64748b;
        font-size: 11.5px;
        display: block;
        margin-top: 2px;
        line-height: 1.4;
    }

    /* Fact List */
    .facts-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .fact-item {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .fact-item small {
        color: #64748b;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .fact-item b {
        color: #1e293b;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.4;
        word-break: break-word;
    }

    /* Photo Grid */
    .photos-gallery {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-top: 8px;
    }

    .photos-gallery a {
        display: block;
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        aspect-ratio: 1 / 1;
        border: 1px solid #e2e8f0;
    }

    .photos-gallery img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.2s ease;
    }

    .photos-gallery img:hover {
        transform: scale(1.05);
    }

    .btn-back-history {
        background: #ffffff;
        color: var(--primary-green) !important;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-radius: 12px;
        padding: 13px;
        font-weight: 700;
        font-size: 14.5px;
        text-decoration: none;
        width: 100%;
        border: 1.5px solid var(--primary-green);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
        margin-top: 8px;
    }

    .btn-back-history:hover {
        background: var(--primary-green);
        color: #ffffff !important;
    }

    .btn-navigate {
        background: #0284c7;
        color: #ffffff !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        border-radius: 8px;
        padding: 7px 14px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        margin-top: 8px;
    }

    .btn-navigate:hover {
        background: #0369a1;
        color: #ffffff !important;
    }
</style>
@endsection

@section('content')
@php
    $status = strtolower($wasteRequest->status ?? 'assigned');
    $dump = $wasteRequest->dump ?: $wasteRequest->dumpRecord;

    $isSubmitted = true;
    $isAssigned = in_array($status, ['assigned', 'picked_up', 'dumped', 'completed']) || !empty($wasteRequest->vehicle_id);
    $isPickedUp = in_array($status, ['picked_up', 'dumped', 'completed']) || !empty($wasteRequest->picked_up_at);
    $isCompleted = in_array($status, ['dumped', 'completed']);
    $isRescheduled = ($status === 'not_available') || !empty($wasteRequest->not_available_at) || !empty($wasteRequest->next_pickup_date);

    $badgeClass = match($status) {
        'picked_up' => 'background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;',
        'dumped', 'completed' => 'background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;',
        'not_available' => 'background: #fef3c7; color: #92400e; border: 1px solid #fde68a;',
        default => 'background: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;'
    };

    $badgeIcon = match($status) {
        'picked_up' => 'fa-solid fa-truck-ramp-box',
        'dumped', 'completed' => 'fa-solid fa-check-double',
        'not_available' => 'fa-solid fa-calendar-xmark',
        default => 'fa-solid fa-truck'
    };

    $badgeLabel = match($status) {
        'picked_up' => 'PICKED UP',
        'dumped', 'completed' => 'DUMPED',
        'not_available', 'rescheduled' => 'RESCHEDULED',
        'assigned' => 'ASSIGNED',
        default => strtoupper(str_replace('_', ' ', $status))
    };

    $categories = is_array($wasteRequest->category_ids) ? implode(', ', $wasteRequest->category_ids) : ($wasteRequest->category_ids ?: 'N/A');
    $subcategories = is_array($wasteRequest->subcategory_ids) ? implode(', ', array_map(fn($s) => Str::contains($s, ': ') ? explode(': ', $s)[1] : $s, $wasteRequest->subcategory_ids)) : ($wasteRequest->subcategory_ids ?: null);

    $submissionPhotos = is_array($wasteRequest->waste_images) ? $wasteRequest->waste_images : [];
    $beforePhotos = is_array($wasteRequest->before_pickup_images) ? $wasteRequest->before_pickup_images : [];
    $afterPhotos = is_array($wasteRequest->picked_up_images) ? $wasteRequest->picked_up_images : [];
    $dumpPhotos = ($dump && is_array($dump->dump_images)) ? $dump->dump_images : [];
@endphp

<div class="container py-2" style="max-width: 460px; margin: 0 auto;">
    <div class="details-container">

        <!-- Header & Tracking Status -->
        <div class="card-ui">
            <div class="ref-header">
                <div>
                    <div class="ref-id">{{ $wasteRequest->request_number }}</div>
                    <div class="ref-date">Submitted: {{ $wasteRequest->created_at ? $wasteRequest->created_at->format('d M Y, h:i A') : 'N/A' }}</div>
                </div>
                <span class="badge-status" style="{{ $badgeClass }}">
                    <i class="{{ $badgeIcon }}"></i> {{ $badgeLabel }}
                </span>
            </div>

            <!-- Lifecycle Timeline -->
            <div class="timeline">
                <div class="timeline-item {{ $isSubmitted ? 'active' : '' }}">
                    <p>1. Request Registered</p>
                    <small>{{ $wasteRequest->created_at ? $wasteRequest->created_at->format('d M Y, h:i A') : 'Recorded' }}</small>
                </div>
                <div class="timeline-item {{ $isAssigned ? 'active' : '' }}">
                    <p>2. Vehicle Allocated</p>
                    <small>
                        {{ $wasteRequest->assigned_at ? $wasteRequest->assigned_at->format('d M Y, h:i A') : ($isAssigned ? 'Assigned to Vehicle' : 'Awaiting assignment') }}
                        @if($wasteRequest->vehicle)
                            ({{ $wasteRequest->vehicle->vehicle_number }})
                        @endif
                    </small>
                </div>
                <div class="timeline-item {{ $isPickedUp ? 'active' : '' }}">
                    <p>3. Waste Collected / Picked Up</p>
                    <small>
                        @if($wasteRequest->picked_up_at)
                            {{ \Carbon\Carbon::parse($wasteRequest->picked_up_at)->format('d M Y, h:i A') }}
                            @if($wasteRequest->approx_weight_kg) &bull; Approx {{ $wasteRequest->approx_weight_kg }} kg @endif
                        @else
                            {{ $isPickedUp ? 'Picked up from location' : 'Pending pickup' }}
                        @endif
                    </small>
                </div>
                @if($status === 'not_available' || $wasteRequest->not_available_reason)
                    <div class="timeline-item active">
                        <p style="color: #92400e;">4. Rescheduled / Not Available</p>
                        <small style="color: #b45309;">
                            Due: {{ $wasteRequest->next_pickup_date ? \Carbon\Carbon::parse($wasteRequest->next_pickup_date)->format('d M Y (l)') : 'Next Sunday' }}
                            @if($wasteRequest->not_available_reason)
                                <br>Reason: {{ $wasteRequest->not_available_reason }}
                            @endif
                        </small>
                    </div>
                @else
                    <div class="timeline-item {{ $isCompleted ? 'active' : '' }}">
                        <p>4. Disposed at Processing Plant</p>
                        <small>
                            @if($dump && $dump->dumped_at)
                                {{ \Carbon\Carbon::parse($dump->dumped_at)->format('d M Y, h:i A') }} &bull; {{ $dump->plant_name ?: 'Facility' }} ({{ $dump->dump_weight }} kg)
                            @else
                                {{ $isCompleted ? 'Completed at processing facility' : 'Pending dump' }}
                            @endif
                        </small>
                    </div>
                @endif
            </div>
        </div>

        <!-- Applicant Contact Details -->
        <div class="card-ui">
            <div class="card-title-bar">
                <i class="fa-solid fa-user-check"></i> Applicant Details
            </div>
            <div class="facts-list">
                <div class="fact-item">
                    <small>Applicant Name</small>
                    <b>{{ $wasteRequest->applicant_name ?: 'Citizen' }}</b>
                </div>
                <div class="fact-item">
                    <small>Mobile Number</small>
                    <div>
                        <b class="text-dark">{{ $wasteRequest->mobile_number }}</b>
                        @if($wasteRequest->mobile_number)
                            <a href="tel:{{ $wasteRequest->mobile_number }}" class="btn btn-sm btn-success py-1 px-2 ms-2 font-12 fw-bold text-white">
                                <i class="fa-solid fa-phone me-1"></i> Call Now
                            </a>
                        @endif
                    </div>
                </div>
                @if($wasteRequest->user && $wasteRequest->user->email)
                <div class="fact-item">
                    <small>Email</small>
                    <b>{{ $wasteRequest->user->email }}</b>
                </div>
                @endif
            </div>
        </div>

        <!-- Pickup Location & Jurisdictions -->
        <div class="card-ui">
            <div class="card-title-bar">
                <i class="fa-solid fa-location-dot"></i> Pickup Location & Jurisdiction
            </div>
            <div class="facts-list">
                <div class="fact-item">
                    <small>Full Address</small>
                    <b>
                        @if($wasteRequest->house_no) House No: {{ $wasteRequest->house_no }}, @endif
                        @if($wasteRequest->floor_no || $wasteRequest->floor) Floor: {{ $wasteRequest->floor_no ?: $wasteRequest->floor }}, @endif
                        {{ $wasteRequest->address }}
                        @if($wasteRequest->landmark)
                            <br><span class="text-muted small">Landmark: {{ $wasteRequest->landmark }}</span>
                        @endif
                        @if($wasteRequest->pincode)
                            <br><span class="text-muted small">PIN: {{ $wasteRequest->pincode }}</span>
                        @endif
                    </b>
                </div>

                <div class="fact-item">
                    <small>Ward / Administrative Zone</small>
                    <b>
                        {{ $wasteRequest->ward?->name ?? 'Ward' }}
                        @if($wasteRequest->constituency) &bull; {{ $wasteRequest->constituency->name }} @endif
                        @if($wasteRequest->corporation) ({{ $wasteRequest->corporation->name }}) @endif
                    </b>
                </div>

                @if($wasteRequest->latitude && $wasteRequest->longitude)
                <div class="fact-item">
                    <small>GPS Coordinates</small>
                    <b>{{ number_format($wasteRequest->latitude, 6) }}, {{ number_format($wasteRequest->longitude, 6) }}</b>
                    <div>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $wasteRequest->latitude }},{{ $wasteRequest->longitude }}" target="_blank" class="btn-navigate">
                            <i class="fa-solid fa-diamond-turn-right"></i> Open Navigation Map
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Waste Items & Specifications -->
        <div class="card-ui">
            <div class="card-title-bar">
                <i class="fa-solid fa-boxes-stacked"></i> Waste Specifications
            </div>
            <div class="facts-list">
                <div class="fact-item">
                    <small>Categories</small>
                    <b class="text-success">{{ $categories }}</b>
                </div>

                @if($subcategories)
                <div class="fact-item">
                    <small>Subcategories</small>
                    <b>{{ $subcategories }}</b>
                </div>
                @endif

                @if($wasteRequest->approx_weight_kg)
                <div class="fact-item">
                    <small>Collected Weight</small>
                    <b>{{ $wasteRequest->approx_weight_kg }} kg</b>
                </div>
                @endif

                <div class="fact-item">
                    <small>Scheduled / Preferred Date</small>
                    <b>{{ $wasteRequest->preferred_pickup_date ? \Carbon\Carbon::parse($wasteRequest->preferred_pickup_date)->format('l, d F Y') : ($wasteRequest->created_at ? $wasteRequest->created_at->format('l, d F Y') : 'N/A') }}</b>
                </div>
            </div>
        </div>

        <!-- Citizen Submitted Waste Photos -->
        @if(count($submissionPhotos) > 0)
        <div class="card-ui">
            <div class="card-title-bar">
                <i class="fa-solid fa-camera"></i> Citizen Submitted Photos ({{ count($submissionPhotos) }})
            </div>
            <p class="text-muted small mb-2">Original waste items uploaded during request creation:</p>
            <div class="photos-gallery">
                @foreach($submissionPhotos as $img)
                    @php $imgUrl = Str::startsWith($img, 'http') ? $img : asset('storage/' . $img); @endphp
                    <a href="{{ $imgUrl }}" target="_blank">
                        <img src="{{ $imgUrl }}" alt="Waste Photo" onerror="this.parentElement.style.display='none'">
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Driver Before Pickup Photos -->
        @if(count($beforePhotos) > 0)
        <div class="card-ui">
            <div class="card-title-bar">
                <i class="fa-solid fa-camera-retro"></i> Before Pickup Verification ({{ count($beforePhotos) }})
            </div>
            <p class="text-muted small mb-2">Photos recorded by driver before collecting waste:</p>
            <div class="photos-gallery">
                @foreach($beforePhotos as $img)
                    @php $imgUrl = Str::startsWith($img, 'http') ? $img : asset('storage/' . $img); @endphp
                    <a href="{{ $imgUrl }}" target="_blank">
                        <img src="{{ $imgUrl }}" alt="Before Pickup Photo" onerror="this.parentElement.style.display='none'">
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Driver After Pickup Photos -->
        @if(count($afterPhotos) > 0)
        <div class="card-ui">
            <div class="card-title-bar">
                <i class="fa-solid fa-circle-check text-success"></i> After Pickup Verification ({{ count($afterPhotos) }})
            </div>
            <p class="text-muted small mb-2">Photos recorded by driver after collection:</p>
            <div class="photos-gallery">
                @foreach($afterPhotos as $img)
                    @php $imgUrl = Str::startsWith($img, 'http') ? $img : asset('storage/' . $img); @endphp
                    <a href="{{ $imgUrl }}" target="_blank">
                        <img src="{{ $imgUrl }}" alt="After Pickup Photo" onerror="this.parentElement.style.display='none'">
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Reschedule Details (if not available) -->
        @if($isRescheduled)
        <div class="card-ui" style="background: #fffbeb; border-color: #fde68a;">
            <div class="card-title-bar" style="color: #92400e; border-bottom-color: #fde68a;">
                <i class="fa-solid fa-calendar-days text-warning"></i> Rescheduled Details
            </div>
            <div class="facts-list">
                <div class="fact-item">
                    <small style="color: #92400e;">Next Scheduled Pickup Date</small>
                    <b style="color: #78350f;">{{ $wasteRequest->next_pickup_date ? \Carbon\Carbon::parse($wasteRequest->next_pickup_date)->format('l, d F Y') : 'Upcoming Sunday' }}</b>
                </div>
                <div class="fact-item">
                    <small style="color: #92400e;">Reason Provided</small>
                    <b style="color: #78350f;">{{ $wasteRequest->not_available_reason ?: 'Citizen requested another date' }}</b>
                </div>
                @if($wasteRequest->not_available_at)
                <div class="fact-item">
                    <small style="color: #92400e;">Recorded At</small>
                    <b style="color: #78350f;">{{ \Carbon\Carbon::parse($wasteRequest->not_available_at)->format('d M Y, h:i A') }}</b>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Disposal & Dump Plant Processing Details -->
        @if($dump)
        <div class="card-ui" style="background: #f0fdf4; border-color: #bbf7d0;">
            <div class="card-title-bar" style="color: #15803d; border-bottom-color: #bbf7d0;">
                <i class="fa-solid fa-dumpster text-success"></i> Disposal Plant Processing Details
            </div>
            <div class="facts-list">
                <div class="fact-item">
                    <small style="color: #15803d;">Disposal Facility / Plant</small>
                    <b style="color: #14532d;">{{ $dump->plant_name ?: 'BBMP Municipal Processing Plant' }}</b>
                </div>
                <div class="fact-item">
                    <small style="color: #15803d;">Actual Unloaded Weight</small>
                    <b style="color: #14532d;">{{ $dump->dump_weight ?? 'N/A' }} kg</b>
                </div>
                @if($dump->dumped_at)
                <div class="fact-item">
                    <small style="color: #15803d;">Dumped At</small>
                    <b style="color: #14532d;">{{ \Carbon\Carbon::parse($dump->dumped_at)->format('d M Y, h:i A') }}</b>
                </div>
                @endif
                @if($dump->remarks)
                <div class="fact-item">
                    <small style="color: #15803d;">Facility Remarks</small>
                    <b style="color: #14532d;">{{ $dump->remarks }}</b>
                </div>
                @endif
            </div>

            @if(count($dumpPhotos) > 0)
            <div class="mt-3 pt-2 border-top border-success-subtle">
                <small class="fw-bold text-success text-uppercase d-block mb-2">Disposal Facility Photos ({{ count($dumpPhotos) }})</small>
                <div class="photos-gallery">
                    @foreach($dumpPhotos as $img)
                        @php $imgUrl = Str::startsWith($img, 'http') ? $img : asset('storage/' . $img); @endphp
                        <a href="{{ $imgUrl }}" target="_blank">
                            <img src="{{ $imgUrl }}" alt="Dump Photo" onerror="this.parentElement.style.display='none'">
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Assigned Vehicle Info -->
        @if($wasteRequest->vehicle)
        <div class="card-ui">
            <div class="card-title-bar">
                <i class="fa-solid fa-truck"></i> Vehicle Details
            </div>
            <div class="facts-list">
                <div class="fact-item">
                    <small>Vehicle Registration Number</small>
                    <b>{{ $wasteRequest->vehicle->vehicle_number }}</b>
                </div>
                <div class="fact-item">
                    <small>Driver Name</small>
                    <b>{{ $wasteRequest->vehicle->driver_name ?: ($wasteRequest->vehicle->owner?->name ?: 'BBMP Driver') }}</b>
                </div>
                @if(!empty($wasteRequest->vehicle->driver_phone) || !empty($wasteRequest->vehicle->owner?->mobile_number))
                <div class="fact-item">
                    <small>Driver Mobile</small>
                    <b>{{ $wasteRequest->vehicle->driver_phone ?: $wasteRequest->vehicle->owner?->mobile_number }}</b>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('vehicle.history') }}" class="btn-back-history">
            <i class="fa-solid fa-arrow-left"></i> Back to History List
        </a>

    </div>
</div>
@endsection
