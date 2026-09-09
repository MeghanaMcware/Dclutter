@extends('admin.layout.app')

@section('title', 'GIS')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #gisMap {
        width: 100%;
        height: 650px;
        border-radius: 8px;
        z-index: 1;
    }

    /* ---------- Filter Card Styling ---------- */
    .gis-filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 14px 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
    }

    /* ---------- Hover-expand status control (top right) ---------- */
    .status-control {
        position: relative;
    }
    .status-control .status-icon {
        width: 40px;
        height: 40px;
        background: #1f2430;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,.35);
        cursor: pointer;
    }
    .status-control .status-icon svg {
        width: 20px;
        height: 20px;
    }
    .status-control .status-panel {
        display: none;
        position: absolute;
        top: 0;
        right: 46px;
        background: #1f2430;
        color: #fff;
        padding: 10px 16px;
        border-radius: 6px;
        font-size: 14px;
        line-height: 1.9;
        box-shadow: 0 2px 8px rgba(0,0,0,.35);
        white-space: nowrap;
    }
    .status-control:hover .status-panel,
    .status-control .status-panel:hover {
        display: block;
    }
    .status-panel .legend-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .status-panel .legend-row input[type="checkbox"] {
        width: 15px;
        height: 15px;
        accent-color: currentColor;
        cursor: pointer;
    }
    .status-panel .swatch {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        display: inline-block;
    }
    .swatch.requested { background:#2563eb; }
    .swatch.scheduled { background:#ea580c; }
    .swatch.completed { background:#16a34a; }
    .swatch.cancelled { background:#dc2626; }

    /* Custom pin marker */
    .pin-marker {
        width: 26px;
        height: 26px;
        border-radius: 50% 50% 50% 0;
        transform: rotate(-45deg);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 1px 4px rgba(0,0,0,.5);
        border: 1px solid rgba(0,0,0,.15);
    }
    .pin-marker.requested { background: #2563eb; }
    .pin-marker.scheduled { background: #ea580c; }
    .pin-marker.completed { background: #16a34a; }
    .pin-marker.cancelled { background: #dc2626; }
    .pin-marker .pin-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #fff;
        transform: rotate(45deg);
    }

    /* Ward popup & tooltip styles */
    .ward-tooltip {
        background: rgba(15, 23, 42, 0.9);
        color: #fff;
        border: none;
        border-radius: 4px;
        padding: 4px 8px;
        font-size: 12px;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    }

    .gis-popup {
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>GIS</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">GIS</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Row: Corporation & Constituency -->
    @php
        $corporationList = $corporations ?? \App\Models\Corporation::orderBy('name')->get();
        $constituencyList = $constituencies ?? \App\Models\Constituency::orderBy('name')->get();
    @endphp
    <div class="row mb-3">
        <div class="container-fluid">
            <div class="gis-filter-card">
                <div class="row g-3 align-items-center">
                    <div class="col-md-5 col-lg-4">
                        <label class="form-label mb-1 fw-bold text-dark small">
                            <i class="fa fa-building text-primary me-1"></i> Corporation
                        </label>
                        <select id="gisCorporationFilter" class="form-select select-sm">
                            <option value="all">All Corporations</option>
                            @foreach($corporationList as $corp)
                                <option value="{{ $corp->id }}">{{ $corp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5 col-lg-4">
                        <label class="form-label mb-1 fw-bold text-dark small">
                            <i class="fa fa-map-marker text-success me-1"></i> Constituency
                        </label>
                        <select id="gisConstituencyFilter" class="form-select select-sm">
                            <option value="all">All Constituencies</option>
                            @foreach($constituencyList as $const)
                                <option value="{{ $const->id }}" data-corp="{{ $const->corporation_id }}">
                                    {{ $const->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 col-lg-4 d-flex align-items-end mt-3 mt-md-4">
                        <button type="button" id="resetGisFiltersBtn" class="btn btn-outline-secondary btn-sm px-3">
                            <i class="fa fa-refresh me-1"></i> Reset
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Card -->
    <div class="row">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div id="gisMap"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ------------------------------------------------------------------
    // 1. BASE MAP (Centered on Bengaluru)
    // ------------------------------------------------------------------
    const defaultCenter = [12.9716, 77.5946];
    const defaultZoom = 11;

    const map = L.map('gisMap', {
        preferCanvas: true,
        zoomControl: true
    }).setView(defaultCenter, defaultZoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors | GBA D-Clutter',
        maxZoom: 19
    }).addTo(map);

    // ------------------------------------------------------------------
    // 2. PIN MARKER ICONS & LAYER GROUPS
    // ------------------------------------------------------------------
    function pinIcon(statusClass) {
        return L.divIcon({
            className: '',
            html: `<div class="pin-marker ${statusClass}"><div class="pin-dot"></div></div>`,
            iconSize: [26, 26],
            iconAnchor: [13, 26],
            popupAnchor: [0, -26]
        });
    }

    const icons = {
        requested: pinIcon('requested'),
        scheduled: pinIcon('scheduled'),
        completed: pinIcon('completed'),
        cancelled: pinIcon('cancelled'),
    };

    const statusLayers = {
        requested: L.layerGroup(),
        scheduled: L.layerGroup(),
        completed: L.layerGroup(),
        cancelled: L.layerGroup(),
    };

    Object.values(statusLayers).forEach(layer => layer.addTo(map));

    // ------------------------------------------------------------------
    // 3. HOVER-EXPAND STATUS CONTROL (top right)
    // ------------------------------------------------------------------
    const statusControl = L.control({ position: 'topright' });
    statusControl.onAdd = function () {
        const div = L.DomUtil.create('div', 'status-control');
        div.innerHTML = `
            <div class="status-icon" title="Toggle Request Statuses">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" fill="#fff"/>
                    <path d="M2 12l10 5 10-5" stroke="#fff" stroke-width="1.6" fill="none"/>
                    <path d="M2 17l10 5 10-5" stroke="#fff" stroke-width="1.6" fill="none"/>
                </svg>
            </div>
            <div class="status-panel">
                <div class="legend-row">
                    <input type="checkbox" data-status="requested" checked>
                    <span class="swatch requested"></span> Requested (<span id="count-requested">0</span>)
                </div>
                <div class="legend-row">
                    <input type="checkbox" data-status="scheduled" checked>
                    <span class="swatch scheduled"></span> Scheduled (<span id="count-scheduled">0</span>)
                </div>
                <div class="legend-row">
                    <input type="checkbox" data-status="completed" checked>
                    <span class="swatch completed"></span> Completed (<span id="count-completed">0</span>)
                </div>
                <div class="legend-row">
                    <input type="checkbox" data-status="cancelled" checked>
                    <span class="swatch cancelled"></span> Cancelled (<span id="count-cancelled">0</span>)
                </div>
            </div>
        `;
        L.DomEvent.disableClickPropagation(div);

        div.querySelectorAll('input[type="checkbox"]').forEach(cb => {
            cb.addEventListener('change', function () {
                const layer = statusLayers[this.dataset.status];
                if (this.checked) {
                    layer.addTo(map);
                } else {
                    map.removeLayer(layer);
                }
            });
        });

        return div;
    };
    statusControl.addTo(map);

    // ------------------------------------------------------------------
    // 4. DYNAMIC LOADER FOR WARDS & REQUESTS WITH FILTERS
    // ------------------------------------------------------------------
    let wardsGeoJsonLayer = null;

    function loadGisLayers() {
        const corpSelect = document.getElementById('gisCorporationFilter');
        const constSelect = document.getElementById('gisConstituencyFilter');

        const corpId = corpSelect ? corpSelect.value : 'all';
        const constId = constSelect ? constSelect.value : 'all';

        // Clear existing markers
        Object.values(statusLayers).forEach(layer => layer.clearLayers());

        // 4A. Fetch and render Ward Boundaries
        const wardsUrl = new URL("{{ route('gis.api.wards') }}", window.location.origin);
        if (corpId && corpId !== 'all') wardsUrl.searchParams.set('corporation_id', corpId);
        if (constId && constId !== 'all') wardsUrl.searchParams.set('constituency_id', constId);

        fetch(wardsUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(geojsonData => {
            if (wardsGeoJsonLayer) {
                map.removeLayer(wardsGeoJsonLayer);
            }

            if (geojsonData.features && geojsonData.features.length > 0) {
                wardsGeoJsonLayer = L.geoJSON(geojsonData, {
                    style: function (feature) {
                        const color = feature.properties?.color || '#3b82f6';
                        return {
                            color: color,
                            weight: 1.5,
                            opacity: 0.8,
                            fillColor: color,
                            fillOpacity: 0.12
                        };
                    },
                    onEachFeature: function (feature, layer) {
                        const props = feature.properties || {};
                        const wardName = props.name || 'Ward';
                        const wardNo = props.ward_number ? `Ward #${props.ward_number}` : '';
                        const constName = props.constituency || 'N/A';
                        const corpName = props.corporation || 'N/A';

                        layer.bindTooltip(`<strong>${wardName}</strong> (${wardNo})<br><small>${corpName} Corporation</small>`, {
                            sticky: true,
                            className: 'ward-tooltip'
                        });

                        layer.on({
                            mouseover: function (e) {
                                const l = e.target;
                                l.setStyle({ weight: 3, fillOpacity: 0.28 });
                                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                    l.bringToFront();
                                }
                            },
                            mouseout: function (e) {
                                wardsGeoJsonLayer.resetStyle(e.target);
                            },
                            click: function (e) {
                                const popupContent = `
                                    <div class="gis-popup">
                                        <h6 class="mb-1 fw-bold text-primary">${wardName}</h6>
                                        <div class="text-muted small mb-2">${wardNo}</div>
                                        <div><strong>Constituency:</strong> ${constName}</div>
                                        <div><strong>Corporation:</strong> ${corpName}</div>
                                    </div>
                                `;
                                layer.bindPopup(popupContent).openPopup(e.latlng);
                            }
                        });
                    }
                }).addTo(map);

                // Auto fit bounds to filtered wards if filtered
                if ((corpId !== 'all' || constId !== 'all') && wardsGeoJsonLayer.getBounds().isValid()) {
                    map.fitBounds(wardsGeoJsonLayer.getBounds(), { padding: [30, 30] });
                } else if (corpId === 'all' && constId === 'all') {
                    map.setView(defaultCenter, defaultZoom);
                }
            }
        })
        .catch(err => console.error("Error loading ward boundaries:", err));

        // 4B. Fetch and render Live Request Pins
        const reqUrl = new URL("{{ route('gis.api.requests') }}", window.location.origin);
        if (corpId && corpId !== 'all') reqUrl.searchParams.set('corporation_id', corpId);
        if (constId && constId !== 'all') reqUrl.searchParams.set('constituency_id', constId);

        fetch(reqUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success || !Array.isArray(data.points)) return;

            const counts = { requested: 0, scheduled: 0, completed: 0, cancelled: 0 };

            data.points.forEach(p => {
                const statusKey = p.status || 'requested';
                if (counts[statusKey] !== undefined) counts[statusKey]++;

                const icon = icons[statusKey] || icons.requested;
                const targetLayer = statusLayers[statusKey] || statusLayers.requested;

                const popupContent = `
                    <div class="gis-popup p-1" style="min-width: 200px;">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-primary fs-6">${p.request_number}</strong>
                            <span class="badge" style="background:${statusKey === 'completed' ? '#16a34a' : (statusKey === 'scheduled' ? '#ea580c' : (statusKey === 'cancelled' ? '#dc2626' : '#2563eb'))}">
                                ${p.status_label}
                            </span>
                        </div>
                        <div class="small mb-1"><strong>Applicant:</strong> ${p.applicant_name}</div>
                        <div class="small mb-1"><strong>Category:</strong> ${p.category}</div>
                        <div class="small mb-1"><strong>Address:</strong> ${p.house_no ? p.house_no + ', ' : ''}${p.address}</div>
                        ${p.ward_name ? `<div class="small mb-2 text-muted"><strong>Ward:</strong> ${p.ward_name} (${p.ward_number ? '#' + p.ward_number : ''})</div>` : ''}
                        <div class="text-end mt-2">
                            <a href="${p.view_url}" target="_blank" class="btn btn-primary btn-xs text-white" style="font-size:11px; padding:3px 10px; text-decoration:none; border-radius:4px;">
                                View Details &rarr;
                            </a>
                        </div>
                    </div>
                `;

                L.marker([p.lat, p.lng], { icon: icon })
                    .bindPopup(popupContent)
                    .addTo(targetLayer);
            });

            // Update counts in legend panel
            ['requested', 'scheduled', 'completed', 'cancelled'].forEach(k => {
                const el = document.getElementById(`count-${k}`);
                if (el) el.innerText = counts[k];
            });
        })
        .catch(err => console.error("Error loading requests points:", err));
    }

    // ------------------------------------------------------------------
    // 5. FILTER EVENT LISTENERS
    // ------------------------------------------------------------------
    const corpFilter = document.getElementById('gisCorporationFilter');
    const constFilter = document.getElementById('gisConstituencyFilter');
    const resetBtn = document.getElementById('resetGisFiltersBtn');

    if (corpFilter) {
        corpFilter.addEventListener('change', function () {
            const selectedCorp = this.value;

            // Filter constituency dropdown options matching selected corporation
            if (constFilter) {
                Array.from(constFilter.options).forEach(opt => {
                    if (opt.value === 'all') {
                        opt.style.display = '';
                    } else {
                        const optCorp = opt.getAttribute('data-corp');
                        if (selectedCorp === 'all' || optCorp === selectedCorp) {
                            opt.style.display = '';
                        } else {
                            opt.style.display = 'none';
                        }
                    }
                });
                constFilter.value = 'all';
            }

            loadGisLayers();
        });
    }

    if (constFilter) {
        constFilter.addEventListener('change', function () {
            loadGisLayers();
        });
    }

    if (resetBtn) {
        resetBtn.addEventListener('click', function () {
            if (corpFilter) corpFilter.value = 'all';
            if (constFilter) {
                Array.from(constFilter.options).forEach(opt => opt.style.display = '');
                constFilter.value = 'all';
            }
            loadGisLayers();
        });
    }

    // Initial load
    loadGisLayers();

});
</script>
@endsection