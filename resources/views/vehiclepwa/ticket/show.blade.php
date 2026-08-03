@extends('vehiclepwa.layout.app')
@section('title') Request {{ $ticket->ticket_number }} @endsection
@section('heading') Request Details @endsection

@section('style')
<style>
    .mt5 { margin-top: 55px; }

    .pwa-card {
        background: #fff;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.08);
        margin-bottom: 16px;
    }

    .info-row {
        display: flex;
        justify-content: start;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 8px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 14px; color: #000; font-weight: 700; min-width: 110px; }
    .info-value { font-size: 14px; color: #222222d1; font-weight: 600; text-align: start; word-break: break-word; }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .s-raised           { background: #e2e3e5; color: #41464b; }
    .s-assigned         { background: #fff3cd; color: #664d03; }
    .s-pickup_scanned   { background: #fde8d8; color: #7d3c0f; }
    .s-pickup_submitted { background: #d6f0ff; color: #0b4a6e; }
    .s-ready_to_dump    { background: #e2d9f3; color: #4b2e83; }
    .s-dump_submitted   { background: #fff3cd; color: #664d03; }
    .s-completed        { background: #d1e7dd; color: #0f5132; }
    .s-cancelled        { background: #f8d7da; color: #842029; }

    .section-heading {
        font-size: 13px;
        font-weight: 700;
        color: #2a5780;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .photo-preview-grid { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
    .photo-thumb {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        border: 1.5px solid #c6d4e8;
    }

    .otp-input {
        width: 100%;
        padding: 14px;
        font-size: 22px;
        font-weight: 700;
        letter-spacing: 10px;
        text-align: center;
        border: 2px solid #c6d4e8;
        border-radius: 12px;
        outline: none;
        transition: border .2s;
    }
    .otp-input:focus { border-color: #2a5780; }

    .btn-pwa-primary {
        width: 100%;
        padding: 14px;
        background: #2a5780;
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        transition: background .2s;
        margin-top: 12px;
    }
    .btn-pwa-primary:hover { background: #1f4060; color: #fff; }

    .btn-pwa-success {
        width: 100%;
        padding: 14px;
        background: #198754;
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background .2s;
        margin-top: 12px;
    }
    .btn-pwa-success:hover { background: #146c43; }

    .btn-pwa-secondary {
        width: 100%;
        padding: 14px;
        background: #f0f4fa;
        color: #2a5780;
        border: 1.5px solid #c6d4e8;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: background .2s, border-color .2s;
        margin-top: 12px;
    }
    .btn-pwa-secondary:hover { background: #e6edf7; border-color: #2a5780; }

    .btn-directions {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 16px;
        background: #e8f0f8;
        color: #2a5780;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        border: 1.5px solid #c6d4e8;
        margin-top: 8px;
    }
    .btn-directions:hover { background: #d0e2f5; color: #2a5780; }

    #qr-reader { width: 100%; border-radius: 12px; overflow: hidden; border: 2px dashed #2a5780; }

    .section-label {
        font-size: 12px;
        font-weight: 600;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        margin-top: 14px;
    }

    .date-tab-group { display: flex; gap: 10px; margin-bottom: 4px; }
    .date-tab {
        flex: 1;
        padding: 10px 6px;
        border: 1.5px solid #c6d4e8;
        border-radius: 10px;
        background: #f5f8ff;
        font-size: 13px;
        font-weight: 600;
        color: #2a5780;
        text-align: center;
        cursor: pointer;
        transition: background 0.2s, border-color 0.2s;
    }
    .date-tab:hover, .date-tab.active {
        background: #2a5780;
        border-color: #2a5780;
        color: #fff;
    }

    .time-input {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1.5px solid #c6d4e8;
        border-radius: 10px;
        outline: none;
        color: #2a5780;
        font-weight: 600;
        transition: border 0.2s;
    }
    .time-input:focus { border-color: #2a5780; }

    .accept-btn {
        width: 100%;
        padding: 14px;
        background: #198754;
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        margin-top: 14px;
        cursor: pointer;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .accept-btn:hover { background: #146c43; }
    .accept-btn:disabled { background: #adb5bd; cursor: not-allowed; }

    .qty-input {
        width: 100%;
        padding: 13px 16px;
        font-size: 18px;
        font-weight: 700;
        border: 2px solid #c6d4e8;
        border-radius: 12px;
        outline: none;
        color: #2a5780;
        transition: border .2s;
        text-align: center;
    }
    .qty-input:focus { border-color: #2a5780; }
    .qty-hint {
        font-size: 12px;
        color: #aaa;
        text-align: center;
        margin-top: 5px;
    }
    .qty-estimated {
        background: #f0f4fa;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        color: #2a5780;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
    }
</style>
@endsection

@section('content')
<div class="container mt5">

@php
    $status = $ticket->status;
    $displayQuantity = (float) ($ticket->estimated_quantity ?? $ticket->unauthorizedWaste?->estimated_weight ?? 0);
            $statusLabels = [
            'raised' => 'Raised',
            'pending_fo_verification' => 'Field Officer Verification Pending',
            'pending_user_acceptance_fo' => 'Action Required (Notice)',
            'pending_user_acceptance_agm' => 'Action Required (AGM)',
            'payment_pending' => 'Payment Pending',
            'verified' => 'Verified',
            'assigned' => 'Pickup Assigned',
            'pickup_scanned' => 'Pickup QR Scanned',
            'pickup_submitted' => 'Plant Approval Pending',
            'ready_to_dump' => 'Ready To Dump',
            'dump_submitted' => 'Plant Approval Pending',
            'completed' => 'Approved by Plant',
            'cancelled' => 'Cancelled',
            'overdue' => 'Overdue',
            'pending_pickup' => 'Delayed - Pickup Pending',
        ];

    $statusLabel = $statusLabels[$status] ?? ucwords(str_replace('_', ' ', $status));
@endphp

@if($status === 'raised')
    <div class="pwa-card">
        <div class="section-heading"><i class="bi bi-calendar-check"></i> Accept & Schedule Pickup</div>
        <p style="font-size:13px;color:#666;margin-bottom:4px;">
            Choose a pickup date and time to accept this request.
        </p>

        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-3" style="font-size:13px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('vehicle.tickets.accept', $ticket) }}" id="accept-form">
            @csrf
            <input type="hidden" name="scheduled_date" id="input-date">
            <input type="hidden" name="scheduled_time" id="input-time">

            <div class="section-label">Select pickup date</div>
            <div class="date-tab-group">
                <button type="button" class="date-tab" data-date="{{ now()->toDateString() }}">
                    Today<br>
                    <span style="font-weight:400;font-size:12px;">{{ now()->format('D, d M') }}</span>
                </button>
                <button type="button" class="date-tab" data-date="{{ now()->addDay()->toDateString() }}">
                    Tomorrow<br>
                    <span style="font-weight:400;font-size:12px;">{{ now()->addDay()->format('D, d M') }}</span>
                </button>
                <button type="button" class="date-tab" data-date="{{ now()->addDays(2)->toDateString() }}">
                    Day after<br>
                    <span style="font-weight:400;font-size:12px;">{{ now()->addDays(2)->format('D, d M') }}</span>
                </button>
            </div>

            <div class="section-label">Select time</div>
            <input type="time" id="time-picker" class="time-input" >

            <button type="submit" class="accept-btn" id="accept-btn" disabled>
                <i class="bi bi-check-lg"></i> Accept &amp; Schedule
            </button>
        </form>
    </div>
@endif

@if($status === 'assigned')
    <div class="pwa-card">
        <div class="section-heading"><i class="bi bi-box-arrow-up"></i><b> Pickup Form</b> </div>
        <p style="font-size:13px;color:#666;margin-bottom:14px;">
            Add proof photos and submit to confirm pickup.
        </p>

        <form method="POST" class="needs-validation" novalidate
              action="{{ route('vehicle.tickets.pickup.submit', $ticket) }}"
              enctype="multipart/form-data">
            @csrf

         

            <label style="font-size:13px;font-weight:600;color:#444;display:block;margin:14px 0 6px;">
                Waste photos <span style="color:#e53935">*</span>
            </label>
            @error('photos')
                <div class="text-danger mb-2" style="font-size:12px;">{{ $message }}</div>
            @enderror
            <input type="file" name="photos[]" id="pickup-photos"
                   accept="image/*" capture="environment" multiple required style="display:none"
                   onchange="previewPhotos(this, 'pickup-preview')">
            <button type="button"
                    onclick="document.getElementById('pickup-photos').click()"
                    class="btn-pwa-primary"
                    style="background:#f0f4fa;color:#2a5780;border:1.5px dashed #2a5780;margin-top:0;">
                <i class="bi bi-camera"></i> Add Photos
            </button>
           
            <div class="photo-preview-grid" id="pickup-preview"></div>
 <div class="invalid-feedback">
                Please provide at least one photo.
            </div>
            <label style="font-size:13px;font-weight:600;color:#444;display:block;margin:14px 0 6px;">
                Remarks (optional)
            </label>
            <textarea name="remarks" rows="2"
                      style="width:100%;border:1.5px solid #c6d4e8;border-radius:10px;padding:10px;font-size:14px;resize:none;outline:none;"
                      placeholder="Any notes...">{{ old('remarks') }}</textarea>

            <button type="submit" class="btn-pwa-success">
                <i class="bi bi-send"></i> Submit Pickup
            </button>
        </form>
    </div>
@endif

<div class="pwa-card">
    <div class="section-heading"><i class="bi bi-ticket-detailed"></i> Request Info</div>

    <div class="info-row">
        <span class="info-label">Request #</span>
        <span class="info-value">{{ $ticket->ticket_number }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Owner</span>
        <span class="info-value">{{ $ticket->user?->name ?? '-' }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Mobile</span>
        <span class="info-value">{{ $ticket->user?->mobile ?? '-' }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Address</span>
        <span class="info-value">{{ $ticket->site_address ?? '-' }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Plant</span>
        <span class="info-value">{{ $ticket->plant?->name ?? '-' }}</span>
    </div>
    <div class="info-row">
        <span class="info-label">Scheduled</span>
        <span class="info-value">
            @if($ticket->scheduled_date)
                {{ \Carbon\Carbon::parse($ticket->scheduled_date)->format('d M Y') }}
                {{ $ticket->scheduled_time ? ' - ' . \Carbon\Carbon::parse($ticket->scheduled_time)->format('h:i A') : '' }}
            @else
                Awaiting acceptance
            @endif
        </span>
    </div>
    <div class="info-row">
        <span class="info-label">Status</span>
        <span class="info-value">
            <span class="status-badge s-{{ $status }}">{{ $statusLabel }}</span>
        </span>
    </div>

    @if($ticket->latitude && $ticket->longitude)
        <a href="https://www.google.com/maps?q={{ $ticket->latitude }},{{ $ticket->longitude }}"
           target="_blank" class="btn-directions">
            <i class="bi bi-geo-alt-fill"></i> Get Directions
        </a>
    @endif
</div>

@php 
    $sitePhotos = $ticket->photos->where('type', 'pickup_request'); 
    // Include unauthorized waste report photo if exists
    if ($ticket->unauthorizedWaste && $ticket->unauthorizedWaste->photo_path) {
        $sitePhotos = $sitePhotos->concat([ (object)['photo_path' => $ticket->unauthorizedWaste->photo_path] ]);
    }
@endphp
@if($sitePhotos->isNotEmpty())
    <div class="pwa-card">
        <div class="section-heading"><i class="bi bi-images"></i> Site Photos</div>
        <div class="photo-preview-grid">
            @foreach($sitePhotos as $photo)
                <a href="{{ asset('storage/' . $photo->photo_path) }}" target="_blank">
                    <img src="{{ asset('storage/' . $photo->photo_path) }}" class="photo-thumb">
                </a>
            @endforeach
        </div>
    </div>
@endif

@if($status !== 'raised')
    @php $pickupPhotos = $ticket->photos->where('type', 'pickup_proof'); @endphp
    @if($pickupPhotos->isNotEmpty())
        <div class="pwa-card">
            <div class="section-heading"><i class="bi bi-images"></i> Pickup Proof Photos</div>
            <div class="photo-preview-grid">
                @foreach($pickupPhotos as $photo)
                    <a href="{{ asset('storage/' . $photo->photo_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" class="photo-thumb">
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endif

</div>
@endsection

@section('script')
<script>

@if($status === 'raised')
var inputDate = document.getElementById('input-date');
var inputTime = document.getElementById('input-time');
var timePicker = document.getElementById('time-picker');
var acceptBtn = document.getElementById('accept-btn');

function updateAcceptBtn() {
    acceptBtn.disabled = !(inputDate.value && inputTime.value);
}

document.querySelectorAll('.date-tab').forEach(function (tab) {
    tab.addEventListener('click', function () {
        document.querySelectorAll('.date-tab').forEach(function (t) { t.classList.remove('active'); });
        tab.classList.add('active');
        inputDate.value = tab.dataset.date;
        updateAcceptBtn();
    });
});

timePicker.addEventListener('change', function () {
    inputTime.value = timePicker.value;
    updateAcceptBtn();
});

document.getElementById('accept-form').addEventListener('submit', function (e) {
    if (!inputDate.value || !inputTime.value) {
        e.preventDefault();
        alert('Please select both a date and a time.');
        return;
    }

    const todayStr = new Date().toISOString().split('T')[0];
    if (inputDate.value === todayStr) {
        const now = new Date();
        const scheduled = new Date(todayStr + ' ' + inputTime.value);
        const minTime = new Date(now.getTime() + (60 * 60 * 1000)); // 1 hour buffer

        if (scheduled < minTime) {
            e.preventDefault();
            alert('For today\'s pickup, please schedule at least 1 hour from now.');
        }
    }
});
@endif

function previewPhotos(input, previewId) {
    var grid = document.getElementById(previewId);
    grid.innerHTML = '';
    Array.from(input.files).forEach(function (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'photo-thumb';
            grid.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

document.querySelectorAll('.dim-input').forEach(function(input) {
    input.addEventListener('input', function() {
        let l = parseFloat(document.querySelector('input[name="actual_length"]').value) || 0;
        let b = parseFloat(document.querySelector('input[name="actual_breadth"]').value) || 0;
        let h = parseFloat(document.querySelector('input[name="actual_height"]').value) || 0;
        let weight = (l * b * h) / 3;
        document.getElementById('calc-weight-display').textContent = weight.toFixed(2) + ' tons';
    });
});
</script>
@endsection
