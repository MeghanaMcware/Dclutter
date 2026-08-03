@extends('vehiclepwa.layout.app')

@section('title') Transit Permits & Pickups @endsection
@section('heading', 'Pickup List')


@section('style')
<style>
.pwa-card {
    border-radius: 12px;
    border: none;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    background: #ffffff;
    overflow: hidden;
    margin-bottom: 20px;
}
.pwa-card-header {
    /* background: #ffffff; */
    border-bottom: 1px solid #f1f5f9;
    padding: 14px 16px;
}
.pwa-table th {
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 700;
    color: #475569;
    background-color: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}
.pwa-table td {
    padding: 12px 10px;
    vertical-align: middle;
    font-size: 12px;
}

   .ticket-table-bordered th,
.ticket-table-bordered td {
    border: 1px solid #dee2e6;
    padding: 10px;
}

.ticket-table-bordered thead th {
    border-bottom: 2px solid #dee2e6;
}

.ticket-table-bordered thead th{
        background: #004f79 !important;
    color: white !important;
}
</style>
@endsection

@section('content')
<div class="container py-3">

    {{-- Top Action Header Bar --}}
    {{-- <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-0 fw-bold text-primary"><i class="bi bi-truck me-1"></i> Vehicle No.: <span style="color:black !important"> #{{ $vehicle->vehicle_number ?? 'Fleet' }}</span></h5>
            <!-- <small class="text-muted font-11">Vehicle #{{ $vehicle->vehicle_number ?? 'Fleet' }}</small> -->
        </div>
     
    </div> --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-3 font-12" role="alert">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- SECTION 1: Active Issued Transit Permits (In Transit) --}}
    

    {{-- SECTION 2: Accepted Requests Ready for Pickup --}}
    <div class="pwa-card">
        <div class="pwa-card-header d-flex justify-content-between align-items-center">
            <h6 class="fw-bold text-success mb-0 font-14">
                <i class="bi bi-check-circle me-1 text-success"></i>Accepted Requests (Ready for Pickup)
            </h6>
            <span class="badge bg-success rounded-pill font-11">{{ $assignedRequests->count() + $assignedTasks->count() }} Ready</span>
        </div>
        <div class="card-body p-0">
            @if($assignedRequests->isEmpty() && $assignedTasks->isEmpty())
                <div class="p-4 text-center text-muted small">
                    <i class="bi bi-box-seam fs-2 d-block mb-1 text-secondary opacity-50"></i>
                    No accepted requests pending pickup.<br>
                    Go to <strong>Requests</strong> tab to view your assigned requests.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table ticket-table ticket-table-bordered table-hover align-middle mb-0 pwa-table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="white-space: nowrap !important;">Applicant Details</th>
                                <th style="white-space: nowrap !important;" class="text-center"> Weight</th>
                                <th style="white-space: nowrap !important;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignedRequests as $ar)
                                <tr>
<td>
    <strong class="d-block text-dark  text-center font-13">{{ $ar->citizen_name }}</strong>
    <small class="text-muted font-13 text-center d-block" style="color: #005079 !important;">
        <i class="bi bi-telephone me-1"></i>{{ $ar->mobile }}
    </small>
    {{-- <small class="text-secondary font-10 d-block" style="color: #005079 !important;">
        {{ \Illuminate\Support\Str::words($ar->address, 4, '...') }}
    </small> --}}
    <a href="https://www.google.com/maps/search/?api=1&query={{ $ar->latitude }},{{ $ar->longitude }}"
       target="_blank"
       class="btn btn-primary btn-xs py-0  mt-1"
       style="font-size: 10px;border-radius: 5px;    white-space: nowrap;"
       title="Navigate in Google Maps">
       <i class="bi bi-geo-alt-fill"></i> Get Direction
    </a>
</td>
                                    <td class="text-center">
                                        <span class="fw-bold text-dark font-12">{{ $ar->remaining_weight }} T</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('vehicle.pickup.create') }}?citizen_request_id={{ $ar->id }}" style="border-radius:5px !important" class="btn btn-success btn-sm py-1 px-2 font-11 fw-bold text-nowrap" >
                                             Waste Pickup
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            @foreach($assignedTasks as $at)
                                <tr>
                                    <td>
                                         <span class="badge bg-warning text-dark font-10">{{ $at->formatted_request_number }}</span>
                                        <small class="d-block text-dark fw-bold font-11">
                                           <a href="https://www.google.com/maps/dir/?api=1&destination={{ $at->latitude }},{{ $at->longitude }}"
   target="_blank"
   class="btn btn-sm btn-primary mt-1"
   title="Get Directions" style="border-radius:5px">
    <i class="bi bi-geo-alt-fill"></i> Get Direction
</a>
                                            
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <span class="fw-bold text-dark font-12">{{ $at->remaining_weight }} T</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('vehicle.pickup.create') }}?waste_task_id={{ $at->id }}" class="btn btn-success text-dark btn-sm py-1 px-2 font-11 fw-bold text-nowrap" style="border-radius:5px !important">
                                            Waste Pickup
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
   

</div>
@endsection
