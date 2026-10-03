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
                        <li class="breadcrumb-item"><a href="{{ route('admin.dump.index') }}">Pickup & Dump List</a></li>
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
                                <div class="detail-value text-primary fw-bold">{{ $wasteRequest->request_number }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    @php
                                        $st = strtolower($wasteRequest->status ?? 'pending');
                                        $badgeClass = match($st) {
                                            'dumped', 'completed' => 'status-completed',
                                            'picked_up' => 'status-in-progress',
                                            default => 'status-pending'
                                        };
                                    @endphp
                                    <span class="status-badge {{ $badgeClass }}">{{ $wasteRequest->status_label }}</span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Customer Name</div>
                                <div class="detail-value">{{ $wasteRequest->applicant_name ?: 'Citizen User' }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Mobile Number</div>
                                <div class="detail-value">{{ $wasteRequest->mobile_number ? ('+91 ' . $wasteRequest->mobile_number) : 'N/A' }}</div>
                            </div>
                            <div class="col-md-8 col-sm-12 mb-3">
                                <div class="detail-label">Address</div>
                                <div class="detail-value">{{ ($wasteRequest->house_no ? ($wasteRequest->house_no . (($wasteRequest->floor_no ?? $wasteRequest->floor) ? ' (Floor: ' . ($wasteRequest->floor_no ?? $wasteRequest->floor) . '), ' : ', ')) : '') . $wasteRequest->address }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Waste Category</div>
                                <div class="detail-value">{{ is_array($wasteRequest->category_ids) ? implode(', ', $wasteRequest->category_ids) : ($wasteRequest->category_ids ?: 'N/A') }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Estimated Weight</div>
                                <div class="detail-value">{{ $wasteRequest->approx_weight_kg ? ($wasteRequest->approx_weight_kg . ' kg') : ($dumpObj && $dumpObj->dump_weight ? ($dumpObj->dump_weight . ' Tons') : 'N/A') }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Assigned Vehicle</div>
                                <div class="detail-value fw-bold text-dark">{{ $wasteRequest->vehicle ? ($wasteRequest->vehicle->vehicle_number . ($wasteRequest->vehicle->vehicle_type ? ' (' . $wasteRequest->vehicle->vehicle_type . ')' : '')) : 'N/A' }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Assigned Driver</div>
                                <div class="detail-value">{{ $wasteRequest->vehicle ? ($wasteRequest->vehicle->driver_name . ($wasteRequest->vehicle->driver_phone ? ' (' . $wasteRequest->vehicle->driver_phone . ')' : '')) : 'N/A' }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Pickup Date</div>
                                <div class="detail-value text-success">{{ $wasteRequest->picked_up_at ? $wasteRequest->picked_up_at->format('d M Y, h:i A') : 'Pending Pickup' }}</div>
                            </div>
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="detail-label">Dump Date</div>
                                <div class="detail-value text-info">{{ $dumpObj && $dumpObj->dumped_at ? $dumpObj->dumped_at->format('d M Y, h:i A') : ($wasteRequest->status === 'dumped' && $wasteRequest->updated_at ? $wasteRequest->updated_at->format('d M Y, h:i A') : 'Pending Dump') }}</div>
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
                            @php
                                $userImg = !empty($userPhotos) ? (str_starts_with($userPhotos[0], 'http') ? $userPhotos[0] : asset('storage/' . $userPhotos[0])) : null;
                                $beforeImg = !empty($beforePhotos) ? (str_starts_with($beforePhotos[0], 'http') ? $beforePhotos[0] : asset('storage/' . $beforePhotos[0])) : null;
                                $afterImg = !empty($afterPhotos) ? (str_starts_with($afterPhotos[0], 'http') ? $afterPhotos[0] : asset('storage/' . $afterPhotos[0])) : null;
                                $dumpImg = !empty($dumpPhotos) ? (str_starts_with($dumpPhotos[0], 'http') ? $dumpPhotos[0] : asset('storage/' . $dumpPhotos[0])) : null;
                            @endphp

                            <!-- User Request Image -->
                            <div class="col-md-3 col-sm-6 mb-3">
                                <h6 class="text-center text-muted fw-bold">User Request Image</h6>
                                <div class="waste-img-card text-center p-2">
                                    @if($userImg)
                                        <img src="{{ $userImg }}" alt="Request Image" class="waste-img-preview rounded mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="viewPhotoModal('{{ $userImg }}', 'User Request Image')">
                                            <i class="fa fa-expand me-1"></i> View Image
                                        </button>
                                    @else
                                        <img src="https://placehold.co/600x400?text=No+Request+Image" alt="No Image" class="waste-img-preview rounded mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100 disabled" disabled>
                                            <i class="fa fa-ban me-1"></i> No Photo
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Driver Before Pickup -->
                            <div class="col-md-3 col-sm-6 mb-3">
                                <h6 class="text-center text-muted fw-bold">Driver Before Pickup</h6>
                                <div class="waste-img-card text-center p-2">
                                    @if($beforeImg)
                                        <img src="{{ $beforeImg }}" alt="Before Pickup" class="waste-img-preview rounded mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="viewPhotoModal('{{ $beforeImg }}', 'Driver Before Pickup')">
                                            <i class="fa fa-expand me-1"></i> View Image
                                        </button>
                                    @else
                                        <img src="https://placehold.co/400x300?text=Before+Pickup+Pending" alt="Pending" class="waste-img-preview rounded mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100 disabled" disabled>
                                            <i class="fa fa-ban me-1"></i> No Photo
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Driver After Pickup -->
                            <div class="col-md-3 col-sm-6 mb-3">
                                <h6 class="text-center text-muted fw-bold">Driver After Pickup</h6>
                                <div class="waste-img-card text-center p-2">
                                    @if($afterImg)
                                        <img src="{{ $afterImg }}" alt="After Pickup" class="waste-img-preview rounded mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="viewPhotoModal('{{ $afterImg }}', 'Driver After Pickup')">
                                            <i class="fa fa-expand me-1"></i> View Image
                                        </button>
                                    @else
                                        <img src="https://placehold.co/400x300?text=After+Pickup+Pending" alt="Pending" class="waste-img-preview rounded mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100 disabled" disabled>
                                            <i class="fa fa-ban me-1"></i> No Photo
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Driver At Dump Yard -->
                            <div class="col-md-3 col-sm-6 mb-3">
                                <h6 class="text-center text-muted fw-bold">Driver At Dump Yard</h6>
                                <div class="waste-img-card text-center p-2">
                                    @if($dumpImg)
                                        <img src="{{ $dumpImg }}" alt="Dump Image" class="waste-img-preview rounded mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100" onclick="viewPhotoModal('{{ $dumpImg }}', 'Dump Yard Photo')">
                                            <i class="fa fa-expand me-1"></i> View Image
                                        </button>
                                    @else
                                        <img src="https://placehold.co/600x400?text=Dump+Pending" alt="Pending" class="waste-img-preview rounded mb-2">
                                        <button type="button" class="btn btn-sm btn-outline-secondary w-100 disabled" disabled>
                                            <i class="fa fa-ban me-1"></i> No Photo
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Photo Lightbox Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title fw-bold" id="photoModalLabel">Photo Evidence</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-2">
                <img id="photoModalImg" src="" alt="Full Preview" class="img-fluid rounded" style="max-height: 80vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    function viewPhotoModal(src, title) {
        document.getElementById('photoModalImg').src = src;
        document.getElementById('photoModalLabel').innerText = title || 'Photo Evidence';
        var modal = new bootstrap.Modal(document.getElementById('photoModal'));
        modal.show();
    }
</script>
@endsection