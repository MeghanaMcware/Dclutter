@extends('vehiclepwa.layout.app')

@section('title') Dump Waste @endsection
@section('heading') Dump Waste @endsection

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    .form-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 2px 10px rgba(0,0,0,.04);
    }

    .pickup-id-box {
        background: var(--primary-brand-light);
        border: 1px solid #cce7d7;
        color: var(--primary-brand-dark);
        border-radius: 10px;
        padding: 11px 13px;
        font-weight: 800;
        margin-bottom: 18px;
    }

    .form-label {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .form-control,
    .form-select {
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        min-height: 40px;
        font-size: 13.5px;
    }

    .select2-container--default .select2-selection--single {
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        min-height: 40px;
        display: flex;
        align-items: center;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
        top: 1px;
    }
    .select2-dropdown {
        border: 1px solid #cbd5e1;
        border-radius: 9px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: var(--primary-brand);
    }

    .location-row {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 10px;
    }

    .location-row .value {
        font-size: 13.5px;
        font-weight: 700;
        color: #111827;
    }

    .photo-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }

    .preview-thumb-wrap {
        position: relative;
        width: 78px;
        height: 78px;
    }

    .preview-thumb-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .btn-remove-thumb {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #dc3545;
        color: #ffffff;
        border: none;
        font-size: 13px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .btn-submit {
        width: 100%;
        background: var(--primary-brand);
        color: #fff;
        border: none;
        border-radius: 9px;
        min-height: 44px;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background: var(--primary-brand-dark);
    }

    .btn-refresh-loc {
        font-size: 11px;
        padding: 2px 8px;
        border-radius: 6px;
        background: #e2e8f0;
        color: #334155;
        border: none;
        cursor: pointer;
    }
</style>
@endsection

@section('content')

@php
    $defaultPickupId = $wasteRequest?->request_number ?? request('pickup_id') ?? '';
@endphp

<div class="container py-2" style="max-width:440px;margin:0 auto;">

    <div class="form-card">

        <div class="pickup-id-box d-flex justify-content-between align-items-center">
            <div>
                <i class="fa-solid fa-recycle me-1"></i>
                Pickup ID:
                <span id="pickupIdText" class="fw-bold">{{ $defaultPickupId ?: 'General Dump' }}</span>
            </div>
            <a href="{{ route('vehicle.dump') }}" class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size:11px;">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <form id="dumpForm">

            <input type="hidden" id="pickupId" name="pickup_id" value="{{ $defaultPickupId }}">
            <input type="hidden" id="requestId" name="request_id" value="{{ $wasteRequest?->id ?? request('id') ?? '' }}">

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0" for="dumpLocation">Dump Location / Yard <span class="text-danger">*</span></label>
                    @if(!empty($vehicle?->constituency_names) && $vehicle->constituency_names !== 'N/A')
                        <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 11px;">
                            <i class="fa-solid fa-map-pin me-1"></i> {{ $vehicle->constituency_names }}
                        </span>
                    @endif
                </div>

                <select class="form-select" id="dumpLocation" name="dump_location" required>
                    @if($plants->isEmpty())
                        <option value="" disabled selected>No Dump Yards Registered in {{ $vehicle?->constituency_names ?: 'your constituency' }}</option>
                    @else
                        <option value="">Select Dump Location</option>
                        @foreach($plants as $plant)
                            <option value="{{ $plant->name }}">
                                {{ $plant->name }} {{ $plant->constituency ? ' (' . $plant->constituency->name . ')' : '' }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="dumpPhotos">Upload Photos <span class="text-danger">*</span></label>

                <input
                    type="file"
                    class="form-control"
                    id="dumpPhotos"
                    capture="environment"
                    multiple
                    required
                    accept="image/*"
                >

                <div id="photoPreview" class="photo-preview"></div>
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label class="form-label mb-0">Current Location (GPS)</label>
                    <button type="button" class="btn-refresh-loc" id="btnRefreshLocation">
                        <i class="fa-solid fa-arrows-rotate me-1"></i> Refresh GPS
                    </button>
                </div>

                <div class="location-row">
                    <div class="small text-muted">Latitude</div>
                    <div class="value" id="latitude">Detecting...</div>
                </div>

                <div class="location-row">
                    <div class="small text-muted">Longitude</div>
                    <div class="value" id="longitude">Detecting...</div>
                </div>
            </div>

            <input type="hidden" id="latInput" name="latitude" value="">
            <input type="hidden" id="lngInput" name="longitude" value="">

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fa-solid fa-trash-can me-1"></i>
                Submit Dump
            </button>

        </form>

    </div>

</div>

@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize Select2
    if (window.jQuery && $('#dumpLocation').length) {
        $('#dumpLocation').select2({
            placeholder: 'Select Dump Location',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            // Trigger validation check on change
            if ($(this).val()) {
                $(this).removeClass('is-invalid');
            }
        });
    }

    // 2. Sync URL params for pickup_id if present
    const params = new URLSearchParams(window.location.search);
    const urlPickupId = params.get('pickup_id');
    const urlReqId = params.get('id');

    if (urlPickupId) {
        document.getElementById('pickupIdText').textContent = urlPickupId;
        document.getElementById('pickupId').value = urlPickupId;
    }
    if (urlReqId) {
        document.getElementById('requestId').value = urlReqId;
    }

    // 3. AUTO FETCH GPS LOCATION
    function fetchLocation() {
        const latElem = document.getElementById('latitude');
        const lngElem = document.getElementById('longitude');
        const latInput = document.getElementById('latInput');
        const lngInput = document.getElementById('lngInput');

        latElem.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-muted me-1"></i> Fetching...';
        lngElem.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-muted me-1"></i> Fetching...';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    latElem.textContent = lat.toFixed(6);
                    lngElem.textContent = lng.toFixed(6);

                    latInput.value = lat.toFixed(6);
                    lngInput.value = lng.toFixed(6);
                },
                function(error) {
                    console.warn("Geolocation notice:", error.message);
                    // Fallback to default or IP approximate location
                    const fallbackLat = 12.9856;
                    const fallbackLng = 77.6057;
                    latElem.textContent = fallbackLat.toFixed(6) + ' (Default)';
                    lngElem.textContent = fallbackLng.toFixed(6) + ' (Default)';
                    latInput.value = fallbackLat;
                    lngInput.value = fallbackLng;
                },
                { enableHighAccuracy: true, timeout: 7000, maximumAge: 0 }
            );
        } else {
            latElem.textContent = '12.985600 (Fallback)';
            lngElem.textContent = '77.605700 (Fallback)';
            latInput.value = '12.9856';
            lngInput.value = '77.6057';
        }
    }

    // Trigger on load & on refresh button click
    fetchLocation();
    const btnRefresh = document.getElementById('btnRefreshLocation');
    if (btnRefresh) {
        btnRefresh.addEventListener('click', fetchLocation);
    }

    // 4. MULTIPLE PHOTO PREVIEW WITH INDIVIDUAL DELETE BUTTON
    const dumpPhotosInput = document.getElementById('dumpPhotos');
    const photoPreview = document.getElementById('photoPreview');
    let selectedFiles = [];

    if (dumpPhotosInput) {
        dumpPhotosInput.addEventListener('change', function() {
            const newFiles = Array.from(this.files);
            const maxFileSize = 1024 * 1024 * 10; // 10MB
            const validFiles = newFiles.filter(file => file.size <= maxFileSize);
            const oversizedFiles = newFiles.filter(file => file.size > maxFileSize);

            if (oversizedFiles.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Image too large',
                    text: 'Each dump image must be 10 MB or smaller.',
                    confirmButtonColor: '#0e7a43'
                });
            }

            selectedFiles = selectedFiles.concat(validFiles);
            renderThumbnails();
            dumpPhotosInput.value = '';
        });
    }

    function renderThumbnails() {
        photoPreview.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const wrap = document.createElement('div');
            wrap.className = 'preview-thumb-wrap';

            const img = document.createElement('img');
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);

            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn-remove-thumb';
            removeBtn.innerHTML = '&times;';
            removeBtn.title = 'Remove Photo';
            removeBtn.onclick = function() {
                selectedFiles.splice(index, 1);
                renderThumbnails();
            };

            wrap.appendChild(img);
            wrap.appendChild(removeBtn);
            photoPreview.appendChild(wrap);
        });

        if (selectedFiles.length > 0) {
            dumpPhotosInput.removeAttribute('required');
        } else {
            dumpPhotosInput.setAttribute('required', 'required');
        }
    }

    // 5. SUBMIT DUMP FORM
    const dumpForm = document.getElementById('dumpForm');
    if (dumpForm) {
        dumpForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const submitButton = document.getElementById('submitBtn');
            const dumpLocationVal = document.getElementById('dumpLocation').value;

            if (!dumpLocationVal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Dump Location Required',
                    text: 'Please select a dump yard/location before submitting.',
                    confirmButtonColor: '#0e7a43'
                });
                return;
            }

            if (selectedFiles.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Photo Required',
                    text: 'Please capture or upload at least one dump verification photo before submitting.',
                    confirmButtonColor: '#0e7a43'
                });
                return;
            }

            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Submitting Dump...';

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('dump_location', dumpLocationVal);
            formData.append('pickup_id', document.getElementById('pickupId').value);
            
            const reqId = document.getElementById('requestId').value;
            if (reqId) {
                formData.append('request_id', reqId);
            }
            formData.append('latitude', document.getElementById('latInput').value || '12.9856');
            formData.append('longitude', document.getElementById('lngInput').value || '77.6057');

            selectedFiles.forEach(file => {
                formData.append('dump_photos[]', file);
            });

            Swal.fire({
                title: 'Recording Dump...',
                text: 'Please wait while we record your dump submission.',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            fetch("{{ route('vehicle.store_dump') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Dump Recorded Successfully!',
                        text: data.message || 'Dump details have been successfully saved.',
                        confirmButtonColor: '#0e7a43'
                    }).then(() => {
                        window.location.href = data.redirect_url || "{{ route('vehicle.dump') }}";
                    });
                } else {
                    submitButton.disabled = false;
                    submitButton.innerHTML = '<i class="fa-solid fa-trash-can me-1"></i> Submit Dump';
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Failed',
                        text: data.message || 'Failed to record dump submission.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                submitButton.disabled = false;
                submitButton.innerHTML = '<i class="fa-solid fa-trash-can me-1"></i> Submit Dump';
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Error',
                    text: 'An unexpected error occurred while saving dump details. Please try again.',
                    confirmButtonColor: '#dc3545'
                });
            });
        });
    }
});
</script>

@endsection
