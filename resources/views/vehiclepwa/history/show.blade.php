@extends('vehiclepwa.layout.app')

@section('title') Audit Trail - {{ $pickup->permit_number }} @endsection
@section('heading', 'History Details')
@section('content')
<div class="container py-3">

    <div class="card border-0 shadow-sm rounded-3 mb-3">
        <div class="card-header bg-dark text-white p-2" style="background: #004f79 !important;border-radius:5px 5px 0px 0px">
            <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i> Full Audit Trail - Permit {{ $pickup->permit_number }}</h6>
        </div>
        <div class="card-body p-3">

           <div class="row g-3 border-bottom pb-3 mb-3">
    <div class="col-6">
        <span class="d-flex flex-column">
            <span class="text-dark d-block"><b>Vehicle Number</b></span>
            <span>{{ $vehicle->vehicle_number }}</span>
        </span>
    </div>
    <div class="col-6">
        <span class="d-flex flex-column">
            <span class="text-dark d-block"><b>Permit Status</b></span>
            <span class="badge bg-primary text-center w-50" style="border-radius:5px">{{ strtoupper($pickup->status) }}</span>
        </span>
    </div>
    <div class="col-6">
        <span class="d-flex flex-column">
            <span class="text-dark d-block"><b>Calculated Weight</b></span>
            <span>{{ $pickup->calculated_weight }} Tons</span>
        </span>
    </div>
    <div class="col-6">
        <span class="d-flex flex-column">
            <span class="text-dark d-block"><b>Issued Date</b></span>
            <span>{{ $pickup->created_at->format('d M Y, h:i A') }}</span>
        </span>
    </div>
</div>

            <h6 class="fw-bold text-secondary mb-3">Activity Log Steps & Media Audit</h6>
            @if($pickup->logs->isEmpty())
                <p class="text-muted small">No logs found.</p>
            @else
                <div class="timeline ps-2">
                    @foreach($pickup->logs as $log)
                        <div class="mb-3 ps-3 position-relative">
                            <strong class="text-primary d-block">{{ str_replace('_', ' ', strtoupper($log->step_key)) }}</strong>
                            <small class="text-muted">{{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('d M Y, h:i A') : '' }}</small>
                            <p class="mb-1 small text-secondary mt-1">{{ $log->remarks ?? 'Step recorded' }}</p>
                            @if(!empty($log->images))
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach((array)$log->images as $imgUrl)
                                        <a href="{{ asset($imgUrl) }}" target="_blank">
                                            <img src="{{ asset($imgUrl) }}" style="width: 65px; height: 65px; object-fit: cover;" class="rounded border shadow-sm" alt="Log Photo">
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
<div class="d-flex flex-column align-items-center">
<a href="{{ route('vehicle.history.index') }}" class="btn btn-primary btn-sm w-75 mt-0" style="font-size:12px;border-radius:5px">
                Back to History List
            </a>
</div>
            

        </div>
    </div>

</div>
@endsection