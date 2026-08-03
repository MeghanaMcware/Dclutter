@extends('vehiclepwa.layout.app')

@section('title') Assigned Requests @endsection
@section('heading', 'Assigned Requests')
@section('style')
    <style>
        .nav-tabs .nav-link {
            color: #555;
            font-weight: 600;
            font-size: 13px;
            border: none;
            border-bottom: 2px solid transparent;
            padding: 10px 16px;
        }

        .nav-tabs .nav-link.active {
            color: #2a5780;
            border-bottom: 2px solid #2a5780;
            background: transparent;
        }

        .search-box {
            position: relative;
            border-radius: 8px !important;
        }

        .search-box input {
            padding-left: 35px;
            border-radius: 8px;
            font-size: 13px;
            line-height: 30px !important;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .pagination-sm .page-link {
            font-size: 12px;
            color: #2a5780;
        }

        .pagination-sm .page-item.active .page-link {
            background-color: #2a5780;
            border-color: #2a5780;
            color: #fff;
        }

        .new-height {
            color: black !important;
            line-height: 20px !important;
        }

        .ln-20 {
            line-height: 20px !important;
        }

        .form-select-sm {
            line-height: 30px !important;
            border-radius: 5px !important;
            border: 1px solid black;
        }

        .ticket-table-bordered th,
        .ticket-table-bordered td {
            border: 1px solid #dee2e6;
            padding: 10px;
        }

        .ticket-table-bordered thead th {
            border-bottom: 2px solid #dee2e6;
        }
    </style>
@endsection

@section('content')
    <div class="container py-3">



        {{-- Live Capacity Meter --}}
        @php
            $remCap = max(0.0, round($maxCapacity - $committedWeight, 2));
            $pct = min(100, round(($committedWeight / $maxCapacity) * 100, 1));
        @endphp
        <div class="card border-0 shadow-sm rounded-3 mb-3 p-3 bg-light border" style="background:white !important">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="small fw-bold text-secondary text-uppercase new-height">Vehicle Trip Load Capacity</span> <br>
                <strong class="small text-primary ln-20">{{ $committedWeight }} T Accepted / {{ $maxCapacity }} T Max
                    ({{ $remCap }} T Available)</strong>
            </div>
            <div class="progress" style="height: 8px;">
                <div class="progress-bar {{ $pct >= 90 ? 'bg-danger' : 'bg-success' }}"
                    style="width: {{ $pct }}%;border-radius: 5px !important;"></div>
            </div>
            @if ($remCap <= 0)
                <div class="alert alert-danger py-1 px-2 mb-0 mt-2 font-11 text-center">
                    <i class="fa-solid fa-triangle-exclamation"></i> <strong>Capacity Limit Full:</strong> You cannot accept
                    more requests until your current load is dumped at the processing plant.
                </div>
            @endif
        </div>

        @if (session('success'))
            <div class="alert alert-success py-2 px-3 mb-3">{{ session('success') }}</div>
        @endif


        <div class="card p-2" style="border-radius:5px !important">
            <div class="card-body p-1">

                <div class="row g-2 mb-3 align-items-center">
                    <div class="col-8">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="unified-search" class="form-control form-control-sm"
                                placeholder="Search ref, name, phone, ward...">
                        </div>
                    </div>
                    <div class="col-4 text-end">
                        <select id="unified-per-page" class="form-select form-select-sm d-inline-block w-auto">
                            <option value="5" selected>5 / page</option>
                            <option value="10">10 / page</option>
                            <option value="20">20 / page</option>
                        </select>
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        @if ($citizenRequests->isEmpty() && $wasteTasks->isEmpty())
                            <div class="p-4 text-center text-muted small">
                                <i class="bi bi-inbox fs-2 text-muted d-block mb-1"></i>
                                No assigned requests found for your vehicle.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="ticket-table ticket-table-bordered table-hover align-middle mb-0" style="font-size: 13px;">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="white-space: nowrap !important;">Request Ref & Type</th>
                                            <th style="white-space: nowrap !important;">Applicant & Location</th>
                                            <th style="white-space: nowrap !important;">Est. Weight</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="unified-table-body">
                                        {{-- Render AE Waste Tasks --}}
                                        @foreach ($wasteTasks as $wt)
                                            <tr class="unified-row" data-search="{{ strtolower(($wt->formatted_request_number ?? '') . ' ' . ($wt->creator->name ?? 'AE Officer') . ' ' . ($wt->ward->name ?? '') . ' ' . ($wt->description ?? '')) }}">
                                                <td>
                                                    <strong>{{ $wt->formatted_request_number }}</strong><br>
                                                    <span class="badge bg-warning text-dark font-11 mt-1">AE Spot Task</span>
                                                </td>
                                                <td>
                                                    <strong>{{ $wt->creator->name ?? 'AE Officer' }}</strong><br>
                                                    <small class="text-muted">{{ $wt->ward->name ?? 'Ward Site' }}</small>
                                                    @if($wt->latitude && $wt->longitude)
                                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $wt->latitude }},{{ $wt->longitude }}"
                                                           target="_blank" class="btn btn-outline-primary btn-sm py-0 px-2 ms-1 font-11" style="border-radius: 5px;"
                                                           title="Navigate in Google Maps">
                                                            <i class="bi bi-geo-alt-fill"></i> Map
                                                        </a>
                                                    @endif
                                                </td>
                                                <td><strong>{{ $wt->total_weight }} T</strong></td>
                                                <td>
                                                    <a href="{{ route('vehicle.pickup.create', ['waste_task_id' => $wt->id]) }}"
                                                       class="btn {{ $remCap <= 0 ? 'btn-secondary disabled' : 'btn-success' }} btn-sm py-1 px-2 fw-bold text-white"
                                                       style="white-space: nowrap;">
                                                        <i class="bi bi-truck me-1"></i> Direct Pickup
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        {{-- Render Citizen Requests --}}
                                        @foreach ($citizenRequests as $cr)
                                            <tr class="unified-row" data-search="{{ strtolower(($cr->formatted_request_number ?? '') . ' ' . $cr->citizen_name . ' ' . $cr->mobile . ' ' . ($cr->ward->name ?? '') . ' ' . $cr->address) }}">
                                                <td>
                                                    <strong>{{ $cr->formatted_request_number }}</strong><br>
                                                    <span class="badge bg-primary font-11 mt-1">Citizen Request</span>
                                                </td>
                                                <td>
                                                    <strong>{{ $cr->citizen_name }}</strong> ({{ $cr->mobile }})<br>
                                                    <small class="text-muted">{{ $cr->ward->name ?? 'Site Location' }}</small>
                                                    @if($cr->latitude && $cr->longitude)
                                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $cr->latitude }},{{ $cr->longitude }}"
                                                           target="_blank" class="btn btn-outline-primary btn-sm py-0 px-2 ms-1 font-11" style="border-radius: 5px;"
                                                           title="Navigate in Google Maps">
                                                            <i class="bi bi-geo-alt-fill"></i> Map
                                                        </a>
                                                    @endif
                                                </td>
                                                <td><strong>{{ $cr->estimated_weight }} T</strong></td>
                                                <td>
                                                    <a href="{{ route('vehicle.pickup.create', ['citizen_request_id' => $cr->id]) }}"
                                                       class="btn {{ $remCap <= 0 ? 'btn-secondary disabled' : 'btn-success' }} btn-sm py-1 px-2 fw-bold text-white"
                                                       style="white-space: nowrap;">
                                                        <i class="bi bi-truck me-1"></i> Direct Pickup
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                                <small class="text-muted" id="unified-info"></small>
                                <nav>
                                    <ul class="pagination pagination-sm mb-0" id="unified-pagination"></ul>
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // --- Generic Client-Side Pagination & Filtering Helper ---
        function initClientPagination(config) {
            const rows = document.querySelectorAll(config.rowSelector);
            const searchInput = document.getElementById(config.searchInputId);
            const perPageSelect = document.getElementById(config.perPageSelectId);
            const paginationList = document.getElementById(config.paginationId);
            const infoText = document.getElementById(config.infoId);

            if (!rows.length || !searchInput || !perPageSelect || !paginationList) return;

            let currentPage = 1;
            let itemsPerPage = parseInt(perPageSelect.value, 10);

            function render() {
                itemsPerPage = parseInt(perPageSelect.value, 10);
                const query = searchInput.value.toLowerCase().trim();

                const filtered = Array.from(rows).filter(row => {
                    const searchData = row.getAttribute('data-search') || '';
                    return !query || searchData.includes(query);
                });

                const totalItems = filtered.length;
                const totalPages = Math.ceil(totalItems / itemsPerPage);

                if (currentPage > totalPages && totalPages > 0) {
                    currentPage = totalPages;
                }

                rows.forEach(row => row.style.display = 'none');

                const start = (currentPage - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                const visibleRows = filtered.slice(start, end);

                visibleRows.forEach(row => row.style.display = '');

                if (infoText) {
                    if (totalItems === 0) {
                        infoText.textContent = 'Showing 0 items';
                    } else {
                        infoText.textContent =
                            `Showing ${start + 1} to ${Math.min(end, totalItems)} of ${totalItems} items`;
                    }
                }

                let html = '';
                html += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage - 1}">Prev</a>
                 </li>`;

                for (let i = 1; i <= totalPages; i++) {
                    html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                     </li>`;
                }

                html += `<li class="page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">Next</a>
                 </li>`;

                paginationList.innerHTML = html;
            }

            searchInput.addEventListener('input', () => {
                currentPage = 1;
                render();
            });
            perPageSelect.addEventListener('change', () => {
                currentPage = 1;
                render();
            });

            paginationList.addEventListener('click', (e) => {
                e.preventDefault();
                const target = e.target.closest('a');
                if (!target) return;
                const page = parseInt(target.getAttribute('data-page'), 10);
                if (page && page >= 1) {
                    currentPage = page;
                    render();
                }
            });

            render();
        }

        document.addEventListener('DOMContentLoaded', function() {
            initClientPagination({
                rowSelector: '.unified-row',
                searchInputId: 'unified-search',
                perPageSelectId: 'unified-per-page',
                paginationId: 'unified-pagination',
                infoId: 'unified-info'
            });
        });

        // --- SweetAlert2 Acceptance Handlers ---
        function acceptCitizen(id, citizenName, weight) {
            Swal.fire({
                title: 'Accept Request?',
                html: `Are you sure you want to accept pickup for <strong>${citizenName}</strong>?<br><span class="badge bg-primary mt-2">${weight} Tons Waste</span>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Accept Request',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Assigning request to your vehicle...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const citizenUrl = `{{ route('vehicle.requests.citizen.accept', ['id' => '__ID__']) }}`
                        .replace('__ID__', id);
                    fetch(citizenUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(async r => {
                            let data;
                            try {
                                data = await r.json();
                            } catch (e) {
                                data = {
                                    success: false,
                                    message: 'Server HTTP ' + r.status + ' - unexpected response.'
                                };
                            }
                            return {
                                status: r.status,
                                data
                            };
                        })
                        .then(res => {
                            if (res.data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Request Accepted!',
                                    text: res.data.message,
                                    confirmButtonColor: '#198754',
                                    timer: 2000,
                                    timerProgressBar: true
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Capacity Limit Exceeded!',
                                    text: res.data.message || 'Cannot accept request.',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An unexpected error occurred. Please try again.',
                                confirmButtonColor: '#dc3545'
                            });
                        });
                }
            });
        }

        function acceptTask(id, weight) {
            Swal.fire({
                title: 'Accept Spot Task?',
                html: `Are you sure you want to accept <strong>Task #${id}</strong>?<br><span class="badge bg-warning text-dark mt-2">${weight} Tons Waste</span>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Accept Task',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Assigning task to your vehicle...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    const taskUrl = `{{ route('vehicle.requests.task.accept', ['id' => '__ID__']) }}`.replace(
                        '__ID__', id);
                    fetch(taskUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(async r => {
                            let data;
                            try {
                                data = await r.json();
                            } catch (e) {
                                data = {
                                    success: false,
                                    message: 'Server HTTP ' + r.status + ' - unexpected response.'
                                };
                            }
                            return {
                                status: r.status,
                                data
                            };
                        })
                        .then(res => {
                            if (res.data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Task Accepted!',
                                    text: res.data.message,
                                    confirmButtonColor: '#198754',
                                    timer: 2000,
                                    timerProgressBar: true
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Capacity Limit Exceeded!',
                                    text: res.data.message || 'Cannot accept task.',
                                    confirmButtonColor: '#dc3545'
                                });
                            }
                        })
                        .catch(err => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'An unexpected error occurred. Please try again.',
                                confirmButtonColor: '#dc3545'
                            });
                        });
                }
            });
        }
    </script>
@endsection
