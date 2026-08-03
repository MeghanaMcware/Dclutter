@extends('vehiclepwa.layout.app')

@section('title') Dump Details - {{ $pickup->permit_number }} @endsection

@section('content')
<div class="container py-3">

    <div class="card border-0 shadow-sm rounded-3 mb-3">
        <div class="card-header bg-success text-white py-3">
            <h6 class="mb-0 fw-bold">✅ Verified Dump Record</h6>
        </div>
        <div class="card-body p-4">

            <div class="text-center py-2 border-bottom mb-3">
                <small class="text-muted text-uppercase fw-bold">Permit Registration Number</small>
                <h4 class="fw-bold text-success mb-1">{{ $pickup->permit_number }}</h4>
                <small class="text-muted">Dumped Date: {{ $pickup->updated_at->format('d M Y, h:i A') }}</small>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <small class="text-muted d-block">Vehicle Number</small>
                    <strong>{{ $vehicle->vehicle_number }}</strong>
                </div>
                <div class="col-6">
                    <small class="text-muted d-block">Calculated Weight</small>
                    <strong>{{ $pickup->calculated_weight }} Tons</strong>
                </div>
                @if($dumpLog && $dumpLog->actual_weight)
                    <div class="col-6">
                        <small class="text-muted d-block">Plant Verified Weight</small>
                        <strong class="text-success fs-6">{{ $dumpLog->actual_weight }} Tons</strong>
                    </div>
                @endif
                <div class="col-6">
                    <small class="text-muted d-block">Status</small>
                    <span class="badge bg-success">DUMP VERIFIED</span>
                </div>
            </div>

            @if($dumpLog)
                <div class="p-3 bg-light rounded-3 mb-3 border">
                    <small class="fw-bold text-secondary text-uppercase d-block mb-1">Verification Remarks</small>
                    <span>{{ $dumpLog->remarks ?? 'Verified at Processing Plant' }}</span>
                </div>
            @endif

            <a href="{{ route('vehicle.dump.index') }}" class="btn btn-outline-secondary btn-sm w-100 mt-2">
                Back to Dump History
            </a>

        </div>
    </div>

</div>
@endsection