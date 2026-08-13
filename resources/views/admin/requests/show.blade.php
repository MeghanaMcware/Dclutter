@extends('admin.layout.app')

@section('title', 'View Request #' . $wasteRequest->request_number)

@section('style')
<style>
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eaebf0;
    }
    .detail-label {
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 4px;
    }
    .detail-value {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 15px;
    }
    .card-custom {
        border: 1px solid #eaebf0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border-radius: 8px;
    }
    .status-badge {
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 4px;
        text-transform: uppercase;
        display: inline-block;
    }
    .status-assigned { background-color: #e3f2fd; color: #2196f3; border: 1px solid #90caf9; }
    .status-pending { background-color: #ffebee; color: #f44336; border: 1px solid #ef9a9a; }
    .status-picked_up { background-color: #fff4e5; color: #ff9800; border: 1px solid #ffcc80; }
    .status-dumped { background-color: #e8f5e9; color: #4caf50; border: 1px solid #a5d6a7; }
    .status-rejected { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    .waste-img-card {
        border: 1px solid #eaebf0;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 15px;
        background: #f8f9fa;
    }
    .waste-img-preview {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="page-title mb-3">
            <div class="row align-items-center">
                <div class="col-12 col-sm-6">
                    <h3 class="fw-bold">
                        Request Details: <span class="text-primary">{{ $wasteRequest->request_number }}</span>
                    </h3>
                </div>
                <div class="col-12 col-sm-6 text-sm-end">
                    <ol class="breadcrumb d-inline-flex mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/dashboard') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.requests.index') }}">All Requests</a></li>
                        <li class="breadcrumb-item active">{{ $wasteRequest->request_number }}</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <!-- Request Info Card -->
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">Request Information</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="detail-label">Request ID</div>
                                <div class="detail-value text-primary fw-bold">{{ $wasteRequest->request_number }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    @php
                                        $statusClasses = [
                                            'pending' => 'status-pending',
                                            'assigned' => 'status-assigned',
                                            'picked_up' => 'status-picked_up',
                                            'dumped' => 'status-dumped',
                                            'rejected' => 'status-rejected',
                                        ];
                                    @endphp
                                    <span class="status-badge {{ $statusClasses[$wasteRequest->status] ?? 'status-pending' }}">
                                        {{ ucfirst(str_replace('_', ' ', $wasteRequest->status)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Date Submitted</div>
                                <div class="detail-value">{{ $wasteRequest->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Pickup Date (Sunday)</div>
                                <div class="detail-value text-success">
                                    {{ $wasteRequest->preferred_pickup_date ? $wasteRequest->preferred_pickup_date->format('d M Y (l)') : 'N/A' }}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Assigned Vehicle</div>
                                <div class="detail-value d-flex align-items-center gap-2">
                                    @if($wasteRequest->vehicle)
                                        <span class="fw-bold text-primary">
                                            <i class="fa fa-truck me-1"></i>
                                            {{ $wasteRequest->vehicle->vehicle_number }}
                                            ({{ $wasteRequest->vehicle->driver_name ?? 'Driver' }})
                                        </span>
                                        <button type="button" class="btn btn-sm btn-outline-warning py-0 px-2" data-bs-toggle="modal" data-bs-target="#assignVehicleModal" style="font-size: 11px;">
                                            Change
                                        </button>
                                    @else
                                        <span class="text-muted fw-normal me-2">Not Assigned Yet</span>
                                        <button type="button" class="btn btn-sm btn-primary py-1 px-2" data-bs-toggle="modal" data-bs-target="#assignVehicleModal" style="font-size: 12px;">
                                            <i class="fa fa-plus me-1"></i> Assign Vehicle
                                        </button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Request Source</div>
                                <div class="detail-value text-capitalize">{{ $wasteRequest->source }}</div>
                            </div>
                        </div>

                        <!-- Waste Information -->
                        <h5 class="section-title mt-3">Waste Categories</h5>
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
                                            <span class="badge bg-secondary me-1 mb-1" style="font-size: 12px; font-weight: 500;">
                                                {{ Str::contains($subcat, ': ') ? explode(': ', $subcat)[1] : $subcat }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted fw-normal">None specified</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Applicant & Location Details -->
                        <h5 class="section-title mt-3">Applicant &amp; Location Details</h5>
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
                            <div class="col-sm-6">
                                <div class="detail-label">House No</div>
                                <div class="detail-value">{{ $wasteRequest->house_no }}</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Landmark</div>
                                <div class="detail-value">{{ $wasteRequest->landmark ?? 'N/A' }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="detail-label">Corporation</div>
                                <div class="detail-value">{{ $wasteRequest->corporation?->name ?? ($wasteRequest->ward?->constituency?->corporation?->name ?? 'N/A') }}</div>
                            </div>
                            <div class="col-sm-4">
                                <div class="detail-label">Constituency</div>
                                <div class="detail-value">{{ $wasteRequest->constituency?->name ?? ($wasteRequest->ward?->constituency?->name ?? 'N/A') }}</div>
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
            </div>

            <!-- Photos Column -->
            <div class="col-xl-4 col-lg-4">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">Uploaded Waste Photos</h5>
                        
                        @if(is_array($wasteRequest->waste_images) && count($wasteRequest->waste_images) > 0)
                            @foreach($wasteRequest->waste_images as $index => $imgPath)
                                <div class="waste-img-card text-center p-2">
                                    <img src="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" 
                                         alt="Waste Image {{ $index + 1 }}" 
                                         class="waste-img-preview rounded mb-2"
                                         onerror="this.src='https://placehold.co/400x300?text=Waste+Image'">
                                    <div>
                                        <a href="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                            <i class="fa fa-expand me-1"></i> View Full Photo {{ $index + 1 }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="p-4 border rounded text-center bg-light">
                                <i class="fa fa-image fa-3x text-muted mb-2"></i>
                                <p class="text-muted mb-0" style="font-size: 13px;">No waste photos uploaded for this request.</p>
                            </div>
                        @endif

                        <!-- Driver Pickup Details & Photos -->
                        <h5 class="section-title mt-4">Driver Before Pickup (Step 1)</h5>
                        @if($wasteRequest->approx_weight_kg)
                            <div class="alert alert-info py-2 px-3 mb-2" style="font-size: 13px;">
                                <strong>Estimated Weight:</strong> {{ $wasteRequest->approx_weight_kg }} kg
                            </div>
                        @endif
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
                            <p class="text-muted small">No before-pickup photos uploaded yet.</p>
                        @endif

                        <h5 class="section-title mt-4">Driver After Pickup (Step 2)</h5>
                        @if($wasteRequest->picked_up_at)
                            <div class="alert alert-success py-2 px-3 mb-2" style="font-size: 13px;">
                                <strong>Picked Up At:</strong> {{ $wasteRequest->picked_up_at->format('d M Y, h:i A') }}
                            </div>
                        @endif
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
                            <p class="text-muted small">No after-pickup photos uploaded yet.</p>
                        @endif

                        <div class="mt-4 pt-3 border-top">
                            <a href="{{ route('admin.requests.index') }}" class="btn btn-secondary w-100">
                                <i class="bi bi-arrow-left me-1"></i> Back to All Requests
                            </a>
                        </div>
                    </div>
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
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="vehicle_id">Select Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                            <option value="" disabled selected>-- Choose Available Vehicle --</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ $wasteRequest->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->vehicle_number }} - {{ $vehicle->vehicle_type ?? 'Truck' }} (Driver: {{ $vehicle->driver_name ?? $vehicle->owner?->name ?? 'N/A' }})
                                </option>
                            @endforeach
                        </select>
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
