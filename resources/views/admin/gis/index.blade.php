@extends('admin.layout.app')

@section('title', 'GIS')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #gisMap {
        width: 100%;
        height: 620px;
        border-radius: 8px;
        z-index: 1;
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
    .swatch.requested { background:#e53935; }
    .swatch.scheduled { background:#ffb300; }
    .swatch.completed { background:#2e7d32; }
    .swatch.cancelled { background:#757575; }

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
    .pin-marker.requested { background: #e53935; }
    .pin-marker.scheduled { background: #ffb300; }
    .pin-marker.completed { background: #2e7d32; }
    .pin-marker.cancelled { background: #757575; }
    .pin-marker .pin-dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
        background: #fff;
        transform: rotate(45deg);
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
    // 1. BASE MAP
    // ------------------------------------------------------------------
    const map = L.map('gisMap').setView([12.9716, 77.5946], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

 
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

    const points = [
        { lat: 13.02, lng: 77.60, status: 'requested', label: 'Point #1' },
        { lat: 13.00, lng: 77.62, status: 'scheduled', label: 'Point #2' },
        { lat: 12.98, lng: 77.63, status: 'completed', label: 'Point #3' },
        { lat: 12.95, lng: 77.61, status: 'scheduled', label: 'Point #4' },
        { lat: 12.93, lng: 77.59, status: 'completed', label: 'Point #5' },
        { lat: 12.90, lng: 77.55, status: 'requested', label: 'Point #6' },
        { lat: 12.88, lng: 77.57, status: 'cancelled', label: 'Point #7' },
        { lat: 12.96, lng: 77.50, status: 'completed', label: 'Point #8' },
    ];

    // One layer group per status so the checkboxes can toggle visibility
    const statusLayers = {
        requested: L.layerGroup(),
        scheduled: L.layerGroup(),
        completed: L.layerGroup(),
        cancelled: L.layerGroup(),
    };

    points.forEach(p => {
        L.marker([p.lat, p.lng], { icon: icons[p.status] })
            .bindPopup(p.label)
            .addTo(statusLayers[p.status]);
    });

    Object.values(statusLayers).forEach(layer => layer.addTo(map));

    // ------------------------------------------------------------------
    // 3. HOVER-EXPAND STATUS CONTROL (top right)
    //    Collapsed = stacked-layers icon (like the reference screenshot).
    //    On hover, expands to show checkboxes that toggle each status's
    //    markers on/off.
    // ------------------------------------------------------------------
    const statusControl = L.control({ position: 'topright' });
    statusControl.onAdd = function () {
        const div = L.DomUtil.create('div', 'status-control');
        div.innerHTML = `
            <div class="status-icon" title="Toggle statuses">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" fill="#fff"/>
                    <path d="M2 12l10 5 10-5" stroke="#fff" stroke-width="1.6" fill="none"/>
                    <path d="M2 17l10 5 10-5" stroke="#fff" stroke-width="1.6" fill="none"/>
                </svg>
            </div>
            <div class="status-panel">
                <div class="legend-row">
                    <input type="checkbox" data-status="requested" checked>
                    <span class="swatch requested"></span> Requested
                </div>
                <div class="legend-row">
                    <input type="checkbox" data-status="scheduled" checked>
                    <span class="swatch scheduled"></span> Scheduled
                </div>
                <div class="legend-row">
                    <input type="checkbox" data-status="completed" checked>
                    <span class="swatch completed"></span> Completed
                </div>
                <div class="legend-row">
                    <input type="checkbox" data-status="cancelled" checked>
                    <span class="swatch cancelled"></span> Cancelled
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

});
</script>
@endsection