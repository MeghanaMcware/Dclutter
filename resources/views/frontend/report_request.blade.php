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

/* Stepper Progress UI */
.progress-ui {
    display: flex;
    justify-content: space-between;
    text-align: center;
    position: relative;
    margin: 10px 2% 30px;
}

.progress-ui::before {
    content: '';
    position: absolute;
    top: 16px;
    left: 8%;
    right: 8%;
    height: 2px;
    background: #d8e3dc;
    z-index: 1;
}

.progress-ui span {
    font-size: 12px;
    font-weight: 600;
    color: var(--muted);
    z-index: 2;
    background: #ffffff;
    padding: 0 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.progress-ui b {
    display: flex;
    width: 34px;
    height: 34px;
    border: 2px solid #aebbb4;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    margin-bottom: 6px;
    background: #ffffff;
    font-size: 13px;
    color: var(--muted);
    transition: all 0.2s ease;
}

.progress-ui .active b {
    background: var(--green);
    border-color: var(--green);
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(8, 125, 69, 0.25);
}

.progress-ui .active {
    color: var(--green);
    font-weight: 700;
}

.progress-ui .completed b {
    background: var(--green-light);
    border-color: var(--green);
    color: var(--green);
}

/* Category selection */
.category-card-container {
    position: relative;
    overflow: hidden;
    background: linear-gradient(145deg, #ffffff 0%, #f7fcf8 100%);
    border: 1px solid #dcebe0;
    border-radius: 20px;
    padding: 16px;
    color: var(--ink);
    margin-bottom: 16px;
    box-shadow: 0 8px 24px rgba(20, 56, 38, 0.08);
}

.category-intro {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 16px;
}

.category-card-container h2 {
    font-size: 20px;
    font-weight: 800;
    letter-spacing: -0.5px;
    margin: 0 0 4px;
    color: var(--ink);
}

.category-card-container p.subtitle {
    font-size: 13px;
    color: #64748b;
    line-height: 1.4;
    margin: 0;
}

.category-count {
    flex: 0 0 auto;
    padding: 6px 10px;
    color: #087d45;
    background: #e7f7ec;
    border: 1px solid #c9edd4;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
}

.category-options-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 10px;
}

.item-option {
    position: relative;
    overflow: hidden;
    min-height: 56px;
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;
    padding: 10px 14px;
    background: #ffffff;
    border: 1px solid #e1e9e4;
    border-radius: 12px;
    cursor: pointer;
    text-align: left;
    box-shadow: 0 3px 8px rgba(15, 23, 42, 0.03);
    transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease, background 0.22s ease;
}

.item-option:hover {
    transform: translateY(-2px);
    border-color: var(--tile-color, var(--green));
    box-shadow: 0 8px 16px color-mix(in srgb, var(--tile-color, var(--green)) 15%, transparent);
}

.item-option.selected {
    background: color-mix(in srgb, var(--tile-color, var(--green)) 8%, #ffffff) !important;
    border-color: var(--tile-color, var(--green)) !important;
    box-shadow: 0 0 0 2px color-mix(in srgb, var(--tile-color, var(--green)) 16%, transparent), 0 8px 16px rgba(15, 23, 42, 0.06) !important;
}

.item-option input[type="checkbox"] {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.category-icon {
    display: flex;
    flex-shrink: 0;
    width: 38px;
    height: 38px;
    align-items: center;
    justify-content: center;
    color: var(--tile-color, var(--green));
    background: color-mix(in srgb, var(--tile-color, var(--green)) 13%, #ffffff);
    border-radius: 10px;
    font-size: 18px;
    transition: transform 0.22s ease, color 0.22s ease, background 0.22s ease;
}

.item-option.selected .category-icon {
    color: #ffffff;
    background: var(--tile-color, var(--green));
    transform: scale(1.05);
}

.item-option-text strong {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    line-height: 1.25;
    color: #1f2937;
}

.item-option::after {
    content: '\f26a';
    position: absolute;
    top: 9px;
    right: 9px;
    display: grid;
    width: 21px;
    height: 21px;
    place-items: center;
    color: #ffffff;
    background: var(--tile-color, var(--green));
    border-radius: 50%;
    font-family: 'bootstrap-icons';
    font-size: 12px;
    opacity: 0;
    transform: scale(0.5);
    transition: opacity 0.2s ease, transform 0.2s ease;
}

.item-option.selected::after {
    opacity: 1;
    transform: scale(1);
}

@media (max-width: 768px) {
    .category-card-container { padding: 16px 12px; border-radius: 16px; }
    .category-intro { gap: 10px; margin-bottom: 14px; }
    .category-card-container h2 { font-size: 18px; }
    .category-card-container p.subtitle { font-size: 12px; }
    .category-count { padding: 4px 8px; font-size: 10px; }
    .category-card-container .category-options-grid { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; gap: 8px; }
    .category-card-container .item-option { min-height: 48px; padding: 8px 10px; border-radius: 10px; gap: 8px; }
    .category-icon { width: 32px; height: 32px; font-size: 15px; border-radius: 8px; }
    .item-option-text strong { font-size: 11px; }
}

/* Form Grid UI */
.grid-ui {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.grid-ui .wide {
    grid-column: span 2;
}

.request-ui label {
    font-size: 13px;
    font-weight: 700;
    display: block;
    margin-bottom: 8px;
    color: var(--ink);
}

.request-ui label span.req {
    color: #d93838;
}

.request-ui input, 
.request-ui select, 
.request-ui textarea {
    width: 100%;
    height: 42px;
    border: 1px solid var(--line);
    border-radius: 6px;
    padding: 0 14px;
    font-size: 13px;
    color: #2b3930;
    background: #ffffff;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
}

.request-ui textarea {
    padding-top: 10px;
    min-height: 80px;
    resize: vertical;
}

/* Custom File Upload Styles */
.file-upload-box {
    display: flex;
    align-items: center;
    border: 1px solid var(--line);
    border-radius: 20px;
    padding: 0;
    cursor: pointer;
    background: #fff;
    transition: all 0.2s ease;
    height: 42px;
    position: relative;
}
.file-upload-box.is-valid {
    border-color: var(--green);
    border-width: 2px;
    background: #f0fdf4;
}
.file-upload-btn {
    padding: 0 16px;
    font-weight: 500;
    color: var(--ink);
    border-right: 1px solid var(--line);
    height: 100%;
    display: flex;
    align-items: center;
    background: transparent;
}
.file-upload-text {
    padding: 0 16px;
    color: var(--muted);
    font-size: 14px;
    flex-grow: 1;
}
.file-upload-box.is-valid .file-upload-text {
    color: var(--ink);
    font-weight: 500;
}
.file-upload-check {
    position: absolute;
    right: 16px;
    font-size: 18px;
    font-weight: bold;
}
.image-preview-container {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-top: 14px;
}
.image-preview-item {
    position: relative;
    width: 70px;
    height: 70px;
    border-radius: 8px;
    overflow: visible;
    border: 1px solid var(--line);
    background: #f8f9fa;
}
.image-preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 8px;
}
.image-preview-remove {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff4d4f;
    color: white;
    border-radius: 50%;
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    z-index: 2;
}

.request-ui input:focus, 
.request-ui select:focus, 
.request-ui textarea:focus {
    border-color: var(--green);
    outline: none;
    box-shadow: 0 0 0 3px rgba(8, 125, 69, 0.12);
}

.request-ui input.is-valid, 
.request-ui select.is-valid, 
.request-ui textarea.is-valid {
    border-color: #087d45 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23087d45' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7L4.3 6.73c-.6.67-1.4.67-2 0z'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 16px 16px !important;
    box-shadow: 0 0 0 3px rgba(8, 125, 69, 0.15) !important;
}

.invalid-feedback, .error-feedback {
    display: none;
    width: 100%;
    margin-top: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #dc3545 !important;
}

.was-validated input:invalid ~ .invalid-feedback,
.was-validated select:invalid ~ .invalid-feedback,
.was-validated textarea:invalid ~ .invalid-feedback,
input.is-invalid ~ .invalid-feedback,
select.is-invalid ~ .invalid-feedback,
textarea.is-invalid ~ .invalid-feedback,
.is-invalid ~ .error-feedback {
    display: block !important;
}

.request-ui input.is-invalid, 
.request-ui select.is-invalid, 
.request-ui textarea.is-invalid,
.was-validated input:invalid, 
.was-validated select:invalid, 
.was-validated textarea:invalid {
    border-color: #dc3545 !important;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5zM6 8.2a.6.6 0 100-1.2.6.6 0 000 1.2z'/%3e%3c/svg%3e") !important;
    background-repeat: no-repeat !important;
    background-position: right 12px center !important;
    background-size: 16px 16px !important;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15) !important;
}

/* Fetch Location Button */
.btn-fetch-loc {
    background: #e3f3e8;
    color: var(--green);
    border: 1px solid #bce4c8;
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}

.btn-fetch-loc:hover {
    background: var(--green);
    color: #ffffff !important;
    border-color: var(--green);
}

/* Interactive Map UI */
.map-container-box {
    border: 1px solid var(--line);
    border-radius: 6px;
    overflow: hidden;
    background: #f7faf8;
}

.map-search-bar {
    display: flex;
    gap: 8px;
    padding: 8px;
    background: #ffffff;
    border-bottom: 1px solid var(--line);
}

.map-search-bar input {
    height: 36px;
}

.map-ui {
    height: 200px;
    width: 100%;
    z-index: 1;
}

.map-hint {
    font-size: 11px;
    color: var(--muted);
    padding: 6px 12px;
    background: #f2f6f4;
    display: flex;
    align-items: center;
    gap: 6px;
}

/* Buttons */
.btn-ui {
    border: 0;
    border-radius: 6px;
    background: var(--green);
    color: #ffffff !important;
    font-size: 14px;
    font-weight: 700;
    padding: 12px 28px;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s ease, transform 0.1s ease;
    box-shadow: 0 3px 10px rgba(8, 125, 69, 0.2);
}

.btn-ui:hover {
    background: var(--green-dark);
    transform: translateY(-1px);
}

.btn-secondary-ui {
    background: #ffffff;
    color: var(--ink) !important;
    border: 1.5px solid #aebbb4;
    box-shadow: none;
}

.btn-secondary-ui:hover {
    background: #f4f7f5;
    border-color: var(--green);
}

.continue-btn {
    display: block;
    width: 100%;
    text-align: center;
    margin-top: 16px;
    font-size: 15px;
    padding: 14px;
}

.step-header {
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 16px;
    color: var(--ink);
    border-bottom: 2px solid var(--green-light);
    padding-bottom: 8px;
}

.mobile-step-badge {
    display: none;
    background: #e8f5ed;
    color: var(--green);
    border: 1px solid #bce4c8;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: 13px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .grid-ui { grid-template-columns: 1fr; }
    .grid-ui .wide { grid-column: span 1; }

    .progress-ui {
        margin: 5px 0 16px;
        padding: 0 4px;
    }

    .progress-ui::before {
        top: 15px;
        left: 10%;
        right: 10%;
    }

    .progress-ui span {
        font-size: 10px;
        font-weight: 600;
        padding: 0 2px;
        max-width: 72px;
        line-height: 1.2;
    }

    .progress-ui b {
        width: 28px;
        height: 28px;
        font-size: 12px;
        margin-bottom: 4px;
    }

    .mobile-step-badge {
        display: block;
    }
}
</style>

@section('content')
<main class="request-ui">
    <div class="crumb"><a href="{{ url('/') }}">Home</a> / Report Request</div>
    <h1>Report D-Clutter Waste</h1>

    <div class="card-ui">
        <!-- Stepper Progress Bar -->
        <div class="progress-ui">
            <span id="step-nav-1" class="active"><b>1</b>Category Select</span>
            <span id="step-nav-2"><b>2</b>Location</span>
            <span id="step-nav-3"><b>3</b>Pickup Day</span>
            <span id="step-nav-4"><b>4</b>Review &amp; Submit</span>
        </div>

        <div id="mobile-step-title" class="mobile-step-badge">
            <i class="bi bi-info-circle-fill me-1"></i> Step 1 of 4: Category Select
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-4" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="cdWasteForm" action="{{ route('citizen.report.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate onsubmit="handleFormSubmit(event)">
            @csrf
            <input type="hidden" name="latitude" id="latitudeInput" value="12.9716">
            <input type="hidden" name="longitude" id="longitudeInput" value="77.5946">
            
            <!-- ================= STEP 1: CATEGORY SELECT ================= -->
            <div id="step-1" class="wizard-step">
                <div class="category-card-container">
                    <div class="category-intro">
                        <div>
                            <h2>Choose items for pickup</h2>
                            <p class="subtitle">Select one or more categories for your pickup request.</p>
                        </div>
                        <span class="category-count" id="selected-category-count">0 selected</span>
                    </div>

                    <div class="category-options-grid">
                        @forelse($categories as $index => $category)
                            @php
                                $colors = ['#0e7a43', '#4d7cda', '#d97706', '#8b5cf6', '#0f9bb4', '#b45309', '#e05d3b', '#64748b'];
                                $tileColor = $colors[$index % count($colors)];
                            @endphp
                            <label class="item-option" style="--tile-color: {{ $tileColor }};">
                                <input type="checkbox" name="pickup_items[]" value="{{ $category->name }}" data-id="{{ $category->id }}" onchange="onCategoryItemChange(this)">
                                <span class="category-icon">
                                    @if($category->icon)
                                        @if(str_starts_with($category->icon, 'fa-') || str_starts_with($category->icon, 'fa'))
                                            <i class="fa-solid {{ $category->icon }}"></i>
                                        @else
                                            <img src="{{ str_starts_with($category->icon, 'http') || str_starts_with($category->icon, '/') ? $category->icon : asset('storage/' . $category->icon) }}" width="24" height="24" class="rounded object-fit-cover" onerror="this.src='https://placehold.co/24x24'">
                                        @endif
                                    @else
                                        <i class="fa-solid fa-box-open"></i>
                                    @endif
                                </span>
                                <span class="item-option-text"><strong>{{ $category->name }}</strong></span>
                            </label>
                        @empty
                            <p class="text-muted col-span-3">No categories active currently.</p>
                        @endforelse
                    </div>

                    <!-- Dynamic Subcategory Section -->
                    <div id="subcategory-section" style="display: none; margin-top: 20px; border-top: 1px solid #dcebe0; padding-top: 16px;">
                        <h3 style="font-size: 16px; font-weight: 700; color: var(--ink); margin-bottom: 12px;">Select Subcategory</h3>
                        <div id="subcategory-container" style="display: flex; flex-direction: column; gap: 16px;">
                            <!-- Subcategories will be injected here via JS -->
                        </div>
                    </div>
                </div>

                <div id="step1-error" class="error-feedback mb-3" style="display:none; color: #dc3545 !important;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Please select at least one item for pickup.
                </div>
                <div id="step1-subcat-error" class="error-feedback mb-3" style="display:none; color: #dc3545 !important;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Please select at least one specific subcategory/detail.
                </div>

                <button type="button" class="btn-ui continue-btn" onclick="goToStep(2)">
                    Next: Location Details <i class="bi bi-arrow-right"></i>
                </button>
            </div>

            <!-- ================= STEP 2: LOCATION ================= -->
            <div id="step-2" class="wizard-step" style="display:none;">
                <div class="step-header">Pickup Location Details</div>

                <div class="grid-ui">
                    <!-- Applicant Name -->
                    <div>
                        <label>Applicant Full Name <span class="req">*</span></label>
                        <input type="text" id="applicantNameInput" name="applicant_name" placeholder="Enter Full Name" required oninput="validateSingleField(this)">
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please enter full applicant name.</div>
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label>Mobile Number <span class="req">*</span></label>
                        <input type="tel" id="mobileInput" name="mobile_number" required oninput="validateSingleField(this)" onchange="validateSingleField(this)" placeholder="Registered Mobile Number" maxlength="10" pattern="[0-9]{10}">
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please enter a valid 10-digit mobile number.</div>
                    </div>

                    <!-- Image Upload -->
                    <div class="wide">
                        <label>Upload Waste Images <span class="req">*</span></label>
                        <div class="custom-file-upload">
                            <input type="file" id="wasteImagesInput" name="waste_images[]" accept="image/*" multiple style="display:none;" onchange="handleImageSelection(event)">
                            <div class="file-upload-box" id="fileUploadBox" onclick="document.getElementById('wasteImagesInput').click()">
                                <div class="file-upload-btn">Choose Files</div>
                                <div class="file-upload-text" id="fileUploadText">No files selected</div>
                                <i class="bi bi-check-lg text-success file-upload-check" style="display:none;" id="fileUploadCheck"></i>
                            </div>
                            <div class="invalid-feedback" id="fileUploadError" style="color: #dc3545 !important; display:none; margin-top:4px;">Please select at least one image.</div>
                            <div style="font-size: 11px; color: var(--muted); margin-top: 4px;">You can select multiple images to upload.</div>
                            
                            <div class="image-preview-container" id="imagePreviewContainer"></div>
                        </div>
                    </div>

                    <!-- Pickup Address -->
                    <div class="wide">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <label style="margin-bottom: 0;">Pickup Location <span class="req">*</span></label>
                            <button type="button" class="btn-fetch-loc" onclick="fetchCurrentLocation()">
                                <i class="bi bi-crosshair"></i> Fetch Location
                            </button>
                        </div>
                        <textarea id="addressInput" name="address" required oninput="validateSingleField(this)" onchange="validateSingleField(this)" placeholder="Enter complete site address (House/Site No, Street, Main, Area)"></textarea>
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please enter complete site address.</div>
                    </div>

                    <!-- Map -->
                    <div class="wide">
                        <label>Pin location on map (Click map to position marker &amp; auto-map Ward)</label>
                        <div class="map-container-box">
                            <div class="map-search-bar">
                                <input type="text" id="mapSearchInput" placeholder="Search location e.g. Indiranagar, Bengaluru">
                                <button type="button" class="btn-ui" onclick="searchOnMap()" style="padding: 6px 14px; font-size: 12px;">Search</button>
                                <button type="button" class="btn-fetch-loc" onclick="fetchCurrentLocation()" style="padding: 6px 12px; font-size: 12px;">
                                    <i class="bi bi-geo-alt-fill"></i> GPS
                                </button>
                            </div>
                            <div id="location-map" class="map-ui"></div>
                            <div class="map-hint">
                                <i class="bi bi-geo-alt-fill text-success"></i> <span id="mapCoordinates">Location selected: 12.9716° N, 77.5946° E</span>
                            </div>
                        </div>
                    </div>

                    <!-- House No -->
                    <div>
                        <label>House No <span class="req">*</span></label>
                        <input type="text" id="houseNoInput" name="house_no" placeholder="e.g. #123" required oninput="validateSingleField(this)">
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please enter house number.</div>
                    </div>

                    <!-- Ward (Readonly - Auto-Mapped from GPS) -->
                    <div>
                        <label>Ward (Auto-Mapped from Map Pin) <span class="req">*</span></label>
                        <input type="hidden" name="ward_id" id="wardIdInput" required>
                        <input type="text" id="wardDisplayInput" placeholder="Pin location on map to map Ward..." readonly required style="background-color: #f8f9fa; cursor: not-allowed; font-weight: 700; color: var(--green);">
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please pin your location on the map to auto-map Ward.</div>
                    </div>

                    <!-- Constituency (Readonly - Auto-Mapped) -->
                    <div>
                        <label>Constituency (Auto-Mapped)</label>
                        <input type="text" id="constituencyInput" placeholder="Auto-mapped from Ward..." readonly style="background-color: #f8f9fa; cursor: not-allowed;">
                    </div>

                    <!-- Corporation (Readonly - Auto-Mapped) -->
                    <div>
                        <label>Corporation (Auto-Mapped)</label>
                        <input type="text" id="corporationInput" placeholder="Auto-mapped from Ward..." readonly style="background-color: #f8f9fa; cursor: not-allowed;">
                    </div>

                    <!-- Landmark -->
                    <div>
                        <label>Landmark <span class="req">*</span></label>
                        <input type="text" id="landmarkInput" name="landmark" placeholder="Enter nearby landmark (e.g. Near Metro Station)" required oninput="validateSingleField(this)">
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please enter a landmark.</div>
                    </div>

                    <!-- Pincode -->
                    <div>
                        <label>Pincode <span class="req">*</span></label>
                        <input type="text" id="pincodeInput" name="pincode" required oninput="validateSingleField(this)" onchange="validateSingleField(this)" placeholder="Enter 6-digit Pincode" maxlength="6" pattern="[0-9]{6}">
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please enter a valid 6-digit pincode.</div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="button" class="btn-ui btn-secondary-ui" onclick="goToStep(1)" style="width: 30%;">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn-ui continue-btn mt-0" onclick="goToStep(3)" style="width: 70%;">
                        Next: Pickup Day <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- ================= STEP 3: PICKUP DAY (SUNDAYS ONLY) ================= -->
            <div id="step-3" class="wizard-step" style="display:none;">
                <div class="step-header">Select Pickup Day (Sundays Only)</div>

                <div class="mb-3">
                    <label for="preferredDateInput">Select Pickup Date (Only Sundays) <span class="req">*</span></label>
                    <input type="date" id="preferredDateInput" name="preferred_pickup_date" required onchange="validateSundayDate(this)">
                    <div id="date-error" class="invalid-feedback" style="color: #dc3545 !important;">
                        Please select a valid Sunday for pickup.
                    </div>
                </div>

                <div style="background: #e8f5ed; border: 1px solid #bce4c8; border-radius: 8px; padding: 14px; margin-bottom: 20px;">
                    <div style="font-weight: 700; color: var(--green); margin-bottom: 4px;">
                        <i class="bi bi-info-circle-fill"></i> Note:
                    </div>
                    <div style="font-size: 13px; color: #2b3930;">
                        All Waste should be dismantled & should be available on the ground floor.
                    </div>
                </div>
                
                <div class="d-flex gap-3 mt-4">
                    <button type="button" class="btn-ui btn-secondary-ui" onclick="goToStep(2)" style="width: 30%;">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn-ui continue-btn mt-0" onclick="goToStep(4)" style="width: 70%;">
                        Next: Review &amp; Submit <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </div>

            <!-- ================= STEP 4: REVIEW & SUBMIT ================= -->
            <div id="step-4" class="wizard-step" style="display:none;">
                <div class="step-header">Review &amp; Submit Request</div>

                <div style="border: 1px solid var(--line); border-radius: 8px; padding: 20px; background: #f8faf9; margin-bottom: 20px;">
                    <h3 style="font-size: 16px; font-weight: 800; color: var(--green); margin-bottom: 16px;">
                        <i class="bi bi-card-checklist"></i> Summary of Selected Details
                    </h3>

                    <div style="margin-bottom: 14px; border-bottom: 1px solid var(--line); padding-bottom: 10px;">
                        <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">SELECTED ITEMS FOR PICKUP</small>
                        <div id="review-items" style="font-weight: 700; color: var(--ink); font-size: 14px; margin-top: 4px;">-</div>
                    </div>

                    <div style="margin-bottom: 14px; border-bottom: 1px solid var(--line); padding-bottom: 10px;">
                        <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">WASTE IMAGES</small>
                        <div id="review-images" style="margin-top: 8px; display: flex; flex-wrap: wrap; gap: 8px;">-</div>
                    </div>

                    <div class="grid-ui" style="margin-bottom: 14px;">
                        <div>
                            <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">APPLICANT NAME</small>
                            <div id="review-applicant-name" style="font-weight: 700; color: var(--ink); font-size: 13px; margin-top: 4px;">-</div>
                        </div>
                        <div>
                            <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">HOUSE NO</small>
                            <div id="review-house-no" style="font-weight: 700; color: var(--ink); font-size: 13px; margin-top: 4px;">-</div>
                        </div>
                    </div>

                    <div class="grid-ui" style="margin-bottom: 14px;">
                        <div>
                            <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">PICKUP LOCATION</small>
                            <div id="review-address" style="font-weight: 700; color: var(--ink); font-size: 13px; margin-top: 4px;">-</div>
                        </div>
                        <div>
                            <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">AUTO-MAPPED WARD &amp; PINCODE</small>
                            <div id="review-ward" style="font-weight: 700; color: var(--ink); font-size: 13px; margin-top: 4px;">-</div>
                        </div>
                    </div>

                    <div class="grid-ui">
                        <div>
                            <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">MOBILE NUMBER</small>
                            <div id="review-mobile" style="font-weight: 700; color: var(--ink); font-size: 13px; margin-top: 4px;">-</div>
                        </div>
                        <div>
                            <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">SCHEDULED SUNDAY PICKUP DATE</small>
                            <div id="review-date" style="font-weight: 800; color: var(--green); font-size: 14px; margin-top: 4px;">-</div>
                        </div>
                    </div>

                    <div style="background: #e8f5ed; border: 1px solid #bce4c8; border-radius: 8px; padding: 14px; margin-bottom: 20px; margin-top: 10px;">
                        <div style="font-weight: 700; color: var(--green); margin-bottom: 4px;">
                            <i class="bi bi-info-circle-fill"></i> Note:
                        </div>
                        <div style="font-size: 13px; color: #2b3930;">
                            All Waste should be dismantled & should be available on the ground floor.
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-3 mt-4">
                    <button type="button" class="btn-ui btn-secondary-ui" onclick="goToStep(3)" style="width: 30%;">
                        <i class="bi bi-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn-ui continue-btn mt-0" style="width: 70%;">
                        <i class="bi bi-check-circle-fill"></i> Submit D-Clutter Request
                    </button>
                </div>
            </div>

        </form>
    </div>
</main>
@endsection

@section('script')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
let globalMap = null;
let globalMarker = null;
let currentStep = 1;
let fpInstance = null;
let updateLocationDebounceTimer = null;
let selectedWasteFiles = [];
let isProgrammaticSync = false;

// Dynamic Categories & Subcategories from Backend Database
const dbCategories = @json($categories);
const subcategoriesMap = {};
const categoryStyles = {};

dbCategories.forEach((cat, index) => {
    const colors = ['#0e7a43', '#4d7cda', '#d97706', '#8b5cf6', '#0f9bb4', '#b45309', '#e05d3b', '#64748b'];
    categoryStyles[cat.name] = { color: colors[index % colors.length] };
    subcategoriesMap[cat.name] = (cat.subcategories || []).map(sub => ({
        id: sub.id,
        name: sub.name,
        icon: sub.icon || 'fa-tag'
    }));
});

document.addEventListener('DOMContentLoaded', function() {
    if (typeof hideLoader === 'function') hideLoader();

    initSundayDatePicker();
    setTimeout(() => {
        initLeafletMap();
    }, 100);
    fetchCurrentLocation({ silent: true });
});

function handleImageSelection(event) {
    if (isProgrammaticSync) return;

    const newFiles = event.target.files;
    if (!newFiles || newFiles.length === 0) return;

    // Reset array to exact files picked in dialog
    selectedWasteFiles = Array.from(newFiles);

    updateImagePreview();
}

function removeImage(index) {
    if (index >= 0 && index < selectedWasteFiles.length) {
        selectedWasteFiles.splice(index, 1);

        // Sync remaining files back to input.files using DataTransfer with guard flag
        isProgrammaticSync = true;
        const dt = new DataTransfer();
        selectedWasteFiles.forEach(file => dt.items.add(file));
        const input = document.getElementById('wasteImagesInput');
        if (input) {
            input.files = dt.files;
        }
        isProgrammaticSync = false;

        updateImagePreview();
    }
}

function updateImagePreview() {
    const container = document.getElementById('imagePreviewContainer');
    if (!container) return;
    container.innerHTML = '';

    const fileText = document.getElementById('fileUploadText');
    const box = document.getElementById('fileUploadBox');
    const check = document.getElementById('fileUploadCheck');
    const err = document.getElementById('fileUploadError');

    if (selectedWasteFiles.length > 0) {
        if (fileText) fileText.textContent = selectedWasteFiles.length + ' file(s) selected';
        if (box) {
            box.classList.add('is-valid');
            box.style.borderColor = '';
        }
        if (check) check.style.display = 'block';
        if (err) err.style.display = 'none';

        selectedWasteFiles.forEach((file, i) => {
            const blobUrl = URL.createObjectURL(file);
            const div = document.createElement('div');
            div.className = 'image-preview-item';
            div.innerHTML = `
                <img src="${blobUrl}" alt="Preview">
                <div class="image-preview-remove" onclick="removeImage(${i})">
                    <i class="bi bi-x"></i>
                </div>
            `;
            container.appendChild(div);
        });
    } else {
        if (fileText) fileText.textContent = 'No files selected';
        if (box) box.classList.remove('is-valid');
        if (check) check.style.display = 'none';
    }
}

function renderSubcategories() {
    const checked = Array.from(document.querySelectorAll('input[name="pickup_items[]"]:checked')).map(cb => cb.value);
    const container = document.getElementById('subcategory-container');
    const section = document.getElementById('subcategory-section');
    
    container.innerHTML = '';
    
    if (checked.length === 0) {
        section.style.display = 'none';
        return;
    }
    
    section.style.display = 'block';
    
    checked.forEach(category => {
        if (subcategoriesMap[category] && subcategoriesMap[category].length > 0) {
            const catDiv = document.createElement('div');
            catDiv.style.marginBottom = '20px';
            
            const title = document.createElement('div');
            title.style.fontWeight = '700';
            title.style.fontSize = '14px';
            title.style.marginBottom = '12px';
            title.style.color = 'var(--ink)';
            title.textContent = `Details for ${category}`;
            catDiv.appendChild(title);
            
            const optionsDiv = document.createElement('div');
            optionsDiv.className = 'category-options-grid';
            
            const styleInfo = categoryStyles[category];
            const tileColor = styleInfo ? styleInfo.color : '#087d45';
            
            subcategoriesMap[category].forEach(subcatObj => {
                const subcatName = subcatObj.name;
                const subcatIcon = subcatObj.icon;

                const label = document.createElement('label');
                label.className = 'item-option';
                label.style.setProperty('--tile-color', tileColor);
                
                const input = document.createElement('input');
                input.type = 'checkbox';
                input.name = 'pickup_subitems[]';
                input.value = `${category}: ${subcatName}`;
                
                input.onchange = function() {
                    if (this.checked) {
                        label.classList.add('selected');
                        const err = document.getElementById('step1-subcat-error');
                        if (err) err.style.display = 'none';
                    } else {
                        label.classList.remove('selected');
                    }
                };
                
                const iconSpan = document.createElement('span');
                iconSpan.className = 'category-icon';
                if (subcatIcon.startsWith('fa-') || subcatIcon.startsWith('fa')) {
                    iconSpan.innerHTML = `<i class="fa-solid ${subcatIcon}"></i>`;
                } else {
                    iconSpan.innerHTML = `<i class="fa-solid fa-tag"></i>`;
                }
                
                const textSpan = document.createElement('span');
                textSpan.className = 'item-option-text';
                textSpan.innerHTML = `<strong>${subcatName}</strong>`;
                
                label.appendChild(input);
                label.appendChild(iconSpan);
                label.appendChild(textSpan);
                optionsDiv.appendChild(label);
            });
            
            catDiv.appendChild(optionsDiv);
            container.appendChild(catDiv);
        }
    });
}

function onCategoryItemChange(cb) {
    const parentLabel = cb.closest('.item-option');
    if (parentLabel) {
        if (cb.checked) {
            parentLabel.classList.add('selected');
        } else {
            parentLabel.classList.remove('selected');
        }
    }
    const checked = document.querySelectorAll('input[name="pickup_items[]"]:checked');
    const selectedCount = document.getElementById('selected-category-count');
    if (selectedCount) {
        selectedCount.textContent = `${checked.length} selected`;
    }
    const err = document.getElementById('step1-error');
    if (checked.length > 0) {
        if (err) err.style.display = 'none';
    }

    renderSubcategories();

    if (cb.checked) {
        setTimeout(() => {
            const section = document.getElementById('subcategory-section');
            if (section && section.style.display !== 'none') {
                section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 50);
    }
}

function validateSingleField(el) {
    if (!el) return;
    if (el.value && el.value.trim() !== '' && el.checkValidity()) {
        el.classList.remove('is-invalid');
        el.classList.add('is-valid');
    } else {
        el.classList.remove('is-valid');
        if (el.hasAttribute('required') || (el.value && !el.checkValidity())) {
            el.classList.add('is-invalid');
        }
    }
}

function initSundayDatePicker() {
    const dateInput = document.getElementById('preferredDateInput');
    if (!dateInput) return;

    dateInput.type = "text";
    dateInput.placeholder = "Click to select a Sunday";

    const today = new Date();
    const dayOfWeek = today.getDay();
    const daysUntilSunday = (7 - dayOfWeek) % 7 || 7;
    const nextSunday = new Date(today);
    nextSunday.setDate(today.getDate() + daysUntilSunday);

    fpInstance = flatpickr("#preferredDateInput", {
        dateFormat: "Y-m-d",
        minDate: "today",
        defaultDate: nextSunday,
        enable: [
            function(date) {
                return (date.getDay() === 0);
            }
        ],
        onChange: function(selectedDates, dateStr, instance) {
            const errorDiv = document.getElementById('date-error');
            if (selectedDates.length > 0 && selectedDates[0].getDay() === 0) {
                dateInput.classList.remove('is-invalid');
                dateInput.classList.add('is-valid');
                if (errorDiv) errorDiv.style.display = 'none';
            } else {
                dateInput.classList.remove('is-valid');
                dateInput.classList.add('is-invalid');
                if (errorDiv) {
                    errorDiv.innerText = "Pickup is strictly available on Sundays only. Please select a Sunday.";
                    errorDiv.style.display = 'block';
                }
            }
        }
    });

    dateInput.classList.add('is-valid');
}

function validateSundayDate(input) {
    const errorDiv = document.getElementById('date-error');
    if (!input || !input.value) {
        if (input) {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
        if (errorDiv) {
            errorDiv.innerText = "Please select a Sunday date.";
            errorDiv.style.display = 'block';
        }
        return false;
    }

    const parts = input.value.split('-');
    const chosenDate = new Date(parts[0], parts[1] - 1, parts[2]);

    if (chosenDate.getDay() !== 0) {
        input.classList.remove('is-valid');
        input.classList.add('is-invalid');
        if (errorDiv) {
            errorDiv.innerText = "Pickup is strictly available on Sundays only. Please pick a Sunday date.";
            errorDiv.style.display = 'block';
        }
        return false;
    } else {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        if (errorDiv) errorDiv.style.display = 'none';
        return true;
    }
}

function goToStep(stepNum) {
    if (stepNum > currentStep) {
        if (!validateStep(currentStep)) {
            return;
        }
    }

    currentStep = stepNum;

    for (let i = 1; i <= 4; i++) {
        const stepEl = document.getElementById(`step-${i}`);
        const navEl = document.getElementById(`step-nav-${i}`);
        if (stepEl) {
            stepEl.style.display = (i === stepNum) ? 'block' : 'none';
        }
        if (navEl) {
            navEl.className = (i === stepNum) ? 'active' : (i < stepNum ? 'completed' : '');
        }
    }

    if (stepNum === 2 && globalMap) {
        setTimeout(() => {
            globalMap.invalidateSize();
        }, 200);
    }

    if (stepNum === 4) {
        buildReviewSummary();
    }

    window.scrollTo({ top: 100, behavior: 'smooth' });
}

function validateStep(step) {
    if (step === 1) {
        const checkedItems = document.querySelectorAll('input[name="pickup_items[]"]:checked');
        const errorDiv = document.getElementById('step1-error');
        const subcatErrorDiv = document.getElementById('step1-subcat-error');
        
        let valid = true;
        
        if (checkedItems.length === 0) {
            if (errorDiv) errorDiv.style.display = 'block';
            if (subcatErrorDiv) subcatErrorDiv.style.display = 'none';
            valid = false;
        } else {
            if (errorDiv) errorDiv.style.display = 'none';
            
            const checkedSubItems = document.querySelectorAll('input[name="pickup_subitems[]"]:checked');
            if (checkedSubItems.length === 0) {
                if (subcatErrorDiv) subcatErrorDiv.style.display = 'block';
                valid = false;
            } else {
                if (subcatErrorDiv) subcatErrorDiv.style.display = 'none';
            }
        }
        
        return valid;
    }

    if (step === 2) {
        const applicantName = document.getElementById('applicantNameInput');
        const address = document.getElementById('addressInput');
        const houseNo = document.getElementById('houseNoInput');
        const landmark = document.getElementById('landmarkInput');
        const wardDisplay = document.getElementById('wardDisplayInput');
        const wardId = document.getElementById('wardIdInput');
        const pincode = document.getElementById('pincodeInput');
        const mobile = document.getElementById('mobileInput');

        let valid = true;
        
        const imageError = document.getElementById('fileUploadError');
        const imageBox = document.getElementById('fileUploadBox');
        if (selectedWasteFiles.length === 0) {
            if (imageError) imageError.style.display = 'block';
            if (imageBox) imageBox.style.borderColor = '#dc3545';
            valid = false;
        } else {
            if (imageError) imageError.style.display = 'none';
        }

        [applicantName, address, houseNo, landmark, wardDisplay, pincode, mobile].forEach(el => {
            if (!el || !el.value || el.value.trim() === '' || !el.checkValidity()) {
                if (el) {
                    el.classList.remove('is-valid');
                    el.classList.add('is-invalid');
                }
                valid = false;
            } else {
                if (el) {
                    el.classList.remove('is-invalid');
                    el.classList.add('is-valid');
                }
            }
        });

        if (!wardId || !wardId.value) {
            if (wardDisplay) {
                wardDisplay.classList.remove('is-valid');
                wardDisplay.classList.add('is-invalid');
            }
            valid = false;
        }

        return valid;
    }

    if (step === 3) {
        const dateInput = document.getElementById('preferredDateInput');
        return validateSundayDate(dateInput);
    }

    return true;
}

function buildReviewSummary() {
    const checkedItems = Array.from(document.querySelectorAll('input[name="pickup_items[]"]:checked')).map(cb => cb.value);
    const checkedSubItems = Array.from(document.querySelectorAll('input[name="pickup_subitems[]"]:checked')).map(cb => cb.value.split(': ')[1]);
    
    let itemsText = checkedItems.length ? checkedItems.join(', ') : 'None selected';
    if (checkedSubItems.length > 0) {
        itemsText += `\n(Details: ${checkedSubItems.join(', ')})`;
    }
    document.getElementById('review-items').innerText = itemsText;
    
    const imageContainer = document.getElementById('review-images');
    imageContainer.innerHTML = '';
    
    if (selectedWasteFiles.length > 0) {
        imageContainer.style.fontWeight = 'normal';
        imageContainer.style.color = '';
        imageContainer.style.fontSize = '';
        
        selectedWasteFiles.forEach(file => {
            const blobUrl = URL.createObjectURL(file);
            const img = document.createElement('img');
            img.src = blobUrl;
            img.style.width = '64px';
            img.style.height = '64px';
            img.style.objectFit = 'cover';
            img.style.borderRadius = '6px';
            img.style.border = '1px solid var(--line)';
            imageContainer.appendChild(img);
        });
    } else {
        imageContainer.innerText = 'None';
        imageContainer.style.fontWeight = '700';
        imageContainer.style.color = 'var(--ink)';
        imageContainer.style.fontSize = '14px';
    }
    
    document.getElementById('review-applicant-name').innerText = document.getElementById('applicantNameInput').value || '-';
    document.getElementById('review-house-no').innerText = document.getElementById('houseNoInput').value || '-';
    document.getElementById('review-address').innerText = document.getElementById('addressInput').value || '-';
    
    const wardDisplay = document.getElementById('wardDisplayInput');
    const pinVal = document.getElementById('pincodeInput').value;
    document.getElementById('review-ward').innerText = `${wardDisplay ? wardDisplay.value : '-'} (${pinVal ? 'Pin: ' + pinVal : '-'})`;
    
    document.getElementById('review-mobile').innerText = document.getElementById('mobileInput').value || '-';
    
    const dateVal = document.getElementById('preferredDateInput').value;
    if (dateVal) {
        const parts = dateVal.split('-');
        const d = new Date(parts[0], parts[1] - 1, parts[2]);
        const formatted = d.toLocaleDateString('en-GB', { weekday: 'long', day: '2-digit', month: 'short', year: 'numeric' });
        document.getElementById('review-date').innerText = formatted;
    } else {
        document.getElementById('review-date').innerText = '-';
    }
}

function initLeafletMap() {
    const mapElement = document.getElementById('location-map');
    if (!mapElement) return;

    const defaultLat = 12.9716;
    const defaultLng = 77.5946;

    globalMap = L.map('location-map').setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(globalMap);

    globalMarker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(globalMap);

    function updateMarkerCoords(lat, lng) {
        document.getElementById('mapCoordinates').innerText = `Location selected: ${lat.toFixed(4)}° N, ${lng.toFixed(4)}° E`;
        document.getElementById('latitudeInput').value = lat;
        document.getElementById('longitudeInput').value = lng;
    }

    globalMarker.on('dragend', function(e) {
        const position = globalMarker.getLatLng();
        updateMarkerCoords(position.lat, position.lng);
        updatePickupLocation(position.lat, position.lng);
    });

    globalMap.on('click', function(e) {
        globalMarker.setLatLng(e.latlng);
        updateMarkerCoords(e.latlng.lat, e.latlng.lng);
        updatePickupLocation(e.latlng.lat, e.latlng.lng);
    });

    window.searchOnMap = function() {
        const query = document.getElementById('mapSearchInput').value;
        if (!query) return;
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Bengaluru')}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lon = parseFloat(data[0].lon);
                    globalMap.setView([lat, lon], 14);
                    globalMarker.setLatLng([lat, lon]);
                    updateMarkerCoords(lat, lon);
                    updatePickupLocation(lat, lon);
                }
            })
            .catch(err => console.error('Map search failed', err));
    };
}

function updatePickupLocation(lat, lng) {
    if (updateLocationDebounceTimer) {
        clearTimeout(updateLocationDebounceTimer);
    }

    updateLocationDebounceTimer = setTimeout(() => {
        const wardIdInput = document.getElementById('wardIdInput');
        const wardDisplay = document.getElementById('wardDisplayInput');
        const constInput = document.getElementById('constituencyInput');
        const corpInput = document.getElementById('corporationInput');

        // 1. Fast local Laravel Spatial Ward Lookup (<20ms)
        fetch(`{{ route('citizen.lookup-ward') }}?lat=${lat}&lng=${lng}`)
            .then(r => r.json())
            .then(wardRes => {
                if (wardRes.success && wardRes.ward) {
                    if (wardIdInput) wardIdInput.value = wardRes.ward.id;
                    if (wardDisplay) {
                        wardDisplay.value = `${wardRes.ward.name} (${wardRes.ward.constituency_name || 'Ward ' + wardRes.ward.ward_number})`;
                        validateSingleField(wardDisplay);
                    }
                    if (constInput) {
                        constInput.value = wardRes.ward.constituency_name || 'N/A';
                        validateSingleField(constInput);
                    }
                    if (corpInput) {
                        corpInput.value = wardRes.ward.corporation_name || 'N/A';
                        validateSingleField(corpInput);
                    }
                }
            })
            .catch(e => console.error('Ward spatial lookup error', e));

        // 2. Safe reverse geocoding with 2.5s AbortController timeout
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 2500);

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lng)}`, {
            signal: controller.signal,
            headers: { 'Accept-Language': 'en' }
        })
        .then(res => {
            clearTimeout(timeoutId);
            if (!res.ok) throw new Error('Reverse geocode error');
            return res.json();
        })
        .then(data => {
            const addrEl = document.getElementById('addressInput');
            if (data && data.display_name && addrEl && !addrEl.value) {
                addrEl.value = data.display_name;
                validateSingleField(addrEl);
            }

            const pinEl = document.getElementById('pincodeInput');
            if (data && data.address && data.address.postcode && pinEl && !pinEl.value) {
                pinEl.value = data.address.postcode;
                validateSingleField(pinEl);
            }
        })
        .catch(err => {
            clearTimeout(timeoutId);
            const addrEl = document.getElementById('addressInput');
            if (addrEl && !addrEl.value) {
                addrEl.value = `Site Location near ${lat.toFixed(4)}° N, ${lng.toFixed(4)}° E, Bengaluru`;
                validateSingleField(addrEl);
            }
        });
    }, 200);
}

window.fetchCurrentLocation = function(options = {}) {
    const silent = options.silent === true;
    if (!silent && typeof showLoader === 'function') {
        showLoader('Fetching your GPS location...');
    }

    if (!navigator.geolocation) {
        if (!silent && typeof hideLoader === 'function') hideLoader();
        if (!silent) alert("Geolocation is not supported by your browser.");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            if (!silent && typeof hideLoader === 'function') hideLoader();

            document.getElementById('latitudeInput').value = lat;
            document.getElementById('longitudeInput').value = lng;

            if (globalMap && globalMarker) {
                globalMap.setView([lat, lng], 15);
                globalMarker.setLatLng([lat, lng]);
                document.getElementById('mapCoordinates').innerText = `Location selected: ${lat.toFixed(4)}° N, ${lng.toFixed(4)}° E`;
            }

            updatePickupLocation(lat, lng);
        },
        function(error) {
            if (typeof hideLoader === 'function') hideLoader();

            const demoLat = 12.9911;
            const demoLng = 77.5971;
            document.getElementById('latitudeInput').value = demoLat;
            document.getElementById('longitudeInput').value = demoLng;

            if (globalMap && globalMarker) {
                globalMap.setView([demoLat, demoLng], 15);
                globalMarker.setLatLng([demoLat, demoLng]);
                document.getElementById('mapCoordinates').innerText = `Location selected: ${demoLat.toFixed(4)}° N, ${demoLng.toFixed(4)}° E`;
            }
            const addrEl = document.getElementById('addressInput');
            if (addrEl && !addrEl.value) {
                addrEl.value = "Millers Tank Bund Road, Kaverappa Layout, Vasanth Nagar, Bengaluru, Karnataka 560052";
                validateSingleField(addrEl);
            }

            const pinEl = document.getElementById('pincodeInput');
            if (pinEl && !pinEl.value) {
                pinEl.value = "560052";
                validateSingleField(pinEl);
            }

            updatePickupLocation(demoLat, demoLng);
        },
        { enableHighAccuracy: true, timeout: 5000 }
    );
};

function handleFormSubmit(event) {
    if (!validateStep(1) || !validateStep(2) || !validateStep(3)) {
        event.preventDefault();
        return;
    }
    
    if (typeof showLoader === 'function') {
        showLoader('Submitting D-Clutter request...');
    }
}
</script>
@endsection
