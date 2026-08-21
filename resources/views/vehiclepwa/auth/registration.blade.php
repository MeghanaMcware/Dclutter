<!DOCTYPE HTML>
<html lang="en">
@php
if(!isset($wards)) {
    $wards = json_decode('[{"id":1, "name":"Central Ward", "number":"101"}, {"id":2, "name":"North Ward", "number":"102"}]');
}
if(!isset($vehicleTypes)) {
    $vehicleTypes = ['Mini Truck', 'Pickup', 'Large Truck', 'Other'];
}
@endphp
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vehicle Registration - {{ env('APP_NAME') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
      
    <style>
        .bg-highlight { background-color: #1f4e79 !important; }
        .spinner-border-sm { width: 1rem; height: 1rem; }
        .custom-label {
            font-size: 14px; font-weight: 600;
            color: #2a5780; letter-spacing: 1px;
        }
        .custom-input {
            background: #f2f2f2; border: none; border-radius: 10px;
            padding: 14px 18px; font-size: 15px;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
        }
        .custom-input:focus {
            background: #f2f2f2;
            box-shadow: 0 0 0 2px rgba(63,185,92,0.25);
        }
        .form-control::placeholder { color: #8f8f8f; }

        .img-status {
            display: none !important;
        }
        .img-preview {
            display: none !important;
        }
        #pageLoader {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(31, 78, 121, 0.92);
            z-index: 99999;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 14px;
        }
        #pageLoader.active { display: flex; }
        #pageLoader .spin {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255,255,255,0.25);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        #pageLoader p { color: #fff; margin: 0; font-size: 15px; font-weight: 600; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .select2-container--default .select2-selection--single {
            height: 52px;
            border: none;
            border-radius: 10px;
            background: #f2f2f2;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
            padding-top: 10px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 52px;
        }
        .select2-container {
            width: 100% !important;
            max-width: 100%;
        }
        .select2-selection__rendered {
            white-space: normal !important;
            line-height: 2.3 !important;
            padding-right: 28px !important;
            word-break: break-word;
        }
        .select2-results__option {
            white-space: normal !important;
            word-break: break-word;
        }
        .header-brand {
            position: absolute;
            z-index: 10;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            width: 100%;
        }
    </style>
</head>

<body class="theme-light" data-highlight="blue2">

<div id="preloader">
    <div class="spinner-border color-highlight" role="status"></div>
</div>

<div id="pageLoader">
    <div class="spin"></div>
    <p>Please wait…</p>
</div>

<div id="page">
    <div class="page-content">
        <div class="page-title page-title-large"></div>

        <div class="card header-card shape-rounded" data-card-height="210">
            <div class="card-overlay bg-highlight opacity-95"></div>
            <div class="card-overlay dark-mode-tint"></div>
            <div class="card-bg preload-img" data-src="{{ asset('frontendwebsite/img/GBA-removebg-preview.png') }}"></div>
            <div class="header-brand">
                <h2 class="text-white mt-1">CLEARIT</h2>
            </div>
        </div>

        @if(Session::has('error'))
            <div class="ms-3 me-3 mb-5 alert alert-small rounded-s shadow-xl bg-red-dark s-alrt" role="alert">
                <span><i class="fa fa-times"></i></span>
                <strong>{{ Session::get('error') }}</strong>
                <button type="button" class="close color-white opacity-60 font-16" data-bs-dismiss="alert" aria-label="Close">&times;</button>
            </div>
        @endif

        <div class="card card-style mt-5">
            <div class="content">
                <div class="col-12 ps-0">
                    <div class="text-center" style="position:relative;">
                       <img src="{{asset('frontendwebsite/img/GBA-removebg-preview.png')}}" width="30%" height="30%" class="rounded-xl">
                    </div>
                </div>
            </div>

            <div class="content mt-2 mb-3">
                <h2 class="mb-3 color-dark text-center">Registration</h2>

                <form class="needs-validation" novalidate id="vehicleForm" method="POST"
                    action="#" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="driver_same_as_owner" id="driverSameAsOwnerInput" value="{{ old('driver_same_as_owner') ? 1 : 0 }}">

                    {{-- ══ Vehicle Details ══ --}}
                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Ward <span class="text-danger">*</span></label>
                        <select name="ward_id" id="wardId"
                            class="form-select custom-input @error('ward_id') is-invalid @enderror" required>
                            <option value="" disabled {{ old('ward_id') ? '' : 'selected' }}>Select Ward</option>
                            @foreach($wards as $ward)
                                <option value="{{ $ward->id }}">
                                    {{ $ward->number ? $ward->number . ' - ' : '' }}{{ $ward->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select the ward for this vehicle.</div>
                        @error('ward_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Vehicle Number <span class="text-danger">*</span></label>
                        <input type="text" name="vehicle_number"
                            class="form-control custom-input @error('vehicle_number') is-invalid @enderror"
                            placeholder="Enter vehicle number (KA01AB1234)"
                            value="{{ old('vehicle_number') }}"
                            oninput="this.value=this.value.toUpperCase();" required>
                        <div class="invalid-feedback">Please enter a valid Indian vehicle number.</div>
                        @error('vehicle_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Vehicle Photo <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('vehicle_photo') is-invalid @enderror"
                            type="file" name="vehicle_photo" accept="image/*,application/pdf"  data-compress required>
                        <img class="img-preview" id="prev_vehicle_photo">
                        <div class="img-status d-none" id="stat_vehicle_photo"></div>
                        <div class="invalid-feedback">Please upload a valid vehicle photo.</div>
                        @error('vehicle_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Vehicle Type <span class="text-danger">*</span></label>
                        <select name="vehicle_type" id="vehicleType" class="form-select custom-input @error('vehicle_type') is-invalid @enderror" required>
                            <option value="" disabled {{ old('vehicle_type') ? '' : 'selected' }}>Select Vehicle Type</option>
                            @foreach($vehicleTypes as $vehicleType)
                                <option value="{{ $vehicleType }}" {{ old('vehicle_type') === $vehicleType ? 'selected' : '' }}>
                                    {{ $vehicleType }}
                                </option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select a vehicle type.</div>
                        @error('vehicle_type')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Capacity of Vehicle (in Tons) <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('capacity') is-invalid @enderror"
                            type="number" step="0.01" name="capacity" placeholder="Enter capacity, e.g. 3 Tons"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                            value="{{ old('capacity') }}" required>
                        <div class="invalid-feedback">Please enter a valid numeric vehicle capacity.</div>
                        @error('capacity')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">RC Photo/PDF <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('rc_document') is-invalid @enderror"
                            type="file" name="rc_document" accept="image/*,application/pdf" required>
                        <div class="invalid-feedback">Please upload a valid RC photo/pdf.</div>
                        @error('rc_document')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Fitness Certificate <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('fitness_certificate') is-invalid @enderror"
                            type="file" name="fitness_certificate" accept="image/*,application/pdf" required>
                        <div class="invalid-feedback">Please upload a valid fitness certificate.</div>
                        @error('fitness_certificate')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Insurance Copy <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('insurance_document') is-invalid @enderror"
                            type="file" name="insurance_document" accept="image/*,application/pdf" required>
                        <div class="invalid-feedback">Please upload a valid insurance copy.</div>
                        @error('insurance_document')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <hr>

                    {{-- ══ Owner Details ══ --}}
                    <h4>Vehicle Owner Details</h4>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Name <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('owner_name') is-invalid @enderror"
                            placeholder="Enter owner's name" type="text" id="ownerName" name="owner_name"
                            value="{{ old('owner_name') }}" required>
                        <div class="invalid-feedback">Please enter the owner's name.</div>
                        @error('owner_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Phone <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('owner_mobile') is-invalid @enderror"
                            placeholder="Enter owner's phone number" type="text" id="ownerPhone" name="owner_mobile"
                            value="{{ old('owner_mobile') }}" maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                        <div class="invalid-feedback">Please enter the owner's phone number.</div>
                        @error('owner_mobile')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Email <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('owner_email') is-invalid @enderror"
                            placeholder="Enter owner's email" type="email" name="owner_email"
                            value="{{ old('owner_email') }}" required>
                        <div class="invalid-feedback">Please enter the owner's email.</div>
                        @error('owner_email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Address <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('owner_address') is-invalid @enderror"
                            placeholder="Enter owner's address" type="text" id="ownerAddress" name="owner_address"
                            value="{{ old('owner_address') }}" required>
                        <div class="invalid-feedback">Please enter the owner's address.</div>
                        @error('owner_address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Photo <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('owner_photo') is-invalid @enderror"
                            type="file" name="owner_photo" accept="image/*,application/pdf" data-compress required>
                        <img class="img-preview" id="prev_owner_photo">
                        <div class="img-status d-none" id="stat_owner_photo"></div>
                        <div class="invalid-feedback">Please upload a valid photo.</div>
                        @error('owner_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Aadhar Number <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('owner_aadhaar_number') is-invalid @enderror"
                            type="text" id="ownerAadhaarNumber" name="owner_aadhaar_number"
                            placeholder="Enter Aadhaar number" maxlength="12"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                            value="{{ old('owner_aadhaar_number') }}" required>
                        <div class="invalid-feedback">Please enter a valid 12-digit Aadhar number.</div>
                        @error('owner_aadhaar_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Aadhar Photo <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('owner_aadhaar_photo') is-invalid @enderror"
                            type="file" name="owner_aadhaar_photo" accept="image/*,application/pdf" data-compress required>
                        <img class="img-preview" id="prev_owner_aadhaar_photo">
                        <div class="img-status d-none" id="stat_owner_aadhaar_photo"></div>
                        <div class="invalid-feedback">Please upload a valid Aadhar photo.</div>
                        @error('owner_aadhaar_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input class="form-control custom-input @error('password') is-invalid @enderror" style="border-radius: 0px !important;"
                                placeholder="Enter password" type="password" name="password" id="password" required>
                            <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                <i id="toggleIcon" class="fa-solid fa-eye-slash"></i>
                            </span>
                        </div>
                        <div class="invalid-feedback">Please enter password.</div>
                        @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <hr>

                    {{-- ══ Driver Details ══ --}}
                    <h4>Driver Details</h4>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="driverSameAsOwner" {{ old('driver_same_as_owner') ? 'checked' : '' }}>
                        <label class="form-check-label" for="driverSameAsOwner">Same as Owner</label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Name <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('driver_name') is-invalid @enderror"
                            placeholder="Enter driver's name" type="text" id="driverName" name="driver_name"
                            value="{{ old('driver_name') }}" required>
                        <div class="invalid-feedback">Please enter the driver's name.</div>
                        @error('driver_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Phone <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('driver_mobile') is-invalid @enderror"
                            placeholder="Enter driver's phone number" type="text" id="driverPhone" name="driver_mobile"
                            value="{{ old('driver_mobile') }}" maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                        <div class="invalid-feedback">Please enter the driver's phone number.</div>
                        @error('driver_mobile')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Address <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('driver_address') is-invalid @enderror"
                            placeholder="Enter driver's address" type="text" id="driverAddress" name="driver_address"
                            value="{{ old('driver_address') }}" required>
                        <div class="invalid-feedback">Please enter the driver's address.</div>
                        @error('driver_address')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">License Number <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('driver_license_number') is-invalid @enderror"
                            placeholder="Enter driver's license number" type="text" id="driverLicense" name="driver_license_number"
                            value="{{ old('driver_license_number') }}" required>
                        <div class="invalid-feedback">Please enter the driver's license number.</div>
                        @error('driver_license_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">License Photo <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('driver_license_photo') is-invalid @enderror"
                            type="file" name="driver_license_photo" accept="image/*,application/pdf" data-compress required>
                        <img class="img-preview" id="prev_driver_license_photo">
                        <div class="img-status d-none" id="stat_driver_license_photo"></div>
                        <div class="invalid-feedback">Please upload a valid license photo.</div>
                        @error('driver_license_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Aadhar Number <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('driver_aadhaar_number') is-invalid @enderror"
                            placeholder="Enter driver's aadhaar number" type="text" id="driverAadhaarNumber" name="driver_aadhaar_number"
                            value="{{ old('driver_aadhaar_number') }}" maxlength="12"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                        <div class="invalid-feedback">Please enter the driver's Aadhar number.</div>
                        @error('driver_aadhaar_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label custom-label mb-0 ms-1">Aadhar Photo <span class="text-danger">*</span></label>
                        <input class="form-control custom-input @error('driver_aadhaar_photo') is-invalid @enderror"
                            type="file" name="driver_aadhaar_photo" accept="image/*,application/pdf" data-compress required>
                        <img class="img-preview" id="prev_driver_aadhaar_photo">
                        <div class="img-status d-none" id="stat_driver_aadhaar_photo"></div>
                        <div class="invalid-feedback">Please upload a valid Aadhar photo.</div>
                        @error('driver_aadhaar_photo')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex flex-column align-items-center justify-content-center">
                        <button type="submit" id="submitBtn" class="btn btn-primary w-50"
                            style="background-color:#2a5780 !important;border-color:#2a5780;border-radius:8px">
                            <span id="btnText">Register</span>
                            <span id="btnLoader" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="footer" data-menu-load="#"></div>
    </div>
</div>

<!-- <div class="position-fixed" style="top:11px;right:3px;">
    <select class="form-control p-0 px-2 m-0" style="border-radius:8px;"
        onchange="window.location.href='{{ url('/local') }}/' + this.value;">
        <option value="en" {{ App::getLocale() == 'en' ? 'selected' : '' }}>KN</option>
        <option value="kn" {{ App::getLocale() == 'kn' ? 'selected' : '' }}>EN</option>
    </select>
</div> -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.2/dist/browser-image-compression.js"></script>

<script>
// ── Scroll to first error ───────────────────────────────────────────────────
function scrollToFirstError() {
    const firstError = document.querySelector('.is-invalid, :invalid');
    if (firstError) {
        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        // If it's a standard input, focus it
        if (typeof firstError.focus === 'function') {
            firstError.focus();
        }
    }
}

/**
 * Compress one image input as soon as a file is picked.
const COMPRESS_OPTIONS = {
    maxSizeMB: 0.4,          // target ≤ 400 KB per image
    maxWidthOrHeight: 1280,  // shrink large photos
    useWebWorker: true,      // non-blocking
    fileType: 'image/jpeg',
    initialQuality: 0.8,
};

/**
 * Compress one image input as soon as a file is picked.
 * Replaces the input's FileList with the compressed Blob via DataTransfer.
 */
async function compressInput(input) {
    const file = input.files[0];
    if (!file) return;

    const name   = input.name;
    const statEl = document.getElementById('stat_' + name);
    const prevEl = document.getElementById('prev_' + name);

    // Skip compression for PDFs
    if (file.type === 'application/pdf') {
        // Show original file info
        const originalKB = (file.size / 1024).toFixed(0);
        statEl.className = 'img-status done';
        statEl.innerHTML = `✓ PDF: ${originalKB} KB (Original)`;
        statEl.classList.remove('d-none');
        if (prevEl) prevEl.style.display = 'none'; // Hide image preview for PDF
        return;
    }

    // Show "compressing" badge
    statEl.className = 'img-status compressing';
    statEl.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Compressing…';
    statEl.classList.remove('d-none');

    try {
        const originalKB   = (file.size / 1024).toFixed(0);
        const compressed   = await imageCompression(file, COMPRESS_OPTIONS);
        const compressedKB = (compressed.size / 1024).toFixed(0);

        // Replace the FileList with the compressed file
        const dt = new DataTransfer();
        dt.items.add(new File([compressed], file.name, { type: compressed.type }));
        input.files = dt.files;

        // Show thumbnail preview
        if (prevEl) {
            prevEl.src = URL.createObjectURL(compressed);
            prevEl.style.display = 'block';
        }

        statEl.className = 'img-status done';
        statEl.innerHTML = `✓ ${originalKB} KB → ${compressedKB} KB`;
    } catch (err) {
        statEl.className = 'img-status error';
        statEl.innerHTML = '⚠ Compression failed — original file will be used';
        console.warn('Image compression error:', err);
    }
}

// Attach compression to every [data-compress] input
document.querySelectorAll('input[type="file"][data-compress]').forEach(input => {
    input.addEventListener('change', () => compressInput(input));
});

// ── Form validation & submit ─────────────────────────────────────────────────
(() => {
    const form   = document.getElementById('vehicleForm');
    const btn    = document.getElementById('submitBtn');
    const loader = document.getElementById('btnLoader');
    const text   = document.getElementById('btnText');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent actual POST to avoid 404
        
        if (!form.checkValidity()) {
            e.stopPropagation();
            form.classList.add('was-validated');
            setTimeout(scrollToFirstError, 100);
            return;
        }

        loader.classList.remove('d-none');
        text.innerHTML = 'Processing…';
        btn.disabled   = true;
        document.getElementById('pageLoader').classList.add('active');
        
        // Mock successful registration and redirect
        setTimeout(() => {
            window.location.href = "{{ route('vehicle.login') }}";
        }, 1500);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const pageLoaderEl = document.getElementById('pageLoader');
        const successMessage = document.querySelector('.swal2-container');

        if (successMessage && pageLoaderEl) {
            pageLoaderEl.classList.remove('active');
        }

        if (successMessage) {
            successMessage.addEventListener('click', function () {
                if (pageLoaderEl) {
                    pageLoaderEl.classList.remove('active');
                }
            });
        }
    });

    @if($errors->any())
        form.classList.add('was-validated');
        setTimeout(scrollToFirstError, 500);
    @endif
})();

// ── Driver same as owner ─────────────────────────────────────────────────────
const sameAsOwnerCheckbox = document.getElementById('driverSameAsOwner');
const sameAsOwnerInput = document.getElementById('driverSameAsOwnerInput');
const sameAsOwnerFields = [
    ['ownerName', 'driverName'],
    ['ownerPhone', 'driverPhone'],
    ['ownerAddress', 'driverAddress'],
    ['ownerAadhaarNumber', 'driverAadhaarNumber'],
];

function syncDriverFromOwner() {
    const checked = sameAsOwnerCheckbox.checked;
    sameAsOwnerInput.value = checked ? '1' : '0';

    sameAsOwnerFields.forEach(([src, dst]) => {
        const srcEl = document.getElementById(src);
        const dstEl = document.getElementById(dst);

        if (checked) {
            dstEl.value = srcEl.value;
            dstEl.setAttribute('readonly', true);
        } else {
            dstEl.removeAttribute('readonly');
        }
    });
}

sameAsOwnerCheckbox.addEventListener('change', syncDriverFromOwner);

sameAsOwnerFields.forEach(([src]) => {
    document.getElementById(src).addEventListener('input', function () {
        if (sameAsOwnerCheckbox.checked) {
            syncDriverFromOwner();
        }
    });
});

if (sameAsOwnerCheckbox.checked) {
    syncDriverFromOwner();
}

function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");
    if (password.type === "password") {
        password.type = "text";
        icon.classList.replace("fa-eye-slash", "fa-eye");
    } else {
        password.type = "password";
        icon.classList.replace("fa-eye", "fa-eye-slash");
    }
}

$(document).ready(function () {
    $('#wardId').select2({
        placeholder: 'Search and select ward',
        width: '100%'
    });

    $('#vehicleType').select2({
        placeholder: 'Select vehicle type',
        width: '100%',
        minimumResultsForSearch: Infinity
    });
});
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: @json(session('success')),
        confirmButtonColor: '#2a5780'
    });
</script>
@endif

</body>
</html>
