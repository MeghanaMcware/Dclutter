@extends('admin.layout.app')

@section('title', 'View Vehicle Details')

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
    .img-preview {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        border: 1px solid #eaebf0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>View Vehicle Details</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.vehicles.index') }}">Vehicles</a></li>
                        <li class="breadcrumb-item active">View Vehicle Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
        
    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card card-custom mb-4">
                <div class="card-body">
                    <h5 class="section-title">Vehicle Information</h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="detail-label">Vehicle Number</div>
                            <div class="detail-value">{{ $vehicle->vehicle_number }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Vehicle Type</div>
                            <div class="detail-value">{{ $vehicle->vehicle_type ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Capacity</div>
                            <div class="detail-value">
                                @if($vehicle->capacity_tons)
                                    {{ (float)$vehicle->capacity_tons * 1000 }} kg ({{ $vehicle->capacity_tons }} T)
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Status</div>
                            <div class="detail-value {{ $vehicle->status ? 'text-success' : 'text-danger' }}">
                                {{ $vehicle->status ? 'Active' : 'Inactive' }}
                            </div>
                        </div>
                    </div>

                    <h5 class="section-title mt-4">Owner Details</h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="detail-label">Name</div>
                            <div class="detail-value">{{ $vehicle->owner?->name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Phone Number</div>
                            <div class="detail-value">{{ $vehicle->owner?->mobile_number ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <h5 class="section-title mt-4">Driver Details</h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="detail-label">Name</div>
                            <div class="detail-value">{{ $vehicle->driver_name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">Phone Number</div>
                            <div class="detail-value">{{ $vehicle->driver_phone ?? 'N/A' }}</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="detail-label">License Number</div>
                            <div class="detail-value">{{ $vehicle->license_number ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4">
            <div class="card card-custom mb-4">
                <div class="card-body">
                    <h5 class="section-title">Photos & Documents</h5>
                    
                    <div class="mb-4">
                        <div class="detail-label">Vehicle Photo</div>
                        <div class="p-2 border rounded text-center bg-light">
                            @if($vehicle->vehicle_photo)
                                <a href="{{ asset('storage/' . $vehicle->vehicle_photo) }}" target="_blank">
                                    <i class="fa fa-image fa-3x text-primary mb-2"></i>
                                    <p class="mb-0 text-primary fw-bold" style="font-size: 12px;">View Vehicle Photo</p>
                                </a>
                            @else
                                <i class="fa fa-image fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">No photo uploaded</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="detail-label">Driver License Photo</div>
                        <div class="p-2 border rounded text-center bg-light">
                            @if($vehicle->license_photo)
                                <a href="{{ asset('storage/' . $vehicle->license_photo) }}" target="_blank">
                                    <i class="fa fa-id-card fa-3x text-primary mb-2"></i>
                                    <p class="mb-0 text-primary fw-bold" style="font-size: 12px;">View License Photo</p>
                                </a>
                            @else
                                <i class="fa fa-id-card fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">No license photo uploaded</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="detail-label">RC Document</div>
                        <div class="p-2 border rounded text-center bg-light">
                            @if($vehicle->rc_document)
                                <a href="{{ asset('storage/' . $vehicle->rc_document) }}" target="_blank">
                                    <i class="fa fa-file-pdf fa-3x text-danger mb-2"></i>
                                    <p class="mb-0 text-primary fw-bold" style="font-size: 12px;">View RC Document</p>
                                </a>
                            @else
                                <i class="fa fa-file-pdf fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">No RC document uploaded</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="detail-label">Fitness Certificate</div>
                        <div class="p-2 border rounded text-center bg-light">
                            @if($vehicle->fitness_document)
                                <a href="{{ asset('storage/' . $vehicle->fitness_document) }}" target="_blank">
                                    <i class="fa fa-file-pdf fa-3x text-danger mb-2"></i>
                                    <p class="mb-0 text-primary fw-bold" style="font-size: 12px;">View Fitness Certificate</p>
                                </a>
                            @else
                                <i class="fa fa-file-pdf fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">No fitness cert uploaded</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="detail-label">Insurance Document</div>
                        <div class="p-2 border rounded text-center bg-light">
                            @if($vehicle->insurance_document)
                                <a href="{{ asset('storage/' . $vehicle->insurance_document) }}" target="_blank">
                                    <i class="fa fa-file-pdf fa-3x text-danger mb-2"></i>
                                    <p class="mb-0 text-primary fw-bold" style="font-size: 12px;">View Insurance Document</p>
                                </a>
                            @else
                                <i class="fa fa-file-pdf fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">No insurance doc uploaded</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
