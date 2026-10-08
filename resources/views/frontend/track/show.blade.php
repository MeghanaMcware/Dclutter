@extends('layouts.app')

@section('content')
<style>
:root {
    --primary: #059669;
    --primary-dark: #047857;
    --primary-light: #d1fae5;
    --ink: #0f172a;
    --muted: #64748b;
    --line: #e2e8f0;
    --surface: #ffffff;
    --bg-page: #f8fafc;
}

body {
    background-color: var(--bg-page);
}

.request-ui {
    max-width: 1100px;
    margin: 0 auto;
    padding: 40px 20px 60px;
    color: var(--ink);
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

.crumb {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 24px;
    padding: 10px 18px;
    border: 1px solid var(--line);
    border-radius: 999px;
    background: var(--surface);
    color: var(--muted);
    font-size: 13px;
    font-weight: 500;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

.crumb a {
    color: var(--primary);
    text-decoration: none;
    transition: color 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.crumb a:hover {
    color: var(--primary-dark);
}

.crumb-current {
    color: var(--ink);
    font-weight: 600;
}

.request-ui h1 {
    font-size: 32px;
    font-weight: 800;
    letter-spacing: -0.02em;
    margin: 0;
    color: var(--ink);
}

.card-ui {
    background: var(--surface);
    border: 1px solid var(--line);
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
}

.topline {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 20px;
    border-bottom: 1px solid var(--line);
    margin-bottom: 24px;
}

.ref {
    font-size: 24px;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.01em;
}

.sub {
    font-size: 13px;
    color: var(--muted);
    margin-top: 6px;
    font-weight: 500;
}

.pill {
    font-size: 12px;
    border-radius: 999px;
    padding: 8px 16px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.pill-pending { background: #ffebee; color: #f44336; border: 1px solid #ef9a9a; }
.pill-assigned { background: #e3f2fd; color: #2196f3; border: 1px solid #90caf9; }
.pill-rescheduled { background: #f3e8ff; color: #7e22ce; border: 1px solid #d8b4fe; }
.pill-picked_up { background: #fff4e5; color: #ff9800; border: 1px solid #ffcc80; }
.pill-dumped { background: #e8f5e9; color: #4caf50; border: 1px solid #a5d6a7; }
.pill-rejected { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.pill-closed { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

.details-grid {
    display: grid;
    grid-template-columns: 1.3fr 0.9fr;
    gap: 32px;
}

.section-label {
    font-size: 15px;
    font-weight: 700;
    margin: 32px 0 16px;
    color: var(--ink);
    border-bottom: 2px solid var(--primary-light);
    padding-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.facts {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.facts small {
    display: block;
    color: var(--muted);
    font-size: 12px;
    margin-bottom: 6px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.02em;
}

.facts b {
    font-size: 14px;
    color: var(--ink);
    font-weight: 600;
}

.badge-tag {
    display: inline-block;
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 4px 10px;
    font-size: 12px;
    font-weight: 600;
    margin-right: 6px;
    margin-bottom: 6px;
}

.driver-info-box {
    background: linear-gradient(145deg, #f0fdf4, #ffffff);
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 20px;
    margin-top: 16px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
}

.timeline {
    position: relative;
    margin: 24px 0 0 16px;
    padding-left: 32px;
}
.timeline::before {
    content: '';
    position: absolute;
    left: 0;
    top: 8px;
    bottom: 20px;
    width: 2px;
    background: var(--line);
}

.timeline div {
    font-size: 14px;
    position: relative;
    margin: 0 0 28px;
}

.timeline div::before {
    content: '';
    position: absolute;
    left: -37.5px; /* Half of padding (32) + width/2 */
    top: 4px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: var(--primary);
    border: 2px solid var(--surface);
    box-shadow: 0 0 0 2px var(--primary-light);
    z-index: 2;
}

.timeline div.pending::before {
    background: var(--surface);
    border: 2px solid var(--line);
    box-shadow: none;
}

.timeline b {
    color: var(--ink);
    display: block;
    font-size: 14px;
    font-weight: 700;
}

.timeline small {
    display: block;
    font-size: 12.5px;
    color: var(--muted);
    margin-top: 4px;
}

/* Photo Gallery Cards */
.image-group-card {
    border: 1px solid var(--line);
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 24px;
    background: #f8fafc;
    transition: box-shadow 0.2s ease;
}
.image-group-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
}

.image-group-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
    font-size: 14px;
    font-weight: 700;
    color: var(--ink);
}

.photos-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
    gap: 16px;
}

.photo-thumb-wrap {
    position: relative;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid var(--line);
    background: var(--surface);
    box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    aspect-ratio: 1;
}

.photos-gallery img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.photo-thumb-wrap:hover img {
    transform: scale(1.08);
}

.photo-badge {
    position: absolute;
    bottom: 6px;
    right: 6px;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    color: #fff;
    font-size: 10px;
    font-weight: 600;
    padding: 4px 8px;
    border-radius: 6px;
    pointer-events: none;
}

.btn-ui {
    border: 0;
    border-radius: 8px;
    background: var(--primary);
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 600;
    padding: 12px 28px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: all 0.2s ease;
    box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.2);
}

.btn-ui:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 6px 8px -1px rgba(5, 150, 105, 0.3);
}

.btn-outline-ui {
    border: 1px solid var(--line);
    background: var(--surface);
    color: var(--ink);
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0,0,0,0.02);
}

.btn-outline-ui:hover {
    background: var(--bg-page);
    border-color: #cbd5e1;
}

@media (max-width: 900px) {
    .details-grid { grid-template-columns: 1fr; }
    .facts { grid-template-columns: 1fr; }
    .card-ui { padding: 20px; }
    .request-ui { padding: 20px 15px; }
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
                'rescheduled' => 'pill-pending',
                'not_available' => 'pill-pending',
                'picked_up' => 'pill-picked_up',
                'dumped' => 'pill-dumped',
                'rejected' => 'pill-rejected',
                'closed' => 'pill-rejected',
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

