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
    margin: 10px 5% 30px;
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
    height: 80px;
    padding: 10px 14px;
    resize: vertical;
}

.request-ui input:focus, 
.request-ui select:focus, 
.request-ui textarea:focus {
    border-color: var(--green);
    outline: none;
    box-shadow: 0 0 0 3px rgba(8, 125, 69, 0.12);
}

/* Category Selection UI (From Reference Screenshot) */
.category-card-container {
    background: #087d45;
    border-radius: 12px;
    padding: 24px;
    color: #ffffff;
    margin-bottom: 20px;
}

.category-card-container h2 {
    font-size: 24px;
    font-weight: 800;
    margin-bottom: 6px;
    color: #ffffff;
}

.category-card-container p.subtitle {
    font-size: 14px;
    opacity: 0.9;
    margin-bottom: 24px;
}

.category-group {
    margin-bottom: 22px;
}

.category-group-title {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 12px;
    color: #ffffff;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    padding-bottom: 4px;
}

.item-option {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    padding: 12px 14px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.item-option:hover {
    background: rgba(255, 255, 255, 0.16);
    border-color: #ffffff;
}

.item-option input[type="checkbox"] {
    width: 20px;
    height: 20px;
    margin-top: 2px;
    accent-color: #ffffff;
    cursor: pointer;
    flex-shrink: 0;
}

.item-option-text strong {
    display: block;
    font-size: 15px;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 2px;
}

.item-option-text small {
    display: block;
    font-size: 12px;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.35;
}

/* Validation Styling (Red Text & Border) */
/* GREEN (Valid) and RED (Invalid) Input Validation Styling */
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

.step-header {
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 16px;
    color: var(--ink);
    border-bottom: 2px solid var(--green-light);
    padding-bottom: 8px;
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

.continue-btn {
    display: block;
    width: 100%;
    text-align: center;
    margin-top: 24px;
    font-size: 15px;
    padding: 14px;
}

.section-label {
    font-size: 15px;
    font-weight: 800;
    margin: 22px 0 12px;
    color: var(--ink);
    border-bottom: 2px solid var(--green-light);
    padding-bottom: 6px;
}

/* Track UI */
.search-ui {
    padding: 10px;
    border: 1px solid var(--line);
    border-radius: 8px;
    display: flex;
    gap: 12px;
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    margin-bottom: 24px;
}

.search-ui input {
    border: 0;
    flex: 1;
    font-size: 14px;
}

.search-ui input:focus {
    box-shadow: none;
}

.search-ui .btn-ui {
    padding: 10px 32px;
}

.track-box {
    margin-top: 10px;
}

.topline {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.ref {
    font-size: 18px;
    font-weight: 800;
    color: var(--ink);
}

.sub {
    font-size: 12px;
    color: var(--muted);
    margin-top: 4px;
}

.pill {
    font-size: 11px;
    background: #e3f3e8;
    color: var(--green);
    border-radius: 20px;
    padding: 6px 14px;
    font-weight: 700;
    border: 1px solid #bce4c8;
}

/* Status Flow Stepper */
.status-flow {
    display: flex;
    justify-content: space-between;
    text-align: center;
    position: relative;
    margin: 32px 0 28px;
    padding: 0 10px;
}

.status-flow::before {
    content: '';
    position: absolute;
    top: 18px;
    left: 8%;
    right: 8%;
    height: 3px;
    background: #e4e9e6;
    z-index: 1;
}

.status-flow-line-fill {
    position: absolute;
    top: 18px;
    left: 8%;
    width: 60%;
    height: 3px;
    background: var(--green);
    z-index: 1;
}

.status-flow span {
    font-size: 11px;
    font-weight: 700;
    z-index: 2;
    background: #ffffff;
    padding: 0 6px;
    min-width: 75px;
    color: var(--muted);
}

.status-flow span::before {
    content: '✓';
    display: flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--green);
    color: #ffffff;
    font-size: 13px;
    margin: 0 auto 8px;
    box-shadow: 0 2px 6px rgba(8, 125, 69, 0.2);
}

.status-flow span.pending::before {
    content: '4';
    background: #ffffff;
    border: 2px solid #aebbb4;
    color: var(--muted);
    box-shadow: none;
}

.status-flow span.pending-last::before {
    content: '5';
    background: #ffffff;
    border: 2px solid #aebbb4;
    color: var(--muted);
    box-shadow: none;
}

.status-flow span.active-stage::before {
    content: '🚚';
    background: var(--green);
    color: #ffffff;
    font-size: 14px;
}

.status-flow span.completed {
    color: var(--ink);
}

/* Facts Grid */
.facts {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border-top: 1px solid var(--line);
    padding-top: 20px;
    gap: 16px;
}

.facts small {
    display: block;
    color: var(--muted);
    font-size: 11px;
    margin-bottom: 4px;
    font-weight: 500;
}

.facts b {
    font-size: 13px;
    color: var(--ink);
}

/* Details Page Grid */
.details-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}

.timeline {
    border-left: 2px solid #cde0d2;
    margin: 16px 0 0 12px;
    padding-left: 22px;
}

.timeline div {
    font-size: 13px;
    position: relative;
    margin: 0 0 20px;
}

.timeline div::before {
    content: '✓';
    position: absolute;
    left: -31px;
    top: 0px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: var(--green);
    color: #ffffff;
    font-size: 10px;
    text-align: center;
    line-height: 18px;
    font-weight: bold;
}

.timeline div.pending::before {
    content: '';
    background: #ffffff;
    border: 2px solid #aebbb4;
}

.timeline b {
    color: var(--ink);
    display: block;
    font-size: 13px;
}

.timeline small {
    display: block;
    font-size: 11px;
    color: var(--muted);
    margin-top: 2px;
}

.photos-gallery {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 14px;
}

.photos-gallery img {
    width: 100%;
    height: 110px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid var(--line);
    cursor: pointer;
    transition: transform 0.2s ease;
}

.photos-gallery img:hover {
    transform: scale(1.03);
}

/* Success UI */
.success-ui {
    text-align: center;
    padding: 40px 20px;
    max-width: 500px;
    margin: 0 auto;
}

.success-check-wrapper {
    position: relative;
    width: 90px;
    height: 90px;
    margin: 0 auto 24px;
}

.success-check {
    width: 90px;
    height: 90px;
    background: var(--green);
    box-shadow: 0 0 0 14px #eff8f1;
    border-radius: 50%;
    color: #ffffff;
    font-size: 48px;
    line-height: 90px;
    margin: 0 auto;
    animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes popIn {
    0% { transform: scale(0); }
    100% { transform: scale(1); }
}

.confetti-dot {
    position: absolute;
    width: 8px;
    height: 8px;
    border-radius: 50%;
}
.c1 { background: #ffb703; top: -10px; left: 10px; }
.c2 { background: #087d45; top: 10px; right: -12px; }
.c3 { background: #2196f3; bottom: -5px; left: -8px; }
.c4 { background: #e91e63; bottom: 10px; right: -10px; }

.id-box {
    border: 1px solid var(--line);
    border-radius: 8px;
    padding: 22px;
    width: 100%;
    margin: 24px auto;
    font-size: 13px;
    background: #f8faf9;
    color: var(--muted);
}

.id-box b {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 20px;
    color: var(--ink);
    margin: 10px 0;
    font-weight: 800;
}

.copy-btn {
    background: none;
    border: none;
    color: var(--green);
    cursor: pointer;
    font-size: 18px;
    padding: 4px;
    transition: transform 0.1s ease;
}

.copy-btn:hover {
    transform: scale(1.15);
}

@media (max-width: 768px) {
    .grid-ui, .details-grid { grid-template-columns: 1fr; }
    .grid-ui .wide { grid-column: span 1; }
    .facts { grid-template-columns: 1fr 1fr; }
    .status-flow { overflow-x: auto; justify-content: flex-start; gap: 16px; padding-bottom: 8px; }
    .status-flow::before, .status-flow-line-fill { display: none; }
}
</style>

@section('content')
<main class="request-ui">

@if($screen === 'report')
    <!-- ============ SCREEN 2: REPORT D-CLUTTER WASTE ============ -->
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

        <form id="cdWasteForm" class="needs-validation" novalidate onsubmit="handleFormSubmit(event)">
            
            <!-- ================= STEP 1: CATEGORY SELECT ================= -->
            <div id="step-1" class="wizard-step">
                <div class="category-card-container">
                    <h2>Choose items for pickup</h2>
                    <p class="subtitle">We handle cots, sofas, mattresses, old clothes, shoes, and more!</p>

                    <!-- Furniture -->
                    <div class="category-group">
                        <div class="category-group-title">Furniture</div>
                        <label class="item-option">
                            <input type="checkbox" name="pickup_items" value="Furniture (cots, sofas, chairs)" onchange="onCategoryItemChange(this)">
                            <div class="item-option-text">
                                <strong>Furniture (cots, sofas, chairs)</strong>
                                <small>All types of furniture including cots, sofas, chairs, tables, and other furniture items</small>
                            </div>
                        </label>
                        <label class="item-option">
                            <input type="checkbox" name="pickup_items" value="Mattresses and cushions" onchange="onCategoryItemChange(this)">
                            <div class="item-option-text">
                                <strong>Mattresses and cushions</strong>
                                <small>Old mattresses, cushions, pillows, and bedding items</small>
                            </div>
                        </label>
                    </div>

                    <!-- Clothing -->
                    <div class="category-group">
                        <div class="category-group-title">Clothing</div>
                        <label class="item-option">
                            <input type="checkbox" name="pickup_items" value="Old clothes and shoes" onchange="onCategoryItemChange(this)">
                            <div class="item-option-text">
                                <strong>Old clothes and shoes</strong>
                                <small>Used clothing, shoes, bags, and accessories in good condition</small>
                            </div>
                        </label>
                    </div>

                    <!-- Appliances -->
                    <div class="category-group">
                        <div class="category-group-title">Appliances</div>
                        <label class="item-option">
                            <input type="checkbox" name="pickup_items" value="Household appliances" onchange="onCategoryItemChange(this)">
                            <div class="item-option-text">
                                <strong>Household appliances</strong>
                                <small>Refrigerators, washing machines, microwaves, fans, and other household appliances</small>
                            </div>
                        </label>
                    </div>

                    <!-- Electronics -->
                    <div class="category-group">
                        <div class="category-group-title">Electronics</div>
                        <label class="item-option">
                            <input type="checkbox" name="pickup_items" value="Electronics" onchange="onCategoryItemChange(this)">
                            <div class="item-option-text">
                                <strong>Electronics</strong>
                                <small>Televisions, computers, mobile phones, and other electronic devices</small>
                            </div>
                        </label>
                    </div>

                    <!-- Other -->
                    <div class="category-group" style="margin-bottom: 0;">
                        <div class="category-group-title">Other</div>
                        <label class="item-option">
                            <input type="checkbox" name="pickup_items" value="Books and magazines" onchange="onCategoryItemChange(this)">
                            <div class="item-option-text">
                                <strong>Books and magazines</strong>
                                <small>Old books, magazines, newspapers, and reading materials</small>
                            </div>
                        </label>
                        <label class="item-option">
                            <input type="checkbox" name="pickup_items" value="Toys and games" onchange="onCategoryItemChange(this)">
                            <div class="item-option-text">
                                <strong>Toys and games</strong>
                                <small>Children toys, board games, and recreational items</small>
                            </div>
                        </label>
                    </div>
                </div>

                <div id="step1-error" class="error-feedback mb-3" style="display:none; color: #dc3545 !important;">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Please select at least one item for pickup.
                </div>

                <button type="button" class="btn-ui continue-btn" onclick="goToStep(2)">
                    Next: Location Details <i class="bi bi-arrow-right"></i>
                </button>
            </div>

            <!-- ================= STEP 2: LOCATION ================= -->
            <div id="step-2" class="wizard-step" style="display:none;">
                <div class="step-header">Pickup Location Details</div>

                <div class="grid-ui">
                    <div class="wide">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <label style="margin-bottom: 0;">Pickup Location <span class="req">*</span></label>
                            <button type="button" class="btn-fetch-loc" onclick="fetchCurrentLocation()">
                                <i class="bi bi-crosshair"></i> Fetch Location
                            </button>
                        </div>
                        <textarea id="addressInput" required oninput="validateSingleField(this)" onchange="validateSingleField(this)" placeholder="Enter complete site address (House/Site No, Street, Main, Area)"></textarea>
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please enter complete site address.</div>
                    </div>

                    <div class="wide">
                        <label>Pin location on map (Click map to position marker)</label>
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

                    <div>
                        <label>Select Ward <span class="req">*</span></label>
                        <select id="wardSelect" required onchange="validateSingleField(this)">
                            <option value="">— Select Ward —</option>
                            <option value="Ward 95 - Subhash Nagar">Ward 95 - Subhash Nagar (South)</option>
                            <option value="Ward 49 - Karanagar">Ward 49 - Karanagar (West)</option>
                            <option value="Ward 110 - Indiranagar">Ward 110 - Indiranagar (East)</option>
                            <option value="Ward 148 - HSR Layout">Ward 148 - HSR Layout (Bommanahalli)</option>
                            <option value="Ward 174 - Jayanagar">Ward 174 - Jayanagar (South)</option>
                            <option value="Ward 12 - Yelahanka">Ward 12 - Yelahanka (North)</option>
                        </select>
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please select a ward.</div>
                    </div>

                    <div>
                        <label>Landmark</label>
                        <input type="text" id="landmarkInput" placeholder="Enter nearby landmark (e.g. Near Metro Station)">
                    </div>

                    <div>
                        <label>Pincode <span class="req">*</span></label>
                        <input type="text" id="pincodeInput" required oninput="validateSingleField(this)" onchange="validateSingleField(this)" placeholder="Enter 6-digit Pincode" maxlength="6" pattern="[0-9]{6}">
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please enter a valid 6-digit pincode.</div>
                    </div>

                    <div>
                        <label>Mobile Number <span class="req">*</span></label>
                        <input type="tel" id="mobileInput" required oninput="validateSingleField(this)" onchange="validateSingleField(this)" placeholder="Registered Mobile Number" maxlength="10" pattern="[0-9]{10}">
                        <div class="invalid-feedback" style="color: #dc3545 !important;">Please enter a valid 10-digit mobile number.</div>
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

                <div style="background: #e8f5ed; border: 1px solid #bce4c8; border-radius: 8px; padding: 14px; margin-bottom: 20px;">
                    <div style="font-weight: 700; color: var(--green); margin-bottom: 4px;">
                        <i class="bi bi-info-circle-fill"></i> Sunday Pickup Policy
                    </div>
                    <div style="font-size: 13px; color: #2b3930;">
                        D-Clutter waste collection is scheduled <strong>exclusively on Sundays</strong>. Other days are unselectable.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="preferredDateInput">Select Pickup Date (Only Sundays) <span class="req">*</span></label>
                    <input type="date" id="preferredDateInput" required onchange="validateSundayDate(this)">
                    <div id="date-error" class="invalid-feedback" style="color: #dc3545 !important;">
                        Please select a valid Sunday for pickup.
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

                    <div class="grid-ui" style="margin-bottom: 14px;">
                        <div>
                            <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">PICKUP LOCATION</small>
                            <div id="review-address" style="font-weight: 700; color: var(--ink); font-size: 13px; margin-top: 4px;">-</div>
                        </div>
                        <div>
                            <small style="color: var(--muted); display: block; font-weight: 600; font-size: 11px;">WARD &amp; PINCODE</small>
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

@elseif($screen === 'track')
    <!-- ============ SCREEN 3: TRACK REQUEST ============ -->
    <div class="crumb"><a href="{{ url('/') }}">Home</a> / Track Request</div>
    <h1>Track Your Request</h1>

    <div class="search-ui">
        <input type="text" id="trackInput" placeholder="Enter Request ID (e.g. DCL-2025-000123) or Mobile Number" value="{{ request('id', 'DCL-2025-000123') }}">
        <button class="btn-ui" onclick="doTrackSearch()">Track</button>
    </div>

    <div class="card-ui track-box">
        <div class="topline">
            <div>
                <div class="ref" id="trackReqId">DCL-2025-000123</div>
                <div class="sub" id="trackReqDate">Requested on: 23 May 2025, 10:30 AM</div>
                <div class="sub" id="trackCategory">Category: D-Clutter Rubble</div>
            </div>
            <span class="pill" id="trackStatusPill">In Progress</span>
        </div>

        <div class="status-flow">
            <div class="status-flow-line-fill"></div>
            <span class="completed">Request<br>Submitted</span>
            <span class="completed">Verified</span>
            <span class="completed">Assigned</span>
            <span class="completed active-stage">Pickup</span>
            <span class="pending-last">Disposed</span>
        </div>

        <div class="facts">
            <div>
                <small>Estimated Pickup Time</small>
                <b>Today, 2:00 PM – 4:00 PM</b>
            </div>
            <div>
                <small>Assigned Contractor</small>
                <b id="trackContractor">GreenBuild Infra Solutions</b>
            </div>
            <div>
                <small>Vehicle No.</small>
                <b id="trackVehicle">KA 01 AB 1234</b>
            </div>
            <div>
                <small>Driver Contact</small>
                <b>+91 98765 43210</b>
            </div>
        </div>

        <div style="margin-top: 20px;">
            <a class="btn-ui" id="viewDetailsBtn" href="{{ route('citizen.details') }}?id=DCL-2025-000123">View Details</a>
        </div>
    </div>

@elseif($screen === 'details')
    <!-- ============ SCREEN 4: REQUEST DETAILS ============ -->
    <div class="crumb"><a href="{{ url('/') }}">Home</a> / <a href="{{ route('citizen.track') }}">Track Request</a> / Request Details</div>
    <h1>Request Details</h1>

    <div class="details-grid">
        <div class="card-ui">
            <div class="topline">
                <div>
                    <div class="ref" id="detailsReqId">DCL-2025-000123</div>
                    <div class="sub" id="detailsReqDate">Requested on: 23 May 2025, 10:30 AM</div>
                </div>
                <span class="pill">In Progress</span>
            </div>

            <div class="facts" style="grid-template-columns: 1fr 1fr; margin-top: 16px;">
                <div>
                    <small>Pickup Location</small>
                    <b id="detailsAddress">123, 1st Cross, Kanamangala 6th Block, Bengaluru, Karnataka - 560064</b>
                </div>
                <div>
                    <small>Waste Details</small>
                    <b id="detailsWasteType">Bricks / Concrete</b>
                </div>
                <div>
                    <small>Ward &amp; Zone</small>
                    <b id="detailsWard">Ward 95 - South Zone</b>
                </div>
                <div>
                    <small>Estimated Quantity</small>
                    <b id="detailsQuantity">2.5 Ton</b>
                </div>
                <div>
                    <small>Preferred Date</small>
                    <b id="detailsPrefDate">23 May 2025</b>
                </div>
                <div>
                    <small>Description</small>
                    <b id="detailsDesc">Renovation debris</b>
                </div>
            </div>

            <div class="section-label">Status Timeline</div>
            <div class="timeline">
                <div>
                    <b>Request Submitted</b>
                    <small>23 May 2025, 10:30 AM</small>
                </div>
                <div>
                    <b>Verified</b>
                    <small>23 May 2025, 10:45 AM</small>
                </div>
                <div>
                    <b>Assigned to Contractor</b>
                    <small>23 May 2025, 11:15 AM</small>
                </div>
                <div>
                    <b>On the Way / Pickup</b>
                    <small>23 May 2025, 01:45 PM</small>
                </div>
                <div class="pending">
                    <b style="color: var(--muted);">Disposed &amp; Recycled</b>
                    <small>Pending completion</small>
                </div>
            </div>
        </div>

        <div class="card-ui">
            <div class="section-label" style="margin-top: 0;">Evidence Photos</div>
            <p style="font-size: 12px; color: var(--muted); margin-bottom: 12px;">
                Digital proof uploaded for site inspection and transport verification:
            </p>
            <div class="photos-gallery">
                <img src="{{ asset('frontendwebsite/img/candd_new_image.png') }}" alt="Waste Debris Photo 1" onclick="openPhotoModal(this.src)">
                <img src="{{ asset('frontendwebsite/img/candd_new_image.png') }}" alt="Waste Debris Photo 2" onclick="openPhotoModal(this.src)">
                <img src="{{ asset('frontendwebsite/img/candd_new_image.png') }}" alt="Waste Debris Photo 3" onclick="openPhotoModal(this.src)">
            </div>
        </div>
    </div>

@else
    <!-- ============ SCREEN 5: REQUEST SUBMITTED SUCCESSFULLY ============ -->
    <div class="success-ui">
        <div class="success-check-wrapper">
            <div class="success-check">✓</div>
            <div class="confetti-dot c1"></div>
            <div class="confetti-dot c2"></div>
            <div class="confetti-dot c3"></div>
            <div class="confetti-dot c4"></div>
        </div>

        <h1>Request Submitted<br>Successfully!</h1>
        <p>Thank you for contributing towards a cleaner, sustainable Bengaluru.</p>

        <div class="id-box">
            <span>Your Request ID</span>
            <b id="successReqId">
                <span id="reqIdText">{{ request('id', 'DCL-2025-000123') }}</span>
                <button class="copy-btn" onclick="copyReqId()" title="Copy Request ID"><i class="bi bi-copy"></i></button>
            </b>
            <span style="font-size: 11px;">You will receive real-time SMS updates<br>on your registered mobile number.</span>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px; align-items: center;">
            <a class="btn-ui" href="{{ url('/') }}" style="width: 100%; text-align: center;">Go to Dashboard</a>
            <a href="{{ route('citizen.report') }}" style="color: var(--green); text-decoration: none; font-weight: 700; font-size: 13px;">Create Another Request</a>
        </div>
    </div>
@endif

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

document.addEventListener('DOMContentLoaded', function() {
    if (typeof hideLoader === 'function') {
        hideLoader();
    }

    initSundayDatePicker();

    const mapElement = document.getElementById('location-map');
    if (mapElement) {
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
        }

        globalMarker.on('dragend', function(e) {
            const position = globalMarker.getLatLng();
            updateMarkerCoords(position.lat, position.lng);
        });

        globalMap.on('click', function(e) {
            globalMarker.setLatLng(e.latlng);
            updateMarkerCoords(e.latlng.lat, e.latlng.lng);
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
                    }
                })
                .catch(err => console.error('Map search failed', err));
        };
    }
});

function initSundayDatePicker() {
    const dateInput = document.getElementById('preferredDateInput');
    if (!dateInput) return;

    dateInput.type = "text";
    dateInput.placeholder = "Click to select a Sunday";

    const today = new Date();
    const dayOfWeek = today.getDay(); // 0 is Sunday
    const daysUntilSunday = (7 - dayOfWeek) % 7 || 7;
    const nextSunday = new Date(today);
    nextSunday.setDate(today.getDate() + daysUntilSunday);

    flatpickr("#preferredDateInput", {
        dateFormat: "Y-m-d",
        minDate: "today",
        defaultDate: nextSunday,
        enable: [
            function(date) {
                // Return true only for Sundays (0 = Sunday)
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
        const checkedItems = document.querySelectorAll('input[name="pickup_items"]:checked');
        const errorDiv = document.getElementById('step1-error');
        if (checkedItems.length === 0) {
            if (errorDiv) errorDiv.style.display = 'block';
            return false;
        } else {
            if (errorDiv) errorDiv.style.display = 'none';
            return true;
        }
    }

    if (step === 2) {
        const address = document.getElementById('addressInput');
        const ward = document.getElementById('wardSelect');
        const pincode = document.getElementById('pincodeInput');
        const mobile = document.getElementById('mobileInput');

        let valid = true;
        [address, ward, pincode, mobile].forEach(el => {
            if (!el || !el.checkValidity()) {
                if (el) el.classList.add('is-invalid');
                valid = false;
            } else {
                el.classList.remove('is-invalid');
            }
        });

        const form = document.getElementById('cdWasteForm');
        if (!valid && form) {
            form.classList.add('was-validated');
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
    const checkedItems = Array.from(document.querySelectorAll('input[name="pickup_items"]:checked')).map(cb => cb.value);
    const itemsEl = document.getElementById('review-items');
    if (itemsEl) itemsEl.innerText = checkedItems.length ? checkedItems.join(', ') : 'None selected';
    
    const addrEl = document.getElementById('review-address');
    if (addrEl) addrEl.innerText = document.getElementById('addressInput')?.value || '-';
    
    const wardVal = document.getElementById('wardSelect')?.value;
    const pinVal = document.getElementById('pincodeInput')?.value;
    const wardEl = document.getElementById('review-ward');
    if (wardEl) wardEl.innerText = `${wardVal || '-'} (${pinVal ? 'Pin: ' + pinVal : '-'})`;
    
    const mobEl = document.getElementById('review-mobile');
    if (mobEl) mobEl.innerText = document.getElementById('mobileInput')?.value || '-';
    
    const dateVal = document.getElementById('preferredDateInput')?.value;
    const dateEl = document.getElementById('review-date');
    if (dateEl) {
        if (dateVal) {
            const parts = dateVal.split('-');
            const d = new Date(parts[0], parts[1] - 1, parts[2]);
            const formatted = d.toLocaleDateString('en-GB', { weekday: 'long', day: '2-digit', month: 'short', year: 'numeric' });
            dateEl.innerText = formatted;
        } else {
            dateEl.innerText = '-';
        }
    }
}

window.fetchCurrentLocation = function() {
    if (typeof showLoader === 'function') {
        showLoader('Fetching your GPS location...');
    }

    if (!navigator.geolocation) {
        if (typeof hideLoader === 'function') hideLoader();
        alert("Geolocation is not supported by your browser.");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            if (typeof hideLoader === 'function') hideLoader();

            if (globalMap && globalMarker) {
                globalMap.setView([lat, lng], 15);
                globalMarker.setLatLng([lat, lng]);
                document.getElementById('mapCoordinates').innerText = `Location selected: ${lat.toFixed(4)}° N, ${lng.toFixed(4)}° E`;
            }

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.display_name) {
                        document.getElementById('addressInput').value = data.display_name;
                        if (data.address && data.address.postcode) {
                            document.getElementById('pincodeInput').value = data.address.postcode;
                        }
                    }
                })
                .catch(() => {
                    document.getElementById('addressInput').value = `GPS Location (${lat.toFixed(4)}° N, ${lng.toFixed(4)}° E), Bengaluru`;
                });
        },
        function(error) {
            if (typeof hideLoader === 'function') hideLoader();

            const demoLat = 12.9716;
            const demoLng = 77.5946;
            if (globalMap && globalMarker) {
                globalMap.setView([demoLat, demoLng], 15);
                globalMarker.setLatLng([demoLat, demoLng]);
                document.getElementById('mapCoordinates').innerText = `Location selected: ${demoLat.toFixed(4)}° N, ${demoLng.toFixed(4)}° E`;
            }
            document.getElementById('addressInput').value = "123, 1st Cross, Kanamangala 6th Block, Bengaluru, Karnataka - 560064";
            document.getElementById('pincodeInput').value = "560064";
            alert("Current location fetched successfully!");
        },
        { enableHighAccuracy: true, timeout: 8000 }
    );
};

function handleFormSubmit(event) {
    event.preventDefault();

    if (!validateStep(1) || !validateStep(2) || !validateStep(3)) {
        return;
    }
    
    if (typeof showLoader === 'function') {
        showLoader('Submitting D-Clutter request...');
    }

    setTimeout(() => {
        const randomNum = Math.floor(100000 + Math.random() * 900000);
        const reqId = `DCL-2025-${randomNum}`;

        const checkedItems = Array.from(document.querySelectorAll('input[name="pickup_items"]:checked')).map(cb => cb.value);

        const requestData = {
            id: reqId,
            items: checkedItems,
            wasteType: checkedItems.join(', '),
            address: document.getElementById('addressInput').value,
            ward: document.getElementById('wardSelect').value,
            landmark: document.getElementById('landmarkInput').value,
            pincode: document.getElementById('pincodeInput').value,
            mobile: document.getElementById('mobileInput').value,
            prefDate: document.getElementById('preferredDateInput').value,
            dateSubmitted: new Date().toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' })
        };

        const saved = JSON.parse(localStorage.getItem('dclutter_requests') || '[]');
        saved.unshift(requestData);
        localStorage.setItem('dclutter_requests', JSON.stringify(saved));
        localStorage.setItem('last_req_id', reqId);

        window.location.href = `{{ route('citizen.success') }}?id=${reqId}`;
    }, 600);
}

function doTrackSearch() {
    const val = document.getElementById('trackInput').value.trim();
    if (!val) return;
    if (typeof showLoader === 'function') {
        showLoader('Tracking request status...');
    }
    setTimeout(() => {
        window.location.href = `{{ route('citizen.track') }}?id=${encodeURIComponent(val)}`;
    }, 400);
}

function copyReqId() {
    const reqId = document.getElementById('reqIdText').innerText;
    navigator.clipboard.writeText(reqId).then(() => {
        alert(`Request ID ${reqId} copied to clipboard!`);
    });
}

function openPhotoModal(src) {
    window.open(src, '_blank');
}
</script>
@endsection
