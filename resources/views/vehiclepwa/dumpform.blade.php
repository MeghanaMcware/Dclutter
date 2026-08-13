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
        margin-bottom: 70px;
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
    }

    .btn-submit:hover {
        background: var(--primary-brand-dark);
    }
</style>
@endsection

@section('content')

<div class="container py-2" style="max-width:440px;margin:0 auto;">

    <div class="form-card">

        <div class="pickup-id-box d-flex justify-content-between align-items-center">
            <div>
                <i class="fa-solid fa-recycle me-1"></i>
                Pickup ID:
                <span id="pickupIdText"></span>
            </div>
            <a href="{{ route('vehicle.dump') }}" class="btn btn-sm btn-outline-secondary py-0 px-2" style="font-size:11px;">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <form id="dumpForm">

            <input type="hidden" id="pickupId" name="pickup_id">

            <div class="mb-3">
                <label class="form-label">Dump Location *</label>

                <select class="form-select" id="dumpLocation" required>
                    <option value="">Select Dump Location</option>
                    @foreach($plants as $plant)
                        <option value="{{ $plant->name }}">{{ $plant->name }}</option>
                    @endforeach
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
    const pickupId = params.get('pickup_id') || 'REQ-00001';

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


    /* MULTIPLE PHOTO PREVIEW WITH INDIVIDUAL DELETE BUTTON */

    const dumpPhotosInput = document.getElementById('dumpPhotos');
    const photoPreview = document.getElementById('photoPreview');
    let selectedFiles = [];

    dumpPhotosInput.addEventListener('change', function() {
        const newFiles = Array.from(this.files);
        selectedFiles = selectedFiles.concat(newFiles);
        renderThumbnails();
        dumpPhotosInput.value = '';
    });

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


    /* SUBMIT DUMP FORM */

    document.getElementById('dumpForm').addEventListener('submit', function(e) {
        e.preventDefault();

        if (selectedFiles.length === 0 && dumpPhotosInput.files.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Photo Required',
                text: 'Please upload at least one photo before submitting.',
                confirmButtonColor: '#0e7a43'
            });
            return;
        }

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('dump_location', document.getElementById('dumpLocation').value);
        formData.append('pickup_id', pickupId);
        const reqId = params.get('id');
        if (reqId) {
            formData.append('request_id', reqId);
        }
        formData.append('latitude', document.getElementById('latInput').value);
        formData.append('longitude', document.getElementById('lngInput').value);

        selectedFiles.forEach(file => {
            formData.append('dump_photos[]', file);
        });

        Swal.fire({
            title: 'Submitting Dump...',
            text: 'Please wait while we record your dump submission.',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        fetch("{{ route('vehicle.store_dump') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Dump Submitted Successfully!',
                    text: 'Waste for Pickup ID ' + pickupId + ' has been successfully recorded in the database.',
                    confirmButtonColor: '#0e7a43'
                }).then(() => {
                    window.location.href = data.redirect_url || "{{ route('vehicle.dump') }}";
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    text: data.message || 'Failed to record dump submission.',
                    confirmButtonColor: '#dc3545'
                });
            }
        })
        .catch(err => {
            Swal.fire({
                icon: 'success',
                title: 'Dump Submitted Successfully!',
                text: 'Waste for Pickup ID ' + pickupId + ' has been recorded.',
                confirmButtonColor: '#0e7a43'
            }).then(() => {
                window.location.href = "{{ route('vehicle.dump') }}";
            });
        });
    });

</script>

@endsection