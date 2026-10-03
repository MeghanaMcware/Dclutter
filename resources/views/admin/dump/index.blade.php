@extends('admin.layout.app')

@section('title', 'Pickup & Dump Lists')

@section('style')
<style>
    .status-badge {
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    .status-completed { background-color: #e8f5e9; color: #4caf50; border: 1px solid #a5d6a7; }
    .status-in-progress { background-color: #fff4e5; color: #ff9800; border: 1px solid #ffcc80; }
    .status-pending { background-color: #ffebee; color: #f44336; border: 1px solid #ef9a9a; }
    
    table.dataTable thead th {
        font-size: 12px;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: 2px solid #eaebf0;
        padding: 12px 10px;
        white-space: nowrap;
    }
    table.dataTable tbody td {
        font-size: 13px;
        color: #212529;
        vertical-align: middle;
        padding: 12px 10px;
        border-bottom: 1px solid #eaebf0;
    }
    .nav-tabs-custom .nav-item .nav-link.active {
        color: #0d6efd;
        font-weight: 600;
        border-bottom: 2px solid #0d6efd;
    }
    .nav-tabs-custom .nav-item .nav-link {
        color: #6c757d;
        font-weight: 500;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 12px 20px;
    }
    .card-custom {
        border: 1px solid #eaebf0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border-radius: 8px;
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
                    <h3 class="fw-bold d-flex align-items-center gap-2 flex-wrap">Pickup & Dump Management</h3>
                </div>
                <div class="col-12 col-sm-6 d-flex align-items-center justify-content-sm-end gap-2 mt-2 mt-sm-0">
                    <ol class="breadcrumb d-inline-flex mb-0 bg-transparent p-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/dashboard') }}">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Pickup & Dump</li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card card-custom">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#pickup-list" role="tab">
                                    <i class="fa fa-truck me-1"></i> Pickup List
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#dump-list" role="tab">
                                    <i class="fa fa-archive me-1"></i> Dump List
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content pt-4">
                            <!-- Pickup List Tab -->
                            <div class="tab-pane active" id="pickup-list" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle dataTable" id="pickup-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>REQUEST ID</th>
                                                <th>CATEGORY</th>
                                                <th>SUB-CATEGORY</th>
                                                <th>PICKUP LOCATION</th>
                                                <th>CONSTITUENCY</th>
                                                <th>REQUESTED BY</th>
                                                <th>MOBILE</th>
                                                <th>VEHICLE NO.</th>
                                                <th>DRIVER NUMBER</th>
                                                <th>STATUS</th>
                                                <th>CREATED AT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($pickupRequests as $req)
                                                <tr>
                                                    <td><span class="text-primary fw-bold">{{ $req->request_number }}</span></td>
                                                    <td>{{ is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?: 'N/A') }}</td>
                                                    <td>{{ is_array($req->subcategory_ids) ? implode(', ', $req->subcategory_ids) : ($req->subcategory_ids ?: 'N/A') }}</td>
                                                    <td>{{ $req->house_no . (($req->floor_no ?? $req->floor) ? ' (Floor: ' . ($req->floor_no ?? $req->floor) . ')' : '') . ', ' . Str::limit($req->address, 30) }}</td>
                                                    <td>{{ $req->constituency?->name ?? 'N/A' }}</td>
                                                    <td>{{ $req->applicant_name }}</td>
                                                    <td>{{ $req->mobile_number }}</td>
                                                    <td>{{ $req->vehicle?->vehicle_number ?? 'N/A' }}</td>
                                                    <td>{{ ($req->vehicle?->driver_name ?? 'Driver') . ' (' . ($req->vehicle?->driver_phone ?? $req->vehicle?->owner?->mobile_number ?? 'N/A') . ')' }}</td>
                                                    <td>
                                                        @php
                                                            $st = strtolower($req->status ?? 'picked_up');
                                                            $badgeClass = match($st) {
                                                                'dumped', 'completed' => 'status-completed',
                                                                'picked_up' => 'status-in-progress',
                                                                default => 'status-pending'
                                                            };
                                                        @endphp
                                                        <span class="status-badge {{ $badgeClass }}">{{ $req->status_label }}</span>
                                                    </td>
                                                    <td>{{ $req->picked_up_at ? $req->picked_up_at->format('d M Y') : ($req->created_at ? $req->created_at->format('d M Y') : 'N/A') }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.dump.show', $req->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i> View</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12" class="text-center text-muted py-4">No pickup records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Dump List Tab -->
                            <div class="tab-pane" id="dump-list" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped align-middle dataTable" id="dump-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>REQUEST ID</th>
                                                <th>CATEGORY</th>
                                                <th>SUB-CATEGORY</th>
                                                <th>DUMP LOCATION</th>
                                                <th>CONSTITUENCY</th>
                                                <th>REQUESTED BY</th>
                                                <th>MOBILE</th>
                                                <th>VEHICLE NO.</th>
                                                <th>DRIVER NUMBER</th>
                                                <th>STATUS</th>
                                                <th>CREATED AT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($dumpRequests as $req)
                                                @php
                                                    $dumpObj = $req->dump ?: $req->dumpRecord;
                                                    $veh = $req->vehicle ?: ($dumpObj?->vehicle ?? null);
                                                    $driverName = $veh?->driver_name ?: 'Driver';
                                                    $driverPhone = $veh?->driver_phone ?: ($veh?->owner?->mobile_number ?: 'N/A');
                                                    $plantName = $dumpObj?->plant_name ?: 'Processing Facility';
                                                    $dumpDate = $dumpObj?->dumped_at ?: $req->updated_at;
                                                @endphp
                                                <tr>
                                                    <td><span class="text-primary fw-bold">{{ $req->request_number }}</span></td>
                                                    <td>{{ is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?: 'N/A') }}</td>
                                                    <td>{{ is_array($req->subcategory_ids) ? implode(', ', $req->subcategory_ids) : ($req->subcategory_ids ?: 'N/A') }}</td>
                                                    <td>{{ $plantName }}</td>
                                                    <td>{{ $req->constituency?->name ?? 'N/A' }}</td>
                                                    <td>{{ $req->applicant_name }}</td>
                                                    <td>{{ $req->mobile_number }}</td>
                                                    <td>{{ $veh?->vehicle_number ?? 'N/A' }}</td>
                                                    <td>{{ $driverName . ' (' . $driverPhone . ')' }}</td>
                                                    <td><span class="status-badge status-completed">Dumped</span></td>
                                                    <td>{{ $dumpDate ? $dumpDate->format('d M Y') : 'N/A' }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.dump.show', $req->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i> View</a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="12" class="text-center text-muted py-4">No dump records found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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

@section('script')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#pickup-table').DataTable({
                "pageLength": 10,
                "ordering": true,
                "info": true,
                "searching": true
            });
            $('#dump-table').DataTable({
                "pageLength": 10,
                "ordering": true,
                "info": true,
                "searching": true
            });
        }
    });
</script>
@endsection
