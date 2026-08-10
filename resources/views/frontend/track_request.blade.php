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

/* Track Search Input */
.search-ui {
    padding: 6px 10px;
    border: 1px solid var(--line);
    border-radius: 8px;
    display: flex;
    gap: 12px;
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
}

.search-ui input {
    border: 0;
    flex: 1;
    font-size: 14px;
    height: 42px;
    padding: 0 14px;
    outline: none;
}

.search-ui .btn-ui {
    padding: 10px 32px;
}

/* Status Card */
.track-box {
    margin-top: 10px;
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

/* Status Flow Stepper */
.status-flow {
    display: flex;
    justify-content: space-between;
    text-align: center;
    position: relative;
    margin: 32px 0 28px;
    padding: 0 10px;
}

.status-flow::before {
    content: '';
    position: absolute;
    top: 18px;
    left: 8%;
    right: 8%;
    height: 3px;
    background: #e4e9e6;
    z-index: 1;
}

.status-flow-line-fill {
    position: absolute;
    top: 18px;
    left: 8%;
    height: 3px;
    background: var(--green);
    z-index: 1;
    transition: width 0.3s ease;
}

.status-flow span {
    font-size: 11px;
    font-weight: 700;
    z-index: 2;
    background: #ffffff;
    padding: 0 6px;
    min-width: 75px;
    color: var(--muted);
}

.status-flow span::before {
    content: '✓';
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--green);
    color: #ffffff;
    font-size: 13px;
    margin: 0 auto 8px;
    box-shadow: 0 2px 6px rgba(8, 125, 69, 0.2);
}

.status-flow span.pending-step::before {
    content: '•';
    background: #ffffff;
    border: 2px solid #aebbb4;
    color: var(--muted);
    box-shadow: none;
}

.status-flow span.active-stage::before {
    content: '🚚';
    background: var(--green);
    color: #ffffff;
    font-size: 14px;
}

.status-flow span.completed {
    color: var(--ink);
}

/* Facts Grid */
.facts {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
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

.btn-ui {
    border: 0;
    border-radius: 6px;
    background: var(--green);
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 700;
    padding: 12px 28px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s ease, transform 0.1s ease;
    box-shadow: 0 3px 10px rgba(8, 125, 69, 0.2);
}

.btn-ui:hover {
    background: var(--green-dark);
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .facts { grid-template-columns: 1fr 1fr; }
    .status-flow { overflow-x: auto; justify-content: flex-start; gap: 16px; padding-bottom: 8px; }
    .status-flow::before, .status-flow-line-fill { display: none; }
}
</style>

<main class="request-ui">
    <div class="crumb"><a href="{{ url('/') }}">Home</a> / Track Request</div>
    <h1>Track Your Request</h1>

    <!-- Search Form -->
    <form action="{{ route('citizen.track') }}" method="GET" class="search-ui">
        <input type="text" name="id" id="trackInput" 
               placeholder="Enter Request ID (e.g. #DCL-2026-000001) or Mobile Number" 
               value="{{ request('id') ?? request('query') ?? ($wasteRequest?->request_number ?? '') }}" required>
        <button type="submit" class="btn-ui">Track</button>
    </form>

    @if($wasteRequest)
        @php
            $status = $wasteRequest->status;
            
            // Stepper logic
            $stepFillWidth = '20%';
            if ($status == 'assigned') $stepFillWidth = '45%';
            elseif ($status == 'picked_up') $stepFillWidth = '70%';
            elseif ($status == 'dumped') $stepFillWidth = '100%';

            $pillMap = [
                'pending' => 'pill-pending',
                'assigned' => 'pill-assigned',
                'picked_up' => 'pill-picked_up',
                'dumped' => 'pill-dumped',
                'rejected' => 'pill-rejected',
            ];
        @endphp

        <div class="card-ui track-box">
            <div class="topline">
                <div>
                    <div class="ref" id="trackReqId">{{ $wasteRequest->request_number }}</div>
                    <div class="sub" id="trackReqDate">
                        Requested on: {{ $wasteRequest->created_at->format('d M Y, h:i A') }}
                    </div>
                    <div class="sub" id="trackCategory">
                        Category: 
                        @if(is_array($wasteRequest->category_ids))
                            {{ implode(', ', $wasteRequest->category_ids) }}
                        @else
                            {{ $wasteRequest->category_ids ?? 'D-Clutter Waste' }}
                        @endif
                    </div>
                </div>
                <span class="pill {{ $pillMap[$status] ?? 'pill-pending' }}">
                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                </span>
            </div>

            <!-- Stepper Progress Flow -->
            <div class="status-flow">
                <div class="status-flow-line-fill" style="width: {{ $stepFillWidth }};"></div>
                
                <span class="completed">Request<br>Submitted</span>
                
                <span class="{{ in_array($status, ['assigned', 'picked_up', 'dumped']) ? 'completed' : ($status == 'pending' ? 'active-stage' : 'pending-step') }}">
                    Verified
                </span>
                
                <span class="{{ in_array($status, ['picked_up', 'dumped']) ? 'completed' : ($status == 'assigned' ? 'active-stage' : 'pending-step') }}">
                    Assigned
                </span>
                
                <span class="{{ $status == 'dumped' ? 'completed' : ($status == 'picked_up' ? 'active-stage' : 'pending-step') }}">
                    Picked Up
                </span>
                
                <span class="{{ $status == 'dumped' ? 'completed active-stage' : 'pending-step' }}">
                    Disposed
                </span>
            </div>

            <!-- Facts Grid -->
            <div class="facts">
                <div>
                    <small>Scheduled Pickup Date</small>
                    <b>{{ $wasteRequest->preferred_pickup_date ? $wasteRequest->preferred_pickup_date->format('d M Y (l)') : 'Sunday Scheduled' }}</b>
                </div>
                <div>
                    <small>Assigned Vehicle</small>
                    <b>
                        @if($wasteRequest->vehicle)
                            {{ $wasteRequest->vehicle->registration_number }}
                        @else
                            Pending Assignment
                        @endif
                    </b>
                </div>
                <div>
                    <small>Driver Details</small>
                    <b>
                        @if($wasteRequest->vehicle?->driver)
                            {{ $wasteRequest->vehicle->driver->name }} ({{ $wasteRequest->vehicle->driver->mobile }})
                        @else
                            Not Assigned
                        @endif
                    </b>
                </div>
                <div>
                    <small>Pickup Address</small>
                    <b>{{ $wasteRequest->house_no }}, {{ Str::limit($wasteRequest->address, 30) }}</b>
                </div>
            </div>

            <div style="margin-top: 20px;">
                <a class="btn-ui" href="{{ route('citizen.details', ['id' => $wasteRequest->request_number]) }}">View Full Details</a>
            </div>
        </div>
    @else
        <div class="card-ui track-box text-center py-5">
            <i class="fa fa-search fa-3x text-muted mb-3"></i>
            <h4 class="fw-bold" style="color: #2c3e50;">No Waste Request Found</h4>
            <p class="text-muted mb-0" style="font-size: 14px;">
                @if($searchId)
                    We couldn't find any request matching "<strong>{{ $searchId }}</strong>". Please double-check your Request ID or Mobile Number.
                @else
                    Enter your Request ID or registered Mobile Number above to track your waste pickup status.
                @endif
            </p>
        </div>
    @endif
</main>
@endsection
