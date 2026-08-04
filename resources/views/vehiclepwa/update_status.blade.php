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
        <div id="formSection">
            <h5 class="fw-bold text-dark mb-3 px-1">Pickup Verification</h5>

            <div class="form-card">
                <form id="statusUpdateForm">
                    <div class="form-group">
                        <label>Before Photo<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="beforePhoto" accept="image/*" multiple required>
                        <div class="invalid-feedback">Please capture or upload at least one before photo.</div>
                        <div id="beforePreview" class="d-flex flex-wrap gap-2 mt-2"></div>
                    </div>

                    <div class="form-group">
                        <label>After Photo<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="afterPhoto" accept="image/*" multiple required>
                        <div class="invalid-feedback">Please capture or upload at least one after photo.</div>
                        <div id="afterPreview" class="d-flex flex-wrap gap-2 mt-2"></div>
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

                    <button type="button" id="submitBtn" class="btn-update mt-4" onclick="submitStatusUpdate()">
                        <i class="fa-solid fa-cloud-arrow-up"></i> <span>Submit Update</span>
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
            <p class="success-sub">You have successfully completed</p>
            
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

        // Standard Javascript arrays to hold our selected files reliably
        const selectedFilesArray = {
            'before': [],
            'after': []
        };

        // Live Validation & Preview: Turn Green on file selection and show thumbnails
        ['before', 'after'].forEach(prefix => {
            const input = document.getElementById(prefix + 'Photo');
            
            input.addEventListener('change', function() {
                // Append new selection to the existing array
                Array.from(this.files).forEach(file => {
                    // Prevent duplicates reliably using array
                    let isDuplicate = false;
                    for (let i = 0; i < selectedFilesArray[prefix].length; i++) {
                        let existing = selectedFilesArray[prefix][i];
                        if (existing.name === file.name && existing.size === file.size && existing.lastModified === file.lastModified) {
                            isDuplicate = true;
                            break;
                        }
                    }
                    if (!isDuplicate) {
                        selectedFilesArray[prefix].push(file);
                    }
                });
                
                // Clear the input so selecting the exact same file again triggers 'change' event
                this.value = '';
                
                renderPreviews(prefix);
            });
        });

        function renderPreviews(prefix) {
            const input = document.getElementById(prefix + 'Photo');
            const previewContainer = document.getElementById(prefix + 'Preview');
            previewContainer.innerHTML = '';
            
            // Sync the input files with our array using a fresh DataTransfer
            const dt = new DataTransfer();
            selectedFilesArray[prefix].forEach(file => dt.items.add(file));
            input.files = dt.files;
            
            if (selectedFilesArray[prefix].length > 0) {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
                
                selectedFilesArray[prefix].forEach((file, index) => {
                    // Create a wrapper for the image and the remove button
                    const wrapper = document.createElement('div');
                    wrapper.style.position = 'relative';
                    wrapper.style.display = 'inline-block';
                    wrapper.style.marginTop = '8px';
                    
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file); // Synchronous and much faster than FileReader
                    img.style.width = '64px';
                    img.style.height = '64px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.border = '1px solid #cbd5e1';
                    
                    // Create the red 'x' button
                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '-6px';
                    removeBtn.style.right = '-6px';
                    removeBtn.style.width = '22px';
                    removeBtn.style.height = '22px';
                    removeBtn.style.background = '#ef4444'; // Red color
                    removeBtn.style.color = '#fff';
                    removeBtn.style.border = 'none';
                    removeBtn.style.borderRadius = '50%';
                    removeBtn.style.fontSize = '16px';
                    removeBtn.style.lineHeight = '1';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.style.display = 'flex';
                    removeBtn.style.alignItems = 'center';
                    removeBtn.style.justifyContent = 'center';
                    removeBtn.style.padding = '0';
                    removeBtn.style.paddingBottom = '2px';
                    removeBtn.style.boxShadow = '0 2px 4px rgba(0,0,0,0.2)';
                    
                    removeBtn.onclick = function(event) {
                        event.preventDefault();
                        selectedFilesArray[prefix].splice(index, 1); // Remove from array
                        renderPreviews(prefix); // Re-render
                    };
                    
                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    previewContainer.appendChild(wrapper);
                });
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        }
    });

    function submitStatusUpdate() {
        const beforePhotoInput = document.getElementById('beforePhoto');
        const afterPhotoInput = document.getElementById('afterPhoto');
        const beforePhoto = beforePhotoInput.files.length;
        const afterPhoto = afterPhotoInput.files.length;
        const latInput = document.getElementById('currentLat');
        const lngInput = document.getElementById('currentLng');
        const currentLat = latInput.value;
        const submitBtn = document.getElementById('submitBtn');

        let isValid = true;
        
        // Remove valid classes in case user clears them
        if (beforePhoto === 0) {
            beforePhotoInput.classList.remove('is-valid');
            beforePhotoInput.classList.add('is-invalid');
            isValid = false;
        }

        if (afterPhoto === 0) {
            afterPhotoInput.classList.remove('is-valid');
            afterPhotoInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!currentLat || currentLat === 'Fetching...' || currentLat === 'Error' || currentLat === 'Not Supported') {
            latInput.classList.remove('is-valid');
            latInput.classList.add('is-invalid');
            lngInput.classList.remove('is-valid');
            lngInput.classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) return;

        // Add Loader State
        document.getElementById('pageLoader').style.display = 'flex';
        submitBtn.disabled = true;

        // Save first images to localStorage for the summary page mockup
        if (beforeFilesArray.length > 0) {
            const readerBefore = new FileReader();
            readerBefore.onload = (e) => localStorage.setItem('recentBeforeImg', e.target.result);
            readerBefore.readAsDataURL(beforeFilesArray[0]);
        }
        if (afterFilesArray.length > 0) {
            const readerAfter = new FileReader();
            readerAfter.onload = (e) => localStorage.setItem('recentAfterImg', e.target.result);
            readerAfter.readAsDataURL(afterFilesArray[0]);
        }

        // Simulate network request (1.5 seconds)
        setTimeout(() => {
            // Hide loaders and show success screen
            document.getElementById('pageLoader').style.display = 'none';
            document.getElementById('formSection').style.display = 'none';
            document.getElementById('successSection').style.display = 'block';
            
            // Restore button in case they go back
            submitBtn.disabled = false;
            
            // Optional tiny success toast before the big screen takes focus
            Swal.fire({
                title: 'Success!',
                text: 'Photos uploaded.',
                icon: 'success',
                timer: 1200,
                toast: true,
                position: 'top-end',
                showConfirmButton: false
            });
        }, 1500);
    }
</script>
@endsection
