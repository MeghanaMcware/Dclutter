@extends('vehiclepwa.layout.app')

@section('title') Dump Waste List @endsection
@section('heading') Waste Picked Up @endsection

@section('style')
<style>
    :root {
        --primary-brand: #0e7a43;
        --primary-brand-dark: #095930;
        --primary-brand-light: #e8f5e9;
        --bg-canvas: #f8fafc;
        --border-color: #e2e8f0;
    }

    body {
        background: var(--bg-canvas);
    }

    .dump-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
        transition: transform 0.15s ease;
    }

    .dump-card:active {
        transform: scale(0.99);
    }

    .req-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .req-badge {
        background: var(--primary-brand-light);
        color: var(--primary-brand-dark);
        font-weight: 800;
        font-size: 13px;
        padding: 5px 11px;
        border-radius: 8px;
    }

    .status-badge-picked {
        background: #d1e7dd;
        color: #0f5132;
        font-weight: 700;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .info-row {
        font-size: 13px;
        color: #334155;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-row i {
        color: var(--primary-brand);
        width: 16px;
    }

    .btn-dump-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: var(--primary-brand);
        color: #ffffff;
        font-weight: 800;
        font-size: 13.5px;
        border-radius: 10px;
        padding: 10px;
        text-decoration: none;
        margin-top: 12px;
        border: none;
    }

    .btn-dump-action:hover, .btn-dump-action:focus {
        background: var(--primary-brand-dark);
        color: #ffffff;
    }
</style>
@endsection

@section('content')

<div class="container py-2" style="max-width:440px; margin:0 auto; padding-bottom:80px;">

    <div class="mb-3">
        <h6 class="fw-bold text-dark mb-1">Items Ready for Dump Disposal</h6>
        <p class="small text-muted mb-0">Select a picked up request below to fill out the dump form.</p>
    </div>

    @forelse($dumpRequests as $req)
        <div class="dump-card">
            <div class="req-header">
                <span class="req-badge">
                    <i class="fa-solid fa-recycle me-1"></i>
                    {{ $req->request_number ?? ('REQ-' . str_pad($req->id, 5, '0', STR_PAD_LEFT)) }}
                </span>
                <span class="status-badge-picked">
                    <i class="fa-solid fa-circle-check me-1"></i> Picked Up
                </span>
            </div>

            <div class="info-row">
                <i class="fa-solid fa-user"></i>
                <span class="fw-bold text-dark">{{ $req->applicant_name ?? 'N/A' }}</span>
                @if(!empty($req->mobile_number))
                    <span class="text-muted">({{ $req->mobile_number }})</span>
                @endif
            </div>

            <div class="info-row">
                <i class="fa-solid fa-location-dot"></i>
                <span>{{ \Illuminate\Support\Str::limit($req->address ?? 'Address not specified', 65) }}</span>
            </div>

            @if(!empty($req->ward?->name) || !empty($req->ward_name_no))
                <div class="info-row">
                    <i class="fa-solid fa-map"></i>
                    <span class="text-secondary">Ward: {{ $req->ward?->name ?? $req->ward_name_no }}</span>
                </div>
            @endif

            <a href="{{ route('vehicle.dumpform', ['pickup_id' => ($req->request_number ?? ('REQ-' . str_pad($req->id, 5, '0', STR_PAD_LEFT))), 'id' => $req->id]) }}" class="btn-dump-action">
                <i class="fa-solid fa-truck-ramp-box"></i>
                Dump
            </a>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fa-solid fa-truck-ramp-box fa-3x text-muted mb-3"></i>
            <h6 class="fw-bold text-secondary">No Picked Up Items Found</h6>
            <p class="small text-muted">Items marked as "Picked Up" will appear here for dump disposal.</p>
        </div>
    @endforelse

</div>

@endsection
