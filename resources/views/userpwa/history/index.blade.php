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

    .pagination-wrapper .page-link {
        color: #0e7a43;
        font-size: 13px;
        border-radius: 8px;
        margin: 0 2px;
    }
    .pagination-wrapper .page-item.active .page-link {
        background-color: #0e7a43;
        border-color: #0e7a43;
        color: #ffffff;
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-3 pt-3 pb-5">
    
    <div class="mb-4">
        <form action="{{ route('user.history') }}" method="GET" class="position-relative">
            <input type="text" name="search" class="form-control" placeholder="Search by ID or Address" value="{{ request('search') }}" style="border-radius: 12px; padding-left: 40px; height: 48px; font-size: 14px;">
            <i class="fa fa-search position-absolute text-muted" style="left: 14px; top: 16px;"></i>
        </form>
    </div>

    <div class="history-list">
        @forelse($requests as $req)
            @php
                $status = strtolower($req->status ?? 'pending');
                $statusClass = match($status) {
                    'picked_up', 'dumped', 'completed' => 'status-completed',
                    default => 'status-pending'
                };
                $statusIcon = match($status) {
                    'picked_up', 'dumped', 'completed' => 'fa fa-check-circle',
                    'assigned', 'scheduled' => 'fa fa-truck',
                    'not_available', 'rescheduled' => 'fa fa-calendar-alt',
                    'rejected', 'cancelled' => 'fa fa-times-circle',
                    default => 'fa fa-clock'
                };
                $statusLabel = match($status) {
                    'pending' => 'Pending',
                    'assigned', 'scheduled' => 'Assigned',
                    'picked_up' => 'In Progress',
                    'dumped', 'completed' => 'Completed',
                    'not_available', 'rescheduled' => 'Rescheduled',
                    'rejected' => 'Rejected',
                    'cancelled' => 'Cancelled',
                    default => ucfirst(str_replace('_', ' ', $status))
                };
                $categories = is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?: 'Waste Request');
                $subcategories = is_array($req->subcategory_ids) ? implode(', ', $req->subcategory_ids) : ($req->subcategory_ids ?: '');
                $firstImage = (!empty($req->waste_images) && is_array($req->waste_images)) ? $req->waste_images[0] : null;
                $pickupDateText = $req->preferred_pickup_date ? \Carbon\Carbon::parse($req->preferred_pickup_date)->format('d M Y (D)') : ($req->created_at ? $req->created_at->format('d M Y (D)') : 'N/A');
            @endphp

            <a href="{{ route('user.history.show', ['id' => $req->id]) }}" class="history-card">
                <div class="history-card-header">
                    <h4 class="history-id">#{{ $req->request_number }}</h4>
                    <span class="status-badge-custom {{ $statusClass }}">
                        <i class="{{ $statusIcon }}"></i> {{ $statusLabel }}
                    </span>
                </div>
                
                <div class="history-title">
                    {{ $categories }}
                    @if($subcategories)
                        <span class="history-title-sub">({{ $subcategories }})</span>
                    @endif
                </div>
                
                <div class="history-info-row">
                    <div class="history-address-block">
                        <i class="fa fa-map-marker-alt history-address-icon"></i>
                        <div class="history-address-text">
                            {{ Str::limit(($req->house_no ? '#'.$req->house_no.', ' : '') . $req->address, 65) }}
                            <strong>{{ $req->ward?->name ?? ($req->constituency?->name ?? 'Bengaluru') }}</strong>
                        </div>
                    </div>
                    
                    @if($firstImage)
                        <img src="{{ asset('storage/' . $firstImage) }}" alt="Waste Photo" style="width: 70px; height: 70px; object-fit: cover; border-radius: 12px; border: 1px solid #e2e8f0; flex-shrink: 0;">
                    @else
                        <div class="history-image-placeholder">
                            <i class="fa fa-box-open"></i>
                        </div>
                    @endif
                </div>
                
                <div class="history-date">
                    <i class="fa-regular fa-calendar-check"></i> Pickup: {{ $pickupDateText }}
                </div>
                
                <div class="history-footer">
                    <span>View Status & Details</span>
                    <i class="fa fa-chevron-right" style="color: #0e7a43;"></i>
                </div>
            </a>
        @empty
            <div class="text-center py-5 text-muted">
                <div class="history-image-placeholder mx-auto mb-3" style="width: 80px; height: 80px;">
                    <i class="fa fa-history fa-2x"></i>
                </div>
                <h6 class="fw-bold text-dark">No Request History Found</h6>
                <p class="small text-muted mb-3">You don't have any past pickup requests recorded yet.</p>
                <a href="{{ route('user.report') }}" class="btn btn-sm btn-success px-4" style="background-color: #0e7a43; border-radius: 8px;">
                    <i class="fa fa-plus me-1"></i> Book New Request
                </a>
            </div>
        @endforelse

        @if($requests->hasPages())
            <div class="pagination-wrapper d-flex justify-content-center mt-4">
                {{ $requests->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
