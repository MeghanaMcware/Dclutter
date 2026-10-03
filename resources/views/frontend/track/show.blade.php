@extends('layouts.app')

@section('content')
<style>
:root {
    --green: #087d45;
    --green-dark: #055a31;
    --green-light: #e8f5ed;
    --ink: #17251d;
    --muted: #64716a;
    --line: #e4e9e6;
}

.request-ui {
    max-width: 1200px;
    margin: 0 auto;
    padding: 30px 20px 50px;
    color: var(--ink);
    font-family: 'Inter', sans-serif;
}

.crumb {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    margin-bottom: 20px;
    padding: 8px 14px 8px 10px;
    border: 1px solid #dce8e0;
    border-radius: 999px;
    background: linear-gradient(135deg, #f7fcf8, #ffffff);
    color: #819087;
    font-size: 12px;
    font-weight: 600;
    letter-spacing: 0.01em;
    box-shadow: 0 4px 12px rgba(23, 50, 32, 0.04);
}

.crumb a {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--green);
    text-decoration: none;
    transition: color 0.2s ease;
}

.crumb a:hover {
    color: var(--green-dark);
}

.crumb a i {
    font-size: 14px;
}

.crumb > i {
    color: #afbeb4;
    font-size: 11px;
}

.crumb-current {
    color: var(--ink);
    font-weight: 700;
}

.request-ui h1 {
    font-size: 26px;
    font-weight: 800;
    margin: 0 0 22px;
    color: var(--ink);
}

.card-ui {
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 24px;
    background: #ffffff;
    box-shadow: 0 2px 12px rgba(23, 50, 32, 0.04);
}

.topline {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--line);
}

.ref {
    font-size: 20px;
    font-weight: 800;
    color: var(--ink);
}

.sub {
    font-size: 12px;
    color: var(--muted);
    margin-top: 4px;
}

.pill {
    font-size: 11px;
    border-radius: 20px;
    padding: 6px 14px;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
}
.pill-pending { background: #ffebee; color: #f44336; border: 1px solid #ef9a9a; }
.pill-assigned { background: #e3f2fd; color: #2196f3; border: 1px solid #90caf9; }
.pill-picked_up { background: #fff4e5; color: #ff9800; border: 1px solid #ffcc80; }
.pill-dumped { background: #e8f5e9; color: #4caf50; border: 1px solid #a5d6a7; }
.pill-rejected { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

.details-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 24px;
}

.section-label {
    font-size: 14px;
    font-weight: 800;
    margin: 22px 0 12px;
    color: var(--ink);
    border-bottom: 2px solid var(--green-light);
    padding-bottom: 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.facts {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-top: 14px;
}

.facts small {
    display: block;
    color: var(--muted);
    font-size: 11px;
    margin-bottom: 4px;
    font-weight: 500;
}

.facts b {
    font-size: 13px;
    color: var(--ink);
}

.badge-tag {
    display: inline-block;
    background: #f0f4f2;
    color: #2c3e50;
    border: 1px solid #dce8e0;
    border-radius: 4px;
    padding: 3px 8px;
    font-size: 11px;
    font-weight: 600;
    margin-right: 4px;
    margin-bottom: 4px;
}

.driver-info-box {
    background: linear-gradient(135deg, #f8fbf9, #f1f8f4);
    border: 1px solid #d4e7db;
    border-radius: 8px;
    padding: 14px 16px;
    margin-top: 14px;
}

.timeline {
    border-left: 2px solid #cde0d2;
    margin: 16px 0 0 12px;
    padding-left: 22px;
}

.timeline div {
    font-size: 13px;
    position: relative;
    margin: 0 0 20px;
}

.timeline div::before {
    content: '✓';
    position: absolute;
    left: -31px;
    top: 0px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--green);
    color: #ffffff;
    font-size: 10px;
    text-align: center;
    line-height: 18px;
    font-weight: bold;
}

.timeline div.pending::before {
    content: '';
    background: #ffffff;
    border: 2px solid #aebbb4;
}

.timeline b {
    color: var(--ink);
    display: block;
    font-size: 13px;
}

.timeline small {
    display: block;
    font-size: 11px;
    color: var(--muted);
    margin-top: 2px;
}

/* Photo Gallery Cards */
.image-group-card {
    border: 1px solid var(--line);
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 20px;
    background: #fafbfc;
}

.image-group-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    font-size: 13px;
    font-weight: 700;
    color: var(--ink);
}

.photos-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 12px;
}

.photo-thumb-wrap {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #dce4df;
    background: #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    aspect-ratio: 4 / 3;
}

.photos-gallery img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.25s ease;
}

.photo-thumb-wrap:hover img {
    transform: scale(1.06);
}

.photo-badge {
    position: absolute;
    bottom: 4px;
    right: 4px;
    background: rgba(0, 0, 0, 0.65);
    color: #fff;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 4px;
    pointer-events: none;
}

.btn-ui {
    border: 0;
    border-radius: 6px;
    background: var(--green);
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 700;
    padding: 10px 24px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s ease, transform 0.1s ease;
    box-shadow: 0 3px 10px rgba(8, 125, 69, 0.2);
}

.btn-ui:hover {
    background: var(--green-dark);
    transform: translateY(-1px);
}

.btn-outline-ui {
    border: 1px solid #dce8e0;
    background: #ffffff;
    color: var(--ink);
    padding: 7px 14px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-outline-ui:hover {
    background: var(--green-light);
    color: var(--green-dark);
}

@media (max-width: 900px) {
    .details-grid { grid-template-columns: 1fr; }
    .facts { grid-template-columns: 1fr; }
}
</style>

<main class="request-ui">
    <div class="crumb">
        <a href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a> 
        <i class="fa fa-chevron-right"></i>
        <a href="{{ route('citizen.track', ['id' => $wasteRequest?->request_number]) }}">Track Request</a> 
        <i class="fa fa-chevron-right"></i>
        <span class="crumb-current">Request Details</span>
    </div>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Request Details</h1>
        <a href="{{ route('citizen.track', ['id' => $wasteRequest?->mobile_number ?? $wasteRequest?->request_number]) }}" class="btn-outline-ui">
            <i class="fa fa-arrow-left"></i> Back to Track
        </a>
    </div>

    @if($wasteRequest)
        @php
            $status = $wasteRequest->status;
            $pillMap = [
                'pending' => 'pill-pending',
                'assigned' => 'pill-assigned',
                'not_available' => 'pill-pending',
                'picked_up' => 'pill-picked_up',
                'dumped' => 'pill-dumped',
                'rejected' => 'pill-rejected',
            ];

            // Normalize image arrays
            $wasteImages = is_array($wasteRequest->waste_images) ? $wasteRequest->waste_images : (!empty($wasteRequest->waste_images) ? json_decode($wasteRequest->waste_images, true) : []);
            $beforeImages = is_array($wasteRequest->before_pickup_images) ? $wasteRequest->before_pickup_images : (!empty($wasteRequest->before_pickup_images) ? json_decode($wasteRequest->before_pickup_images, true) : []);
            $afterImages = is_array($wasteRequest->after_pickup_images) ? $wasteRequest->after_pickup_images : (!empty($wasteRequest->after_pickup_images) ? json_decode($wasteRequest->after_pickup_images, true) : []);
            
            $dumpImages = [];
            if ($wasteRequest->dump) {
                if (is_array($wasteRequest->dump->dump_images)) {
                    $dumpImages = $wasteRequest->dump->dump_images;
                } elseif (!empty($wasteRequest->dump->dump_images)) {
                    $dumpImages = json_decode($wasteRequest->dump->dump_images, true) ?: [];
                }
            }

            $totalImages = count($wasteImages ?? []) + count($beforeImages ?? []) + count($afterImages ?? []) + count($dumpImages ?? []);
        @endphp

        <!-- Rescheduled Banner -->
        @if($status == 'not_available' && $wasteRequest->next_pickup_date)
            <div style="background: #fff8e1; border: 1px solid #ffe082; color: #856404; padding: 14px 18px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.03);">
                <i class="fa fa-calendar-alt fa-2x" style="color: #f39c12;"></i>
                <div>
                    <strong style="font-size: 14px;">Pickup Rescheduled for Sunday:</strong> Citizen requested next pickup on <strong>{{ $wasteRequest->next_pickup_date->format('d M Y (l)') }}</strong>.
                    @if($wasteRequest->not_available_reason)
                        <div style="font-size: 12px; color: #6c757d; margin-top: 3px;"><strong>Reason:</strong> {{ $wasteRequest->not_available_reason }}</div>
                    @endif
                </div>
            </div>
        @endif

        <div class="details-grid">
            <!-- Left Column: Request Information & Timeline -->
            <div class="card-ui">
                <div class="topline">
                    <div>
                        <div class="ref" id="detailsReqId">{{ $wasteRequest->request_number }}</div>
                        <div class="sub" id="detailsReqDate">
                            <i class="fa fa-clock me-1"></i> Submitted on: {{ $wasteRequest->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                    <span class="pill {{ $pillMap[$status] ?? 'pill-pending' }}">
                        {{ $status == 'not_available' ? 'Rescheduled' : ucfirst(str_replace('_', ' ', $status)) }}
                    </span>
                </div>

                <!-- Applicant & Contact Info -->
                <div class="section-label">
                    <span><i class="fa fa-user me-2" style="color: var(--green);"></i> Applicant &amp; Contact Details</span>
                </div>
                <div class="facts">
                    <div>
                        <small>Applicant Name</small>
                        <b>{{ $wasteRequest->applicant_name ?: 'Citizen' }}</b>
                    </div>
                    <div>
                        <small>Mobile Number</small>
                        <b>{{ $wasteRequest->mobile_number }}</b>
                    </div>
                </div>

                <!-- Location & Geographic Info -->
                <div class="section-label">
                    <span><i class="fa fa-map-marker-alt me-2" style="color: var(--green);"></i> Pickup Location Details</span>
                    @if($wasteRequest->latitude && $wasteRequest->longitude)
                        <a href="https://www.google.com/maps?q={{ $wasteRequest->latitude }},{{ $wasteRequest->longitude }}" target="_blank" class="btn-outline-ui" style="padding: 2px 8px; font-size: 11px;">
                            <i class="fa fa-location-arrow"></i> View Map
                        </a>
                    @endif
                </div>
                <div class="facts">
                    <div>
                        <small>House / Flat No.</small>
                        <b>{{ $wasteRequest->house_no }}</b>
                    </div>
                    <div>
                        <small>Floor</small>
                        <b>{{ $wasteRequest->floor_no ?? $wasteRequest->floor ?? 'Ground / Standard' }}</b>
                    </div>
                    <div style="grid-column: span 2;">
                        <small>Complete Address</small>
                        <b>{{ $wasteRequest->address }}</b>
                    </div>
                    <div>
                        <small>Landmark</small>
                        <b>{{ $wasteRequest->landmark ?? 'N/A' }}</b>
                    </div>
                    <div>
                        <small>Pincode</small>
                        <b>{{ $wasteRequest->pincode }}</b>
                    </div>
                    <div>
                        <small>Ward &amp; Zone</small>
                        <b>
                            {{ $wasteRequest->ward ? ($wasteRequest->ward->name . ' (Ward ' . $wasteRequest->ward->ward_number . ')') : 'N/A' }} 
                            - {{ $wasteRequest->constituency?->name ?? 'N/A' }}
                        </b>
                    </div>
                    <div>
                        <small>Corporation</small>
                        <b>{{ $wasteRequest->corporation?->name ?? ($wasteRequest->ward?->constituency?->corporation?->name ?? 'BBMP') }}</b>
                    </div>
                </div>

                <!-- Waste Categories -->
                <div class="section-label">
                    <span><i class="fa fa-trash-alt me-2" style="color: var(--green);"></i> Waste Items &amp; Scheduling</span>
                </div>
                <div class="facts">
                    <div>
                        <small>Categories</small>
                        <div>
                            @if(is_array($wasteRequest->category_ids))
                                @foreach($wasteRequest->category_ids as $cat)
                                    <span class="badge-tag">{{ $cat }}</span>
                                @endforeach
                            @else
                                <span class="badge-tag">{{ $wasteRequest->category_ids ?? 'D-Clutter Waste' }}</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <small>Sub-Categories</small>
                        <div>
                            @if(!empty($wasteRequest->subcategory_ids))
                                @php
                                    $subCats = is_array($wasteRequest->subcategory_ids) ? $wasteRequest->subcategory_ids : [$wasteRequest->subcategory_ids];
                                @endphp
                                @foreach($subCats as $sub)
                                    <span class="badge-tag">{{ \Illuminate\Support\Str::contains($sub, ': ') ? explode(': ', $sub)[1] : $sub }}</span>
                                @endforeach
                            @else
                                <span style="font-size: 13px; color: var(--muted);">General Waste</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <small>Scheduled Pickup Date</small>
                        <b>
                            @if($wasteRequest->next_pickup_date)
                                {{ $wasteRequest->next_pickup_date->format('d M Y (l)') }} (Rescheduled)
                            @elseif($wasteRequest->preferred_pickup_date)
                                {{ $wasteRequest->preferred_pickup_date->format('d M Y (l)') }}
                            @else
                                Sunday Scheduled
                            @endif
                        </b>
                    </div>
                    <div>
                        <small>Request Source</small>
                        <b style="text-transform: capitalize;">{{ $wasteRequest->source ?? 'Citizen Web' }}</b>
                    </div>
                </div>

                <!-- Assigned Vehicle & Driver -->
                <div class="section-label">
                    <span><i class="fa fa-truck me-2" style="color: var(--green);"></i> Assigned Vehicle &amp; Driver</span>
                </div>
                @if($wasteRequest->vehicle)
                    <div class="driver-info-box">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-size: 15px; font-weight: 800; color: var(--green-dark);">
                                <i class="fa fa-truck me-1"></i> {{ $wasteRequest->vehicle->vehicle_number }}
                            </span>
                            <span class="badge bg-success" style="font-size: 11px;">
                                {{ $wasteRequest->vehicle->vehicle_type ?? 'Waste Truck' }} ({{ $wasteRequest->vehicle->capacity_tons ? $wasteRequest->vehicle->capacity_tons . ' Tons' : 'Standard' }})
                            </span>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size: 13px;">
                            <div>
                                <span class="text-muted">Driver:</span> 
                                <strong>{{ $wasteRequest->vehicle->driver_name ?? $wasteRequest->vehicle->owner?->name ?? 'Assigned Driver' }}</strong>
                            </div>
                            <div>
                                <span class="text-muted">Phone:</span> 
                                <strong>{{ $wasteRequest->vehicle->driver_phone ?? $wasteRequest->vehicle->owner?->mobile_number ?? 'N/A' }}</strong>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-3 border rounded text-center bg-light mt-2">
                        <span class="text-muted" style="font-size: 13px;">
                            <i class="fa fa-clock me-1"></i> Vehicle assignment is currently pending. You will be notified via WhatsApp once assigned.
                        </span>
                    </div>
                @endif

                <!-- Disposal Information (if Dumped) -->
                @if($status == 'dumped' || $wasteRequest->dump)
                    <div class="section-label">
                        <span><i class="fa fa-recycle me-2" style="color: var(--green);"></i> Disposal / Processing Plant</span>
                    </div>
                    <div class="facts">
                        <div>
                            <small>Processing Facility</small>
                            <b>{{ $wasteRequest->dump?->plant_name ?? 'Municipal Waste Processing Plant' }}</b>
                        </div>
                        <div>
                            <small>Dumped Weight</small>
                            <b>{{ $wasteRequest->dump?->dump_weight ? $wasteRequest->dump->dump_weight . ' Tons' : 'Recorded' }}</b>
                        </div>
                        <div>
                            <small>Disposal Timestamp</small>
                            <b>{{ $wasteRequest->dump?->dumped_at ? $wasteRequest->dump->dumped_at->format('d M Y, h:i A') : $wasteRequest->updated_at->format('d M Y, h:i A') }}</b>
                        </div>
                    </div>
                @endif

                <!-- Status Timeline -->
                <div class="section-label">
                    <span><i class="fa fa-stream me-2" style="color: var(--green);"></i> Lifecycle &amp; Status Timeline</span>
                </div>
                <div class="timeline">
                    <div>
                        <b>Request Submitted</b>
                        <small>{{ $wasteRequest->created_at->format('d M Y, h:i A') }}</small>
                    </div>
                    
                    <div class="{{ in_array($status, ['assigned', 'not_available', 'picked_up', 'dumped']) ? '' : 'pending' }}">
                        <b>Verified &amp; Processed</b>
                        <small>{{ in_array($status, ['assigned', 'not_available', 'picked_up', 'dumped']) ? 'Verified by BBMP Team' : 'Processing verification' }}</small>
                    </div>
                    
                    <div class="{{ in_array($status, ['assigned', 'not_available', 'picked_up', 'dumped']) ? '' : 'pending' }}">
                        <b>{{ $status == 'not_available' ? 'Pickup Rescheduled' : 'Vehicle Assigned' }}</b>
                        <small>
                            @if($status == 'not_available')
                                Rescheduled for next Sunday: {{ $wasteRequest->next_pickup_date?->format('d M Y') }}
                            @elseif($wasteRequest->vehicle)
                                Assigned to {{ $wasteRequest->vehicle->vehicle_number }} (Driver: {{ $wasteRequest->vehicle->driver_name ?? $wasteRequest->vehicle->owner?->name ?? 'Assigned' }})
                            @else
                                Pending vehicle assignment
                            @endif
                        </small>
                    </div>
                    
                    <div class="{{ in_array($status, ['picked_up', 'dumped']) ? '' : 'pending' }}">
                        <b>Waste Picked Up</b>
                        <small>
                            @if(in_array($status, ['picked_up', 'dumped']))
                                Collected by vehicle {{ $wasteRequest->vehicle?->vehicle_number }}
                                @if(!empty($wasteRequest->before_pickup_coordinates))
                                    (GPS: {{ $wasteRequest->before_pickup_coordinates }})
                                @endif
                            @else
                                Awaiting scheduled pickup
                            @endif
                        </small>
                    </div>
                    
                    <div class="{{ $status == 'dumped' ? '' : 'pending' }}">
                        <b>Disposed &amp; Processed</b>
                        <small>
                            @if($status == 'dumped')
                                Dumped at {{ $wasteRequest->dump?->plant_name ?? 'Processing Plant' }}
                            @else
                                Pending disposal
                            @endif
                        </small>
                    </div>
                </div>
            </div>

            <!-- Right Column: ALL IMAGES & EVIDENCE -->
            <div class="card-ui">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="color: var(--ink); font-size: 16px;">
                        <i class="fa fa-camera me-2" style="color: var(--green);"></i> Request Images &amp; Evidence
                    </h5>
                    <span class="badge bg-light text-dark border" style="font-size: 11px;">
                        {{ $totalImages }} Photo(s)
                    </span>
                </div>
                <p style="font-size: 12px; color: var(--muted); margin-bottom: 18px;">
                    All photo records from citizen submission, driver collection, and disposal facility:
                </p>

                <!-- 1. Uploaded Waste Photos (Submission) -->
                <div class="image-group-card">
                    <div class="image-group-header">
                        <span><i class="fa fa-upload me-1 text-primary"></i> 1. Citizen Uploaded Waste Photos</span>
                        <span class="badge bg-primary" style="font-size: 10px;">{{ count($wasteImages ?? []) }}</span>
                    </div>
                    @if(!empty($wasteImages) && count($wasteImages) > 0)
                        <div class="photos-gallery">
                            @foreach($wasteImages as $index => $imgPath)
                                <div class="photo-thumb-wrap">
                                    <img src="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" 
                                         alt="Waste Photo {{ $index + 1 }}" 
                                         onclick="window.open(this.src, '_blank')"
                                         title="Click to view full size"
                                         onerror="this.src='https://placehold.co/400x300?text=Waste+Image'">
                                    <span class="photo-badge">Photo {{ $index + 1 }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0" style="font-size: 12px;">No initial waste photos uploaded.</p>
                    @endif
                </div>

                <!-- 2. Before-Pickup Photos (Collection Proof) -->
                <div class="image-group-card">
                    <div class="image-group-header">
                        <span><i class="fa fa-clipboard-check me-1 text-warning"></i> 2. Before-Pickup Photos (Driver)</span>
                        <span class="badge bg-warning text-dark" style="font-size: 10px;">{{ count($beforeImages ?? []) }}</span>
                    </div>
                    @if(!empty($beforeImages) && count($beforeImages) > 0)
                        <div class="photos-gallery">
                            @foreach($beforeImages as $index => $imgPath)
                                <div class="photo-thumb-wrap">
                                    <img src="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" 
                                         alt="Before Pickup Photo {{ $index + 1 }}" 
                                         onclick="window.open(this.src, '_blank')"
                                         title="Click to view full size"
                                         onerror="this.src='https://placehold.co/400x300?text=Before+Pickup'">
                                    <span class="photo-badge">Before {{ $index + 1 }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0" style="font-size: 12px;">No before-pickup photos recorded yet.</p>
                    @endif
                </div>

                <!-- 3. After-Pickup Photos (Cleaned Location Proof) -->
                <div class="image-group-card">
                    <div class="image-group-header">
                        <span><i class="fa fa-check-circle me-1 text-success"></i> 3. After-Pickup Photos (Driver)</span>
                        <span class="badge bg-success" style="font-size: 10px;">{{ count($afterImages ?? []) }}</span>
                    </div>
                    @if(!empty($afterImages) && count($afterImages) > 0)
                        <div class="photos-gallery">
                            @foreach($afterImages as $index => $imgPath)
                                <div class="photo-thumb-wrap">
                                    <img src="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" 
                                         alt="After Pickup Photo {{ $index + 1 }}" 
                                         onclick="window.open(this.src, '_blank')"
                                         title="Click to view full size"
                                         onerror="this.src='https://placehold.co/400x300?text=After+Pickup'">
                                    <span class="photo-badge">After {{ $index + 1 }}</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0" style="font-size: 12px;">No after-pickup photos recorded yet.</p>
                    @endif
                </div>

                <!-- 4. Disposal / Dump Plant Photos -->
                @if(!empty($dumpImages) && count($dumpImages) > 0)
                    <div class="image-group-card">
                        <div class="image-group-header">
                            <span><i class="fa fa-industry me-1 text-info"></i> 4. Processing Plant Dump Photos</span>
                            <span class="badge bg-info text-dark" style="font-size: 10px;">{{ count($dumpImages) }}</span>
                        </div>
                        <div class="photos-gallery">
                            @foreach($dumpImages as $index => $imgPath)
                                <div class="photo-thumb-wrap">
                                    <img src="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" 
                                         alt="Dump Plant Photo {{ $index + 1 }}" 
                                         onclick="window.open(this.src, '_blank')"
                                         title="Click to view full size"
                                         onerror="this.src='https://placehold.co/400x300?text=Dump+Photo'">
                                    <span class="photo-badge">Plant {{ $index + 1 }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                @if(in_array($status, ['picked_up', 'dumped']))
                <div class="card-ui" style="margin-top: 15px;">
                    <div class="section-label" style="margin-top: 0;">Pickup Details</div>
                    <div class="facts mt-3">
                        <div>
                            <b>Picked Up At</b>
                            <small>{{ $wasteRequest->picked_up_at ? \Carbon\Carbon::parse($wasteRequest->picked_up_at)->format('d M Y, h:i A') : 'N/A' }}</small>
                        </div>
                        <div>
                            <b>Approx Weight (Kg)</b>
                            <small>{{ $wasteRequest->approx_weight_kg ?? 'N/A' }}</small>
                        </div>
                    </div>
                    @php
                        $pickedUpImages = is_string($wasteRequest->picked_up_images) ? json_decode($wasteRequest->picked_up_images, true) : $wasteRequest->picked_up_images;
                    @endphp
                    @if(is_array($pickedUpImages) && count($pickedUpImages) > 0)
                        <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px; margin-top: 15px;">
                            Evidence photos taken during pickup:
                        </p>
                        <div class="photos-gallery">
                            @foreach($pickedUpImages as $index => $imgPath)
                                <img src="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" 
                                     alt="Pickup Photo {{ $index + 1 }}" 
                                     onclick="window.open(this.src, '_blank')"
                                     onerror="this.src='https://placehold.co/400x300?text=Pickup+Image'">
                            @endforeach
                        </div>
                    @endif
                </div>
                @endif
                
                @if($status === 'dumped' && $wasteRequest->dump)
                <div class="card-ui" style="margin-top: 15px;">
                    <div class="section-label" style="margin-top: 0;">Disposal Details</div>
                    <div class="facts mt-3">
                        <div>
                            <b>Disposed At</b>
                            <small>{{ $wasteRequest->dump->dumped_at ? \Carbon\Carbon::parse($wasteRequest->dump->dumped_at)->format('d M Y, h:i A') : 'N/A' }}</small>
                        </div>
                        <div>
                            <b>Disposal Plant / Location</b>
                            <small>{{ $wasteRequest->dump->plant_name ?? 'N/A' }}</small>
                        </div>
                        <div>
                            <b>Dump Weight (Kg)</b>
                            <small>{{ $wasteRequest->dump->dump_weight ?? 'N/A' }}</small>
                        </div>
                        @if($wasteRequest->dump->remarks)
                        <div style="grid-column: 1 / -1;">
                            <b>Remarks</b>
                            <small>{{ $wasteRequest->dump->remarks }}</small>
                        </div>
                        @endif
                    </div>
                    @php
                        $dumpImages = is_string($wasteRequest->dump->dump_images) ? json_decode($wasteRequest->dump->dump_images, true) : $wasteRequest->dump->dump_images;
                    @endphp
                    @if(is_array($dumpImages) && count($dumpImages) > 0)
                        <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px; margin-top: 15px;">
                            Evidence photos taken at disposal site:
                        </p>
                        <div class="photos-gallery">
                            @foreach($dumpImages as $index => $imgPath)
                                <img src="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" 
                                     alt="Dump Photo {{ $index + 1 }}" 
                                     onclick="window.open(this.src, '_blank')"
                                     onerror="this.src='https://placehold.co/400x300?text=Dump+Image'">
                            @endforeach
                        </div>
                    @endif
                </div>
                @endif

                <div class="mt-4 pt-3 border-top">
                    <a href="{{ route('citizen.track', ['id' => $wasteRequest->mobile_number ?? $wasteRequest->request_number]) }}" class="btn-ui w-100 text-center">
                        <i class="fa fa-arrow-left me-1"></i> Back to Track Request
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="card-ui text-center py-5">
            <i class="fa fa-search fa-3x text-muted mb-3"></i>
            <h4 class="fw-bold" style="color: #2c3e50;">Request Details Not Found</h4>
            <p class="text-muted mb-0" style="font-size: 14px;">
                We couldn't find any request matching "<strong>{{ $reqId }}</strong>".
            </p>
            <div class="mt-4">
                <a href="{{ route('citizen.track') }}" class="btn-ui">Return to Track Request</a>
            </div>
        </div>
    @endif
</main>
@endsection
