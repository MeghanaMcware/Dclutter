@extends('admin.layout.app')

@section('title', 'Imported Request Details #' . $requestData->id)

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>Imported Request Details #{{ $requestData->id }}</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.imported-requests.index') }}">Imported Requests</a></li>
                    <li class="breadcrumb-item active">View Request</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-sm-12 col-xl-9 offset-xl-1">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 fw-bold text-dark">Legacy Pickup Request Details</h4>
                    <a href="{{ route('admin.imported-requests.index') }}" class="btn btn-light btn-sm">
                        <i class="fa fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-success me-2 font-13">ID: #{{ $requestData->id }}</span>
                            @if($requestData->excel_id)
                                <span class="badge bg-secondary font-12">Excel Row ID: {{ $requestData->excel_id }}</span>
                            @endif
                        </div>
                        <span class="badge bg-light text-dark fw-bold text-capitalize" style="font-size:12px;">Status: {{ $requestData->status }}</span>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle">
                                <tbody>
                                    <tr>
                                        <th width="30%">Applicant Name</th>
                                        <td><strong class="text-dark">{{ $requestData->applicant_name ?? 'N/A' }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Mobile Number</th>
                                        <td>
                                            @if($requestData->mobile_number)
                                                <a href="tel:{{ $requestData->mobile_number }}" class="text-decoration-none text-primary font-weight-bold">
                                                    <i class="fa fa-phone me-1"></i>{{ $requestData->mobile_number }}
                                                </a>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Corporation</th>
                                        <td>
                                            <span class="badge bg-success" style="font-size:13px;">{{ $requestData->corporation?->name ?? ($requestData->corporation_name ?? 'N/A') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Constituency</th>
                                        <td>
                                            <span class="badge bg-primary" style="font-size:13px;">{{ $requestData->constituency?->name ?? ($requestData->division_name ?? 'N/A') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Ward</th>
                                        <td>
                                            <span class="badge bg-warning text-dark" style="font-size:13px;">{{ $requestData->ward?->name ?? ($requestData->ward_name_no ?? 'N/A') }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $requestData->address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Preferred Pickup Date</th>
                                        <td>
                                            @if($requestData->preferred_pickup_date)
                                                <i class="fa fa-calendar-alt text-secondary me-1"></i>{{ $requestData->preferred_pickup_date->format('d M Y, h:i A') }}
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Items Description</th>
                                        <td>{{ $requestData->items_text ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created Date (Excel Text)</th>
                                        <td>{{ $requestData->created_at_text ?? $requestData->created_at->format('d M Y, h:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.imported-requests.index') }}" class="btn btn-secondary btn-sm px-4">
                                <i class="fa fa-arrow-left me-1"></i> Back to Imported Requests
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
