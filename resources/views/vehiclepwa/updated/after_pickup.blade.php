@extends('vehiclepwa.layout.app')

@section('title') After Pickup @endsection
@section('heading') After Pickup @endsection

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
        
        <div id="afterFormSection">
            <h5 class="fw-bold text-dark mb-3 px-1">Step 2: After Pickup</h5>

            <div class="form-card">
                <form id="statusUpdateForm">
                    <div class="form-group">
                        <label>After Photo<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="afterPhoto" accept="image/*" multiple required>
                        <div class="invalid-feedback">Please capture or upload at least one after photo.</div>
                        <div id="afterPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>


                    <div class="location-group d-flex gap-2 mb-3">
                        <div class="form-group flex-fill mb-0">
                            <label>Latitude</label>
                            <input type="text" class="form-control bg-light" id="currentLat" readonly placeholder="Fetching...">
                            <div class="invalid-feedback">Location required.</div>
                        </div>
                        <div class="form-group flex-fill mb-0">
                            <label>Longitude</label>
                            <input type="text" class="form-control bg-light" id="currentLng" readonly placeholder="Fetching...">
                            <div class="invalid-feedback">Location required.</div>
                        </div>
                    </div>

                    <button type="button" id="submitBtn" class="btn-update mt-4" onclick="submitStatusUpdate()">
                        <i class="fa-solid fa-cloud-arrow-up"></i> <span>Submit Final Update</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Success Section -->
        <div id="successSection" class="text-center" style="display: none; padding-top: 20px;">
            <div class="check-circle">
                <i class="fa-solid fa-check"></i>
            </div>
            <h2 class="success-title">Collection Completed!</h2>
            <p class="success-sub">You have successfully completed the collection.</p>
            
            <a href="{{ route('driver.trip_summary') }}" class="btn-end-trip mt-5">
                <span>View Trip Summary</span>
            </a>
        </div>

        <!-- Page Loader Overlay -->
        <div id="pageLoader" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.9); z-index: 9999; flex-direction: column; justify-content: center; align-items: center;">
            <div class="spinner-border" style="width: 3.5rem; height: 3.5rem; color: var(--primary-green);" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <h5 class="mt-4 text-dark fw-bold">Uploading Photos...</h5>
            <p class="text-muted">Please do not close the app.</p>
        </div>

    </div>
@endsection

@section('script')
<script>
    const selectedFilesArray = { 'after': [] };

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

        const fileInput = document.getElementById('afterPhoto');
        const previewContainer = document.getElementById('afterPreview');

        fileInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            
            if (files.length > 0) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }

            files.forEach(file => {
                if (selectedFilesArray['after'].length >= 3) {
                    Swal.fire('Limit Reached', 'You can upload a maximum of 3 after photos.', 'warning');
                    return;
                }
                
                selectedFilesArray['after'].push(file);
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
                        const index = selectedFilesArray['after'].indexOf(file);
                        if (index > -1) {
                            selectedFilesArray['after'].splice(index, 1);
                        }
                        imgContainer.remove();
                        if (selectedFilesArray['after'].length === 0) {
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

    function submitStatusUpdate() {
        const afterPhotoInput = document.getElementById('afterPhoto');

        const latInput = document.getElementById('currentLat');
        const lngInput = document.getElementById('currentLng');
        const submitBtn = document.getElementById('submitBtn');
        const loader = document.getElementById('pageLoader');
        const formSection = document.getElementById('afterFormSection');
        const successSection = document.getElementById('successSection');

        let isValid = true;
        
        if (selectedFilesArray['after'].length === 0) {
            afterPhotoInput.classList.remove('is-valid');
            afterPhotoInput.classList.add('is-invalid');
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

        if (!isValid) return;

        // Simulate API call
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
        loader.style.display = 'flex';

        setTimeout(() => {
            loader.style.display = 'none';
            formSection.style.display = 'none';
            successSection.style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }, 1500);
    }
</script>
@endsection
