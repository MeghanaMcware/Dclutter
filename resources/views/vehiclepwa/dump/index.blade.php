@extends('vehiclepwa.layout.app')

@section('title') Cargo in Transit & Dump History @endsection

@section('content')
<div class="container py-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 fw-bold text-primary">🚚 Vehicle Dump Status</h5>
        <span class="badge bg-success">Total Delivered: {{ number_format($totalWeightDumped, 1) }} T</span>
    </div>

    {{-- SECTION 1: Active Cargo in Transit to Plant --}}
    <h6 class="fw-bold text-primary mb-2">
        <i class="bi bi-truck me-1"></i>Active Cargo in Transit to Plant
    </h6>
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            @if($inTransitPickups->isEmpty())
                <div class="text-center py-3 text-muted small">
                    <i class="bi bi-check-circle fs-2 text-success d-block mb-1"></i>
                    No active cargo in transit. Vehicle is empty and ready for new pickups.
                </div>
            @else
                <div class="alert alert-info py-2 px-3 mb-3 small">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>System Status:</strong> Drive to the Processing Plant. The Plant Operator will weigh your truck and approve the dump process upon arrival.
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="table-light">
                            <tr>
                                <th>System Permit #</th>
                                <th>Loaded Weight</th>
                                <th>Source</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inTransitPickups as $p)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $p->permit_number }}</strong>
                                        <small class="d-block text-muted">{{ $p->created_at->format('d M, h:i A') }}</small>
                                    </td>
                                    <td><strong class="fs-6 text-dark">{{ $p->calculated_weight }} T</strong></td>
                                    <td>
                                        @if($p->citizenRequest)
                                            <span class="badge bg-info text-dark">{{ $p->citizenRequest->formatted_request_number }}</span>
                                        @elseif($p->wasteTask)
                                            <span class="badge bg-warning text-dark">{{ $p->wasteTask->formatted_request_number }}</span>
                                        @else
                                            <span class="badge bg-secondary">Direct</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary px-2 py-1">IN TRANSIT TO PLANT</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- SECTION 2: Verified Plant Unload History --}}
    <h6 class="fw-bold text-secondary mb-2">Verified Plant Unload History</h6>
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            @if($dumps->isEmpty())
                <div class="p-3 text-center text-muted small">
                    No past dump records found for this vehicle.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" style="font-size: 13px;">
                        <thead class="table-light">
                            <tr>
                                <th>Permit #</th>
                                <th>Unloaded Weight</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dumps as $d)
                                <tr>
                                    <td>
                                        <strong>{{ $d->permit_number }}</strong>
                                    </td>
                                    <td><strong>{{ $d->calculated_weight }} T</strong></td>
                                    <td>
                                        <span class="badge bg-success">PLANT APPROVED</span>
                                    </td>
                                    <td><small class="text-muted">{{ $d->updated_at->format('d M Y, h:i A') }}</small></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-3">
                    {{ $dumps->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection