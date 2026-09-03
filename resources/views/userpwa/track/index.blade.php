@extends('userpwa.layout.app')

@section('title', 'Track Request')
@section('heading', 'Track Request')

@section('style')
<style>
    body {
        background-color: #f8fafc;
    }
    .track-container { 
        display: flex;
        flex-direction: column;
        padding-bottom: 24px;
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
        padding: 0 20px;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .tab-item {
        padding: 16px 4px;
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        text-decoration: none;
        position: relative;
        cursor: pointer;
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
    
    .requests-list {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    
    .request-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
    }
    
    .card-header-main {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 16px 12px;
    }
    
    .req-id {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
    }
    
    .badge-status {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }
    
    .badge-inprogress {
        background-color: #fff7ed;
        color: #ea580c;
    }
    
    .badge-completed {
        background-color: #f0fdf4;
        color: #16a34a;
    }
    
    .card-body-main {
        padding: 0 16px 16px;
    }
    
    .category-title {
        font-size: 14px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 12px;
    }
    
    .details-row {
        display: flex;
        gap: 12px;
    }
    
    .info-column {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 12px;
        color: #475569;
        line-height: 1.5;
    }
    
    .info-item i {
        color: #94a3b8;
        font-size: 14px;
        margin-top: 2px;
    }
    
    .thumb-column {
        width: 80px;
        height: 60px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        background-color: #f1f5f9;
    }
    
    .thumb-column img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .card-footer-main {
        padding: 14px 16px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        text-decoration: none;
        color: #1e293b;
        font-weight: 700;
        font-size: 14px;
    }
    
    .card-footer-main i {
        color: #94a3b8;
    }
</style>
@endsection

@section('content')
<div class="track-container">
    <div class="search-wrapper">
        <div class="search-box">
            <input type="text" placeholder="Search by Request ID">
            <i class="fa-solid fa-magnifying-glass"></i>
        </div>
    </div>
    
    <div class="tabs-wrapper" id="status-tabs">
        <a href="javascript:void(0)" class="tab-item active" data-filter="all">All</a>
        <a href="javascript:void(0)" class="tab-item" data-filter="inprogress">In Progress</a>
        <a href="javascript:void(0)" class="tab-item" data-filter="completed">Completed</a>
        <a href="javascript:void(0)" class="tab-item" data-filter="closed">Closed</a>
    </div>

    <div class="requests-list" id="requests-container">
        <!-- Card 1 -->
        <div class="request-card" data-status="inprogress">
            <div class="card-header-main">
                <div class="req-id">#DCL-2025-001256</div>
                <div class="badge-status badge-inprogress">In Progress</div>
            </div>
            
            <div class="card-body-main">
                <div class="category-title">Unmanned Debris</div>
                <div class="details-row">
                    <div class="info-column">
                        <div class="info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>12th Cross, BTM Layout 2nd Stage,<br>Bengaluru, Karnataka - 560076</span>
                        </div>
                        <div class="info-item">
                            <i class="fa-regular fa-calendar"></i>
                            <span>23 May 2025, 10:30 AM</span>
                        </div>
                    </div>
                    <div class="thumb-column">
                        <img src="{{ asset('frontendwebsite/img/debris-thumb.jpg') }}" alt="Debris Thumbnail">
                    </div>
                </div>
            </div>
            
            <a href="{{ route('user.details') }}" class="card-footer-main">
                <span>View Details</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>

        <!-- Card 2 -->
        <div class="request-card" data-status="completed">
            <div class="card-header-main">
                <div class="req-id">#DCL-2025-001124</div>
                <div class="badge-status badge-completed">Completed</div>
            </div>
            
            <div class="card-body-main">
                <div class="category-title">Overflowing Bin</div>
                <div class="details-row">
                    <div class="info-column">
                        <div class="info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Jayanagar 4th Block,<br>Bengaluru, Karnataka - 560011</span>
                        </div>
                        <div class="info-item">
                            <i class="fa-regular fa-calendar"></i>
                            <span>22 May 2025, 07:30 PM</span>
                        </div>
                    </div>
                    <div class="thumb-column">
                        <img src="https://images.unsplash.com/photo-1611284446314-60a58ac0deb9?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Bin Thumbnail">
                    </div>
                </div>
            </div>
            
            <a href="{{ route('user.details') }}" class="card-footer-main">
                <span>View Details</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-item');
        const cards = document.querySelectorAll('.request-card');

        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                tabs.forEach(t => t.classList.remove('active'));
                
                // Add active class to clicked tab
                this.classList.add('active');
                
                // Get filter value
                const filterValue = this.getAttribute('data-filter');
                
                // Show/hide cards based on filter
                cards.forEach(card => {
                    if (filterValue === 'all') {
                        card.style.display = 'flex';
                    } else {
                        const status = card.getAttribute('data-status');
                        if (status === filterValue) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    }
                });
            });
        });
    });
</script>
@endsection
