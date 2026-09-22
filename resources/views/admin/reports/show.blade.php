@extends('admin.layout.app')

@section('title', 'Report Details - ' . $wasteRequest->request_number)

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
        padding: 6px 14px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
    }
    .status-in-progress {
        background-color: #fff4e5;
        color: #ff9800;
        border: 1px solid #ffcc80;
    }
    .status-assigned {
        background-color: #e3f2fd;
        color: #2196f3;
        border: 1px solid #90caf9;
    }
    .status-pending {
        background-color: #ffebee;
        color: #f44336;
        border: 1px solid #ef9a9a;
    }
    .status-completed {
        background-color: #e8f5e9;
        color: #4caf50;
        border: 1px solid #a5d6a7;
    }
    .status-rejected {
        background-color: #ffebee;
        color: #f44336;
        border: 1px solid #ef9a9a;
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
                        Report Details: <span class="text-primary">{{ $wasteRequest->request_number }}</span>
                    </h3>
                </div>
                <div class="col-12 col-sm-6 text-sm-end">
                    <ol class="breadcrumb d-inline-flex mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Reports</a></li>
                        <li class="breadcrumb-item active">{{ $wasteRequest->request_number }}</li>
                    </ol>
                </div>
            </div>
        </div>

        @php
            $pickupDate = $wasteRequest->picked_up_at ? $wasteRequest->picked_up_at->format('d-m-Y h:i A') : ($wasteRequest->preferred_pickup_date ? $wasteRequest->preferred_pickup_date->format('d-m-Y') : 'N/A');
            $dumpDate = ($wasteRequest->dump?->dumped_at ?? $wasteRequest->dump?->created_at ?? $wasteRequest->dumpRecord?->dumped_at ?? $wasteRequest->dumpRecord?->created_at)?->format('d-m-Y h:i A') ?? 'N/A';
            
            $statusClass = match($wasteRequest->status) {
                'pending' => 'status-pending',
                'assigned' => 'status-assigned',
                'picked_up' => 'status-in-progress',
                'dumped' => 'status-completed',
                'rejected' => 'status-rejected',
                'not_available' => 'status-in-progress',
                default => 'status-pending'
            };

            $statusLabels = [
                'pending' => 'Pending',
                'assigned' => 'Assigned',
                'picked_up' => 'In Progress / Picked Up',
                'dumped' => 'Completed / Dumped',
                'rejected' => 'Rejected',
                'not_available' => 'Rescheduled',
            ];
            $statusLabel = $statusLabels[$wasteRequest->status] ?? ucfirst(str_replace('_', ' ', $wasteRequest->status));
        @endphp

        <div class="row">
            <div class="col-lg-8">
                <div class="card card-custom mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="card-title mb-0 font-weight-bold" style="font-size: 16px; color: #1e293b;">
                            <i class="fa fa-file-text me-2 text-primary"></i> Request Report Summary
                        </h5>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-arrow-left me-1"></i> Back to Reports
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th width="35%" class="bg-light">Request Id</th>
                                    <td><span class="fw-bold text-primary" style="font-size:14px;">{{ $wasteRequest->request_number }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Corporation</th>
                                    <td><span style="font-size:13px;">{{ $wasteRequest->corporation?->name ?? 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Constituency</th>
                                    <td><span style="font-size:13px;">{{ $wasteRequest->constituency?->name ?? 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Ward</th>
                                    <td><span style="font-size:13px;">{{ $wasteRequest->ward?->ward_name ?? $wasteRequest->ward?->name ?? 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Category</th>
                                    <td>
                                        <span style="font-size:13px;">
                                            @if(is_array($wasteRequest->category_ids))
                                                {{ implode(', ', $wasteRequest->category_ids) }}
                                            @else
                                                {{ $wasteRequest->category_ids ?? 'N/A' }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Sub-Category</th>
                                    <td>
                                        <span style="font-size:13px;">
                                            @if(is_array($wasteRequest->subcategory_ids))
                                                {{ implode(', ', $wasteRequest->subcategory_ids) }}
                                            @else
                                                {{ $wasteRequest->subcategory_ids ?? 'N/A' }}
                                            @endif
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Status</th>
                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Assigned Vehicle No</th>
                                    <td>
                                        <span style="font-size:13px;" class="fw-semibold">
                                            {{ $wasteRequest->vehicle?->vehicle_number ?? 'Not Assigned' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Driver Phone</th>
                                    <td>
                                        <span style="font-size:13px;">
                                            {{ $wasteRequest->vehicle?->driver_phone ?? $wasteRequest->vehicle?->owner?->mobile_number ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Pickup Date & Time</th>
                                    <td><span style="font-size:13px;">{{ $pickupDate }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dump Date & Time</th>
                                    <td><span style="font-size:13px;">{{ $dumpDate }}</span></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dump Plant / Location</th>
                                    <td>
                                        <span style="font-size:13px;">
                                            {{ $wasteRequest->dump?->plant_name ?? $wasteRequest->dumpRecord?->plant_name ?? 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Dump Weight (kg)</th>
                                    <td>
                                        <span style="font-size:13px;">
                                            {{ ($wasteRequest->dump?->dump_weight ?? $wasteRequest->dumpRecord?->dump_weight) ? ($wasteRequest->dump?->dump_weight ?? $wasteRequest->dumpRecord?->dump_weight) . ' kg' : 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Citizen & Location Info Card -->
                <div class="card card-custom mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 font-weight-bold" style="font-size: 15px; color: #1e293b;">
                            <i class="fa fa-user me-2 text-primary"></i> Citizen & Location
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="detail-label">Applicant Name</div>
                            <div class="detail-value">{{ $wasteRequest->applicant_name ?? 'N/A' }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="detail-label">Mobile Number</div>
                            <div class="detail-value">{{ $wasteRequest->mobile_number ?? 'N/A' }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="detail-label">House / Flat No & Floor</div>
                            <div class="detail-value">
                                {{ $wasteRequest->house_no ?? 'N/A' }}
                                @if($wasteRequest->floor_no ?? $wasteRequest->floor)
                                    (Floor: {{ $wasteRequest->floor_no ?? $wasteRequest->floor }})
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="detail-label">Full Address</div>
                            <div class="detail-value text-muted" style="font-weight: 500;">
                                {{ $wasteRequest->address ?? 'N/A' }}
                                @if($wasteRequest->pincode)
                                    - {{ $wasteRequest->pincode }}
                                @endif
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="detail-label">Submitted On</div>
                            <div class="detail-value">{{ $wasteRequest->created_at->format('d M Y, h:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
