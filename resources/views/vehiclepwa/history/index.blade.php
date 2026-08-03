@extends('vehiclepwa.layout.app')

@section('title') Trip History @endsection
@section('heading', 'History')


@section('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<style>
.h-95{
        height: 95px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
.dataTables_wrapper .dataTables_length,
.dataTables_wrapper .dataTables_filter {
    padding: 10px 14px;
    font-size: 12px;
}
.dataTables_wrapper .dataTables_filter input {
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    padding: 4px 10px;
    font-size: 12px;
    outline: none;
}
.dataTables_wrapper .dataTables_info,
.dataTables_wrapper .dataTables_paginate {
    padding: 10px 14px;
    font-size: 11px;
}
.btn-view-sm {
    padding: 2px 8px !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    border-radius: 4px !important;
}
div.dataTables_wrapper div.dataTables_length select{
        border: 1px solid black !important;
    border-radius: 5px !important;
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
.page-item.active a{
    background: #005079 !important;
    border: 1px solid #005079 !important;
}
</style>
@endsection

@section('content')
<div class="container py-3">

    {{-- <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 fw-bold text-primary"> Vehicle Trip History</h5>
        <span class="badge bg-primary">Total Trips: {{ $totalTrips }}</span>
    </div> --}}

    <div class="row g-2 mb-3">
        <div class="col-6">
            <div class="p-3 bg-white rounded-3 border text-center shadow-sm h-95">
                <small class="text-muted d-block text-uppercase fw-bold" style="    font-size: 12px;
    color: black !important;">Total Trips</small>
                <span class="fs-6 fw-bold text-primary">{{ $totalTrips }}</span>
            </div>
        </div>
        <div class="col-6">
            <div class="p-3 bg-white rounded-3 border text-center shadow-sm h-95">
                <small class="text-muted d-block text-uppercase fw-bold" style="    font-size: 12px;    line-height: 17px;
    color: black !important;">Total Weight Delivered</small>
                <span class="fs-6 fw-bold text-success">{{ number_format($totalWeight, 1) }} Tons</span>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            @if($history->isEmpty())
                <div class="p-4 text-center text-muted">
                    No history logs found for this vehicle.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table ticket-table ticket-table-bordered table-hover align-middle mb-0 datatables" id="historyTable" style="font-size: 12px; width: 100%;">
                        <thead class="table-light">
                            <tr>
                                <th>Permit No</th>
                                <th>Weight</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $h)
                                <tr>
                                    <td><strong class="text-primary">{{ $h->permit_number }}</strong></td>
                                    <td><span class="fw-bold text-dark">{{ $h->calculated_weight }} T</span></td>
                                    <td>
                                        <strong class="badge {{ $h->status === 'dumped' ? 'bg-success' : 'bg-warning text-dark' }}" style="font-size: 11px;border-radius:5px" >
                                            {{ strtoupper($h->status) }}
                                        </strong>
                                    </td>
                                    <td><strong class="fw-bold text-dark" style="white-space: nowrap;">{{ $h->created_at->format('d M Y') }}</strong></td>
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

@section('script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    if ($('#historyTable').length) {
        $('#historyTable').DataTable({
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search trips...",
                paginate: {
                    previous: "&lsaquo;",
                    next: "&rsaquo;"
                }
            }
        });
    }
});
</script>
@endsection
