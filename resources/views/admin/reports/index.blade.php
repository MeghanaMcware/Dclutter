@extends('admin.layout.app')

@section('title', 'Reports')

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

/* Table styling to match the theme */
table.dataTable thead th {
    font-size: 12px;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    border-bottom: 2px solid #eaebf0;
    padding: 12px 10px;
}

table.dataTable tbody td {
    font-size: 13px;
    color: #212529;
    vertical-align: middle;
    padding: 12px 10px;
    border-bottom: 1px solid #eaebf0;
}
</style>
@endsection

@section('content')
<div class="container-fluid pt-3">
    <div class="row">
        <!-- Main Content Section -->
        <div class="col-sm-12">
            <h4 class="mb-3 font-weight-bold" style="color: #1e293b; font-weight: 700;">Reports</h4>

            <div class="card"
                style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                <div class="card-body p-4">
                    
                    <!-- Filter Form -->
                    <form id="reportFilterForm" method="GET" action="{{ route('admin.reports.index') }}">
                        <div class="row g-3 mb-4">
                            <!-- Request ID Filter -->
                            <div class="col-md-4 col-lg-2">
                                <label class="form-label mb-1"><b>Request Id</b></label>
                                <select name="request_id" id="requestIdFilter" class="form-select filter-input">
                                    <option value="">All Request IDs</option>
                                    @foreach($requestNumbers as $rNum)
                                        <option value="{{ $rNum }}" {{ request('request_id') == $rNum ? 'selected' : '' }}>
                                            {{ $rNum }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Corporation Filter -->
                            <div class="col-md-4 col-lg-2">
                                <label class="form-label mb-1"><b>Corporation</b></label>
                                <select name="corporation" id="corporationFilter" class="form-select filter-input">
                                    <option value="">All Corporations</option>
                                    @foreach($corporations as $corp)
                                        <option value="{{ $corp->name }}" {{ request('corporation') == $corp->name ? 'selected' : '' }}>
                                            {{ $corp->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Constituency Filter -->
                            <div class="col-md-4 col-lg-2">
                                <label class="form-label mb-1"><b>Constituency</b></label>
                                <select name="constituency" id="constituencyFilter" class="form-select filter-input">
                                    <option value="">All Constituencies</option>
                                    @foreach($constituencies as $constituency)
                                        <option value="{{ $constituency->name }}" {{ request('constituency') == $constituency->name ? 'selected' : '' }}>
                                            {{ $constituency->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Category Filter -->
                            <div class="col-md-4 col-lg-2">
                                <label class="form-label mb-1"><b>Category</b></label>
                                <select name="category" id="categoryFilter" class="form-select filter-input">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Filter (Valid Backend Statuses) -->
                            <div class="col-md-4 col-lg-2">
                                <label class="form-label mb-1"><b>Status</b></label>
                                <select name="status" id="statusFilter" class="form-select filter-input">
                                    <option value="">All Statuses</option>
                                    @foreach($statuses as $val => $label)
                                        <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="col-md-4 col-lg-2 d-flex align-items-end justify-content-end gap-2">
                                <button type="submit" class="btn btn-filter-primary d-flex align-items-center gap-1">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.reports.index') }}" class="btn btn-reset-outline d-flex align-items-center">
                                    Reset
                                </a>
                                <button type="button" id="btnExport" class="btn btn-export d-flex align-items-center gap-1">
                                    <i class="fa fa-download"></i> Export
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle" id="admin-reports-table">
                            <thead>
                                <tr>
                                    <th class="text-dark">Request Id</th>
                                    <th class="text-dark">Corporation</th>
                                    <th class="text-dark">Constituency</th>
                                    <th class="text-dark">Category</th>
                                    <th class="text-dark">Status</th>
                                    <th class="text-dark">Pickup Date</th>
                                    <th class="text-dark">Dump Date</th>
                                    <th class="text-dark text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $req)
                                    @php
                                        $pickupDate = $req->picked_up_at ? $req->picked_up_at->format('d-m-Y') : ($req->preferred_pickup_date ? $req->preferred_pickup_date->format('d-m-Y') : 'N/A');
                                        $dumpDate = ($req->dump?->dumped_at ?? $req->dump?->created_at ?? $req->dumpRecord?->dumped_at ?? $req->dumpRecord?->created_at)?->format('d-m-Y') ?? 'N/A';
                                        
                                        $statusClass = match($req->status) {
                                            'pending' => 'status-pending',
                                            'assigned' => 'status-assigned',
                                            'picked_up' => 'status-in-progress',
                                            'dumped' => 'status-completed',
                                            'rejected' => 'status-rejected',
                                            'not_available' => 'status-in-progress',
                                            default => 'status-pending'
                                        };

                                        $statusLabel = $statuses[$req->status] ?? ucfirst(str_replace('_', ' ', $req->status));
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $req->request_number }}</td>
                                        <td>{{ $req->corporation?->name ?? 'N/A' }}</td>
                                        <td>{{ $req->constituency?->name ?? 'N/A' }}</td>
                                        <td>
                                            @if(is_array($req->category_ids))
                                                {{ implode(', ', $req->category_ids) }}
                                            @else
                                                {{ $req->category_ids ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td>{{ $pickupDate }}</td>
                                        <td>{{ $dumpDate }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.reports.show', $req->id) }}" class="btn btn-primary btn-sm px-3">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">No reports found matching criteria.</td>
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
@endsection

@section('script')
<!-- DataTables JS & Select2 Plugins if present -->
<script src="{{ asset('/theme/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables
    var table = $('#admin-reports-table').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'desc']],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search reports..."
        }
    });

    // Handle Export button click with current active filters
    $('#btnExport').on('click', function() {
        var formParams = $('#reportFilterForm').serialize();
        var exportUrl = "{{ route('admin.reports.export') }}?" + formParams;
        window.location.href = exportUrl;
    });
});
</script>
@endsection