@extends('userpwa.layout.app')

@section('title', 'Track Requests')
@section('heading', 'Track Requests')

@section('style')
<style>
    body {
        background-color: #f8fafc;
    }
    .track-container { 
        display: flex;
        flex-direction: column;
        padding-bottom: 28px;
    }
    
    .search-wrapper {
        background: #ffffff;
        padding: 16px 20px 0;
    }
    
    .search-box {
        position: relative;
        display: flex;
        align-items: center;
        background: #f1f5f9;
        border-radius: 12px;
        padding: 4px 12px;
        border: 1px solid #e2e8f0;
    }
    
    .search-box input {
        border: none;
        background: transparent;
        padding: 10px 8px;
        font-size: 14px;
        color: #334155;
        width: 100%;
        outline: none;
    }
    
    .search-box input::placeholder {
        color: #94a3b8;
    }
    
    .search-box i {
        color: #64748b;
        font-size: 16px;
    }
    
    .tabs-wrapper {
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 16px;
        border-bottom: 1px solid #f1f5f9;
        overflow-x: auto;
    }
    
    .tab-item {
        padding: 14px 8px;
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        text-decoration: none;
        position: relative;
        cursor: pointer;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .tab-item.active {
        color: #0e7a43;
    }
    
    .tab-item.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background-color: #0e7a43;
        border-radius: 3px 3px 0 0;
    }

    .tab-badge {
        background: #e2e8f0;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 12px;
    }

    .tab-item.active .tab-badge {
        background: #dcfce7;
        color: #0e7a43;
    }
    
    .requests-list {
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    
    .request-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        display: flex;
        flex-direction: column;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .request-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.06);
    }
    
    .card-header-main {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 16px 10px;
    }
    
    .req-id {
        font-size: 15px;
        font-weight: 800;
        color: #0e7a43;
    }
    
    .badge-status {
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .card-body-main {
        padding: 0 16px 14px;
    }
    
    .category-title {
        font-size: 14px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }
    
    .details-row {
        display: flex;
        gap: 12px;
    }
    
    .info-column {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 12px;
        color: #475569;
        line-height: 1.4;
    }
    
    .info-item i {
        color: #0e7a43;
        font-size: 13px;
        margin-top: 2px;
        flex-shrink: 0;
    }
    
    .thumb-column {
        width: 80px;
        height: 70px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .thumb-column img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumb-column i {
        font-size: 24px;
        color: #94a3b8;
    }
    
    .card-footer-main {
        padding: 12px 16px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        color: #0e7a43;
        font-weight: 700;
        font-size: 13px;
        background: #fafcfb;
        border-radius: 0 0 16px 16px;
    }

    .card-footer-main:hover {
        background: #f0fdf4;
        color: #085e33;
    }
    
    .card-footer-main i {
        color: #0e7a43;
        transition: transform 0.15s ease;
    }

    .card-footer-main:hover i {
        transform: translateX(3px);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        background: #ffffff;
        border-radius: 16px;
        border: 1px dashed #cbd5e1;
        margin-top: 10px;
    }

    .btn-create-req {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #0e7a43;
        color: #ffffff !important;
        font-weight: 700;
        font-size: 14px;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        margin-top: 14px;
    }
</style>
@endsection

@section('content')
<div class="track-container">
    @php
        $allCount = $requests->count();
        $inprogressCount = $requests->filter(fn($r) => in_array(strtolower($r->status), ['pending', 'assigned', 'picked_up', 'in_transit']))->count();
        $completedCount = $requests->filter(fn($r) => in_array(strtolower($r->status), ['completed', 'dumped']))->count();
        $closedCount = $requests->filter(fn($r) => in_array(strtolower($r->status), ['rejected', 'cancelled', 'closed']))->count();
    @endphp

    <div class="search-wrapper">
        <div class="search-box">
            <input type="text" id="trackSearchInput" placeholder="Search by Request ID, Items, Address..." value="{{ request('query') ?? request('id') ?? '' }}" oninput="filterRequests()">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </div>
    
    <div class="tabs-wrapper" id="status-tabs">
        <a href="javascript:void(0)" class="tab-item active" data-filter="all" onclick="setTabFilter(this, 'all')">
            All <span class="tab-badge">{{ $allCount }}</span>
        </a>
        <a href="javascript:void(0)" class="tab-item" data-filter="inprogress" onclick="setTabFilter(this, 'inprogress')">
            In Progress <span class="tab-badge">{{ $inprogressCount }}</span>
        </a>
        <a href="javascript:void(0)" class="tab-item" data-filter="completed" onclick="setTabFilter(this, 'completed')">
            Completed <span class="tab-badge">{{ $completedCount }}</span>
        </a>
        <a href="javascript:void(0)" class="tab-item" data-filter="closed" onclick="setTabFilter(this, 'closed')">
            Closed <span class="tab-badge">{{ $closedCount }}</span>
        </a>
    </div>

    <div class="requests-list" id="requests-container">
        @forelse($requests as $req)
            @php
                $status = strtolower($req->status ?? 'pending');
                
                if (in_array($status, ['completed', 'dumped'])) {
                    $filterGroup = 'completed';
                    $statusLabel = 'Completed';
                    $badgeStyle = 'background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0;';
                    $icon = 'fa-check-circle';
                } elseif (in_array($status, ['rejected', 'cancelled', 'closed'])) {
                    $filterGroup = 'closed';
                    $statusLabel = 'Closed';
                    $badgeStyle = 'background: #fef2f2; color: #dc2626; border: 1px solid #fecaca;';
                    $icon = 'fa-times-circle';
                } elseif ($status === 'assigned') {
                    $filterGroup = 'inprogress';
                    $statusLabel = 'Vehicle Assigned';
                    $badgeStyle = 'background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe;';
                    $icon = 'fa-truck';
                } elseif (in_array($status, ['picked_up', 'in_transit'])) {
                    $filterGroup = 'inprogress';
                    $statusLabel = 'Picked Up';
                    $badgeStyle = 'background: #fef3c7; color: #d97706; border: 1px solid #fde68a;';
                    $icon = 'fa-box';
                } else {
                    $filterGroup = 'inprogress';
                    $statusLabel = 'Pending Pickup';
                    $badgeStyle = 'background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa;';
                    $icon = 'fa-clock';
                }

                $categoriesText = is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?: 'Bulky Waste');
                $subcategoriesText = is_array($req->subcategory_ids) ? implode(', ', array_map(fn($s) => explode(': ', $s)[1] ?? $s, $req->subcategory_ids)) : '';
                
                $images = is_array($req->waste_images) ? $req->waste_images : [];
                $firstImage = count($images) > 0 ? $images[0] : null;

                $searchText = strtolower($req->request_number . ' ' . $categoriesText . ' ' . $subcategoriesText . ' ' . $req->address . ' ' . $req->landmark . ' ' . $statusLabel);
            @endphp

            <div class="request-card" data-status-group="{{ $filterGroup }}" data-search-text="{{ $searchText }}">
                <div class="card-header-main">
                    <div class="req-id">{{ $req->request_number }}</div>
                    <span class="badge-status" style="{{ $badgeStyle }}">
                        <i class="fa-solid {{ $icon }}"></i> {{ $statusLabel }}
                    </span>
                </div>
                
                <div class="card-body-main">
                    <div class="category-title">
                        {{ $categoriesText }}
                        @if($subcategoriesText)
                            <span style="font-size: 12px; font-weight: 500; color: #64748b;">({{ $subcategoriesText }})</span>
                        @endif
                    </div>
                    
                    <div class="details-row">
                        <div class="info-column">
                            <div class="info-item">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>
                                    @if($req->house_no) {{ $req->house_no }}, @endif
                                    {{ Str::limit($req->address, 65) }}
                                    @if($req->ward) <br><strong style="color:#0e7a43;">{{ $req->ward->name }}</strong> @endif
                                </span>
                            </div>
                            <div class="info-item">
                                <i class="fa-regular fa-calendar-check"></i>
                                <span>
                                    Pickup: <strong>{{ $req->preferred_pickup_date ? $req->preferred_pickup_date->format('d M Y (D)') : $req->created_at->format('d M Y') }}</strong>
                                </span>
                            </div>
                        </div>
                        
                        <div class="thumb-column">
                            @if($firstImage)
                                <img src="{{ asset('storage/' . $firstImage) }}" alt="Waste Photo" onerror="this.onerror=null;this.parentElement.innerHTML='<i class=\'fa-solid fa-box-open\'></i>';">
                            @else
                                <i class="fa-solid fa-box-open"></i>
                            @endif
                        </div>
                    </div>
                </div>
                
                <a href="{{ route('user.details', ['id' => $req->id]) }}" class="card-footer-main">
                    <span>View Status &amp; Details</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        @empty
            <div class="empty-state" id="empty-state-box">
                <i class="fa-solid fa-inbox text-muted" style="font-size: 40px; margin-bottom: 12px; display: block;"></i>
                <h6 style="font-weight: 800; color: #1e293b; margin-bottom: 6px;">No Pickup Requests Found</h6>
                <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">You haven't submitted any pickup requests yet.</p>
                <a href="{{ route('user.report') }}" class="btn-create-req">
                    <i class="fa-solid fa-plus-circle"></i> Request Waste Pickup
                </a>
            </div>
        @endforelse

        <div class="empty-state" id="no-filter-match" style="display: none;">
            <i class="fa-solid fa-search text-muted" style="font-size: 36px; margin-bottom: 12px; display: block;"></i>
            <h6 style="font-weight: 800; color: #1e293b; margin-bottom: 6px;">No Matching Requests</h6>
            <p style="font-size: 13px; color: #64748b; margin-bottom: 0;">Try adjusting your search or tab filter.</p>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let currentFilter = 'all';

    function setTabFilter(el, filter) {
        currentFilter = filter;
        document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
        if (el) el.classList.add('active');
        filterRequests();
    }

    function filterRequests() {
        const query = (document.getElementById('trackSearchInput')?.value || '').toLowerCase().trim();
        const cards = document.querySelectorAll('.request-card');
        const noMatchBox = document.getElementById('no-filter-match');
        let visibleCount = 0;

        cards.forEach(card => {
            const statusGroup = card.getAttribute('data-status-group');
            const searchText = card.getAttribute('data-search-text') || '';

            const matchesTab = (currentFilter === 'all' || statusGroup === currentFilter);
            const matchesSearch = (!query || searchText.includes(query));

            if (matchesTab && matchesSearch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (noMatchBox) {
            if (cards.length > 0 && visibleCount === 0) {
                noMatchBox.style.display = 'block';
            } else {
                noMatchBox.style.display = 'none';
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        filterRequests();
    });
</script>
@endsection
