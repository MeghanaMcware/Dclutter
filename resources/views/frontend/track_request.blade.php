@extends('layouts.app')

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
    padding: 10px;
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
    background: #e3f3e8;
    color: var(--green);
    border-radius: 20px;
    padding: 6px 14px;
    font-weight: 700;
    border: 1px solid #bce4c8;
}

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
    width: 60%;
    height: 3px;
    background: var(--green);
    z-index: 1;
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

.status-flow span.pending-last::before {
    content: '5';
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

@section('content')
<main class="request-ui">
    <div class="crumb"><a href="{{ url('/') }}">Home</a> / Track Request</div>
    <h1>Track Your Request</h1>

    <div class="search-ui">
        <input type="text" id="trackInput" placeholder="Enter Request ID (e.g. DCL-2025-000123) or Mobile Number" value="{{ request('id', 'DCL-2025-000123') }}">
        <button class="btn-ui" onclick="doTrackSearch()">Track</button>
    </div>

    <div class="card-ui track-box">
        <div class="topline">
            <div>
                <div class="ref" id="trackReqId">{{ request('id', 'DCL-2025-000123') }}</div>
                <div class="sub" id="trackReqDate">Requested on: 23 May 2025, 10:30 AM</div>
                <div class="sub" id="trackCategory">Category: D-Clutter Rubble</div>
            </div>
            <span class="pill" id="trackStatusPill">In Progress</span>
        </div>

        <div class="status-flow">
            <div class="status-flow-line-fill"></div>
            <span class="completed">Request<br>Submitted</span>
            <span class="completed">Verified</span>
            <span class="completed">Assigned</span>
            <span class="completed active-stage">Pickup</span>
            <span class="pending-last">Disposed</span>
        </div>

        <div class="facts">
            <div>
                <small>Estimated Pickup Time</small>
                <b>Today, 2:00 PM – 4:00 PM</b>
            </div>
            <div>
                <small>Assigned Contractor</small>
                <b id="trackContractor">GreenBuild Infra Solutions</b>
            </div>
            <div>
                <small>Vehicle No.</small>
                <b id="trackVehicle">KA 01 AB 1234</b>
            </div>
            <div>
                <small>Driver Contact</small>
                <b>+91 98765 43210</b>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <a class="btn-ui" id="viewDetailsBtn" href="{{ route('citizen.details') }}?id={{ request('id', 'DCL-2025-000123') }}">View Details</a>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof hideLoader === 'function') hideLoader();

    // Check if matching record in localStorage
    const searchId = new URLSearchParams(window.location.search).get('id') || 'DCL-2025-000123';
    const saved = JSON.parse(localStorage.getItem('dclutter_requests') || '[]');
    const found = saved.find(r => r.id === searchId);

    if (found) {
        document.getElementById('trackReqId').innerText = found.id;
        document.getElementById('trackReqDate').innerText = `Requested on: ${found.dateSubmitted}`;
        document.getElementById('trackCategory').innerText = `Category: D-Clutter (${found.wasteType})`;
        document.getElementById('viewDetailsBtn').href = `{{ route('citizen.details') }}?id=${found.id}`;
    }
});

function doTrackSearch() {
    const val = document.getElementById('trackInput').value.trim();
    if (!val) return;
    if (typeof showLoader === 'function') {
        showLoader('Tracking request status...');
    }
    setTimeout(() => {
        window.location.href = `{{ route('citizen.track') }}?id=${encodeURIComponent(val)}`;
    }, 400);
}
</script>
@endsection
