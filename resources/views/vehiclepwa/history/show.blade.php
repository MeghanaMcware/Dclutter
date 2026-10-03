@extends('vehiclepwa.layout.app')

@section('title') Request History Details @endsection
@section('heading') Details @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; }
        .stop-card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 20px; }
        .detail-row {
            margin-bottom: 12px;
        }
        .detail-row label {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            color: #64748b;
            display: block;
            margin-bottom: 2px;
        }
        .detail-row .value {
            font-size: 15px;
            font-weight: 600;
            color: #0f172a;
        }
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        .photo-grid img {
            width: 100%;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">
        @if($wasteRequest)
            <div class="stop-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-secondary mb-1">{{ strtoupper($wasteRequest->status) }}</span>
                        <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-recycle text-success"></i> {{ $wasteRequest->request_number }}</h5>
                    </div>
                </div>

                <div class="detail-row">
                    <label>Applicant Name</label>
                    <div class="value">{{ $wasteRequest->applicant_name }} ({{ $wasteRequest->mobile_number }})</div>
                </div>

                <div class="detail-row">
                    <label>Pickup Address</label>
                    <div class="value">{{ $wasteRequest->house_no }}, {{ $wasteRequest->address }}</div>
                </div>

                <div class="detail-row">
                    <label>Ward / Constituency</label>
                    <div class="value">
                        {{ $wasteRequest->ward ? $wasteRequest->ward->ward_name : 'N/A' }} / 
                        {{ $wasteRequest->constituency ? $wasteRequest->constituency->constituency_name : 'N/A' }}
                    </div>
                </div>

                @if($wasteRequest->approx_weight_kg)
                <div class="detail-row">
                    <label>Collected Weight (Approx)</label>
                    <div class="value">{{ $wasteRequest->approx_weight_kg }} kg</div>
                </div>
                @endif
                
                @if($wasteRequest->picked_up_at)
                <div class="detail-row">
                    <label>Picked Up At</label>
                    <div class="value">{{ \Carbon\Carbon::parse($wasteRequest->picked_up_at)->format('d M Y, h:i A') }}</div>
                </div>
                @endif
            </div>

            <!-- Before Photos -->
            @if(is_array($wasteRequest->before_photos) && count($wasteRequest->before_photos) > 0)
            <div class="stop-card">
                <h6 class="fw-bold mb-0">Before Photos</h6>
                <div class="photo-grid">
                    @foreach($wasteRequest->before_photos as $photo)
                        <img src="{{ asset('storage/' . $photo) }}" alt="Before Photo">
                    @endforeach
                </div>
            </div>
            @endif

            <!-- After Photos -->
            @if(is_array($wasteRequest->after_photos) && count($wasteRequest->after_photos) > 0)
            <div class="stop-card">
                <h6 class="fw-bold mb-0">After Photos</h6>
                <div class="photo-grid">
                    @foreach($wasteRequest->after_photos as $photo)
                        <img src="{{ asset('storage/' . $photo) }}" alt="After Photo">
                    @endforeach
                </div>
            </div>
            @endif

            @if($wasteRequest->dumpRecord)
            <div class="stop-card bg-light">
                <h6 class="fw-bold mb-2">Dump Details</h6>
                <div class="detail-row">
                    <label>Dump Location</label>
                    <div class="value">{{ $wasteRequest->dumpRecord->plant_name ?: 'N/A' }}</div>
                </div>
                <div class="detail-row">
                    <label>Actual Weight</label>
                    <div class="value">{{ $wasteRequest->dumpRecord->dump_weight }} kg</div>
                </div>
                @if($wasteRequest->dumpRecord->dumped_at)
                <div class="detail-row">
                    <label>Dumped At</label>
                    <div class="value">{{ \Carbon\Carbon::parse($wasteRequest->dumpRecord->dumped_at)->format('d M Y, h:i A') }}</div>
                </div>
                @endif
                
                @if($wasteRequest->dumpRecord->remarks)
                <div class="detail-row">
                    <label>Remarks</label>
                    <div class="value">{{ $wasteRequest->dumpRecord->remarks }}</div>
                </div>
                @endif
            </div>

            <!-- Dump Photos -->
            @if(is_array($wasteRequest->dumpRecord->dump_images) && count($wasteRequest->dumpRecord->dump_images) > 0)
            <div class="stop-card">
                <h6 class="fw-bold mb-0">Dump Photos</h6>
                <div class="photo-grid">
                    @foreach($wasteRequest->dumpRecord->dump_images as $photo)
                        <img src="{{ asset('storage/' . $photo) }}" alt="Dump Photo">
                    @endforeach
                </div>
            </div>
            @endif
            @endif
        @else
            <div class="stop-card text-center py-4">
                <h5 class="text-danger fw-bold">Not Found</h5>
                <p class="text-muted small">This request does not exist or you don't have access.</p>
            </div>
        @endif
    </div>
@endsection
