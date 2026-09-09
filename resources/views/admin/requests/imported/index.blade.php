@extends('admin.layout.app')

@section('title', 'Imported Requests')

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
    .status-in-progress { background-color: #fff4e5; color: #ff9800; border: 1px solid #ffcc80; }
    .status-assigned { background-color: #e3f2fd; color: #2196f3; border: 1px solid #90caf9; }
    .status-pending { background-color: #ffebee; color: #f44336; border: 1px solid #ef9a9a; }
    .status-completed { background-color: #e8f5e9; color: #4caf50; border: 1px solid #a5d6a7; }
    .status-rejected { background-color: #ffebee; color: #f44336; border: 1px solid #ef9a9a; }

    .filter-input {
        font-size: 13px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        height: 40px;
    }
    
    .btn-filter-primary {
        background-color: #0d6efd;
        color: white;
        font-size: 13px;
        padding: 8px 18px;
        border-radius: 6px;
        border: none;
        height: 40px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-filter-primary:hover {
        background-color: #0b5ed7;
        color: white;
    }

    .btn-reset-outline {
        background-color: #ffffff;
        color: #6c757d;
        font-size: 13px;
        padding: 8px 18px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        height: 40px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-reset-outline:hover {
        background-color: #f8f9fa;
        color: #212529;
    }
    
    .btn-export {
        background-color: #198754;
        color: white;
        font-size: 13px;
        padding: 8px 18px;
        border-radius: 6px;
        border: none;
        height: 40px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-export:hover {
        background-color: #157347;
        color: white;
    }
    
    table.dataTable thead th, table thead th {
        font-size: 12px;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        border-bottom: 2px solid #eaebf0;
        padding: 12px 10px;
    }
    table.dataTable tbody td, table tbody td {
        font-size: 13px;
        color: #212529;
        vertical-align: middle;
        padding: 12px 10px;
        border-bottom: 1px solid #eaebf0;
    }

    /* Custom Bootstrap 5 Pagination Fixes */
    .pagination-wrapper nav svg {
        width: 16px;
        height: 16px;
    }
    .pagination {
        margin-bottom: 0 !important;
        gap: 3px;
    }
    .pagination .page-item .page-link {
        color: #0d6efd;
        border-radius: 5px !important;
        padding: 6px 12px;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #dee2e6;
    }
    .pagination .page-item.active .page-link {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #ffffff;
    }
    .pagination .page-item.disabled .page-link {
        color: #94a3b8;
    }
    .text-start1{
    color: black !important;
}
</style>
@endsection

@section('content')
<div class="container-fluid pt-3">
    <div class="row">
        <!-- Main Content Section -->
        <div class="col-sm-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;">Imported Requests</h4>
                <span class="badge bg-primary fs-6 px-3 py-2">Total: {{ number_format($totalCount) }} Records</span>
            </div>
            
            <div class="card" style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                <div class="card-body p-4">
                    
                    <!-- Clean 2-Row Filter Section -->
                    <form method="GET" action="{{ route('admin.imported-requests.index') }}" id="importedFilterForm">
                        <div class="row g-3 mb-4">
                            <!-- Row 1: Dropdown Selection Filters -->
                            <div class="col-md-4">
                                <label class="form-label mb-0" ><b>Search</b></label>
                                <input type="text" name="search" class="form-control filter-input" placeholder="Search applicant, mobile, address..." value="{{ request('search') }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-0" ><b>Corporation</b></label>
                                <select name="corporation_id" class="form-select filter-input">
                                    <option value="">All Corporations</option>
                                    @foreach($corporations as $corp)
                                        <option value="{{ $corp->id }}" {{ request('corporation_id') == $corp->id ? 'selected' : '' }}>{{ $corp->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label mb-0" ><b>Constituency</b></label>
                                <select name="constituency_id" class="form-select filter-input">
                                    <option value="">All Constituencies</option>
                                    @foreach($constituencies as $constituency)
                                        <option value="{{ $constituency->id }}" {{ request('constituency_id') == $constituency->id ? 'selected' : '' }}>{{ $constituency->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Row 2: Action Buttons -->
                            <div class="col-md-12 d-flex align-items-center justify-content-end gap-2">
                                <button type="submit" class="btn btn-filter-primary d-flex align-items-center gap-1">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.imported-requests.index') }}" class="btn btn-reset-outline text-decoration-none d-flex align-items-center justify-content-center">Reset</a>
                                <button type="button" class="btn btn-export d-flex align-items-center gap-1" onclick="exportTableToCSV('imported_requests.csv')">
                                    <i class="fa fa-download"></i> Export
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Table Data -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center align-middle" id="admin-imported-requests-table">
                            <thead>
                                <tr>
                                    <th class="text-start text-start1">Request ID</th>
                                    <th class="text-start text-start1">Applicant Name</th>
                                    <th class="text-start text-start1">Mobile</th>
                                    <th class="text-start text-start1">Corporation</th>
                                    <th class="text-start text-start1">Constituency</th>
                                    <th class="text-start text-start1">Ward</th>
                                    <th class="text-start text-start1">Address</th>
                                    <th class="text-start text-start1">Status</th>
                                    <th class="text-center text-start1">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($importedRequests as $req)
                                    <tr>
                                        <td class="text-start ">#{{ $req->id }}</td>
                                        <td class="text-start ">{{ $req->applicant_name ?? 'N/A' }}</td>
                                        <td class="text-start">{{ $req->mobile_number ?? 'N/A' }}</td>
                                        <td class="text-start">{{ $req->corporation?->name ?? ($req->corporation_name ?? 'N/A') }}</td>
                                        <td class="text-start">{{ $req->constituency?->name ?? ($req->division_name ?? 'N/A') }}</td>
                                        <td class="text-start">{{ $req->ward?->name ?? ($req->ward_name_no ?? 'N/A') }}</td>
                                        <td class="text-start">{{ Str::limit($req->address ?? 'N/A', 35) }}</td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'requested' => 'status-pending',
                                                    'pending' => 'status-pending',
                                                    'assigned' => 'status-assigned',
                                                    'picked_up' => 'status-in-progress',
                                                    'completed' => 'status-completed',
                                                    'rejected' => 'status-rejected',
                                                ];
                                            @endphp
                                            <span class="status-badge {{ $statusClasses[$req->status] ?? 'status-pending' }}">
                                                {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('admin.imported-requests.show', $req->id) }}" class="btn btn-primary" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-secondary" title="Assign Vehicle">
                                                    <i class="fa fa-truck"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-muted py-4">No imported legacy requests found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
     <div class="modal-content">
            <form action="" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="assignVehicleModalLabel">
                        <i class="fa fa-truck text-primary me-2"></i> Assign Vehicle to Request ##DCL-2026-000022
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="vehicle_id">Select Vehicle <span class="text-danger">*</span></label>
                        <select class="form-select" id="vehicle_id" name="vehicle_id" required>
                            <option value="" disabled selected>-- Choose Available Vehicle --</option>
                           
                                <option value="">
                                   KA07S7242 - Truck (Driver: suprith)
                                </option>
                            
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold" for="remarks">Approval / Assignment Remarks <span class="text-muted font-11 fw-normal">(Optional)</span></label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter any notes or remarks for this approval/assignment...">Remarks</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i> Assign Vehicle</button>
                </div>
            </form>
        </div>
  </div>
</div>

                    <!-- Clean Bootstrap 5 Server-Side Pagination Bar -->
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <div class="small text-muted font-13">
                            Showing <strong>{{ $importedRequests->firstItem() ?? 0 }}</strong> to <strong>{{ $importedRequests->lastItem() ?? 0 }}</strong> of <strong>{{ number_format($importedRequests->total()) }}</strong> entries
                        </div>
                        <div class="pagination-wrapper">
                            {{ $importedRequests->withQueryString()->links('pagination::bootstrap-5') }}
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
function exportTableToCSV(filename) {
    let csv = [];
    let rows = document.querySelectorAll("#admin-imported-requests-table tr");
    
    for (let i = 0; i < rows.length; i++) {
        let row = [], cols = rows[i].querySelectorAll("td, th");
        for (let j = 0; j < cols.length - 1; j++) {
            let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/"/g, '""');
            row.push('"' + data + '"');
        }
        csv.push(row.join(","));
    }

    let csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    let downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}
</script>
@endsection
