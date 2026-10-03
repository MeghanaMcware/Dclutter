@extends('vehiclepwa.layout.app')

@section('title') History @endsection
@section('heading') History @endsection

@section('style')
<style>
    :root { --primary-green: #0e7a43; }
    .history-card {
        background: #fff;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    }
    .history-card .top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .req-badge {
        background: #e6f4ea;
        color: #0e7a43;
        font-weight: 800;
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge {
        background: #e2e8f0;
        color: #1e293b;
        font-weight: 700;
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 14px;
        color: #334155;
    }
    .info-row i {
        color: #0e7a43;
        margin-top: 3px;
        width: 16px;
        text-align: center;
    }
    .info-row .name {
        font-weight: 700;
        color: #0f172a;
    }
    .info-row .phone {
        color: #64748b;
        font-weight: 500;
    }
    .btn-action {
        width: 100%;
        background: var(--primary-green);
        color: #fff;
        border: none;
        padding: 10px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 15px;
        display: block;
        text-align: center;
        text-decoration: none;
        margin-top: 12px;
    }
    .btn-action:hover {
        background: #095930;
        color: #fff;
    }
</style>
@endsection

@section('content')
<div class="container py-2" style="max-width: 440px; margin: 0 auto;">

    <!-- Search Form -->
    <div class="mb-3">
        <form method="GET" action="{{ route('vehicle.history') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search ID, Name or Mobile" value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit" style="background: var(--primary-green); border-color: var(--primary-green);">
                    <i class="fa-solid fa-search text-white"></i>
                </button>
            </div>
        </form>
    </div>

    @forelse($requests as $req)
        <a href="{{ route('vehicle.history.show', $req->id) }}" style="text-decoration: none; color: inherit;">
            <div class="history-card">
                <div class="top-row">
                    <div class="req-badge">
                        <i class="fa-solid fa-recycle"></i> {{ $req->request_number }}
                    </div>
                    <div class="status-badge">
                        <i class="fa-solid fa-check-double"></i> {{ strtoupper($req->status) }}
                    </div>
                </div>
                
                <div class="info-row">
                    <i class="fa-solid fa-user"></i>
                    <div>
                        <span class="name">{{ $req->applicant_name }}</span>
                        <span class="phone">({{ $req->mobile_number }})</span>
                    </div>
                </div>
                
                <div class="info-row">
                    <i class="fa-solid fa-location-dot"></i>
                    <div>{{ Str::limit($req->address, 60) }}</div>
                </div>
                
                @if($req->ward)
                <div class="info-row">
                    <i class="fa-solid fa-map"></i>
                    <div>Ward: {{ $req->ward->ward_name }}</div>
                </div>
                @endif
                
                <div class="btn-action">
                    <i class="fa-solid fa-eye"></i> View Details
                </div>
            </div>
        </a>
    @empty
        <div class="text-center py-5">
            <i class="fa-solid fa-clock-rotate-left fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold">No History Found</h5>
            <p class="text-muted small">You haven't completed any pickups yet.</p>
        </div>
    @endforelse
    
    @if($requests->total() > 0)
    <div class="mt-4 mb-4 pb-4">
        <div class="d-flex flex-column align-items-center justify-content-center text-center">
            <div class="text-muted small mb-2 fw-bold w-100">
                Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of {{ $requests->total() }} entries
            </div>
            <div class="w-100 d-flex justify-content-center" style="overflow-x: auto;">
                {{ $requests->appends(request()->query())->links('vendor.pagination.circle') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

