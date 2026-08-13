@extends('vehiclepwa.layout.app')

@section('title') Dump Form @endsection
@section('heading') Dump Waste @endsection

@section('style')
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
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 5px;
    }

    .form-control,
    .form-select {
        min-height: 44px;
        border-radius: 9px;
        border: 1px solid #cbd5e1;
        font-size: 13px;
    }

    .location-row {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 12px;
        margin-top: 10px;
    }

    .location-row .value {
        font-size: 13px;
        font-weight: 700;
        color: #111827;
    }

    .photo-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .photo-preview img {
        width: 78px;
        height: 78px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .btn-submit {
        width: 100%;
        background: var(--primary-brand);
        color: #fff;
        border: none;
        border-radius: 9px;
        min-height: 44px;
        font-weight: 800;
    }

    .btn-submit:hover {
        background: var(--primary-brand-dark);
    }
</style>
@endsection

@section('content')

<div class="container py-2" style="max-width:440px;margin:0 auto;">

    <div class="form-card">

        <div class="pickup-id-box">
            <i class="fa-solid fa-recycle me-1"></i>
            Pickup ID:
            <span id="pickupIdText"></span>
        </div>

        <form id="dumpForm">

            <input type="hidden" id="pickupId" name="pickup_id">

            <div class="mb-3">
                <label class="form-label">Dump Location *</label>

                <select class="form-select" id="dumpLocation" required>
                    <option value="">Select Dump Location</option>
                    <option value="Kannahalli Plant">Kannahalli Plant</option>
                    <option value="Mavallipura Plant">Mavallipura Plant</option>
                    <option value="Bellahalli Plant">Bellahalli Plant</option>
                    <option value="Other Plant">Other Plant</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Photos *</label>

                <input
                    type="file"
                    class="form-control"
                    id="dumpPhotos"
                    accept="image/*"
                    multiple
                    required
                >

                <div id="photoPreview" class="photo-preview"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Location</label>

                <div class="location-row">
                    <div class="small text-muted">Latitude</div>
                    <div class="value" id="latitude">Fetching...</div>
                </div>

                <div class="location-row">
                    <div class="small text-muted">Longitude</div>
                    <div class="value" id="longitude">Fetching...</div>
                </div>
            </div>

            <input type="hidden" id="latInput">
            <input type="hidden" id="lngInput">

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-trash-can me-1"></i>
                Submit Dump
            </button>

        </form>

    </div>

</div>

@endsection

@section('script')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    const params = new URLSearchParams(window.location.search);
    const pickupId = params.get('pickup_id') || '';

    document.getElementById('pickupIdText').textContent = pickupId;
    document.getElementById('pickupId').value = pickupId;


    /* AUTO FETCH LATITUDE & LONGITUDE */

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(

            function(position) {

                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                document.getElementById('latitude').textContent = lat.toFixed(6);
                document.getElementById('longitude').textContent = lng.toFixed(6);

                document.getElementById('latInput').value = lat;
                document.getElementById('lngInput').value = lng;

            },

            function() {

                document.getElementById('latitude').textContent = 'Location unavailable';
                document.getElementById('longitude').textContent = 'Location unavailable';

            }

        );

    }


    /* MULTIPLE PHOTO PREVIEW */

    document.getElementById('dumpPhotos').addEventListener('change', function() {

        const preview = document.getElementById('photoPreview');

        preview.innerHTML = '';

        Array.from(this.files).forEach(file => {

            const reader = new FileReader();

            reader.onload = function(e) {

                const img = document.createElement('img');

                img.src = e.target.result;

                preview.appendChild(img);

            };

            reader.readAsDataURL(file);

        });

    });


    /* SUBMIT - FRONTEND ONLY */

    document.getElementById('dumpForm').addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
            icon: 'success',
            title: 'Dump Submitted Successfully!',
            text: 'Waste for Pickup ID ' + pickupId + ' has been successfully recorded.',
            confirmButtonColor: '#0e7a43'
        }).then(() => {

           window.location.href = "{{ url('/driver/route') }}";

        });

    });

</script>

@endsection