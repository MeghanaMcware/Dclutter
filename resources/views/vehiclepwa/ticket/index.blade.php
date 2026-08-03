@extends('vehiclepwa.layout.app')
@section('title') My Requests @endsection
@section('heading') My Requests @endsection

@section('style')
<style>
    .mt5 { margin-top: 55px; }

    /* ── Section label ── */
    .section-label {
        font-size: 13px;
        font-weight: 700;
        color: #2a5780;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 23px 0 10px;
    }
    thead{
        background:#2a5780;
    }
    /* ── Ticket table ── */
    .ticket-table-container {
        background: #fff;
        border-radius: 14px;
        padding: 16px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.07);
        overflow-x: auto;
    }

    .ticket-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .ticket-table th {
        text-align: left;
        padding: 12px 8px;
        font-weight: 600;
        color: #2a5780;
        border-bottom: 2px solid #f0f0f0;
        white-space: nowrap;
    }

    .ticket-table td {
        padding: 12px 8px;
        border-bottom: 1px solid #f0f0f0;
        color: #666;
    }

    .ticket-table tr:last-child td {
        border-bottom: none;
    }

    .status-pill {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .sp-assigned       { background:#fff3cd; color:#664d03; }
    .sp-pickup_scanned { background:#fde8d8; color:#7d3c0f; }
    .sp-pickup_submitted { background:#d6f0ff; color:#0b4a6e; }
    .sp-ready_to_dump  { background:#e2d9f3; color:#4b2e83; }
    .sp-picked_up      { background:#e2d9f3; color:#4b2e83; }
    .sp-dump_submitted { background:#fff3cd; color:#664d03; }
    .sp-completed      { background:#d1e7dd; color:#0f5132; }
    .sp-accepted       { background:#d1e7dd; color:#0f5132; }
    .sp-rejected       { background:#f8d7da; color:#842029; }

    .status-select {
        border: 1px solid #d0d0d0;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 12px;
        color: #2a5780;
        background: #fff;
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        text-decoration: none;
        color: #fff;
    }
    .btn-view { background: #2a5780; }
    .btn-view:hover { background: #1f4060;color: #fff; }

    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pagination .page-item {
        display: flex;
    }

    .pagination .page-link {
        color: #2a5780;
        border: 1px solid #e0e0e0;
        background: #fff;
        padding: 8px 14px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        min-width: 40px;
        text-align: center;
    }

    .pagination .page-link:hover {
        background-color: #2a5780;
        color: #fff;
        border-color: #2a5780;
    }

    .pagination .page-item.active .page-link {
        background-color: #2a5780;
        border-color: #2a5780;
        color: #fff;
        font-weight: 600;
    }

    .pagination .page-item.disabled .page-link {
        color: #ccc;
        background-color: #f5f5f5;
        border-color: #e0e0e0;
        cursor: not-allowed;
    }

    .pagination .page-item.disabled .page-link:hover {
        background-color: #f5f5f5;
        color: #ccc;
        border-color: #e0e0e0;
    }

    .ticket-table {
    width: 100%;
    border-collapse: collapse;
}

.ticket-table.bordered,
.ticket-table.bordered th,
.ticket-table.bordered td {
    border: 1px solid #00000045;
}

.ticket-table th,
.ticket-table td {
    padding: 8px 12px;
    vertical-align: middle;
}

    /* ── Search and filter controls ── */
    .table-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }

    .search-wrapper {
        flex: 1;
        min-width: 200px;
        max-width: 400px;
        position: relative;
    }

    .search-wrapper input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s ease;
        background: #f8f9fa;
    }

    .search-wrapper input:focus {
        outline: none;
        border-color: #2a5780;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(42, 87, 128, 0.1);
    }

    .search-wrapper::before {
        content: '🔍';
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 14px;
        opacity: 0.5;
    }

    .items-per-page-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: #666;
    }

    .items-per-page-wrapper select {
        padding: 6px 28px 6px 12px;
        border: 1px solid #d0d0d0;
        border-radius: 6px;
        font-size: 14px;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s ease;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        min-width: 60px;
    }

    .items-per-page-wrapper select:focus {
        outline: none;
        border-color: #2a5780;
        box-shadow: 0 0 0 3px rgba(42, 87, 128, 0.1);
    }

    .items-per-page-wrapper::after {
        content: '▼';
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 10px;
        color: #000;
        pointer-events: none;
    }

    .results-info {
        font-size: 12px;
        color: #888;
        margin-top: 8px;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #888;
    }
    .empty-state i {
        font-size: 48px;
        margin-bottom: 12px;
        display: block;
    }
</style>
@endsection

@section('content')
<div class="container mt5">

    @if ($tickets->isEmpty())
        <div class="empty-state">
            <i class="bi bi-ticket-perforated"></i>
            <p>No active requests assigned to you.</p>
        </div>
    @else
        <!-- <div class="section-label"><b>My Requests</b></div> -->

        <div class="ticket-table-container mb-3">
            {{-- Search and items per page --}}
            <div class="table-controls">
                <div class="search-wrapper">
                    <input type="text" id="search-input" placeholder="Search tickets...">
                </div>
                <div class="items-per-page-wrapper">
                    <span>Show</span>
                    <select id="items-per-page">
                        <option value="5" selected>5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>

            <div class="results-info" id="results-info">Showing all tickets</div>

            <table class="ticket-table bordered">
                <thead>
                    <tr>
                        <th class="text-white">Request #</th>
                        <th class="text-white">User</th>
                        <th class="text-white">Job Id</th>
                        <th class="text-white">Scheduled</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody id="ticket-table-body">
                    @foreach ($tickets as $ticket)
                        @php
                            $displayQuantity = (float) ($ticket->estimated_quantity ?? $ticket->unauthorizedWaste?->estimated_weight ?? 0);
                            $pillClass = 'sp-' . $ticket->status;
                                    $statusLabels = [
            'raised' => 'Raised',
            'pending_fo_verification' => 'Field Officer Verification Pending',
            'pending_user_acceptance_fo' => 'Action Required (Notice)',
            'pending_user_acceptance_agm' => 'Action Required (AGM)',
            'payment_pending' => 'Payment Pending',
            'verified' => 'Verified',
            'assigned' => 'Pickup Assigned',
            'pickup_scanned' => 'Pickup QR Scanned',
            'pickup_submitted' => 'Plant Approval Pending',
            'ready_to_dump' => 'Ready To Dump',
            'dump_submitted' => 'Plant Approval Pending',
            'completed' => 'Approved by Plant',
            'cancelled' => 'Cancelled',
            'overdue' => 'Overdue',
            'pending_pickup' => 'Delayed - Pickup Pending',
        ];
                        @endphp
                        <tr class="ticket-row">
                            <td><strong>Req-00-11</strong></td>
                            <td style="white-space:nowrap">{{ $ticket->user?->name ?? '-' }}</td>
                            <td style="white-space:nowrap">
                                Job-012
                            </td>
                           
                            <td style="white-space:nowrap">
                                @if ($ticket->scheduled_date)
                                    {{ \Carbon\Carbon::parse($ticket->scheduled_date)->format('d M') }}
                                    {{ $ticket->scheduled_time ? '· ' . \Carbon\Carbon::parse($ticket->scheduled_time)->format('h:i A') : '' }}
                                @else
                                    -
                                @endif
                            </td>
                            <td style="white-space:nowrap">
                                <div class="d-flex gap-1">
                                    @if ($ticket->latitude && $ticket->longitude)
                                        <a href="https://www.google.com/maps?q={{ $ticket->latitude }},{{ $ticket->longitude }}"
                                           target="_blank" class="btn-action btn-view" style="background: #e8f0f8; color: #2a5780; border: 1.5px solid #c6d4e8;">
                                            <i class="fas fa-directions"></i> Directions
                                        </a>
                                    @endif
                                    <a href="{{ route('vehicle.tickets.show', $ticket) }}"
                                       class="btn-action btn-view">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Client Side Pagination -->
            <nav id="client-pagination" aria-label="pagination-demo" class="mt-4" style="margin-bottom: 10px;">
                <ul class="pagination justify-content-center" id="pagination-list">
                    <!-- Dynamic Pagination -->
                </ul>
            </nav>
        </div>
    @endif

</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rows = document.querySelectorAll('.ticket-row');
    const paginationList = document.getElementById('pagination-list');
    const searchInput = document.getElementById('search-input');
    const itemsPerPageSelect = document.getElementById('items-per-page');
    const resultsInfo = document.getElementById('results-info');
    let itemsPerPage = 5;
    let currentPage = 1;
    let filteredRows = Array.from(rows);

    function updateResultsInfo() {
        const total = filteredRows.length;
        const start = total === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
        const end = Math.min(currentPage * itemsPerPage, total);
        if (searchInput.value.trim() === '') {
            resultsInfo.textContent = `Showing ${start}-${end} of ${total} tickets`;
        } else {
            resultsInfo.textContent = `Found ${total} tickets (showing ${start}-${end})`;
        }
    }

    function filterRows() {
        const searchTerm = searchInput.value.toLowerCase();
        filteredRows = Array.from(rows).filter(row => {
            const text = row.textContent.toLowerCase();
            return text.includes(searchTerm);
        });
        currentPage = 1;
        showPage(1);
    }

    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        rows.forEach(row => row.style.display = 'none');
        filteredRows.forEach((row, index) => {
            row.style.display = (index >= start && index < end) ? '' : 'none';
        });
        currentPage = page;
        renderPagination();
        updateResultsInfo();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredRows.length / itemsPerPage);
        paginationList.innerHTML = '';
        if (totalPages <= 1) {
            document.getElementById('client-pagination').style.display = 'none';
            return;
        }
        document.getElementById('client-pagination').style.display = 'block';
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#" ${currentPage === 1 ? 'tabindex="-1"' : ''}>&lsaquo; Prev</a>`;
        prevLi.querySelector('a').addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage > 1) showPage(currentPage - 1);
        });
        paginationList.appendChild(prevLi);
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.querySelector('a').addEventListener('click', (e) => {
                e.preventDefault();
                showPage(i);
            });
            paginationList.appendChild(li);
        }
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#" ${currentPage === totalPages ? 'tabindex="-1"' : ''}>Next &rsaquo;</a>`;
        nextLi.querySelector('a').addEventListener('click', (e) => {
            e.preventDefault();
            if (currentPage < totalPages) showPage(currentPage + 1);
        });
        paginationList.appendChild(nextLi);
    }

    searchInput.addEventListener('input', filterRows);
    itemsPerPageSelect.addEventListener('change', function() {
        itemsPerPage = parseInt(this.value);
        currentPage = 1;
        showPage(1);
    });

    document.querySelectorAll('.status-select').forEach(function(select) {
        select.addEventListener('change', function() {
            const value = this.value;
            const label = value === 'accepted' ? 'Accepted' : value === 'rejected' ? 'Rejected' : 'Updated';

            Swal.fire({
                title: `${label} Successfully`,
                text: `The request has been ${label.toLowerCase()} successfully.`,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false
            });

            setTimeout(() => {
                this.selectedIndex = 0;
            }, 1500);
        });
    });

    updateResultsInfo();
    showPage(1);
});
</script>
@endsection
