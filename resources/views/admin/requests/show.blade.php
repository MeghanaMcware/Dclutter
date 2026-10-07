@extends('admin.layout.app')

@section('title', 'View Request ' . $wasteRequest->request_number)

@section('style')
<style>
    .section-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 14px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .detail-label {
        font-size: 12.5px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 3px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .detail-value {
        font-size: 14px;
        color: #1e293b;
        font-weight: 600;
        margin-bottom: 14px;
    }
    .card-custom {
        border: 1px solid #eaebf0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        border-radius: 10px;
        background: #ffffff;
    }
    .status-badge {
        font-size: 12px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        text-transform: uppercase;
        display: inline-block;
    }
    .status-assigned { background-color: #e0f2fe; color: #0284c7; border: 1px solid #bae6fd; }
    .status-pending { background-color: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
    .status-picked_up { background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .status-dumped { background-color: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
    .status-rejected { background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }

    .waste-img-card {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        background: #f8fafc;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .waste-img-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.06);
    }
    .waste-img-preview {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .timeline-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 24px;
    }
    .timeline-steps::before {
        content: '';
        position: absolute;
        top: 14px;
        left: 20px;
        right: 20px;
        height: 2px;
        background: #e2e8f0;
        z-index: 1;
    }
    .timeline-step {
        position: relative;
        z-index: 2;
        text-align: center;
        background: #fff;
        padding: 0 8px;
    }
    .timeline-dot {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #e2e8f0;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .timeline-step.active .timeline-dot {
        background: #0284c7;
        color: #ffffff;
    }
    .timeline-step.completed .timeline-dot {
        background: #16a34a;
        color: #ffffff;
    }
    .timeline-text {
        font-size: 11px;
        font-weight: 600;
        color: #64748b;
    }
    .timeline-step.active .timeline-text,
    .timeline-step.completed .timeline-text {
        color: #1e293b;
    }
</style>
@endsection

@section('content')
@php
    $dumpObj = $wasteRequest->dumpRecord ?? $wasteRequest->dump;
    $statusClasses = [
        'pending' => 'status-pending',
        'assigned' => 'status-assigned',
        'scheduled' => 'status-assigned',
        'not_available' => 'status-pending',
        'rescheduled' => 'status-pending',
        'picked_up' => 'status-picked_up',
        'dumped' => 'status-dumped',
        'completed' => 'status-dumped',
    ];
@endphp

<div class="content-body">
    <div class="container-fluid pt-3">
        <!-- Page Title & Breadcrumbs -->
        <div class="page-title mb-3">
            <div class="row align-items-center">
                <div class="col-12 col-sm-6">
                    <h3 class="fw-bold d-flex align-items-center gap-2 flex-wrap mb-0">
                        Request Details: <span class="text-primary">{{ $wasteRequest->request_number }}</span>
                    </h3>
                </div>
                <div class="col-12 col-sm-6 d-flex align-items-center justify-content-sm-end gap-2 mt-2 mt-sm-0">
                    <ol class="breadcrumb d-inline-flex mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/dashboard') }}">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.requests.index') }}">All Requests</a></li>
                        <li class="breadcrumb-item active">{{ $wasteRequest->request_number }}</li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Lifecycle Timeline Progress -->
        <div class="card card-custom mb-4">
            <div class="card-body p-3">
                <div class="timeline-steps">
                    <!-- Step 1: Submitted -->
                    <div class="timeline-step completed">
                        <div class="timeline-dot"><i class="fa fa-check"></i></div>
                        <div class="timeline-text">1. Submitted</div>
                        <small class="text-muted d-block" style="font-size: 10px;">{{ $wasteRequest->created_at->format('d M, h:i A') }}</small>
                    </div>

                    <!-- Step 2: Assigned -->
                    <div class="timeline-step {{ $wasteRequest->vehicle_id ? 'completed' : ($wasteRequest->status === 'pending' ? 'active' : '') }}">
                        <div class="timeline-dot">
                            @if($wasteRequest->vehicle_id)
                                <i class="fa fa-check"></i>
                            @else
                                2
                            @endif
                        </div>
                        <div class="timeline-text">2. Vehicle Assigned</div>
                        <small class="text-muted d-block" style="font-size: 10px;">
                            {{ $wasteRequest->assigned_at ? $wasteRequest->assigned_at->format('d M, h:i A') : ($wasteRequest->vehicle_id ? 'Assigned' : 'Pending') }}
                        </small>
                    </div>

                    <!-- Step 3: Picked Up -->
                    <div class="timeline-step {{ $wasteRequest->picked_up_at ? 'completed' : ($wasteRequest->status === 'assigned' ? 'active' : '') }}">
                        <div class="timeline-dot">
                            @if($wasteRequest->picked_up_at)
                                <i class="fa fa-check"></i>
                            @else
                                3
                            @endif
                        </div>
                        <div class="timeline-text">3. Picked Up</div>
                        <small class="text-muted d-block" style="font-size: 10px;">
                            {{ $wasteRequest->picked_up_at ? $wasteRequest->picked_up_at->format('d M, h:i A') : 'Pending' }}
                        </small>
                    </div>

                    <!-- Step 4: Dumped / Processed -->
                    <div class="timeline-step {{ in_array(strtolower($wasteRequest->status), ['dumped', 'completed']) ? 'completed' : ($wasteRequest->status === 'picked_up' ? 'active' : '') }}">
                        <div class="timeline-dot">
                            @if(in_array(strtolower($wasteRequest->status), ['dumped', 'completed']))
                                <i class="fa fa-check"></i>
                            @else
                                4
                            @endif
                        </div>
                        <div class="timeline-text">4. Dumped &amp; Processed</div>
                        <small class="text-muted d-block" style="font-size: 10px;">
                            {{ ($dumpObj?->dumped_at ?? $dumpObj?->created_at) ? ($dumpObj->dumped_at ?? $dumpObj->created_at)->format('d M, h:i A') : 'Pending' }}
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Details -->
            <div class="col-xl-8 col-lg-8">
                <!-- 1. Request Overview Card -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="section-title mb-0">
                                <i class="fa fa-file-lines text-primary"></i> Request Information
                            </h5>

                            @if(!in_array($wasteRequest->status, ['dumped', 'completed']))
                                <button type="button"
                                        class="btn btn-success btn-sm edit-request"
                                        data-bs-toggle="modal"
                                        data-bs-target="#assignVehicleModal"
                                        data-db-id="{{ $wasteRequest->id }}"
                                        data-request-number="{{ $wasteRequest->request_number }}"
                                        data-constituency-id="{{ $wasteRequest->constituency_id }}"
                                        data-constituency-name="{{ $wasteRequest->constituency?->name ?? 'N/A' }}"
                                        title="Assign / Reassign Vehicle">
                                    <i class="fa fa-truck me-1"></i> {{ $wasteRequest->vehicle ? 'Change Vehicle' : 'Assign Vehicle' }}
                                </button>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="detail-label">Request ID</div>
                                <div class="detail-value text-primary fw-bold">{{ $wasteRequest->request_number }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Current Status</div>
                                <div class="detail-value">
                                    <span class="status-badge {{ $statusClasses[$wasteRequest->status] ?? 'status-pending' }}">
                                        {{ $wasteRequest->status_label }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Date Submitted</div>
                                <div class="detail-value">{{ $wasteRequest->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Requested Pickup Date (Sunday)</div>
                                <div class="detail-value text-success">
                                    {{ $wasteRequest->preferred_pickup_date ? $wasteRequest->preferred_pickup_date->format('d M Y (l)') : $wasteRequest->created_at->format('d M Y (l)') }}
                                </div>
                            </div>
                            @if($wasteRequest->next_pickup_date)
                                <div class="col-sm-6">
                                    <div class="detail-label">Rescheduled Pickup Date</div>
                                    <div class="detail-value text-warning fw-bold">
                                        <i class="fa fa-calendar-alt me-1"></i> {{ $wasteRequest->next_pickup_date->format('d M Y (l)') }}
                                    </div>
                                </div>
                            @endif
                            @if($wasteRequest->not_available_reason)
                                <div class="col-sm-6">
                                    <div class="detail-label">Citizen Unavailability Reason</div>
                                    <div class="detail-value text-danger">
                                        <i class="fa fa-circle-exclamation me-1"></i> {{ $wasteRequest->not_available_reason }}
                                        @if($wasteRequest->not_available_at)
                                            <span class="text-muted small fw-normal">({{ $wasteRequest->not_available_at->format('d M Y, h:i A') }})</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="col-sm-6">
                                <div class="detail-label">Request Source</div>
                                <div class="detail-value text-capitalize">{{ $wasteRequest->source ?: 'Web Citizen Portal' }}</div>
                            </div>
                        </div>

                        <!-- Waste Categories -->
                        <h5 class="section-title mt-2">
                            <i class="fa fa-boxes-stacked text-secondary"></i> Waste Category &amp; Items
                        </h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="detail-label">Selected Categories</div>
                                <div class="detail-value">
                                    @if(is_array($wasteRequest->category_ids))
                                        @foreach($wasteRequest->category_ids as $cat)
                                            <span class="badge bg-primary me-1 mb-1" style="font-size: 12px; font-weight: 500;">{{ $cat }}</span>
                                        @endforeach
                                    @else
                                        {{ $wasteRequest->category_ids ?? 'N/A' }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Sub-Category Details</div>
                                <div class="detail-value">
                                    @if(is_array($wasteRequest->subcategory_ids) && count($wasteRequest->subcategory_ids) > 0)
                                        @foreach($wasteRequest->subcategory_ids as $subcat)
                                            @php
                                                $subcatName = Str::contains($subcat, ': ') ? explode(': ', $subcat)[1] : $subcat;
                                                $subModel = \App\Models\Subcategory::where('name', $subcatName)->first();
                                            @endphp
                                            <span class="badge bg-secondary me-1 mb-1 d-inline-flex align-items-center gap-1" style="font-size: 12px; font-weight: 500;">
                                                @if($subModel && $subModel->icon)
                                                    @if(str_starts_with($subModel->icon, 'fa-') || str_starts_with($subModel->icon, 'fa '))
                                                        <i class="fa-solid {{ $subModel->icon }}"></i>
                                                    @else
                                                        <img src="{{ str_starts_with($subModel->icon, 'http') || str_starts_with($subModel->icon, '/') ? $subModel->icon : asset('storage/' . $subModel->icon) }}" alt="{{ $subcatName }}" width="16" height="16" class="rounded object-fit-cover" onerror="this.style.display='none'">
                                                    @endif
                                                @endif
                                                {{ $subcatName }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted fw-normal">None specified</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Applicant & Location Details -->
                        <h5 class="section-title mt-2">
                            <i class="fa fa-location-dot text-danger"></i> Applicant &amp; Location Details
                        </h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="detail-label">Applicant Name</div>
                                <div class="detail-value">{{ $wasteRequest->applicant_name }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Mobile Number</div>
                                <div class="detail-value">
                                    <a href="tel:{{ $wasteRequest->mobile_number }}" class="text-decoration-none text-dark">
                                        <i class="fa fa-phone text-success me-1"></i>{{ $wasteRequest->mobile_number }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="detail-label">House No</div>
                                <div class="detail-value">{{ $wasteRequest->house_no }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="detail-label">Floor / Level</div>
                                <div class="detail-value">{{ $wasteRequest->floor_no ?? $wasteRequest->floor ?? 'N/A' }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="detail-label">Landmark</div>
                                <div class="detail-value">{{ $wasteRequest->landmark ?? 'N/A' }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="detail-label">Corporation</div>
                                <div class="detail-value">{{ $wasteRequest->corporation?->name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="detail-label">Constituency</div>
                                <div class="detail-value">{{ $wasteRequest->constituency?->name ?? 'N/A' }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="detail-label">Ward</div>
                                <div class="detail-value">
                                    {{ $wasteRequest->ward ? ($wasteRequest->ward->name . ' (Ward ' . $wasteRequest->ward->ward_number . ')') : 'N/A' }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Pincode</div>
                                <div class="detail-value">{{ $wasteRequest->pincode }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">GPS Coordinates</div>
                                <div class="detail-value">
                                    @if($wasteRequest->latitude && $wasteRequest->longitude)
                                        <a href="https://maps.google.com/?q={{ $wasteRequest->latitude }},{{ $wasteRequest->longitude }}" target="_blank" class="text-primary text-decoration-none">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            {{ number_format($wasteRequest->latitude, 4) }}° N, {{ number_format($wasteRequest->longitude, 4) }}° E
                                        </a>
                                    @else
                                        <span class="text-muted fw-normal">N/A</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="detail-label">Complete Address</div>
                                <div class="detail-value">{{ $wasteRequest->address }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Assigned Vehicle & Driver Card -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">
                            <i class="fa fa-truck text-success"></i> Assigned Vehicle &amp; Driver Details
                        </h5>

                        @if($wasteRequest->vehicle)
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="detail-label">Vehicle Registration No.</div>
                                    <div class="detail-value text-primary fw-bold">
                                        <i class="fa fa-truck me-1"></i> {{ $wasteRequest->vehicle->vehicle_number }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-label">Vehicle Type &amp; Capacity</div>
                                    <div class="detail-value">
                                        {{ $wasteRequest->vehicle->vehicle_type ?? 'Truck' }} 
                                        @if($wasteRequest->vehicle->capacity_tons)
                                            ({{ (float)$wasteRequest->vehicle->capacity_tons * 1000 }} kg)
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-label">Driver Name</div>
                                    <div class="detail-value">{{ $wasteRequest->vehicle->driver_name ?? 'N/A' }}</div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-label">Driver Phone Number</div>
                                    <div class="detail-value">
                                        @if($wasteRequest->vehicle->driver_phone)
                                            <a href="tel:{{ $wasteRequest->vehicle->driver_phone }}" class="text-decoration-none text-dark">
                                                <i class="fa fa-phone text-success me-1"></i> {{ $wasteRequest->vehicle->driver_phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-label">Vehicle Owner</div>
                                    <div class="detail-value">
                                        {{ $wasteRequest->vehicle->owner?->name ?? 'N/A' }} 
                                        @if($wasteRequest->vehicle->owner?->mobile_number)
                                            ({{ $wasteRequest->vehicle->owner->mobile_number }})
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-label">Assignment Timestamp</div>
                                    <div class="detail-value">
                                        {{ $wasteRequest->assigned_at ? $wasteRequest->assigned_at->format('d M Y, h:i A') : 'N/A' }}
                                    </div>
                                </div>
                                @if(!empty($wasteRequest->remarks))
                                    <div class="col-sm-12">
                                        <div class="detail-label">Approval / Assignment Remarks</div>
                                        <div class="detail-value p-2 bg-light rounded border-start border-4 border-success">
                                            <i class="fa fa-comment-dots text-success me-1"></i> {{ $wasteRequest->remarks }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-3 bg-light rounded text-center text-muted">
                                <i class="fa fa-truck-ramp-box fa-2x mb-2 text-secondary"></i>
                                <p class="mb-2" style="font-size: 13px;">No vehicle has been assigned to this request yet.</p>
                                @if(!in_array($wasteRequest->status, ['dumped', 'completed']))
                                    <button type="button" class="btn btn-success btn-sm px-3" data-bs-toggle="modal" data-bs-target="#assignVehicleModal">
                                        <i class="fa fa-plus me-1"></i> Assign Vehicle Now
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 3. Complete Pickup Details (Step 1 & Step 2) -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">
                            <i class="fa fa-box-open text-warning"></i> Complete Pickup Collection Details
                        </h5>

                        <div class="row">
                            <!-- Step 1: Before Pickup -->
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded h-100" style="background-color: #fafafa;">
                                    <h6 class="fw-bold text-dark mb-2" style="font-size: 13.5px;">
                                        <i class="fa fa-weight-hanging text-info me-1"></i> Step 1: Before Pickup
                                    </h6>
                                    <div class="detail-label">Estimated Waste Weight</div>
                                    <div class="detail-value text-info fw-bold">
                                        {{ $wasteRequest->approx_weight_kg ? $wasteRequest->approx_weight_kg . ' kg' : 'Not recorded' }}
                                    </div>

                                    <div class="detail-label">Before Pickup GPS</div>
                                    <div class="detail-value">
                                        @if($wasteRequest->before_pickup_latitude && $wasteRequest->before_pickup_longitude)
                                            <a href="https://maps.google.com/?q={{ $wasteRequest->before_pickup_latitude }},{{ $wasteRequest->before_pickup_longitude }}" target="_blank" class="text-primary text-decoration-none">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                {{ number_format($wasteRequest->before_pickup_latitude, 4) }}, {{ number_format($wasteRequest->before_pickup_longitude, 4) }}
                                            </a>
                                        @else
                                            <span class="text-muted fw-normal">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: After Pickup -->
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded h-100" style="background-color: #fafafa;">
                                    <h6 class="fw-bold text-dark mb-2" style="font-size: 13.5px;">
                                        <i class="fa fa-check-double text-success me-1"></i> Step 2: After Pickup
                                    </h6>
                                    <div class="detail-label">Actual Pickup Timestamp</div>
                                    <div class="detail-value text-success fw-bold">
                                        {{ $wasteRequest->picked_up_at ? $wasteRequest->picked_up_at->format('d M Y, h:i A') : 'Not Picked Up Yet' }}
                                    </div>

                                    <div class="detail-label">After Pickup GPS</div>
                                    <div class="detail-value">
                                        @if($wasteRequest->after_pickup_latitude && $wasteRequest->after_pickup_longitude)
                                            <a href="https://maps.google.com/?q={{ $wasteRequest->after_pickup_latitude }},{{ $wasteRequest->after_pickup_longitude }}" target="_blank" class="text-primary text-decoration-none">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                {{ number_format($wasteRequest->after_pickup_latitude, 4) }}, {{ number_format($wasteRequest->after_pickup_longitude, 4) }}
                                            </a>
                                        @else
                                            <span class="text-muted fw-normal">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Complete Dump / Disposal Details Card -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">
                            <i class="fa fa-dumpster text-primary"></i> Complete Dump / Disposal Plant Processing Details
                        </h5>

                        @if($dumpObj)
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="detail-label">Dump Facility / Processing Plant</div>
                                    <div class="detail-value text-primary fw-bold">
                                        <i class="fa fa-industry me-1"></i> {{ $dumpObj->plant_name ?: 'BBMP Processing Plant' }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-label">Dump Timestamp</div>
                                    <div class="detail-value text-success fw-bold">
                                        <i class="fa fa-clock me-1"></i> {{ ($dumpObj->dumped_at ?? $dumpObj->created_at)?->format('d M Y, h:i A') ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-label">Dump Weight Recorded</div>
                                    <div class="detail-value">
                                        {{ $dumpObj->dump_weight ? $dumpObj->dump_weight . ' kg' : ($wasteRequest->approx_weight_kg ? $wasteRequest->approx_weight_kg . ' kg' : 'N/A') }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="detail-label">Dump Site GPS Coordinates</div>
                                    <div class="detail-value">
                                        @if($dumpObj->dump_latitude && $dumpObj->dump_longitude)
                                            <a href="https://maps.google.com/?q={{ $dumpObj->dump_latitude }},{{ $dumpObj->dump_longitude }}" target="_blank" class="text-primary text-decoration-none">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                {{ number_format($dumpObj->dump_latitude, 4) }}° N, {{ number_format($dumpObj->dump_longitude, 4) }}° E
                                            </a>
                                        @else
                                            <span class="text-muted fw-normal">N/A</span>
                                        @endif
                                    </div>
                                </div>
                                @if(!empty($dumpObj->pickup_number))
                                    <div class="col-sm-6">
                                        <div class="detail-label">Pickup Reference No.</div>
                                        <div class="detail-value">{{ $dumpObj->pickup_number }}</div>
                                    </div>
                                @endif
                                @if(!empty($dumpObj->remarks))
                                    <div class="col-sm-12">
                                        <div class="detail-label">Dump Remarks</div>
                                        <div class="detail-value p-2 bg-light rounded">{{ $dumpObj->remarks }}</div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-3 bg-light rounded text-center text-muted">
                                <i class="fa fa-industry fa-2x mb-2 text-secondary"></i>
                                <p class="mb-0" style="font-size: 13px;">This waste request has not been unloaded / dumped at a processing plant yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: All Multi-Stage Photos Galleries -->
            <div class="col-xl-4 col-lg-4">
                <!-- 1. Citizen Uploaded Waste Photos -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">
                            <i class="fa fa-camera text-primary"></i> 1. Citizen Waste Photos
                        </h5>
                        @if(is_array($wasteRequest->waste_images) && count($wasteRequest->waste_images) > 0)
                            @foreach($wasteRequest->waste_images as $index => $imgPath)
                                <div class="waste-img-card text-center p-2 mb-2">
                                    <img src="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" 
                                         alt="Waste Image {{ $index + 1 }}" 
                                         class="waste-img-preview rounded mb-2"
                                         onerror="this.src='https://placehold.co/400x300?text=Waste+Image'">
                                    <a href="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                        <i class="fa fa-expand me-1"></i> View Photo {{ $index + 1 }}
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="p-3 border rounded text-center bg-light">
                                <i class="fa fa-image fa-2x text-muted mb-1"></i>
                                <p class="text-muted mb-0 small">No waste photos uploaded.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 2. Before-Pickup Photos (Step 1) -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">
                            <i class="fa fa-camera-retro text-info"></i> 2. Before-Pickup Photos
                        </h5>
                        @if(is_array($wasteRequest->before_pickup_images) && count($wasteRequest->before_pickup_images) > 0)
                            @foreach($wasteRequest->before_pickup_images as $bIndex => $bPath)
                                <div class="waste-img-card text-center p-2 mb-2">
                                    <img src="{{ Str::startsWith($bPath, 'http') ? $bPath : asset('storage/' . $bPath) }}" 
                                         alt="Before Pickup {{ $bIndex + 1 }}" 
                                         class="waste-img-preview rounded mb-2"
                                         onerror="this.src='https://placehold.co/400x300?text=Before+Pickup'">
                                    <a href="{{ Str::startsWith($bPath, 'http') ? $bPath : asset('storage/' . $bPath) }}" target="_blank" class="btn btn-sm btn-outline-info w-100">
                                        <i class="fa fa-expand me-1"></i> View Before Photo {{ $bIndex + 1 }}
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="p-3 border rounded text-center bg-light">
                                <i class="fa fa-image fa-2x text-muted mb-1"></i>
                                <p class="text-muted mb-0 small">No before-pickup photos.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 3. After-Pickup Photos (Step 2) -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">
                            <i class="fa fa-check-circle text-success"></i> 3. After-Pickup Photos
                        </h5>
                        @if(is_array($wasteRequest->picked_up_images) && count($wasteRequest->picked_up_images) > 0)
                            @foreach($wasteRequest->picked_up_images as $aIndex => $aPath)
                                <div class="waste-img-card text-center p-2 mb-2">
                                    <img src="{{ Str::startsWith($aPath, 'http') ? $aPath : asset('storage/' . $aPath) }}" 
                                         alt="After Pickup {{ $aIndex + 1 }}" 
                                         class="waste-img-preview rounded mb-2"
                                         onerror="this.src='https://placehold.co/400x300?text=After+Pickup'">
                                    <a href="{{ Str::startsWith($aPath, 'http') ? $aPath : asset('storage/' . $aPath) }}" target="_blank" class="btn btn-sm btn-outline-success w-100">
                                        <i class="fa fa-expand me-1"></i> View After Photo {{ $aIndex + 1 }}
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="p-3 border rounded text-center bg-light">
                                <i class="fa fa-image fa-2x text-muted mb-1"></i>
                                <p class="text-muted mb-0 small">No after-pickup photos.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 4. Dump / Processing Plant Photos -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">
                            <i class="fa fa-industry text-primary"></i> 4. Dump / Plant Photos
                        </h5>
                        @if($dumpObj && is_array($dumpObj->dump_images) && count($dumpObj->dump_images) > 0)
                            @foreach($dumpObj->dump_images as $dIndex => $dPath)
                                <div class="waste-img-card text-center p-2 mb-2">
                                    <img src="{{ Str::startsWith($dPath, 'http') ? $dPath : asset('storage/' . $dPath) }}" 
                                         alt="Dump Photo {{ $dIndex + 1 }}" 
                                         class="waste-img-preview rounded mb-2"
                                         onerror="this.src='https://placehold.co/400x300?text=Dump+Photo'">
                                    <a href="{{ Str::startsWith($dPath, 'http') ? $dPath : asset('storage/' . $dPath) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                        <i class="fa fa-expand me-1"></i> View Dump Photo {{ $dIndex + 1 }}
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="p-3 border rounded text-center bg-light">
                                <i class="fa fa-image fa-2x text-muted mb-1"></i>
                                <p class="text-muted mb-0 small">No dump photos uploaded yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column gap-2 mb-4">
                    @if(!in_array($wasteRequest->status, ['dumped', 'completed']))
                        <button type="button" class="btn btn-success w-100 py-2 fw-bold d-flex align-items-center justify-content-center gap-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#assignVehicleModal">
                            <i class="fa fa-truck"></i> {{ $wasteRequest->vehicle ? 'Change Assigned Vehicle' : 'Assign Vehicle' }}
                        </button>
                    @endif
                    <a href="{{ route('admin.requests.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-left me-1"></i> Back to All Requests
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Assign Vehicle Modal -->
<div class="modal fade" id="assignVehicleModal" tabindex="-1" aria-labelledby="assignVehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.requests.assign-vehicle', $wasteRequest->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="assignVehicleModalLabel">
                        <i class="fa fa-truck text-primary me-2"></i> Assign Vehicle to Request #{{ $wasteRequest->request_number }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if($wasteRequest->constituency)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Request Constituency</label>
                            <input type="text" class="form-control" value="{{ $wasteRequest->constituency->name }}" readonly style="background-color: #f8f9fa;">
                        </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="vehicle_id">Select Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                            @if($vehicles->isEmpty())
                                <option value="" disabled selected>No active vehicles registered for {{ $wasteRequest->constituency?->name ?? 'this constituency' }}</option>
                            @else
                                <option value="" disabled {{ !$wasteRequest->vehicle_id ? 'selected' : '' }}>-- Choose Available Vehicle ({{ $wasteRequest->constituency?->name ?? 'Constituency' }}) --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ $wasteRequest->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->vehicle_number }} - {{ $vehicle->vehicle_type ?? 'Truck' }} (Driver: {{ $vehicle->driver_name ?? $vehicle->owner?->name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="remarks">Approval / Assignment Remarks <span class="text-muted font-11 fw-normal">(Optional)</span></label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter any notes or remarks for this approval/assignment...">{{ old('remarks', $wasteRequest->remarks) }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Assign Vehicle</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
