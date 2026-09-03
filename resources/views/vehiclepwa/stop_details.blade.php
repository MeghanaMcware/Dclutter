@extends('vehiclepwa.layout.app')

@section('title') Stop Details @endsection
@section('heading') Stop Details @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }
        .stop-card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .btn-action { width: 100%; height: 48px; background: var(--primary-green); color: #fff; border: none; border-radius: 12px; font-size: 15px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">
        @if($wasteRequest)
            <div class="stop-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-success mb-1">{{ strtoupper($wasteRequest->status) }}</span>
                        <h5 class="fw-bold text-dark mb-0">{{ $wasteRequest->request_number }}</h5>
                    </div>
                    <a href="tel:{{ $wasteRequest->mobile_number }}" class="btn btn-outline-success btn-sm">
                        <i class="fa-solid fa-phone"></i> Call
                    </a>
                </div>

                <div class="mb-3">
                    <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 11px;">Applicant Name</small>
                    <strong class="text-dark">{{ $wasteRequest->applicant_name }}</strong>
                </div>

                <div class="mb-3">
                    <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 11px;">Pickup Address</small>
                    <p class="text-dark mb-0 small">{{ $wasteRequest->house_no }}, {{ $wasteRequest->address }}</p>
                </div>

                <div class="mb-3">
                    <small class="text-muted text-uppercase fw-bold d-block" style="font-size: 11px;">Category</small>
                    <strong class="text-dark small">
                        {{ is_array($wasteRequest->category_ids) ? implode(', ', $wasteRequest->category_ids) : ($wasteRequest->category_ids ?? 'N/A') }}
                    </strong>
                </div>
            </div>

            <a href="{{ route('vehicle.before_pickup', ['id' => $wasteRequest->id]) }}" class="btn-action">
                <i class="fa-solid fa-camera"></i> Start Pickup (Step 1)
            </a>
        @else
            <div class="stop-card text-center py-4">
                <p class="text-muted mb-0">No assigned request found.</p>
            </div>
        @endif
    </div>
@endsection
