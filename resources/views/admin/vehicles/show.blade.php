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
                    <h3>
                        View Vehicle Details
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">View Vehicle Details</li>
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
                                <div class="detail-value">KA-01-AB-1234</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Vehicle Type</div>
                                <div class="detail-value">Truck</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Capacity</div>
                                <div class="detail-value">1000 kg</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Status</div>
                                <div class="detail-value text-success">Active</div>
                            </div>
                        </div>

                        <h5 class="section-title mt-4">Owner Details</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="detail-label">Name</div>
                                <div class="detail-value">John Doe</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Phone Number</div>
                                <div class="detail-value">9876543210</div>
                            </div>
                        </div>

                        <h5 class="section-title mt-4">Driver Details</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="detail-label">Name</div>
                                <div class="detail-value">Jane Smith</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Phone Number</div>
                                <div class="detail-value">8765432109</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">License Number</div>
                                <div class="detail-value">DL-14-2020-0012345</div>
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
                                <i class="fa fa-image fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">vehicle_photo.jpg</p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="detail-label">Driver License Photo</div>
                            <div class="p-2 border rounded text-center bg-light">
                                <i class="fa fa-id-card fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">license_img.jpg</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="detail-label">RC Document</div>
                            <div class="p-2 border rounded text-center bg-light">
                                <i class="fa fa-file-pdf fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">rc_cert.pdf</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="detail-label">Fitness Certificate</div>
                            <div class="p-2 border rounded text-center bg-light">
                                <i class="fa fa-file-pdf fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">fitness_cert.pdf</p>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="detail-label">Insurance Document</div>
                            <div class="p-2 border rounded text-center bg-light">
                                <i class="fa fa-file-pdf fa-3x text-muted mb-2"></i>
                                <p class="mb-0 text-muted" style="font-size: 12px;">insurance.pdf</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-end gap-2 mb-4">
            <a href="{{ url('admin/vehicles/edit') }}" class="btn btn-warning text-white"><i class="fa fa-pencil me-1"></i> Edit Vehicle</a>
            <a href="{{ url('admin/vehicles') }}" class="btn btn-light"><i class="fa fa-arrow-left me-1"></i> Back to List</a>
        </div>
    </div>
</div>
@endsection
