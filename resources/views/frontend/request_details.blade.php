@extends('layouts.app')

@section('content')
<style>
:root {
    --green: #087d45;
    --green-dark: #055a31;
    --green-light: #e8f5ed;
    --ink: #17251d;
    --muted: #64716a;
    --line: #e4e9e6;
}

.request-ui {
    max-width: 1080px;
    margin: 0 auto;
    padding: 30px 20px 50px;
    color: var(--ink);
    font-family: 'Inter', sans-serif;
}

.crumb {
    font-size: 13px;
    color: #738078;
    margin-bottom: 18px;
    font-weight: 500;
}

.crumb a {
    color: #738078;
    text-decoration: none;
}

.crumb a:hover {
    color: var(--green);
}

.request-ui h1 {
    font-size: 26px;
    font-weight: 800;
    margin: 0 0 22px;
    color: var(--ink);
}

.card-ui {
    border: 1px solid var(--line);
    border-radius: 10px;
    padding: 24px;
    background: #ffffff;
    box-shadow: 0 2px 12px rgba(23, 50, 32, 0.04);
}

.topline {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.ref {
    font-size: 18px;
    font-weight: 800;
    color: var(--ink);
}

.sub {
    font-size: 12px;
    color: var(--muted);
    margin-top: 4px;
}

.pill {
    font-size: 11px;
    border-radius: 20px;
    padding: 6px 14px;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-block;
}
.pill-pending { background: #ffebee; color: #f44336; border: 1px solid #ef9a9a; }
.pill-assigned { background: #e3f2fd; color: #2196f3; border: 1px solid #90caf9; }
.pill-picked_up { background: #fff4e5; color: #ff9800; border: 1px solid #ffcc80; }
.pill-dumped { background: #e8f5e9; color: #4caf50; border: 1px solid #a5d6a7; }
.pill-rejected { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

.facts {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    border-top: 1px solid var(--line);
    padding-top: 20px;
    gap: 16px;
}

.facts small {
    display: block;
    color: var(--muted);
    font-size: 11px;
    margin-bottom: 4px;
    font-weight: 500;
}

.facts b {
    font-size: 13px;
    color: var(--ink);
}

.details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.section-label {
    font-size: 15px;
    font-weight: 800;
    margin: 22px 0 12px;
    color: var(--ink);
    border-bottom: 2px solid var(--green-light);
    padding-bottom: 6px;
}

.timeline {
    border-left: 2px solid #cde0d2;
    margin: 16px 0 0 12px;
    padding-left: 22px;
}

.timeline div {
    font-size: 13px;
    position: relative;
    margin: 0 0 20px;
}

.timeline div::before {
    content: '✓';
    position: absolute;
    left: -31px;
    top: 0px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--green);
    color: #ffffff;
    font-size: 10px;
    text-align: center;
    line-height: 18px;
    font-weight: bold;
}

.timeline div.pending::before {
    content: '';
    background: #ffffff;
    border: 2px solid #aebbb4;
}

.timeline b {
    color: var(--ink);
    display: block;
    font-size: 13px;
}

.timeline small {
    display: block;
    font-size: 11px;
    color: var(--muted);
    margin-top: 2px;
}

.photos-gallery {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-top: 14px;
}

.photos-gallery img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid var(--line);
    cursor: pointer;
    transition: transform 0.2s ease;
}

.photos-gallery img:hover {
    transform: scale(1.03);
}

@media (max-width: 768px) {
    .details-grid { grid-template-columns: 1fr; }
    .facts { grid-template-columns: 1fr; }
}
</style>

<main class="request-ui">
    <div class="crumb">
        <a href="{{ url('/') }}">Home</a> / 
        <a href="{{ route('citizen.track', ['id' => $wasteRequest?->request_number]) }}">Track Request</a> / 
        Request Details
    </div>
    <h1>Request Details</h1>

    @if($wasteRequest)
        @php
            $status = $wasteRequest->status;
            $pillMap = [
                'pending' => 'pill-pending',
                'assigned' => 'pill-assigned',
                'picked_up' => 'pill-picked_up',
                'dumped' => 'pill-dumped',
                'rejected' => 'pill-rejected',
            ];
        @endphp

        <div class="details-grid">
            <div class="card-ui">
                <div class="topline">
                    <div>
                        <div class="ref" id="detailsReqId">{{ $wasteRequest->request_number }}</div>
                        <div class="sub" id="detailsReqDate">
                            Requested on: {{ $wasteRequest->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                    <span class="pill {{ $pillMap[$status] ?? 'pill-pending' }}">
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </span>
                </div>

                <div class="facts">
                    <div>
                        <small>Pickup Address</small>
                        <b>{{ $wasteRequest->house_no }}, {{ $wasteRequest->address }} (Pincode: {{ $wasteRequest->pincode }})</b>
                    </div>
                    <div>
                        <small>Waste Categories</small>
                        <b>
                            @if(is_array($wasteRequest->category_ids))
                                {{ implode(', ', $wasteRequest->category_ids) }}
                            @else
                                {{ $wasteRequest->category_ids ?? 'D-Clutter Waste' }}
                            @endif
                        </b>
                    </div>
                    <div>
                        <small>Ward &amp; Zone</small>
                        <b>
                            {{ $wasteRequest->ward ? ($wasteRequest->ward->name . ' (Ward ' . $wasteRequest->ward->ward_number . ')') : 'N/A' }} 
                            - {{ $wasteRequest->constituency?->name ?? 'N/A' }}
                        </b>
                    </div>
                    <div>
                        <small>Corporation</small>
                        <b>{{ $wasteRequest->corporation?->name ?? ($wasteRequest->ward?->constituency?->corporation?->name ?? 'N/A') }}</b>
                    </div>
                    <div>
                        <small>Scheduled Pickup Date</small>
                        <b>{{ $wasteRequest->preferred_pickup_date ? $wasteRequest->preferred_pickup_date->format('d M Y (l)') : 'Sunday Scheduled' }}</b>
                    </div>
                    <div>
                        <small>Landmark</small>
                        <b>{{ $wasteRequest->landmark ?? 'N/A' }}</b>
                    </div>
                </div>

                <div class="section-label">Status Timeline</div>
                <div class="timeline">
                    <div>
                        <b>Request Submitted</b>
                        <small>{{ $wasteRequest->created_at->format('d M Y, h:i A') }}</small>
                    </div>
                    
                    <div class="{{ in_array($status, ['assigned', 'picked_up', 'dumped']) ? '' : 'pending' }}">
                        <b>Verified &amp; Processed</b>
                        <small>{{ in_array($status, ['assigned', 'picked_up', 'dumped']) ? 'Verified by BBMP Team' : 'Processing verification' }}</small>
                    </div>
                    
                    <div class="{{ in_array($status, ['assigned', 'picked_up', 'dumped']) ? '' : 'pending' }}">
                        <b>Assigned to Vehicle</b>
                        <small>
                            @if($wasteRequest->vehicle)
                                {{ $wasteRequest->vehicle->registration_number }} ({{ $wasteRequest->vehicle->driver?->name ?? 'Driver' }})
                            @else
                                Pending vehicle assignment
                            @endif
                        </small>
                    </div>
                    
                    <div class="{{ in_array($status, ['picked_up', 'dumped']) ? '' : 'pending' }}">
                        <b>On the Way / Picked Up</b>
                        <small>{{ in_array($status, ['picked_up', 'dumped']) ? 'Picked up from location' : 'Pending pickup' }}</small>
                    </div>
                    
                    <div class="{{ $status == 'dumped' ? '' : 'pending' }}">
                        <b>Disposed &amp; Dumped</b>
                        <small>{{ $status == 'dumped' ? 'Dumped at processing facility' : 'Pending completion' }}</small>
                    </div>
                </div>
            </div>

            <!-- Evidence Photos Card -->
            <div class="card-ui">
                <div class="section-label" style="margin-top: 0;">Uploaded Waste Photos</div>
                <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px;">
                    Digital photo evidence uploaded during request submission:
                </p>
                
                @if(is_array($wasteRequest->waste_images) && count($wasteRequest->waste_images) > 0)
                    <div class="photos-gallery">
                        @foreach($wasteRequest->waste_images as $index => $imgPath)
                            <img src="{{ Str::startsWith($imgPath, 'http') ? $imgPath : asset('storage/' . $imgPath) }}" 
                                 alt="Waste Photo {{ $index + 1 }}" 
                                 onclick="window.open(this.src, '_blank')"
                                 onerror="this.src='https://placehold.co/400x300?text=Waste+Image'">
                        @endforeach
                    </div>
                @else
                    <div class="p-4 border rounded text-center bg-light mt-3">
                        <i class="fa fa-image fa-3x text-muted mb-2"></i>
                        <p class="text-muted mb-0" style="font-size: 13px;">No waste photos uploaded for this request.</p>
                    </div>
                @endif
                
                <div class="mt-4 pt-3 border-top">
                    <a href="{{ route('citizen.track', ['id' => $wasteRequest->request_number]) }}" class="btn-ui w-100 text-center">
                        <i class="fa fa-arrow-left me-1"></i> Back to Track Request
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="card-ui text-center py-5">
            <i class="fa fa-search fa-3x text-muted mb-3"></i>
            <h4 class="fw-bold" style="color: #2c3e50;">Request Details Not Found</h4>
            <p class="text-muted mb-0" style="font-size: 14px;">
                We couldn't find any request matching "<strong>{{ $reqId }}</strong>".
            </p>
            <div class="mt-4">
                <a href="{{ route('citizen.track') }}" class="btn-ui">Return to Track Request</a>
            </div>
        </div>
    @endif
</main>
@endsection
