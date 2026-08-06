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
                <option value="all" selected>All Items</option>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
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
                    </div>

                    <div class="d-flex gap-2 mt-4" id="modalActionButtons">
                        <a id="modalDirectionsBtn" href="#" target="_blank" class="btn btn-get-directions w-50 d-flex align-items-center justify-content-center py-2">
                            <i class="fa-solid fa-diamond-turn-right me-1"></i> Directions
                        </a>
                        <a href="{{ route('driver.update_status') }}" class="btn btn-view-card w-50 d-flex align-items-center justify-content-center py-2">
                            <i class="fa-solid fa-camera me-1"></i> Update
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        // Frontend-only demo data. Replace this array with an API response when backend integration is needed.
        const allRequestData = [
            {
                id: 4177,
                ref: 'DCL-2025-000123',
                status: 'PENDING',
                category: 'Furniture',
                subCategory: 'Cots, Sofas',
                applicant: 'Ramesh Kumar',
                mobile: '9876543210',
                date: '09-Aug-2026',
                houseNo: '#123',
                ward: 'Ward 150',
                constituency: 'Bommanahalli',
                pincode: '560102',
                location: 'BTM Layout 2nd Stage, Bengaluru',
                lat: 12.9166,
                lng: 77.6101
            },
            {
                id: 4178,
                ref: 'DCL-2025-000124',
                status: 'PENDING',
                category: 'Electronics',
                subCategory: 'Laptops, Mobile Phones',
                applicant: 'AE Spot Officer - Ward 174',
                mobile: '9123456780',
                date: '16-Aug-2026',
                houseNo: 'Opp. Park',
                ward: 'Ward 174',
                constituency: 'HSR Layout',
                pincode: '560102',
                location: 'Silk Board Flyover Dump Site',
                lat: 12.9172,
                lng: 77.6228
            },
            {
                id: 4179,
                ref: 'DCL-2025-000125',
                status: 'ACCEPTED',
                category: 'Mattresses & Cushions',
                subCategory: 'Double Mattress',
                applicant: 'Suresh Reddy (Commercial Complex)',
                mobile: '9988776655',
                date: '23-Aug-2026',
                houseNo: '#45, Ground Floor',
                ward: 'Ward 151',
                constituency: 'Koramangala',
                pincode: '560034',
                location: 'Koramangala 5th Block',
                lat: 12.9352,
                lng: 77.6245
            }
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
            
            // Set Directions Link
            const directionsBtn = document.getElementById('modalDirectionsBtn');
            if (directionsBtn) {
                directionsBtn.href = `https://www.google.com/maps/search/?api=1&query=${item.lat},${item.lng}`;
            }

            const modal = new bootstrap.Modal(document.getElementById('requestDetailModal'));
            modal.show();
        }

        function renderRequestCards() {
            const cardsContainer = document.getElementById('cards-container');
            cardsContainer.innerHTML = allRequestData.map((item, index) => {
                const isPending = item.status === 'PENDING';
                const statusBadge = isPending
                    ? '<span class="badge-status-pending"><i class="fa-regular fa-clock"></i> PENDING</span>'
                    : `<span class="badge-status-accepted"><i class="fa-solid fa-circle-check"></i> ${item.status}</span>`;
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
