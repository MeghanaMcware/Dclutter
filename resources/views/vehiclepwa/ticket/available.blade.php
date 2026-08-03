@extends('vehiclepwa.layout.app')

@section('title') Available Requests @endsection
@section('heading') Available Requests @endsection

@section('style')
<style>
    .mt5 { margin-top: 55px; }

    .ticket-card {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        transition: 0.3s;
        height: 100%;
    }

    .ticket-card:hover { transform: translateY(-3px); }

    .ticket-title { font-weight: 600; font-size: 15px; color: #000000bd; }
    .ticket-value { font-size: 14px; color: #666; }

    .badge-raised {
        display: inline-block;
        background: #fff3cd;
        color: #856404;
        border-radius: 6px;
        padding: 2px 8px;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-view {
        width: 100%;
        padding: 11px;
        background: #2a5780;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        margin-top: 14px;
        text-align: center;
        display: block;
        text-decoration: none;
        transition: background 0.2s;
    }
    .btn-view:hover { background: #1f4060; color: #fff; }

    /* Client Pagination Styles */
    .bg-blue-dark {
        background-color: #2a5780 !important;
        color: #FFF !important;
    }
    .bg-blue-dark-active {
        background-color: #198754 !important;
        color: #FFF !important;
    }
    .bg-gray-dark {
        background-color: #6c757d !important;
        color: #FFF !important;
    }
</style>
@endsection

@section('content')
<div class="container mt5">

    <div id="available-container" class="row g-3">
        @forelse ($tickets as $ticket)
            @php $displayQuantity = (float) ($ticket->estimated_quantity ?? $ticket->unauthorizedWaste?->estimated_weight ?? 0); @endphp
            <div class="col-6 ticket-item">
                <div class="ticket-card">

                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge-raised">Waiting</span>
                    </div>

                    <div class="mt-1">
                        <div class="ticket-title">Request ID</div>
                        <div class="ticket-value">{{ $ticket->ticket_number }}</div>
                    </div>

                    <div class="mt-2">
                        <div class="ticket-title">Owner</div>
                        <div class="ticket-value">{{ $ticket->user?->name ?? '-' }}</div>
                    </div>

                    <div class="mt-2">
                        <div class="ticket-title">Quantity</div>
                        <div class="ticket-value">
                            {{ number_format($displayQuantity, 2) }} ton
                        </div>
                    </div>

                    <div class="mt-2">
                        <div class="ticket-title">Ward</div>
                        <div class="ticket-value">{{ $ticket->ward?->name ?? '-' }}</div>
                    </div>

                    <a href="{{ route('vehicle.tickets.show', $ticket) }}"
                       class="btn-view">
                        View
                    </a>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="ticket-card text-center py-4">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <div class="ticket-title mt-2">No available requests right now.</div>
                    <div class="ticket-value">Check back later.</div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Client Side Pagination -->
    <nav id="client-pagination" aria-label="pagination-demo" class="mt-4" style="display: none; margin-bottom: 100px;">
        <ul class="pagination justify-content-center" id="pagination-list">
            <!-- Dynamic Pagination -->
        </ul>
    </nav>

</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    const itemsPerPage = 4;
    const $items = $('.ticket-item');
    const totalItems = $items.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    let currentPage = 1;

    if (totalItems > itemsPerPage) {
        $('#client-pagination').show();
        renderPagination();
        showPage(1);
    }

    function showPage(page) {
        currentPage = page;
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;

        $items.hide().slice(start, end).fadeIn(300);
        updatePaginationUI();
        window.scrollTo(0, 0);
    }

    function renderPagination() {
        const $list = $('#pagination-list');
        $list.empty();

        // Previous
        $list.append(`
            <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link rounded-l line-height-s color-white bg-gray-dark shadow-xl border-0 prev-page" href="#"><i class="fa fa-angle-left"></i></a>
            </li>
        `);

        // Pages
        for (let i = 1; i <= totalPages; i++) {
            $list.append(`
                <li class="page-item"><a class="page-link rounded-l line-height-s bg-blue-dark shadow-xl border-0 page-num" href="#" data-page="${i}">${i}</a></li>
            `);
        }

        // Next
        $list.append(`
            <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link rounded-l line-height-s color-white bg-gray-dark shadow-xl border-0 next-page" href="#"><i class="fa fa-angle-right"></i></a>
            </li>
        `);

        // Events
        $('.page-num').on('click', function(e) {
            e.preventDefault();
            showPage(parseInt($(this).data('page')));
        });

        $('.prev-page').on('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) showPage(currentPage - 1);
        });

        $('.next-page').on('click', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) showPage(currentPage + 1);
        });
    }

    function updatePaginationUI() {
        $('.page-num').each(function() {
            const page = parseInt($(this).data('page'));
            if (page === currentPage) {
                $(this).removeClass('bg-blue-dark').addClass('bg-blue-dark-active');
            } else {
                $(this).removeClass('bg-blue-dark-active').addClass('bg-blue-dark');
            }
        });

        $('.prev-page').parent().toggleClass('disabled', currentPage === 1);
        $('.next-page').parent().toggleClass('disabled', currentPage === totalPages);
    }
});
</script>
@endsection
