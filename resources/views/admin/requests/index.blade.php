@extends('admin.layout.app')

@section('title', 'All Requests')

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
            <h4 class="mb-3 font-weight-bold" style="color: #1e293b; font-weight: 700;">All Requests</h4>
            
            <div class="card" style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                <div class="card-body p-4">
                    
                    <!-- Clean 2-Row Filter Section -->
                    <div class="row g-3 mb-4">
                        <!-- Row 1: Dropdown Selection Filters -->
                        <div class="col-md-4">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #6c757d;">Status</label>
                            <select id="statusFilter" class="form-select filter-input">
                                <option value="">All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Assigned">Assigned</option>
                                <option value="Picked Up">Picked Up</option>
                                <option value="Dumped">Dumped</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #6c757d;">Corporation</label>
                            <select id="corporationFilter" class="form-select filter-input">
                                <option value="">All Corporations</option>
                                @foreach($corporations as $corp)
                                    <option value="{{ $corp->name }}">{{ $corp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #6c757d;">Constituency</label>
                            <select id="constituencyFilter" class="form-select filter-input">
                                <option value="">All Constituencies</option>
                                @foreach($constituencies as $constituency)
                                    <option value="{{ $constituency->name }}">{{ $constituency->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Row 2: Date Filters & Action Buttons -->
                        <div class="col-md-4">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #6c757d;">From Date</label>
                            <input id="fromDateFilter" class="form-control filter-input" type="date">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #6c757d;">To Date</label>
                            <input id="toDateFilter" class="form-control filter-input" type="date">
                        </div>
                        <div class="col-md-4 d-flex align-items-end justify-content-end gap-2">
                            <button type="button" id="applyFilterBtn" class="btn btn-filter-primary d-flex align-items-center gap-1">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                            <button type="button" id="resetFilterBtn" class="btn btn-reset-outline">Reset</button>
                            <button type="button" id="exportBtn" class="btn btn-export d-flex align-items-center gap-1" onclick="exportTableToCSV('waste_requests.csv')">
                                <i class="fa fa-download"></i> Export
                            </button>
                        </div>
                    </div>

                    <!-- Table Data with Unique ID admin-waste-requests-table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped text-center align-middle" id="admin-waste-requests-table">
                            <thead>
                                <tr>
                                    <th class="text-start">Request ID</th>
                                    <th class="text-start">Category</th>
                                    <th class="text-start">Pickup Location</th>
                                    <th class="text-start">Constituency</th>
                                    <th class="text-start">Requested By</th>
                                    <th class="text-start">Mobile</th>
                                    <th>Status</th>
                                    <th class="text-start">Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $req)
                                    <tr>
                                        <td class="text-start text-dark fw-bold">{{ $req->request_number }}</td>
                                        <td class="text-start">
                                            @if(is_array($req->category_ids))
                                                {{ implode(', ', $req->category_ids) }}
                                            @else
                                                {{ $req->category_ids }}
                                            @endif
                                        </td>
                                        <td class="text-start">{{ $req->house_no }}, {{ Str::limit($req->address, 30) }}</td>
                                        <td class="text-start">{{ $req->constituency?->name ?? 'N/A' }}</td>
                                        <td class="text-start">{{ $req->applicant_name }}</td>
                                        <td class="text-start">{{ $req->mobile_number }}</td>
                                        <td>
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'status-pending',
                                                    'assigned' => 'status-assigned',
                                                    'picked_up' => 'status-in-progress',
                                                    'dumped' => 'status-completed',
                                                    'rejected' => 'status-rejected',
                                                ];
                                            @endphp
                                            <span class="status-badge {{ $statusClasses[$req->status] ?? 'status-pending' }}">
                                                {{ ucfirst(str_replace('_', ' ', $req->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-start">{{ $req->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('admin.requests.show', $req->id) }}" class="btn btn-primary" title="View">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="#" class="btn btn-success" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-muted py-4">No waste requests found.</td>
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
<!-- Container-fluid Ends-->
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Prevent DataTables popup alerts
        $.fn.dataTable.ext.errMode = 'none';

        const corporationsData = @json($corporations);

        // Dependent Constituency Dropdown Filter
        $('#corporationFilter').on('change', function() {
            const corpName = $(this).val();
            const $constSelect = $('#constituencyFilter');
            $constSelect.html('<option value="">All Constituencies</option>');

            if (corpName) {
                const corp = corporationsData.find(c => c.name === corpName);
                if (corp && corp.constituencies) {
                    corp.constituencies.forEach(constituency => {
                        $constSelect.append(new Option(constituency.name, constituency.name));
                    });
                }
            } else {
                @foreach($constituencies as $constituency)
                    $constSelect.append(new Option("{{ $constituency->name }}", "{{ $constituency->name }}"));
                @endforeach
            }
        });

        // Initialize DataTables on unique ID admin-waste-requests-table
        if ($.fn.DataTable.isDataTable('#admin-waste-requests-table')) {
            $('#admin-waste-requests-table').DataTable().destroy();
        }

        var table = $('#admin-waste-requests-table').DataTable({
            "order": [],
            "pageLength": 10,
            "lengthChange": false,
            "searching": true,
            "info": true,
            "language": {
                "paginate": {
                    "previous": "<",
                    "next": ">"
                },
                "emptyTable": "No waste requests found matching selected criteria."
            }
        });

        // Dynamic AJAX Filtering without Page Reload
        function performAjaxFilter() {
            const status = $('#statusFilter').val();
            const corporation = $('#corporationFilter').val();
            const constituency = $('#constituencyFilter').val();
            const fromDate = $('#fromDateFilter').val();
            const toDate = $('#toDateFilter').val();

            const $tableBody = $('#admin-waste-requests-table tbody');
            $tableBody.css('opacity', '0.4');

            const params = new URLSearchParams({
                status: status,
                corporation: corporation,
                constituency: constituency,
                from_date: fromDate,
                to_date: toDate
            });

            fetch(`{{ route('admin.requests.index') }}?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                table.clear();

                if (data.success && Array.isArray(data.requests) && data.requests.length > 0) {
                    const statusClassMap = {
                        'pending': 'status-pending',
                        'assigned': 'status-assigned',
                        'picked_up': 'status-in-progress',
                        'dumped': 'status-completed',
                        'rejected': 'status-rejected'
                    };

                    data.requests.forEach(req => {
                        const statusClass = statusClassMap[req.status] || 'status-pending';
                        const statusHtml = `<span class="status-badge ${statusClass}">${req.status_label}</span>`;
                        const actionsHtml = `
                            <div class="d-flex justify-content-center gap-2">
                                <a href="${req.show_url}" class="btn btn-primary" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="#" class="btn btn-success" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>
                        `;

                        table.row.add([
                            `<span class="text-start text-dark fw-bold">${req.request_number}</span>`,
                            `<span class="text-start">${req.category}</span>`,
                            `<span class="text-start">${req.pickup_location}</span>`,
                            `<span class="text-start">${req.constituency}</span>`,
                            `<span class="text-start">${req.applicant_name}</span>`,
                            `<span class="text-start">${req.mobile_number}</span>`,
                            statusHtml,
                            `<span class="text-start">${req.created_at}</span>`,
                            actionsHtml
                        ]);
                    });
                }

                table.draw();
                $tableBody.css('opacity', '1');
            })
            .catch(err => {
                console.error('AJAX Filter failed', err);
                $tableBody.css('opacity', '1');
            });
        }

        // Apply Filter Button Click
        $('#applyFilterBtn').on('click', function(e) {
            e.preventDefault();
            performAjaxFilter();
        });

        // Reset Button Click
        $('#resetFilterBtn').on('click', function(e) {
            e.preventDefault();
            $('#statusFilter').val('');
            $('#corporationFilter').val('');
            $('#fromDateFilter').val('');
            $('#toDateFilter').val('');
            
            const $constSelect = $('#constituencyFilter');
            $constSelect.html('<option value="">All Constituencies</option>');
            @foreach($constituencies as $constituency)
                $constSelect.append(new Option("{{ $constituency->name }}", "{{ $constituency->name }}"));
            @endforeach

            performAjaxFilter();
        });
    });

    // Simple Table CSV Export helper
    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("#admin-waste-requests-table tr");
        
        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
            for (var j = 0; j < cols.length - 1; j++) {
                var text = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").trim();
                row.push('"' + text.replace(/"/g, '""') + '"');
            }
            csv.push(row.join(","));
        }

        var csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
        var downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = "none";
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
</script>
@endsection
