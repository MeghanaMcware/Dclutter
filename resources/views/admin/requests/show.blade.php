@extends('admin.layout.app')

@section('title', 'View Request Details')

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
        padding: 4px 8px;
        border-radius: 4px;
    }
    .status-in-progress { background-color: #ffeeba; color: #856404; }
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        View Request Details
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/dashboard') }}">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/requests') }}">All Requests</a></li>
                        <li class="breadcrumb-item active">View Request</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title">Request Information</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="detail-label">Request ID</div>
                                <div class="detail-value text-primary">#DCL-2025-001256</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Status</div>
                                <div class="detail-value"><span class="status-badge status-in-progress">In-Progress</span></div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Date Submitted</div>
                                <div class="detail-value">20 May 2026, 10:30 AM</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Pickup Date</div>
                                <div class="detail-value">23 May 2026</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Assigned To</div>
                                <div class="detail-value">Ramesh B. (Truck KA-01-AB-1234)</div>
                            </div>
                        </div>

                        <h5 class="section-title mt-4">Waste Information</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="detail-label">Category</div>
                                <div class="detail-value">Electronics</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Sub-Category</div>
                                <div class="detail-value">TV, Fridge</div>
                            </div>
                           
                        </div>

                        <h5 class="section-title mt-4">Location Details</h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="detail-label">Mobile Number</div>
                                <div class="detail-value">9876543210</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">House No</div>
                                <div class="detail-value">#123</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Corporation</div>
                                <div class="detail-value">BBMP</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Constituency</div>
                                <div class="detail-value">BTM Layout</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Ward</div>
                                <div class="detail-value">Ward 95 - Subhash Nagar</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Pincode</div>
                                <div class="detail-value">560029</div>
                            </div>
                            <div class="col-sm-6">
                                <div class="detail-label">Landmark</div>
                                <div class="detail-value">Near Metro Station</div>
                            </div>
                            <div class="col-sm-12">
                                <div class="detail-label">Complete Address</div>
                                <div class="detail-value">12th Cross, 4th Main, BTM Layout, Bengaluru</div>
                            </div>
                            <div class="col-sm-12">
                                <div class="detail-label">GPS Location</div>
                                <div class="detail-value">12.9165° N, 77.6101° E</div>
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
                            <div class="detail-label">Uploaded Waste Image</div>
                            <div class="p-2 border rounded text-center bg-light">
                                <i class="fa fa-image fa-4x text-muted mb-2 mt-3"></i>
                                <p class="mb-3 text-muted" style="font-size: 13px;">waste_photo.jpg</p>
                                <a href="#" class="btn btn-sm btn-outline-primary mb-2">View Full Image</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</div>
@endsection
