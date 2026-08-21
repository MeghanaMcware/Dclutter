@extends('vehiclepwa.layout.app')

@section('title') Assigned Requests & Map @endsection
@section('heading') Assigned Requests @endsection

@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <style>
        :root {
            --primary-brand: #0e7a43;
            --primary-brand-dark: #095930;
            --primary-brand-light: #e8f5e9;
            --status-yellow: #ffc107;
            --bg-canvas: #f8fafc;
            --border-color: #e2e8f0;
        }

        /* Capacity Card */
        .capacity-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 14px 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            margin-bottom: 14px;
        }

        .capacity-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
            gap: 8px;
        }

        .capacity-title {
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            line-height: 1.3;
        }

        .capacity-stats {
            font-size: 12px;
            font-weight: 800;
            color: var(--primary-brand);
            text-align: right;
            line-height: 1.3;
            margin: 0;
            white-space: nowrap;
        }

        /* View Toggle Switcher (List vs Map) */
        .view-toggle-box {
            background: #e2e8f0;
            padding: 4px;
            border-radius: 12px;
            display: flex;
            gap: 4px;
            border: 1px solid #cbd5e1;
            margin-bottom: 14px;
        }

        .btn-toggle-view {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px 14px;
            border-radius: 9px;
            font-size: 13.5px;
            font-weight: 700;
            color: #475569;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
        }

        .btn-toggle-view.active {
            background: var(--primary-brand);
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(14, 122, 67, 0.3);
        }

        /* Search & Filter Controls */
        .search-filter-row {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }

        .search-box-wrap {
            position: relative;
            flex: 1;
        }

        .search-box-wrap input {
            width: 100%;
            height: 42px;
            padding-left: 38px;
            padding-right: 12px;
            border-radius: 10px;
            font-size: 13.5px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
        }

        .search-box-wrap i {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
        }

        .filter-select {
            width: 110px;
            height: 42px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 13px;
            font-weight: 600;
            background: #ffffff;
            padding: 0 10px;
        }

        /* Request Card Matching Image EXACTLY */
        .request-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 16px 18px;
            margin-bottom: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .request-card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        /* Badge CWD Ref */
        .badge-cwd-id {
            background-color: var(--primary-brand);
            color: #ffffff !important;
            font-size: 13.5px;
            font-weight: 800;
            padding: 5px 12px;
            border-radius: 8px;
            display: inline-block;
            letter-spacing: 0.3px;
        }

        /* Badge Status */
        .badge-status-pending {
            background-color: var(--status-yellow);
            color: #111827 !important;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            letter-spacing: 0.3px;
        }

        .badge-status-accepted {
            background-color: #10b981;
            color: #ffffff !important;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            letter-spacing: 0.3px;
        }

        /* Custom Map Route Markers */
        .custom-map-icon {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .route-marker-green {
            background-color: #0f763b;
            color: #fff;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 800;
            font-size: 11px;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        .route-marker-blue {
            background-color: #2563eb;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
        }

        /* Get Directions Button */
        .btn-get-directions {
            background-color: #ffffff;
            color: var(--primary-brand);
            border: 1.5px solid var(--primary-brand);
            font-size: 13px;
            font-weight: 700;
            padding: 5px 13px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s ease;
            margin-top: 8px;
        }

        .btn-get-directions:hover {
            background-color: var(--primary-brand);
            color: #ffffff !important;
        }

        /* Divider */
        .card-divider {
            border: 0;
            border-top: 1px solid #e5e7eb;
            margin: 14px 0;
        }

        /* Card Info Section */
        .card-info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13.5px;
            color: #374151;
            margin-bottom: 5px;
        }

        .card-info-label {
            color: #4b5563;
            font-weight: 500;
        }

        .card-info-value {
            color: #111827;
            font-weight: 800;
        }

        /* Bottom View Button */
        .btn-view-card {
            background-color: var(--primary-brand);
            color: #ffffff !important;
            font-size: 13.5px;
            font-weight: 800;
            padding: 7px 20px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(14, 122, 67, 0.25);
            cursor: pointer;
            text-decoration: none;
            margin-top: 8px;
        }

        .btn-view-card:hover {
            background-color: var(--primary-brand-dark);
            color: #ffffff !important;
        }


/* Availability Controls */
.modal-availability-row {
    display: flex;
    gap: 8px;
    align-items: stretch;
}

.modal-availability-select,
.modal-reason-select {
    width: 100%;
    height: 38px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background-color: #ffffff;
    color: #374151;
    font-size: 13px;
    font-weight: 600;
    padding: 5px 3px 5px 3px;
    box-shadow: none;
}

.modal-availability-select:focus,
.modal-reason-select:focus {
    border-color: var(--primary-brand);
    box-shadow: 0 0 0 2px rgba(14, 122, 67, 0.08);
    outline: none;
}

.modal-reason-section {
    margin-top: 10px;
}

.modal-reason-label {
    color: #64748b;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    margin-bottom: 5px;
}

.modal-submit-btn {
    width: 100%;
    height: 38px;
    margin-top: 10px;
    border: 1.5px solid var(--primary-brand);
    border-radius: 8px;
    background-color: var(--primary-brand);
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.modal-submit-btn:hover:not(:disabled) {
    background-color: var(--primary-brand-dark);
    color: #ffffff;
}

.modal-submit-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}







        /* Map styling */
        #requests-map {
            height: 440px;
            width: 100%;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.05);
        }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- <div class="capacity-card">
            <div class="capacity-header">
                <span class="capacity-title">Vehicle Load Capacity</span>
                <span class="capacity-stats">2 T Accepted / 10 T Max (8 T Free)</span>
            </div>
            <div class="progress" style="height: 7px; border-radius: 5px;">
                <div class="progress-bar bg-success" style="width: 20%; border-radius: 5px;"></div>
            </div>
        </div> -->

        {{-- View Toggle Switcher: List View vs Map View --}}
        <div class="view-toggle-box">
            <button type="button" class="btn-toggle-view active" id="btn-view-list" onclick="switchView('list')">
                <i class="fa-solid fa-list-ul"></i> List View
            </button>
            <button type="button" class="btn-toggle-view" id="btn-view-map" onclick="switchView('map')">
                <i class="fa-solid fa-map-location-dot"></i> Map View
            </button>
        </div>

        {{-- Search & Filter Controls --}}
        <div class="search-filter-row">
            <div class="search-box-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="unified-search" placeholder="Search ref, area, ward...">
            </div>
            <select id="unified-filter" class="filter-select">
                <option value="all" selected>All Statuses</option>
                <option value="assigned">Assigned</option>
                <option value="picked_up">Picked Up</option>
            </select>
        </div>

        {{-- ================= LIST VIEW ================= --}}
        <div id="list-view-section">
            <div id="cards-container"></div>

            <div id="no-results-msg" class="p-4 text-center text-muted card border-0 rounded-4 shadow-sm" style="display: none;">
                <i class="fa-solid fa-folder-open fs-2 mb-2 text-secondary"></i>
                <h6 class="fw-bold">No requests match your filter</h6>
            </div>
        </div>

        {{-- ================= MAP VIEW ================= --}}
        <div id="map-view-section" style="display: none;">
            <div id="requests-map"></div>
        </div>

    </div>

    {{-- Request Detail Modal --}}
    <div class="modal fade" id="requestDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0" style="background: var(--primary-brand); color: #fff; border-radius: 16px 16px 0 0;">
                    <div>
                       
                        <h5 class="modal-title fw-extrabold text-white" id="modalRefTitle">DCL-2025-000123</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="d-flex justify-content-end mb-3">
                        <div class="d-flex align-items-center px-2 py-1 rounded-3 bg-light border" style="gap: 12px;">
                            <span class="small text-muted font-weight-bold" style="margin-bottom: 0; font-size: 12px;">Status:</span>
                            <span class="badge-status-pending" id="modalStatusBadge"><i class="fa-regular fa-clock"></i> PENDING</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="small text-muted font-weight-bold text-uppercase d-block mb-1">Applicant Name</label>
                            <strong class="fs-6 text-dark" id="modalApplicantName">Ramesh Kumar</strong>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted font-weight-bold text-uppercase d-block mb-1">Mobile No</label>
                            <strong class="fs-6 text-dark">
                                <a href="#" id="modalMobileLink" class="text-decoration-none text-dark" style="border-bottom: 1px dashed;">
                                    <i class="fa-solid fa-phone text-success me-1"></i> <span id="modalMobile">9876543210</span>
                                </a>
                            </strong>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted font-weight-bold text-uppercase d-block mb-1">Pickup Address</label>
                        <p class="small text-dark mb-1">
                            <strong id="modalHouseNo">#123</strong>, <span id="modalAddress">BTM Layout 2nd Stage, Bengaluru</span>
                        </p>
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <span class="badge bg-secondary text-white fw-normal" id="modalWard">Ward 150</span>
                            <span class="badge bg-secondary text-white fw-normal" id="modalConstituency">Bommanahalli</span>
                            <span class="badge bg-secondary text-white fw-normal" id="modalPincode">560102</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted font-weight-bold text-uppercase d-block mb-1">Pickup Date</label>
                        <strong class="fs-6 text-dark"><i class="fa-regular fa-calendar text-primary me-1"></i> <span id="modalDate">09-Aug-2026</span></strong>
                    </div>

                    <div class="row g-2 mb-3">
                       
                        <div class="col-6">
                            <div class="p-2 border rounded-3 bg-light h-100">
                                <span class="small text-muted d-block">Pickup Category</span>
                                <strong class="text-dark" id="modalCategory">Furniture</strong>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 border rounded-3 bg-light h-100">
                                <span class="small text-muted d-block">Sub Category</span>
                                <strong class="text-dark" id="modalSubCategory">Cots, Sofas</strong>
                            </div>
                        </div>
                    <!-- Before / After Pickup Photos Section -->
                    <div id="modalImagesContainer" class="mt-3 pt-3 border-top" style="display: none;">
                        <label class="small text-muted font-weight-bold text-uppercase d-block mb-2">Pickup Photos</label>
                        <div id="modalBeforePhotosWrapper" class="mb-2" style="display: none;">
                            <span class="badge bg-primary mb-1">Before Pickup Photos</span>
                            <div id="modalBeforePhotosList" class="d-flex gap-2 overflow-auto py-1"></div>
                        </div>
                        <div id="modalAfterPhotosWrapper" style="display: none;">
                            <span class="badge bg-success mb-1">After Pickup Photos</span>
                            <div id="modalAfterPhotosList" class="d-flex gap-2 overflow-auto py-1"></div>
                        </div>
                    </div>

                    <!-- <div class="d-flex gap-2 mt-4" id="modalActionButtons">
                        <a id="modalDirectionsBtn" href="#" target="_blank" class="btn btn-get-directions w-50 d-flex align-items-center justify-content-center py-2">
                            <i class="fa-solid fa-diamond-turn-right me-1"></i> Directions
                        </a>
                        <a id="modalPickupActionBtn" href="#" class="btn btn-view-card w-50 d-flex align-items-center justify-content-center py-2">
                            <i class="fa-solid fa-camera me-1"></i> <span id="modalPickupActionText">Before Pickup</span>
                        </a>
                    </div> -->
                    <div class="mt-4" id="modalActionButtons">

    <!-- Directions + Availability -->
    <div class="d-flex gap-2">
        
        <a id="modalDirectionsBtn"
           href="#"
           target="_blank"
           class="btn btn-get-directions w-50 d-flex align-items-center justify-content-center py-2">
            <i class="fa-solid fa-diamond-turn-right me-1"></i>
            Directions
        </a>

        <div class="w-50" id="pickupAvailabilityContainer" style="margin-top:8px;">
          <select id="pickupAvailability"
        class="modal-availability-select">
                <option value="">Select Availability</option>
                <option value="available">Available</option>
                <option value="not_available">Not Available</option>
            </select>
        </div>

    </div>

    <!-- Not Available Reason -->
    <div id="notAvailableSection" class="mt-3" style="display: none;">

        <label class="modal-reason-label d-block">
            Reason
        </label>

       <select id="notAvailableReason"
        class="modal-reason-select">

            <option value="">Select Reason</option>
            <option value="door_closed">Door Closed</option>
            <option value="call_not_attended">Call Not Attended</option>
            <option value="not_ready_today">Not Ready Today</option>
            <option value="asking_next_date">Asking for Next Date</option>

        </select>
<button type="button"
        id="notAvailableSubmitBtn"
        class="modal-submit-btn"
        disabled>
    <i class="fa-solid fa-paper-plane"></i>
    Submit
</button>

    </div>

    <!-- Available / Existing Before Pickup Action -->
    <div id="availablePickupSection" class="mt-3" style="display: none;">

        <a id="modalPickupActionBtn"
           href="#"
           class="btn btn-success w-100 d-flex align-items-center justify-content-center py-2">

            <i class="fa-solid fa-camera me-1"></i>
            <span id="modalPickupActionText">Before Pickup</span>

        </a>

    </div>

</div>





                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const allRequestData = [
            @foreach($assignedRequests as $req)
            {
                id: {{ $req->id }},
                ref: '{{ $req->request_number }}',
                status: '{{ strtoupper($req->status) }}',
                beforePickupDone: {{ (!empty($req->before_pickup_images) || !empty($req->approx_weight_kg)) ? 'true' : 'false' }},
                beforePhotos: {!! json_encode(array_map(function($img) { return Str::startsWith($img, 'http') ? $img : asset('storage/' . $img); }, $req->before_pickup_images ?? [])) !!},
                afterPhotos: {!! json_encode(array_map(function($img) { return Str::startsWith($img, 'http') ? $img : asset('storage/' . $img); }, $req->picked_up_images ?? [])) !!},
                category: '{{ is_array($req->category_ids) ? implode(", ", $req->category_ids) : ($req->category_ids ?? "N/A") }}',
                subCategory: '{{ is_array($req->subcategory_ids) ? implode(", ", $req->subcategory_ids) : ($req->subcategory_ids ?? "N/A") }}',
                applicant: '{{ addslashes($req->applicant_name) }}',
                mobile: '{{ $req->mobile_number }}',
                date: '{{ $req->created_at->format("d-M-Y") }}',
                houseNo: '{{ addslashes($req->house_no) }}',
                ward: '{{ $req->ward?->name ?? "Ward" }}',
                constituency: '{{ $req->constituency?->name ?? "Constituency" }}',
                pincode: '{{ $req->pincode }}',
                location: '{{ addslashes($req->address) }}',
                lat: {{ $req->latitude ?? 12.9716 }},
                lng: {{ $req->longitude ?? 77.5946 }}
            },
            @endforeach
        ];
        let mapInstance = null;
        let mapMarkers = [];

        function switchView(viewName) {
            const listSec = document.getElementById('list-view-section');
            const mapSec = document.getElementById('map-view-section');
            const btnList = document.getElementById('btn-view-list');
            const btnMap = document.getElementById('btn-view-map');

            if (viewName === 'list') {
                listSec.style.display = 'block';
                mapSec.style.display = 'none';
                btnList.classList.add('active');
                btnMap.classList.remove('active');
            } else {
                listSec.style.display = 'none';
                mapSec.style.display = 'block';
                btnMap.classList.add('active');
                btnList.classList.remove('active');
                initMapIfNeeded();
            }
        }

        function initMapIfNeeded() {
            if (mapInstance) {
                setTimeout(() => mapInstance.invalidateSize(), 200);
                return;
            }

            const centerLat = allRequestData.length ? allRequestData[0].lat : 12.9166;
            const centerLng = allRequestData.length ? allRequestData[0].lng : 77.6101;

            mapInstance = L.map('requests-map').setView([centerLat, centerLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(mapInstance);

            const bounds = [];

            // Draw connecting route line
            const latlngs = allRequestData.map(item => [item.lat, item.lng]);
            if (latlngs.length > 1) {
                L.polyline(latlngs, {
                    color: '#0f763b',
                    weight: 4,
                    opacity: 0.9,
                    lineJoin: 'round'
                }).addTo(mapInstance);
            }

            allRequestData.forEach((item, index) => {
                const markerNumber = index + 1;
                let iconHtml = `<div class="route-marker-green">${markerNumber}</div>`;
                
                // Make the first one a blue dot (current location / starting point)
                if (index === 0) {
                    iconHtml = `<div class="route-marker-blue"></div>`;
                }

                const customIcon = L.divIcon({
                    className: 'custom-map-icon',
                    html: iconHtml,
                    iconSize: [26, 26],
                    iconAnchor: [13, 13]
                });

                const marker = L.marker([item.lat, item.lng], { icon: customIcon }).addTo(mapInstance);
                const popupHtml = `
                    <div style="min-width:200px; padding:4px;">
                        <span class="badge-cwd-id" style="font-size:11px;">${item.ref}</span>
                        <div class="small fw-bold text-dark mt-2">${item.applicant}</div>
                        <div class="small text-muted mb-2">${item.location}</div>
                        <div class="small text-muted mb-1"><strong>Category:</strong> ${item.category}</div>
                        <div class="small text-muted mb-2"><strong>Sub Category:</strong> ${item.subCategory}</div>
                        <a href="https://www.google.com/maps/search/?api=1&query=${item.lat},${item.lng}" target="_blank" class="btn-get-directions py-1 px-2 font-11">
                            <i class="fa-solid fa-diamond-turn-right"></i> Navigate
                        </a>
                    </div>
                `;
                marker.bindPopup(popupHtml);
                mapMarkers.push({ marker, item });
                bounds.push([item.lat, item.lng]);
            });

            if (bounds.length > 0) {
                mapInstance.fitBounds(bounds, { padding: [30, 30] });
            }
        }

        let currentActiveRef = '';
        function openRequestModal(item) {
            currentActiveRef = item.ref;
            document.getElementById('modalRefTitle').innerText = item.ref;
            document.getElementById('modalApplicantName').innerText = item.applicant;
            document.getElementById('modalMobile').innerText = item.mobile;
            document.getElementById('modalMobileLink').href = 'tel:' + item.mobile;
            document.getElementById('modalHouseNo').innerText = item.houseNo;
            document.getElementById('modalAddress').innerText = item.location;
            document.getElementById('modalWard').innerText = item.ward;
            document.getElementById('modalConstituency').innerText = item.constituency;
            document.getElementById('modalPincode').innerText = item.pincode;
            document.getElementById('modalDate').innerText = item.date;
          
            document.getElementById('modalCategory').innerText = item.category;
            document.getElementById('modalSubCategory').innerText = item.subCategory;
            
            // Dynamic Modal Status Badge
            const statusBadgeElem = document.getElementById('modalStatusBadge');
            if (statusBadgeElem) {
                if (item.status === 'PICKED_UP') {
                    statusBadgeElem.className = 'badge bg-success text-white py-1 px-2 font-12';
                    statusBadgeElem.innerHTML = '<i class="fa-solid fa-circle-check me-1"></i> PICKED UP';
                } else if (item.status === 'ASSIGNED') {
                    statusBadgeElem.className = 'badge bg-primary text-white py-1 px-2 font-12';
                    statusBadgeElem.innerHTML = '<i class="fa-solid fa-truck-fast me-1"></i> ASSIGNED';
                } else {
                    statusBadgeElem.className = 'badge-status-pending font-12';
                    statusBadgeElem.innerHTML = '<i class="fa-regular fa-clock me-1"></i> ' + item.status;
                }
            }

            // Dynamic Before / After Photos Preview
            const imagesContainer = document.getElementById('modalImagesContainer');
            const beforeWrapper = document.getElementById('modalBeforePhotosWrapper');
            const beforeList = document.getElementById('modalBeforePhotosList');
            const afterWrapper = document.getElementById('modalAfterPhotosWrapper');
            const afterList = document.getElementById('modalAfterPhotosList');

            let hasPhotos = false;
            if (item.beforePhotos && item.beforePhotos.length > 0) {
                hasPhotos = true;
                beforeWrapper.style.display = 'block';
                beforeList.innerHTML = item.beforePhotos.map(url => `
                    <a href="${url}" target="_blank">
                        <img src="${url}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </a>
                `).join('');
            } else {
                beforeWrapper.style.display = 'none';
            }

            if (item.afterPhotos && item.afterPhotos.length > 0) {
                hasPhotos = true;
                afterWrapper.style.display = 'block';
                afterList.innerHTML = item.afterPhotos.map(url => `
                    <a href="${url}" target="_blank">
                        <img src="${url}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </a>
                `).join('');
            } else {
                afterWrapper.style.display = 'none';
            }

            if (imagesContainer) {
                imagesContainer.style.display = hasPhotos ? 'block' : 'none';
            }

            // Set Directions Link
            const directionsBtn = document.getElementById('modalDirectionsBtn');
            if (directionsBtn) {
                directionsBtn.href = `https://www.google.com/maps/search/?api=1&query=${item.lat},${item.lng}`;
            }

            // Set Pickup Action Button (Before Pickup vs After Pickup vs Completed)
            const pickupBtn = document.getElementById('modalPickupActionBtn');
            const pickupBtnText = document.getElementById('modalPickupActionText');
            if (pickupBtn && pickupBtnText) {
                if (item.status === 'PICKED_UP') {
                    pickupBtnText.innerText = 'Picked Up';
                    pickupBtn.href = '#';
                    pickupBtn.className = 'btn btn-secondary w-50 d-flex align-items-center justify-content-center py-2 disabled';
                } else if (item.beforePickupDone) {
                    pickupBtnText.innerText = 'After Pickup';
                    pickupBtn.href = '/vehicle/after-pickup/' + item.id;
                    pickupBtn.className = 'btn btn-primary w-50 d-flex align-items-center justify-content-center py-2';
                } else {
                    pickupBtnText.innerText = 'Before Pickup';
                    pickupBtn.href = '/vehicle/before-pickup/' + item.id;
                    pickupBtn.className = 'btn btn-success w-50 d-flex align-items-center justify-content-center py-2';
                }
            }

             // NEW: Initialize Availability dropdown
            setupAvailabilityControls(item);


            const modal = new bootstrap.Modal(document.getElementById('requestDetailModal'));
            modal.show();
        }

        


        function setupAvailabilityControls(item) {

    const availabilitySelect = document.getElementById('pickupAvailability');
    const availabilityContainer = document.getElementById('pickupAvailabilityContainer');
    const directionsBtn = document.getElementById('modalDirectionsBtn');
    const notAvailableSection = document.getElementById('notAvailableSection');
    const notAvailableReason = document.getElementById('notAvailableReason');
    const notAvailableSubmitBtn = document.getElementById('notAvailableSubmitBtn');
    const availablePickupSection = document.getElementById('availablePickupSection');

    if (!availabilitySelect) return;

    // Reset every time modal opens
    availabilitySelect.value = '';
    notAvailableReason.value = '';
    notAvailableSection.style.display = 'none';
    availablePickupSection.style.display = 'none';
    notAvailableSubmitBtn.disabled = true;

    // Check status: Only show availability dropdown for ASSIGNED / pending requests
    const isAlreadyPickedUp = (item.status === 'PICKED_UP' || item.status === 'COMPLETED' || item.status === 'DUMPED' || item.status === 'NOT_AVAILABLE' || item.pickedUpDone);

    if (isAlreadyPickedUp) {
        if (availabilityContainer) availabilityContainer.style.display = 'none';
        if (directionsBtn) {
            directionsBtn.classList.remove('w-50');
            directionsBtn.classList.add('w-100');
        }
    } else {
        if (availabilityContainer) availabilityContainer.style.display = 'block';
        if (directionsBtn) {
            directionsBtn.classList.remove('w-100');
            directionsBtn.classList.add('w-50');
        }
    }

    // Availability selection
    availabilitySelect.onchange = function () {

        if (this.value === 'available') {

            // Show existing Before Pickup functionality
            availablePickupSection.style.display = 'block';

            // Hide not available section
            notAvailableSection.style.display = 'none';

        } else if (this.value === 'not_available') {

            // Show reason dropdown
            notAvailableSection.style.display = 'block';

            // Hide Before Pickup
            availablePickupSection.style.display = 'none';

        } else {

            notAvailableSection.style.display = 'none';
            availablePickupSection.style.display = 'none';
        }
    };

    // Enable Submit only after reason is selected
    notAvailableReason.onchange = function () {

        notAvailableSubmitBtn.disabled = this.value === '';

    };

    // Not Available Submit
    notAvailableSubmitBtn.onclick = function () {
        const reason = notAvailableReason.value;
        if (!reason) return;

        const reasonText = notAvailableReason.options[notAvailableReason.selectedIndex].text;

        notAvailableSubmitBtn.disabled = true;
        notAvailableSubmitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';

        fetch('/vehicle/not-available/' + item.id, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                reason: reasonText
            })
        })
        .then(async res => {
            const data = await res.json();
            if (res.ok && data.success) {
                Swal.fire({
                    title: 'Status Updated!',
                    text: 'Request marked as Waste Not Available.',
                    icon: 'info',
                    confirmButtonColor: '#0e7a43'
                }).then(() => {
                    location.reload();
                });
            } else {
                notAvailableSubmitBtn.disabled = false;
                notAvailableSubmitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit';
                Swal.fire('Notice', data.message || 'Failed to update status.', 'warning');
            }
        })
        .catch(err => {
            notAvailableSubmitBtn.disabled = false;
            notAvailableSubmitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit';
            Swal.fire('Error', 'An unexpected error occurred.', 'error');
        });
    };
}





        function renderRequestCards() {
            const cardsContainer = document.getElementById('cards-container');
            cardsContainer.innerHTML = allRequestData.map((item, index) => {
                const statusBadge = item.status === 'PICKED_UP'
                    ? '<span class="badge bg-success py-1 px-2 font-11 rounded-2"><i class="fa-solid fa-circle-check"></i> PICKED UP</span>'
                    : '<span class="badge bg-primary py-1 px-2 font-11 rounded-2"><i class="fa-solid fa-truck-fast"></i> ASSIGNED</span>';
                const searchText = `${item.ref} ${item.applicant} ${item.location} ${item.category} ${item.status}`.toLowerCase();

                return `
                    <div class="request-card request-item-row" data-search="${searchText}" data-status="${item.status.toLowerCase()}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge-cwd-id">${item.ref}</span>
                            ${statusBadge}
                        </div>
                        <div>
                            <a href="https://www.google.com/maps/search/?api=1&query=${item.lat},${item.lng}" target="_blank" class="btn-get-directions">
                                <i class="fa-solid fa-diamond-turn-right"></i> Get Directions
                            </a>
                        </div>
                        <hr class="card-divider">
                        <div class="d-flex justify-content-between align-items-end">
                            <div>
                                <div class="card-info-item">
                                    <i class="fa-solid fa-recycle text-success"></i>
                                    <span class="card-info-label">Category:</span>
                                    <span class="card-info-value">${item.category}</span>
                                </div>
                                <div class="card-info-item" style="margin-top: 4px;">
                                    <i class="fa-solid fa-list-ul text-info"></i>
                                    <span class="card-info-label">Sub Category:</span>
                                    <span class="card-info-value">${item.subCategory}</span>
                                </div>
                            </div>
                            <button type="button" class="btn-view-card" data-request-index="${index}">
                                <i class="fa-regular fa-eye"></i> View
                            </button>
                        </div>
                    </div>`;
            }).join('');

            cardsContainer.querySelectorAll('[data-request-index]').forEach(button => {
                button.addEventListener('click', () => {
                    const item = allRequestData[Number(button.dataset.requestIndex)];
                    openRequestModal(item);
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderRequestCards();
            const searchInput = document.getElementById('unified-search');
            const filterSelect = document.getElementById('unified-filter');
            const rows = document.querySelectorAll('.request-item-row');
            const noResults = document.getElementById('no-results-msg');

            function filterItems() {
                const q = searchInput.value.toLowerCase().trim();
                const statusFilter = filterSelect.value;
                let visibleCount = 0;

                rows.forEach(row => {
                    const searchData = row.getAttribute('data-search') || '';
                    const statusData = row.getAttribute('data-status') || '';
                    const matchesSearch = !q || searchData.includes(q);
                    const matchesStatus = statusFilter === 'all' || statusData === statusFilter;

                    if (matchesSearch && matchesStatus) {
                        row.style.display = 'block';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                noResults.style.display = visibleCount === 0 ? 'block' : 'none';
            }

            searchInput.addEventListener('input', filterItems);
            filterSelect.addEventListener('change', filterItems);
        });
    </script>
@endsection
