@extends('userpwa.layout.app')

@section('title', 'Request History')
@section('heading', 'History')

@section('style')
<style>
    body { background-color: #f8fafc; }
    
    .history-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        text-decoration: none;
        color: inherit;
    }
    
    .history-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }
    
    .history-id {
        font-size: 16px;
        font-weight: 700;
        color: #0e7a43;
        margin: 0;
    }
    
    .status-badge-custom {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .status-pending { background-color: #fff7ed; color: #ea580c; border: 1px solid #ffedd5; }
    .status-completed { background-color: #f0fdf4; color: #16a34a; border: 1px solid #dcfce7; }

    .history-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 12px;
    }
    
    .history-title-sub {
        font-weight: 400;
        color: #64748b;
    }
    
    .history-info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 16px;
    }
    
    .history-address-block {
        display: flex;
        gap: 8px;
        flex: 1;
        padding-right: 12px;
    }
    
    .history-address-icon {
        color: #0e7a43;
        font-size: 14px;
        margin-top: 2px;
    }
    
    .history-address-text {
        font-size: 13px;
        color: #64748b;
        line-height: 1.5;
    }
    
    .history-address-text strong {
        display: block;
        color: #0e7a43;
        font-weight: 600;
        margin-top: 2px;
    }
    
    .history-image-placeholder {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        background-color: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #e2e8f0;
    }
    
    .history-image-placeholder i {
        font-size: 24px;
        color: #94a3b8;
    }
    
    .history-date {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #475569;
        font-weight: 600;
        margin-bottom: 16px;
    }
    
    .history-date i {
        color: #0e7a43;
    }
    
    .history-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 14px;
        border-top: 1px solid #f1f5f9;
        font-size: 14px;
        font-weight: 700;
        color: #0e7a43;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-3 pt-3 pb-5">
    
    <div class="mb-4">
        <form action="#" method="GET" class="position-relative">
            <input type="text" name="search" class="form-control" placeholder="Search by ID or Address" style="border-radius: 12px; padding-left: 40px; height: 48px; font-size: 14px;">
            <i class="fa fa-search position-absolute text-muted" style="left: 14px; top: 16px;"></i>
        </form>
    </div>

    <div class="history-list">
        <!-- Completed Card UI -->
        <a href="{{ route('user.history.show') }}" class="history-card">
            <div class="history-card-header">
                <h4 class="history-id">#DCL-2026-000023</h4>
                <span class="status-badge-custom status-completed">
                    <i class="fa fa-check-circle"></i> Completed
                </span>
            </div>
            
            <div class="history-title">
                Electronic Waste 
                <span class="history-title-sub">(TV, Computers)</span>
            </div>
            
            <div class="history-info-row">
                <div class="history-address-block">
                    <i class="fa fa-map-marker-alt history-address-icon"></i>
                    <div class="history-address-text">
                        #13, Millers Tank Bund Road, Kaverappa Layout...
                        <strong>Vasanth Nagar</strong>
                    </div>
                </div>
                
                <div class="history-image-placeholder">
                    <i class="fa fa-box-open"></i>
                </div>
            </div>
            
            <div class="history-date">
                <i class="fa-regular fa-calendar-check"></i> Pickup: 01 Oct 2026 (Thu)
            </div>
            
            <div class="history-footer">
                <span>View Status & Details</span>
                <i class="fa fa-chevron-right" style="color: #0e7a43;"></i>
            </div>
        </a>

       
    </div>
</div>
@endsection
