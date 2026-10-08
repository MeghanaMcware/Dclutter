@extends('admin.layout.app')

@section('title', 'Imported Requests')

@section('style')
<style>
    .status-badge {
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        display: inline-block;
        min-width: 85px;
        text-align: center;
    }
    .status-pending { background-color: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .status-assigned { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .status-rescheduled { background-color: #faf5ff; color: #6b21a8; border: 1px solid #e9d5ff; }
    .status-picked_up { background-color: #ecfeff; color: #0e7490; border: 1px solid #a5f3fc; }
    .status-dumped, .status-completed { background-color: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .status-rejected { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
    .status-closed { background-color: #f8fafc; color: #475569; border: 1px solid #cbd5e1; }

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
                            <div class="col-md-3">
                                <label class="form-label mb-0"><b>Search</b></label>
                                <input type="text" name="search" class="form-control filter-input" placeholder="Search applicant, mobile, address..." value="{{ request('search') }}">
                            </div>

                            <div class="col-md-3">
                                <label class="form-label mb-0"><b>Corporation</b></label>
                                <select name="corporation_id" class="form-select filter-input">
                                    <option value="">All Corporations</option>
                                    @foreach($corporations as $corp)
                                        <option value="{{ $corp->id }}" {{ request('corporation_id') == $corp->id ? 'selected' : '' }}>{{ $corp->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label mb-0"><b>Constituency</b></label>
                                <select name="constituency_id" class="form-select filter-input">
                                    <option value="">All Constituencies</option>
                                    @foreach($constituencies as $constituency)
                                        <option value="{{ $constituency->id }}" {{ request('constituency_id') == $constituency->id ? 'selected' : '' }}>{{ $constituency->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label mb-0"><b>Status</b></label>
                                <select name="status" class="form-select filter-input">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                    <option value="rescheduled" {{ request('status') == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                                    <option value="picked_up" {{ request('status') == 'picked_up' ? 'selected' : '' }}>Picked Up</option>
                                    <option value="dumped" {{ request('status') == 'dumped' ? 'selected' : '' }}>Dumped</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                                </select>
                            </div>

                            <!-- Row 2: Action Buttons -->
                            <div class="col-md-12 d-flex align-items-center justify-content-end gap-2">
                                <button type="submit" class="btn btn-filter-primary d-flex align-items-center gap-1">
                                    <i class="fa fa-filter"></i> Filter
                                </button>
                                <a href="{{ route('admin.imported-requests.index') }}" class="btn btn-reset-outline text-decoration-none d-flex align-items-center justify-content-center">Reset</a>
                                <button type="button" class="btn btn-export d-flex align-items-center gap-1" onclick="submitExport()">
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
                                    <th class="text-center text-start1" style="min-width: 140px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($importedRequests as $req)
                                    @php
                                        $st = strtolower($req->status ?? 'pending');
                                        $badgeClass = match($st) {
                                            'pending', 'requested' => 'status-pending',
                                            'assigned', 'scheduled' => 'status-assigned',
                                            'rescheduled', 'not_available' => 'status-rescheduled',
                                            'picked_up' => 'status-picked_up',
                                            'dumped', 'completed' => 'status-dumped',
                                            'rejected' => 'status-rejected',
                                            'closed', 'door_closed', 'call_not_attended', 'not_ready_today', 'cancelled' => 'status-closed',
                                            default => 'status-pending'
                                        };
                                    @endphp
                                    <tr>
                                        <td class="text-start">#{{ $req->id }}</td>
                                        <td class="text-start">{{ $req->applicant_name ?? 'N/A' }}</td>
                                        <td class="text-start">{{ $req->mobile_number ?? 'N/A' }}</td>
                                        <td class="text-start">{{ $req->corporation?->name ?? ($req->corporation_name ?? 'N/A') }}</td>
                                        <td class="text-start">{{ $req->constituency?->name ?? ($req->division_name ?? 'N/A') }}</td>
                                        <td class="text-start">{{ $req->ward?->name ?? ($req->ward_name_no ?? 'N/A') }}</td>
                                        <td class="text-start">{{ Str::limit($req->address ?? 'N/A', 35) }}</td>
                                        <td>
                                            <span class="status-badge {{ $badgeClass }}">
                                                {{ $req->status_label }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('admin.imported-requests.show', $req->id) }}" class="btn btn-sm btn-primary" title="View Details">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                @if(!in_array($st, ['dumped', 'completed']))
                                                    <button type="button" 
                                                            class="btn btn-sm btn-success edit-legacy-request" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#assignLegacyVehicleModal" 
                                                            data-db-id="{{ $req->id }}" 
                                                            data-ref-id="{{ $req->excel_id ?? ('#' . $req->id) }}" 
                                                            data-applicant="{{ $req->applicant_name ?? 'Citizen' }}"
                                                            data-constituency-id="{{ $req->constituency_id }}" 
                                                            data-constituency-name="{{ $req->constituency?->name ?? ($req->division_name ?? 'N/A') }}" 
                                                            title="Assign Vehicle & Promote">
                                                        <i class="fa fa-truck"></i>
                                                    </button>
                                                @endif
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

                    <!-- Assign Vehicle Modal -->
                    <div class="modal fade" id="assignLegacyVehicleModal" tabindex="-1" aria-labelledby="assignLegacyVehicleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold" id="assignLegacyVehicleModalLabel">
                                        <i class="fa fa-truck text-primary me-2"></i> Assign Vehicle to Legacy Request <span id="modalRefId" class="text-primary"></span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" id="modalLegacyDbId">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Applicant Name</label>
                                        <input type="text" id="modalApplicantName" class="form-control" readonly style="background-color: #f8f9fa;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Constituency / Division</label>
                                        <input type="text" id="modalConstituencyName" class="form-control" readonly style="background-color: #f8f9fa;">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold" for="assignVehicleSelect">Select Available Vehicle <span class="text-danger">*</span></label>
                                        <select class="form-select" id="assignVehicleSelect" required>
                                            <option value="" disabled selected>-- Choose Available Vehicle --</option>
                                        </select>
                                        <div id="vehicleError" class="text-danger small mt-1" style="display: none;">
                                            Please select a vehicle.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold" for="modalRemarks">Approval / Assignment Remarks <span class="text-muted font-11 fw-normal">(Optional)</span></label>
                                        <textarea class="form-control" id="modalRemarks" rows="2" placeholder="Enter any notes or remarks for this assignment..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" id="submitAssignVehicleBtn" class="btn btn-primary"><i class="fa fa-check me-1"></i> Assign Vehicle & Promote</button>
                                </div>
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
function submitExport() {
    const form = document.getElementById('importedFilterForm');
    const params = new URLSearchParams(new FormData(form)).toString();
    window.location.href = "{{ route('admin.imported-requests.export') }}?" + params;
}

$(document).ready(function() {
    const vehicles = [
        @foreach($vehicles as $vehicle)
        {
            id: {{ $vehicle->id }},
            number: '{{ addslashes($vehicle->vehicle_number) }}',
            type: '{{ addslashes($vehicle->vehicle_type ?? "Garbage Truck") }}',
            driver: '{{ addslashes($vehicle->driver_name ?? $vehicle->owner?->name ?? "N/A") }}',
            driver_phone: '{{ addslashes($vehicle->driver_phone ?? $vehicle->owner?->mobile_number ?? "N/A") }}',
            constituency_ids: @json($vehicle->constituency_ids ?? []),
        },
        @endforeach
    ];

    let currentRow = null;

    // Open Assign Vehicle Modal
    $(document).on('click', '.edit-legacy-request', function() {
        currentRow = $(this).closest('tr');
        const dbId = $(this).data('db-id');
        const refId = $(this).data('ref-id');
        const applicant = $(this).data('applicant');
        const constituencyId = $(this).data('constituency-id');
        const constituencyName = $(this).data('constituency-name');

        $('#modalLegacyDbId').val(dbId);
        $('#modalRefId').text(refId);
        $('#modalApplicantName').val(applicant);
        $('#modalConstituencyName').val(constituencyName);
        $('#modalRemarks').val('');
        $('#vehicleError').hide();

        // Populate Vehicle Dropdown filtered by constituency if available
        const $select = $('#assignVehicleSelect');
        $select.empty();

        const filtered = constituencyId 
            ? vehicles.filter(v => {
                if (!v.constituency_ids) return false;
                const ids = Array.isArray(v.constituency_ids) ? v.constituency_ids : [];
                return ids.includes(Number(constituencyId)) || ids.includes(String(constituencyId));
            }) 
            : vehicles;

        if (filtered.length === 0) {
            $select.append(new Option('No active vehicles registered for ' + (constituencyName || 'this area'), '', true, true));
            $select.prop('disabled', true);
            $('#submitAssignVehicleBtn').prop('disabled', true);
        } else {
            $select.prop('disabled', false);
            $('#submitAssignVehicleBtn').prop('disabled', false);
            $select.append(new Option('-- Choose Available Vehicle (' + filtered.length + ' available) --', ''));
            filtered.forEach(v => {
                $select.append(new Option(v.number + ' - ' + v.type + ' (Driver: ' + v.driver + ')', v.id));
            });
        }
    });

    // Submit Assign Vehicle via AJAX
    $('#submitAssignVehicleBtn').on('click', function() {
        const dbId = $('#modalLegacyDbId').val();
        const vehicleId = $('#assignVehicleSelect').val();
        const remarks = $('#modalRemarks').val();

        if (!vehicleId) {
            $('#vehicleError').show();
            return;
        }

        const $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');

        $.ajax({
            url: "{{ url('/admin/imported-requests') }}/" + dbId + "/assign-vehicle",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                vehicle_id: vehicleId,
                remarks: remarks
            },
            success: function(response) {
                $btn.prop('disabled', false).html('<i class="fa fa-check me-1"></i> Assign Vehicle & Promote');
                $('#assignLegacyVehicleModal').modal('hide');

                if (currentRow) {
                    // Update status badge to Assigned in table row
                    currentRow.find('td').eq(7).html('<span class="status-badge status-assigned">Assigned</span>');
                }

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Assigned & Unified Successfully!',
                        html: response.message + '<br><br><a href="{{ url("/admin/requests") }}/' + response.unified_request_id + '" class="btn btn-sm btn-primary" target="_blank">View Active Request #' + response.unified_request_number + '</a>',
                        confirmButtonColor: '#28a745'
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html('<i class="fa fa-check me-1"></i> Assign Vehicle & Promote');
                const msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Failed to assign vehicle. Please try again.';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: msg,
                        confirmButtonColor: '#dc3545'
                    });
                } else {
                    alert(msg);
                }
            }
        });
    });
});
</script>
@endsection
