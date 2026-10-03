@extends('admin.layout.app')

@section('title', 'View Request Details (Pickup & Dump)')

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
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
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

.status-completed {
    background-color: #e8f5e9;
    color: #4caf50;
    border: 1px solid #a5d6a7;
}

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
        <!-- Page Title -->
        <div class="page-title mb-3">
            <div class="row align-items-center">
                <div class="col-12 col-sm-6">
                    <h3 class="fw-bold d-flex align-items-center gap-2 flex-wrap">
                        Request Details: <span class="text-primary">REQ-1001</span>
                    </h3>
                </div>
                <div class="col-12 col-sm-6 d-flex align-items-center justify-content-sm-end gap-2 mt-2 mt-sm-0">
                    <ol class="breadcrumb d-inline-flex mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/dashboard') }}">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/dump') }}">Pickup & Dump List</a></li>
                        <li class="breadcrumb-item active">View Details</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            
         

            <!--  Row: Request Info -->
            <div class="col-12">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fa fa-info-circle me-2 text-primary"></i> Request
                            Information</h5>
                        <div class="row">
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Request ID</div>
                                <div class="detail-value text-primary fw-bold">REQ-1001</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    <span class="status-badge status-completed">Dumped</span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Customer Name</div>
                                <div class="detail-value">John Doe</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Mobile Number</div>
                                <div class="detail-value">+91 9876543210</div>
                            </div>
                            <div class="col-md-8 col-sm-12 mb-3">
                                <div class="detail-label">Address</div>
                                <div class="detail-value">H.No 1-23, Sector 1, Area A, City, State, 123456</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Waste Category</div>
                                <div class="detail-value">Plastic & Dry Waste</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Estimated Weight</div>
                                <div class="detail-value">15 kg</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Assigned Vehicle</div>
                                <div class="detail-value fw-bold text-dark">TS-09-XX-1234 (Truck)</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Assigned Driver</div>
                                <div class="detail-value">Ramesh Kumar</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Pickup Date</div>
                                <div class="detail-value text-success">01 Oct 2026, 10:30 AM</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Dump Date</div>
                                <div class="detail-value text-info">01 Oct 2026, 02:15 PM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!--  Row: Images -->
               <div class="col-12">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="section-title"><i class="fa fa-camera me-2 text-success"></i> Photo Evidence</h5>
                        <div class="row">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <h6 class="text-center text-muted fw-bold">User Request Image</h6>
                                <div class="waste-img-card text-center p-2">
                                    <img src="https://placehold.co/600x400?text=User+Request+Image" alt="Request Image"
                                        class="waste-img-preview rounded mb-2">
                                    <button class="btn btn-sm btn-outline-secondary w-100">
                                        <i class="fa fa-expand me-1"></i> View Image
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <h6 class="text-center text-muted fw-bold">Driver Before Pickup</h6>
                                <div class="waste-img-card text-center p-2">
                                    <img src="https://placehold.co/400x300?text=Before+Pickup" alt="Before Pickup"
                                        class="waste-img-preview rounded mb-2">
                                    <button class="btn btn-sm btn-outline-secondary w-100">
                                        <i class="fa fa-expand me-1"></i> View Image
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <h6 class="text-center text-muted fw-bold">Driver After Pickup</h6>
                                <div class="waste-img-card text-center p-2">
                                    <img src="https://placehold.co/400x300?text=After+Pickup" alt="After Pickup"
                                        class="waste-img-preview rounded mb-2">
                                    <button class="btn btn-sm btn-outline-secondary w-100">
                                        <i class="fa fa-expand me-1"></i> View Image
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <h6 class="text-center text-muted fw-bold">Driver At Dump Yard</h6>
                                <div class="waste-img-card text-center p-2">
                                    <img src="https://placehold.co/600x400?text=Dumped+Waste+Image" alt="Dump Image"
                                        class="waste-img-preview rounded mb-2">
                                    <button class="btn btn-sm btn-outline-secondary w-100">
                                        <i class="fa fa-expand me-1"></i> View Image
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection