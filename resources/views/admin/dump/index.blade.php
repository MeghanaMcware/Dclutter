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
                                            <tr>
                                                <td><span class="text-primary fw-bold">REQ-1001</span></td>
                                                <td>Plastic</td>
                                                <td>PET Bottles</td>
                                                <td>Sector 1, Area A</td>
                                                <td>Central Zone</td>
                                                <td>John Doe</td>
                                                <td>9876543210</td>
                                                <td>TS-09-XX-1234</td>
                                                <td>Ramesh (9988776655)</td>
                                                <td><span class="status-badge status-completed">Picked Up</span></td>
                                                <td>2026-10-01</td>
                                                <td>
                                                    <a href="{{ url('admin/dump/show/1') }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i> View</a>
                                                </td>
                                            </tr>
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
                                            <tr>
                                                <td><span class="text-primary fw-bold">REQ-1002</span></td>
                                                <td>E-Waste</td>
                                                <td>Batteries</td>
                                                <td>Central Dump Yard</td>
                                                <td>North Zone</td>
                                                <td>Jane Smith</td>
                                                <td>8765432109</td>
                                                <td>TS-08-YY-5678</td>
                                                <td>Suresh (8877665544)</td>
                                                <td><span class="status-badge status-in-progress">In Transit</span></td>
                                                <td>2026-10-02</td>
                                                <td>
                                                    <a href="{{ url('admin/dump/show/2') }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i> View</a>
                                                </td>
                                            </tr>
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
