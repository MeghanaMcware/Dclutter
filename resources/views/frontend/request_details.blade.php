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
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 14px;
}

.photos-gallery img {
    width: 100%;
    height: 110px;
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
    .facts { grid-template-columns: 1fr 1fr; }
}
</style>

@section('content')
<main class="request-ui">
    <div class="crumb"><a href="{{ url('/') }}">Home</a> / <a href="{{ route('citizen.track') }}">Track Request</a> / Request Details</div>
    <h1>Request Details</h1>

    <div class="details-grid">
        <div class="card-ui">
            <div class="topline">
                <div>
                    <div class="ref" id="detailsReqId">{{ request('id', 'DCL-2025-000123') }}</div>
                    <div class="sub" id="detailsReqDate">Requested on: 23 May 2025, 10:30 AM</div>
                </div>
                <span class="pill">In Progress</span>
            </div>

            <div class="facts" style="grid-template-columns: 1fr 1fr; margin-top: 16px;">
                <div>
                    <small>Pickup Location</small>
                    <b id="detailsAddress">123, 1st Cross, Kanamangala 6th Block, Bengaluru, Karnataka - 560064</b>
                </div>
                <div>
                    <small>Waste Details</small>
                    <b id="detailsWasteType">Bricks / Concrete</b>
                </div>
                <div>
                    <small>Ward &amp; Zone</small>
                    <b id="detailsWard">Ward 95 - South Zone</b>
                </div>
                <div>
                    <small>Estimated Quantity</small>
                    <b id="detailsQuantity">2.5 Ton</b>
                </div>
                <div>
                    <small>Preferred Date</small>
                    <b id="detailsPrefDate">23 May 2025</b>
                </div>
                <div>
                    <small>Description</small>
                    <b id="detailsDesc">Renovation debris</b>
                </div>
            </div>

            <div class="section-label">Status Timeline</div>
            <div class="timeline">
                <div>
                    <b>Request Submitted</b>
                    <small id="timelineSubDate">23 May 2025, 10:30 AM</small>
                </div>
                <div>
                    <b>Verified</b>
                    <small>23 May 2025, 10:45 AM</small>
                </div>
                <div>
                    <b>Assigned to Contractor</b>
                    <small>23 May 2025, 11:15 AM</small>
                </div>
                <div>
                    <b>On the Way / Pickup</b>
                    <small>23 May 2025, 01:45 PM</small>
                </div>
                <div class="pending">
                    <b style="color: var(--muted);">Disposed &amp; Recycled</b>
                    <small>Pending completion</small>
                </div>
            </div>
        </div>

        <div class="card-ui">
            <div class="section-label" style="margin-top: 0;">Evidence Photos</div>
            <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px;">
                Digital proof uploaded for site inspection and transport verification:
            </p>
            <div class="photos-gallery">
                <img src="{{ asset('frontendwebsite/img/candd_new_image.png') }}" alt="Waste Debris Photo 1" onclick="openPhotoModal(this.src)">
                <img src="{{ asset('frontendwebsite/img/candd_new_image.png') }}" alt="Waste Debris Photo 2" onclick="openPhotoModal(this.src)">
                <img src="{{ asset('frontendwebsite/img/candd_new_image.png') }}" alt="Waste Debris Photo 3" onclick="openPhotoModal(this.src)">
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof hideLoader === 'function') hideLoader();

    const searchId = new URLSearchParams(window.location.search).get('id') || 'DCL-2025-000123';
    const saved = JSON.parse(localStorage.getItem('dclutter_requests') || '[]');
    const found = saved.find(r => r.id === searchId);

    if (found) {
        document.getElementById('detailsReqId').innerText = found.id;
        document.getElementById('detailsReqDate').innerText = `Requested on: ${found.dateSubmitted}`;
        document.getElementById('detailsAddress').innerText = `${found.address}, Pincode: ${found.pincode}`;
        document.getElementById('detailsWasteType').innerText = found.wasteType;
        document.getElementById('detailsWard').innerText = found.ward;
        document.getElementById('detailsQuantity').innerText = found.quantity;
        document.getElementById('detailsPrefDate').innerText = found.prefDate;
        document.getElementById('detailsDesc').innerText = found.description || 'N/A';
        document.getElementById('timelineSubDate').innerText = found.dateSubmitted;
    }
});

function openPhotoModal(src) {
    window.open(src, '_blank');
}
</script>
@endsection
