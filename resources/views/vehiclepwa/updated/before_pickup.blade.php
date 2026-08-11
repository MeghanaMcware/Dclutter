@extends('vehiclepwa.layout.app')

@section('title') Update Status @endsection
@section('heading') Update Status @endsection

@section('style')
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .form-card { background: #fff; border-radius: 16px; padding: 20px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 24px; text-align: left; }
        .form-group { margin-bottom: 16px; }
        .form-group label { font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 8px; display: block; text-transform: uppercase; letter-spacing: 0.5px; }
        
        .form-control { width: 100%; border: 1.5px solid #cbd5e1; border-radius: 12px; padding: 12px; font-size: 14px; outline: none; font-family: 'Inter', sans-serif; background: #fff; }
        .form-control:focus { border-color: var(--primary-green); }
        .form-control.bg-light { background: #f8fafc; color: #64748b; }

        .btn-update { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); cursor: pointer; }
        .btn-update:hover { background: var(--primary-dark); color: #fff; }
        
        .location-group { display: flex; gap: 12px; }
        .location-group .form-group { flex: 1; }

        /* Success Screen Styles */
        .check-circle { width: 90px; height: 90px; background: var(--primary-green); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 20px auto 24px; font-size: 42px; box-shadow: 0 10px 25px rgba(14,122,67,0.3); }
        .success-title { font-size: 22px; font-weight: 800; color: var(--primary-green); margin-bottom: 6px; }
        .success-sub { font-size: 14px; color: #64748b; margin-bottom: 28px; line-height: 1.5; }
        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">
        
        <!-- Form Section -->
        <!-- Before Pickup Form -->
        <div id="beforeFormSection">
            <h5 class="fw-bold text-dark mb-3 px-1">Step 1: Arrived at Location</h5>

            <div class="form-card mb-4">
                <form id="beforeStatusForm">
                    <div class="form-group">
                        <label>Before Photo<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="beforePhoto" accept="image/*" multiple required>
                        <div class="invalid-feedback">Please capture or upload at least one before photo.</div>
                        <div id="beforePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>

                    <div class="form-group">
                        <label>Approximate Weight (kg)<span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="approxWeight" placeholder="Enter approximate weight" min="0" step="0.1" required>
                        <div class="invalid-feedback">Please enter the approximate weight.</div>
                    </div>

                    <div class="location-group">
                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" class="form-control bg-light" id="currentLat" readonly placeholder="Fetching...">
                            <div class="invalid-feedback">Location required.</div>
                        </div>
                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" class="form-control bg-light" id="currentLng" readonly placeholder="Fetching...">
                            <div class="invalid-feedback">Location required.</div>
                        </div>
                    </div>

                    <button type="button" id="saveBeforeBtn" class="btn-update mt-4" onclick="saveBeforeDetails()">
                        <i class="fa-solid fa-camera"></i> <span>Save Before Details</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('script')
<script>
    const selectedFilesArray = {
        'before': []
    };

    document.addEventListener('DOMContentLoaded', () => {
        // Auto-fetch location on load
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const latInput = document.getElementById('currentLat');
                    const lngInput = document.getElementById('currentLng');
                    
                    latInput.value = position.coords.latitude.toFixed(6);
                    lngInput.value = position.coords.longitude.toFixed(6);
                    
                    latInput.classList.remove('is-invalid');
                    latInput.classList.add('is-valid');
                    lngInput.classList.remove('is-invalid');
                    lngInput.classList.add('is-valid');
                },
                function(error) {
                    console.error("Error getting location: ", error);
                    const latInput = document.getElementById('currentLat');
                    const lngInput = document.getElementById('currentLng');
                    
                    latInput.value = "Error";
                    lngInput.value = "Error";
                    latInput.classList.add('is-invalid');
                    lngInput.classList.add('is-invalid');
                    
                    Swal.fire('Location Error', 'Unable to fetch your current location. Please ensure location services are enabled.', 'warning');
                },
                { enableHighAccuracy: true }
            );
        } else {
            const latInput = document.getElementById('currentLat');
            const lngInput = document.getElementById('currentLng');
            latInput.value = "Not Supported";
            lngInput.value = "Not Supported";
            latInput.classList.add('is-invalid');
            lngInput.classList.add('is-invalid');
        }

        // Live validation for regular inputs (Approximate Weight)
        document.querySelectorAll('input:not([type="file"]), select').forEach(input => {
            input.addEventListener('input', function() {
                if (this.value) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
        });

        const fileInput = document.getElementById('beforePhoto');
        const previewContainer = document.getElementById('beforePreview');

        fileInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            if (files.length > 0) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }

            files.forEach(file => {
                if (selectedFilesArray['before'].length >= 3) {
                    Swal.fire('Limit Reached', 'You can upload a maximum of 3 before photos.', 'warning');
                    return;
                }
                
                selectedFilesArray['before'].push(file);
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgContainer = document.createElement('div');
                    imgContainer.style.position = 'relative';
                    imgContainer.style.width = '70px';
                    imgContainer.style.height = '70px';
                    imgContainer.style.borderRadius = '8px';
                    imgContainer.style.overflow = 'hidden';
                    imgContainer.style.border = '1px solid #cbd5e1';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';

                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '2px';
                    removeBtn.style.right = '2px';
                    removeBtn.style.background = 'rgba(0,0,0,0.6)';
                    removeBtn.style.color = '#fff';
                    removeBtn.style.border = 'none';
                    removeBtn.style.borderRadius = '50%';
                    removeBtn.style.width = '20px';
                    removeBtn.style.height = '20px';
                    removeBtn.style.fontSize = '14px';
                    removeBtn.style.lineHeight = '1';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.style.display = 'flex';
                    removeBtn.style.alignItems = 'center';
                    removeBtn.style.justifyContent = 'center';

                    removeBtn.onclick = function(ev) {
                        ev.preventDefault();
                        const index = selectedFilesArray['before'].indexOf(file);
                        if (index > -1) {
                            selectedFilesArray['before'].splice(index, 1);
                        }
                        imgContainer.remove();
                        if (selectedFilesArray['before'].length === 0) {
                            fileInput.classList.remove('is-valid');
                            fileInput.classList.add('is-invalid');
                        }
                    };

                    imgContainer.appendChild(img);
                    imgContainer.appendChild(removeBtn);
                    previewContainer.appendChild(imgContainer);
                }
                reader.readAsDataURL(file);
            });
            
            // Clear input so same file can be selected again if needed
            this.value = '';
        });
    });

    function saveBeforeDetails() {
        const beforePhotoInput = document.getElementById('beforePhoto');
        const approxWeightInput = document.getElementById('approxWeight');
        const latInput = document.getElementById('currentLat');
        const lngInput = document.getElementById('currentLng');
        const saveBeforeBtn = document.getElementById('saveBeforeBtn');

        let isValid = true;
        
        if (selectedFilesArray['before'].length === 0) {
            beforePhotoInput.classList.remove('is-valid');
            beforePhotoInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!approxWeightInput.value || parseFloat(approxWeightInput.value) <= 0) {
            approxWeightInput.classList.remove('is-valid');
            approxWeightInput.classList.add('is-invalid');
            isValid = false;
        }

        const currentLat = latInput.value;
        if (!currentLat || currentLat === 'Fetching...' || currentLat === 'Error' || currentLat === 'Not Supported') {
            latInput.classList.remove('is-valid');
            latInput.classList.add('is-invalid');
            lngInput.classList.remove('is-valid');
            lngInput.classList.add('is-invalid');
            isValid = false;
            Swal.fire('Location Error', 'Unable to fetch your current location. Please wait or ensure location services are enabled.', 'warning');
        }

        if (isValid) {
            saveBeforeBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Processing...</span>';
            saveBeforeBtn.disabled = true;
            beforePhotoInput.disabled = true;
            approxWeightInput.disabled = true;

            // Save to local storage for demo purposes if needed
            if (selectedFilesArray['before'].length > 0) {
                const readerBefore = new FileReader();
                readerBefore.onload = (e) => localStorage.setItem('recentBeforeImg', e.target.result);
                readerBefore.readAsDataURL(selectedFilesArray['before'][0]);
            }

            setTimeout(() => {
                window.location.href = "after_pickup";
            }, 1000);
        }
    }
</script>
@endsection
