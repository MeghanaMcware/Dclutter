@extends('vehiclepwa.layout.app')

@section('title') Log Waste Pickup @endsection
@section('heading', 'Pickup Form')


@section('style')
<style>
.form-label {
    font-size: 13px !important;
    font-weight: 500 !important;
    color: black !important;
    margin-bottom: 0px !important;
}

.form-control {
    font-size: 13px !important;
    line-height: 2.0 !important;
    border-radius: 7px !important;
}

.form-select {
    font-size: 13px !important;
    line-height: 2.0 !important;
    border-radius: 7px !important;
}

.invalid-feedback {
    font-size: 12px;
}

.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #dc3545;
}

.was-validated .form-control:invalid,
.was-validated .form-select:invalid {
    border-color: #dc3545;
}

.alert-dismissible .btn-close {
    top: 11px !important;
    right: -25px !important;
}

.theme-light #preloader {
    background-color: #004f7978 !important;
}

.alert-dismissible .btn-close {
    top: 8px !important;
    right: -30px !important;
}

/* Tonnage field is read-only by design: value can only be set via the quick-select buttons */
#tonnage[readonly] {
    background-color: #ffffff !important;
    cursor: pointer;
}
</style>
@endsection

@section('content')
<div class="container py-3">

    <div class="card border-0 shadow-sm rounded-3">

        <div class="card-body p-2">

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show py-2 px-3 mb-3" role="alert">
                <strong class="d-block"><i class="bi bi-exclamation-triangle-fill me-1"></i> Capacity Limit
                    Exceeded!</strong>
                <small>{{ session('error') }}</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @php
            $maxCap = (float)($vehicle->capacity ?? 10.0);
            $currWt = (float)$activeLoad;
            $remCap = max(0.0, round($maxCap - $currWt, 2));
            $capPct = min(100, round(($currWt / $maxCap) * 100, 1));
            @endphp

            <div class="p-3 bg-light border rounded-3 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-bold text-secondary" style="line-height: 17px;
    color: black !important;">Vehicle {{ $vehicle->vehicle_number }}<br> capacity</span>
                    <strong class="small text-primary" style="line-height: 17px !important;">{{ $currWt }} T /
                        {{ $maxCap }} T Max<br> ({{ $remCap }} T Remaining)</strong>
                </div>
                <div class="progress" style="height: 8px;border-radius:5px !important">
                    <div class="progress-bar {{ $capPct >= 90 ? 'bg-danger' : 'bg-primary' }}"
                        style="width: {{ $capPct }}%"></div>
                </div>
            </div>

            <form action="{{ route('vehicle.pickup.store') }}" method="POST" enctype="multipart/form-data"
                id="pickupForm" class="needs-validation" novalidate>
                @csrf

                {{-- Auto-Bound Pickup Source (No Dropdown Needed) --}}
                @php
                $selectedCr = $citizenRequests->firstWhere('id', $selectedRequestId) ?? $citizenRequests->first();
                $selectedWt = $wasteTasks->firstWhere('id', $selectedTaskId) ?? ($selectedCr ? null :
                $wasteTasks->first());
                @endphp

                @if($selectedCr)
                <input type="hidden" name="citizen_request_id" value="{{ $selectedCr->id }}">
                <div class="p-3 bg-light border rounded-3 mb-3 border-start border-4 border-primary shadow-sm">
                    <h4 class="text-dark d-block font-12 text-uppercase fw-bold"><b><i
                                class="bi bi-geo-alt-fill text-primary me-1"></i>Pickup Source (Accepted Request)</b>
                    </h4>
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        <strong class="text-dark font-14">Citizen Request
                            #{{ $selectedCr->request_number ?? $selectedCr->id }}</strong>
                        <span class="badge bg-primary px-2 py-1">{{ $selectedCr->remaining_weight }} Tons</span>
                    </div>
                    <div class="small text-secondary mt-1 d-flex flex-row gap-1 align-items-center  flex-wrap">
                        <span class="font-14 text-dark">
                            <i class="fa fa-user"></i> <strong>{{ $selectedCr->citizen_name }}</strong>
                        </span>
                        <span class="d-flex flex-column align-items-start">
                            <a href="https://www.google.com/maps/search/?api=1&query={{ $selectedCr->latitude }},{{ $selectedCr->longitude }}"
                                target="_blank" class="btn btn-sm btn-primary py-0 px-2 ms-1 mt-1"
                                style="font-size:11px; border-radius:5px !important;" title="Navigate in Google Maps">
                                <i class="bi bi-geo-alt-fill me-1"></i>Get Direction
                            </a>
                        </span>
                    </div>
                </div>
                @elseif($selectedWt)
                <input type="hidden" name="waste_task_id" value="{{ $selectedWt->id }}">
                <div class="p-3 bg-light border rounded-3 mb-3 border-start border-4 border-warning shadow-sm">
                    <small class="text-muted d-block font-10 text-uppercase fw-bold"><i
                            class="bi bi-geo-alt-fill text-warning me-1"></i>Pickup Source (Accepted AE Request)</small>
                    <div class="d-flex justify-content-between align-items-center mt-1">
                        <strong class="text-dark font-14">AE Request #{{ $selectedWt->id }}</strong>
                        <span class="badge bg-warning text-dark px-2 py-1">{{ $selectedWt->remaining_weight }}
                            Tons</span>
                    </div>
                    <div class="small text-secondary mt-1 d-flex justify-content-between align-items-center flex-wrap">
                        {{-- <span>
                                <i class="fas fa-map-marker-alt text-danger me-1"></i> Ward #{{ $selectedWt->ward->ward_number ?? $selectedWt->ward_id }}
                        &bull;
                        {{ \Illuminate\Support\Str::words($selectedWt->description ?? 'AE Waste Request', 4, '...') }}
                        </span> --}}
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $selectedWt->latitude }},{{ $selectedWt->longitude }}"
                            target="_blank" class="btn btn-sm btn-primary py-0 px-2 ms-1 mt-1"
                            style="font-size:11px; border-radius:5px !important;" title="Navigate in Google Maps">
                            <i class="bi bi-geo-alt-fill me-1"></i>Get Direction
                        </a>
                    </div>
                </div>
                @else
                <div class="p-3 bg-light border rounded-3 mb-3 border-start border-4 border-secondary shadow-sm">
                    <small class="text-muted d-block font-10 text-uppercase fw-bold"><i
                            class="bi bi-geo-alt-fill text-secondary me-1"></i>Pickup Source</small>
                    <strong class="text-dark font-14 d-block mt-1">Direct Vehicle Waste Pickup</strong>
                </div>
                @endif

                {{-- Multiple Photo Upload Section --}}
                <div class="mb-3">
                    <label class="form-label fw-bold small text-secondary">
                        Upload Before Pickup image <small class="text-muted">(Multiple photos allowed)</small>
                    </label>
                    <input type="file" name="pickup_photos[]" id="pickupPhotosInput" class="form-control"
                        accept="image/*" multiple>
                    <small class="text-muted d-block mt-1 font-10">You can select multiple photos (site condition,
                        loaded waste, etc.)</small>

                    {{-- Live Image Thumbnails Preview --}}
                    <div id="photoPreviewContainer" class="d-flex flex-wrap gap-2 mt-2"></div>
                </div>

                {{-- Size Inputs --}}
                <div class="row g-2 mb-3">
                    <div class="col-12">
                        <label class="form-label fw-bold small text-secondary" for="tonnage">
                            Tonnage <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">
                            <input type="number" step="0.01" min="0.01" id="tonnage" name="tonnage"
                                class="form-control mb-2" value="" required readonly
                                placeholder="Please select a value below" inputmode="none">
                            <div class="invalid-feedback">
                                Please select a valid tonnage using the buttons below.
                            </div>
                        </div>
                        {{-- Quick Select 1-10 Tonnage Buttons --}}
                        <div class="d-flex flex-wrap gap-2 mb-2" id="tonnageQuickSelect">
                            @for ($i = 1; $i <= 10; $i++) <button type="button"
                                class="btn btn-outline-primary tonnage-quick-btn" data-value="{{ $i }}"
                                style="width:70px; height:38px; padding:0; border-radius:7px !important; font-size:13px; font-weight:600;">
                                {{ $i }}</button>
                                @endfor
                        </div>
                    </div>
                </div>

                {{-- Location Coords --}}
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-bold small text-secondary">Latitude <span
                                class="text-danger">*</span></label>
                        <input type="number" step="0.00000001" id="latitude" name="latitude" class="form-control"
                            value="{{ old('latitude') }}" required>
                        <div class="invalid-feedback">Latitude is required.</div>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold small text-secondary">Longitude <span
                                class="text-danger">*</span></label>
                        <input type="number" step="0.00000001" id="longitude" name="longitude" class="form-control"
                            value="{{ old('longitude') }}" required>
                        <div class="invalid-feedback">Longitude is required. </div>
                    </div>
                </div>

                <span class="">
                    <div class="mb-3 d-flex flex-column align-items-center">
                        <button type="button" class="btn btn-outline-primary btn-sm w-75 py-2 fw-bold"
                            onclick="useGPS()" style="border-radius:5px !important">
                            <i class="bi bi-geo-alt-fill me-1"></i> Fetch Current GPS Location
                        </button>
                    </div>

                    <div class="d-flex flex-column align-items-center mb-3">

                        <button type="submit" id="pickupSubmitBtn"
                            class="btn btn-primary btn-lg w-75  fw-bold text-white shadow-sm"
                            style="background-color: #1f4e79 !important; border-color: #1f4e79 !important; color: #ffffff !important;border-radius:5px !important;font-size:14px !important">
                            Submit
                        </button>
                    </div>
                </span>
            </form>
        </div>
    </div>

</div>

{{-- Full Page Loader Overlay --}}
<div id="pageLoader"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.9); z-index:9999;">
    <div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center;">
        <div class="spinner-border text-primary" style="width:3rem; height:3rem;" role="status"></div>
        <div class="mt-2 fw-bold" style="color:#1f4e79;">Submitting pickup, please wait...</div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Tonnage Quick-Select Buttons
    const tonnageInput = document.getElementById('tonnage');
    const tonnageBtns = document.querySelectorAll('.tonnage-quick-btn');

    tonnageBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const value = this.getAttribute('data-value');

            // Set the tonnage field value (readonly does not block programmatic updates)
            tonnageInput.value = value;

            // Clear invalid state if present
            tonnageInput.classList.remove('is-invalid');

            // Toggle active styling: highlight the clicked button only
            tonnageBtns.forEach(b => b.classList.remove('btn-primary', 'text-white'));
            tonnageBtns.forEach(b => b.classList.add('btn-outline-primary'));
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary', 'text-white');
        });
    });

    // Multiple Photo Preview Logic
    const photosInput = document.getElementById('pickupPhotosInput');
    const previewContainer = document.getElementById('photoPreviewContainer');

    photosInput.addEventListener('change', function() {
        previewContainer.innerHTML = '';
        if (this.files) {
            Array.from(this.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '70px';
                    img.style.height = '70px';
                    img.style.objectFit = 'cover';
                    img.className = 'rounded border shadow-sm';
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }
    });

    // Bootstrap 5 validation + Page Loader on Submit
    const form = document.getElementById('pickupForm');
    const submitBtn = document.getElementById('pickupSubmitBtn');
    const pageLoader = document.getElementById('pageLoader');

    form.addEventListener('submit', function (event) {
        // --- Tonnage validation fix ---
        // The tonnage input is `readonly`, and per the HTML spec the native
        // "required" constraint only applies to *mutable* controls. A
        // readonly field is not mutable, so the browser silently SKIPS the
        // required check for it — form.checkValidity() alone will NOT catch
        // a missing tonnage selection. We validate it manually here instead.
        const tonnageVal = parseFloat(tonnageInput.value);
        const tonnageValid = !isNaN(tonnageVal) && tonnageVal >= 0.01;

        tonnageInput.classList.toggle('is-invalid', !tonnageValid);

        const nativelyValid = form.checkValidity();

        if (!nativelyValid || !tonnageValid) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
            if (!tonnageValid) {
                tonnageInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }

        // Valid form — show loader and disable button to prevent double submit
        pageLoader.style.display = 'block';
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting...';
        form.classList.add('was-validated');
    }, false);
});

function useGPS() {
    if (!navigator.geolocation) return alert('GPS not supported.');
    navigator.geolocation.getCurrentPosition(pos => {
        document.getElementById('latitude').value = pos.coords.latitude.toFixed(8);
        document.getElementById('longitude').value = pos.coords.longitude.toFixed(8);
    }, () => alert('Could not fetch GPS.'));
}
</script>
@endsection