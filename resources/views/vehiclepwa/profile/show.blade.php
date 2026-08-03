@extends('vehiclepwa.layout.app')
@section('title') Vehicle Profile @endsection
@section('heading') Vehicle Profile @endsection

@section('style')
<style>
    .mt5 { margin-top: 55px; }
    .pwa-card { background:#fff; border-radius:16px; padding:20px; box-shadow:0 6px 18px rgba(0,0,0,0.08); margin-bottom:16px; }
    .info-row { display:flex; justify-content:space-between; align-items:flex-start; padding:10px 0; border-bottom:1px solid #f0f0f0; gap:8px; }
    .info-row:last-child { border-bottom:none; }
    .info-label { font-size:13px; color:#888; font-weight:500; min-width:120px; }
    .info-value { font-size:14px; color:#222; font-weight:600; text-align:right; word-break:break-word; }
    .section-heading { font-size:13px; font-weight:700; color:#2a5780; text-transform:uppercase; letter-spacing:.6px; margin-bottom:14px; display:flex; align-items:center; gap:7px; }
    .photo-thumb { width:100px; height:100px; object-fit:cover; border-radius:12px; border:1.5px solid #c6d4e8; }
    .qr-thumb { width:180px; max-width:100%; border-radius:12px; border:1.5px solid #c6d4e8; background:#fff; padding:10px; }
    .btn-open { display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:10px 16px; background:#e8f0f8; color:#2a5780; border-radius:10px; font-size:14px; font-weight:600; text-decoration:none; border:1.5px solid #c6d4e8; margin-top:10px; }
    .btn-open:hover { background:#d0e2f5; color:#2a5780; }
</style>
@endsection

@section('content')
<div class="container mt5">

    <div class="pwa-card">
        <div class="section-heading"><i class="bi bi-truck"></i> Vehicle Information</div>
        <div class="info-row"><span class="info-label">Vehicle Number</span><span class="info-value">{{ $vehicle->vehicle_number }}</span></div>
        <div class="info-row"><span class="info-label">Vehicle Type</span><span class="info-value">{{ $vehicle->vehicle_type }}</span></div>
        <div class="info-row"><span class="info-label">Capacity</span><span class="info-value">{{ $vehicle->capacity }}</span></div>
        <div class="info-row"><span class="info-label">Ward</span><span class="info-value">{{ $vehicle->ward?->name ?? '-' }}</span></div>
        <div class="info-row"><span class="info-label">Corporation</span><span class="info-value">{{ $vehicle->ward?->constituency?->zone?->corporation?->name ?? '-' }}</span></div>
        <div class="info-row"><span class="info-label">Status</span><span class="info-value">{{ ucfirst($vehicle->status) }}</span></div>
    </div>

    <div class="pwa-card">
        <div class="section-heading"><i class="bi bi-person-circle"></i> Owner & Driver</div>
        <div class="info-row"><span class="info-label">Owner Name</span><span class="info-value">{{ $vehicle->user?->name ?? '-' }}</span></div>
        <div class="info-row"><span class="info-label">Owner Mobile</span><span class="info-value">{{ $vehicle->user?->mobile ?? '-' }}</span></div>
        <div class="info-row"><span class="info-label">Owner Email</span><span class="info-value">{{ $vehicle->user?->email ?? '-' }}</span></div>
        <div class="info-row"><span class="info-label">Driver Name</span><span class="info-value">{{ $vehicle->driver_name ?? '-' }}</span></div>
        <div class="info-row"><span class="info-label">Driver Mobile</span><span class="info-value">{{ $vehicle->driver_mobile ?? '-' }}</span></div>
        <div class="info-row"><span class="info-label">Driver License</span><span class="info-value">{{ $vehicle->driver_license_number ?? '-' }}</span></div>
    </div>

    <div class="pwa-card">
        <div class="section-heading"><i class="bi bi-qr-code"></i> Vehicle QR Code</div>
        @if($vehicle->qr_code_path)
            <div class="text-center">
                <a href="{{ asset('storage/' . $vehicle->qr_code_path) }}" target="_blank">
                    <img src="{{ asset('storage/' . $vehicle->qr_code_path) }}" alt="Vehicle QR Code" class="qr-thumb">
                </a>
                <div>
                    <a href="{{ route('vehicle.scan', $vehicle) }}" target="_blank" class="btn-open">
                        <i class="bi bi-eye"></i> View Scan Page
                    </a>
                </div>
            </div>
        @else
            <div class="text-muted" style="font-size:13px;">QR code not generated yet.</div>
        @endif
    </div>

    <div class="pwa-card">
        <div class="section-heading"><i class="bi bi-images"></i> Vehicle Photo</div>
        @if($vehicle->vehicle_photo)
            <a href="{{ asset('storage/' . $vehicle->vehicle_photo) }}" target="_blank">
                <img src="{{ asset('storage/' . $vehicle->vehicle_photo) }}" alt="Vehicle Photo" class="photo-thumb">
            </a>
        @else
            <div class="text-muted" style="font-size:13px;">Vehicle photo not available.</div>
        @endif
    </div>

</div>
@endsection
