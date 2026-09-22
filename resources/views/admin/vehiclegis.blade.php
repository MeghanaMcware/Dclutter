@extends('admin.layout.app')

@section('title') Vehicle GIS Route Tracking @endsection

@section('style')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* Modern Glassmorphic Filter Card */
        .gis-filter-card {
            background: #ffffff;
            border-radius: 18px;
            padding: 20px 24px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.04);
            position: relative;
            z-index: 1;
        }

        /* Ensure Datepicker is above Leaflet Map and All UI Overlays */
        .datepickers-container { z-index: 99999 !important; }
        .datepicker {
            z-index: 99999 !important;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.18) !important;
            border: 1px solid #e2e8f0 !important;
        }

        .filter-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* Select2 theme tweaks */
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 10px !important;
            display: flex;
            align-items: center;
            padding-left: 6px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 8px !important;
            right: 8px !important;
        }
        .select2-container { width: 100% !important; }

        /* Map Container */
        .map-wrapper {
            position: relative;
            background: #ffffff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.07);
            border: 1px solid rgba(0, 0, 0, 0.05);
            z-index: 1;
        }
        #map {
            height: 80vh;
            width: 100%;
            background: #f1f5f9;
        }

        /* Floating Overlays on Map */
        .map-glass-control {
            background: rgba(255, 255, 255, 0.92) !important;
            backdrop-filter: blur(12px) !important;
            -webkit-backdrop-filter: blur(12px) !important;
            border: 1px solid rgba(255, 255, 255, 0.7) !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12) !important;
            padding: 10px 16px !important;
            font-size: 13px;
            color: #1e293b;
        }

        /* Custom Numbered Badges for Stops */
        .stop-marker-badge {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 800;
            font-size: 13px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.25);
            border: 2.5px solid #ffffff;
            position: relative;
            transition: transform 0.2s ease;
        }
        .stop-marker-badge:hover { transform: scale(1.18); z-index: 1000 !important; }
        .stop-collected { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .stop-closed { background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%); }

        /* Start and End Stop Pulsing */
        .stop-start-pulse { animation: startPulse 2s infinite; }
        @keyframes startPulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 14px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
        .stop-end-pulse { animation: endPulse 2s infinite; }
        @keyframes endPulse {
            0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7); }
            70% { box-shadow: 0 0 0 14px rgba(59, 130, 246, 0); }
            100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
        }

        /* Rich Stop Popup */
        .leaflet-popup-content-wrapper {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(12px) !important;
            border-radius: 14px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.16) !important;
            padding: 4px;
        }
        .leaflet-popup-content { margin: 12px 14px; line-height: 1.4; }

        .stop-popup-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .stop-seq-badge {
            background: #2563eb;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 20px;
        }

        /* Sliding Route Timeline Drawer */
        .route-drawer {
            position: absolute;
            top: 15px;
            right: -420px;
            width: 380px;
            height: calc(100% - 30px);
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(16px);
            border-radius: 16px;
            box-shadow: -6px 0 25px rgba(0, 0, 0, 0.12);
            border: 1px solid rgba(0, 0, 0, 0.06);
            transition: right 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        .route-drawer.active { right: 15px; }
        .drawer-header {
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #f8fafc;
        }
        .drawer-body { padding: 14px 16px; overflow-y: auto; flex: 1; }

        /* Summary strip inside drawer */
        .drawer-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 12px;
        }
        .drawer-summary .sum-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 8px 10px;
            text-align: center;
        }
        .drawer-summary .sum-box b { display: block; font-size: 15px; color: #0f172a; }
        .drawer-summary .sum-box span { font-size: 11px; color: #64748b; }

        .timeline-stop-item {
            display: flex;
            gap: 12px;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
            border: 1px solid #f1f5f9;
            background: #ffffff;
        }
        .timeline-stop-item:hover {
            background: #f8fafc;
            transform: translateX(-3px);
            border-color: #cbd5e1;
        }
        .timeline-stop-item.active-stop { background: #eff6ff; border-color: #93c5fd; }

        .timeline-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            color: #ffffff;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .bg-success-light { background: #d1fae5; }
        .bg-danger-light { background: #ffe4e6; }

        /* Map Loading Spinner Overlay */
        .map-loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(4px);
            z-index: 999;
            display: none;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 12px;
        }
        .map-loading-overlay.active { display: flex; }

        /* Toggle drawer button */
        .btn-toggle-drawer {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 900;
            border: none;
            border-radius: 10px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            color: #1e293b;
            background: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }
        .btn-toggle-drawer:hover { background: #f8fafc; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); }

        /* Legend */
        .map-legend {
            display: flex;
            gap: 14px;
            align-items: center;
            font-size: 12px;
            color: #334155;
        }
        .map-legend i.dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            margin-right: 5px;
        }

        @media (max-width: 575px) {
            .route-drawer { width: calc(100% - 30px); }
            #map { height: 70vh; }
        }
    </style>
@endsection

@section('content')
<div class="container-fluid" style="padding: 20px 20px 0 20px;">
    {{-- PAGE HEADER --}}
    <div class="page-title" style="padding-bottom: 15px;">
        <div class="row align-items-center">
            <div class="col-12 col-sm-6">
                <h4 style="font-weight: 700; color: #1e293b; margin: 0;">
                    <i class="bi bi-truck-front-fill text-primary me-2"></i> Vehicle GIS Route Tracking
                </h4>
            </div>
            <div class="col-12 col-sm-6 d-flex justify-content-sm-end mt-2 mt-sm-0">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#"><i class="fa-solid fa-house"></i></a></li>
                    <li class="breadcrumb-item"><a href="#">GIS Map</a></li>
                    <li class="breadcrumb-item active">Vehicles GIS</li>
                </ol>
            </div>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="gis-filter-card">
        <form id="gisFilterForm" onsubmit="return false;">
            <div class="row g-3 align-items-end">
                {{-- Corporation Filter --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <label class="filter-label"><i class="bi bi-building"></i> Corporation</label>
                    <select name="corporation_id" id="filter_corporation" class="form-select select2-filter">
                        <option value="">All Corporations</option>
                        <option value="1">Bruhat Bengaluru Mahanagara Palike</option>
                        <option value="2">Bengaluru East Corporation</option>
                        <option value="3">Bengaluru West Corporation</option>
                    </select>
                </div>

                {{-- Category Filter --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <label class="filter-label"><i class="bi bi-recycle"></i> Category</label>
                    <select name="waste_type" id="filter_waste_type" class="form-select select2-filter">
                        <option value="">All Category</option>
                        <option value="Furniture">Furniture</option>
                        <option value="Clothes">Clothes & Shoes</option>
                        <option value="Household">Household appliances</option>
                    </select>
                </div>

                {{-- Vehicle Filter --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <label class="filter-label"><i class="bi bi-truck"></i> Vehicle</label>
                    <select name="vehicle_id" id="filter_vehicle" class="form-select select2-filter">
                        <option value="">-- Choose Vehicle --</option>
                    </select>
                </div>

                {{-- Date Filter --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <label class="filter-label"><i class="bi bi-calendar3"></i> Collection Date</label>
                    <input type="text" name="date" id="filter_date"
                           class="form-control datepicker-here"
                           placeholder="dd-mm-yyyy"
                           value=""
                           data-language="en"
                           data-date-format="dd-mm-yyyy"
                           autocomplete="off">
                </div>

                {{-- Action Buttons --}}
                <div class="col-lg-3 col-md-6 col-12 d-flex gap-2">
                    <button type="button" id="btnFilterApply" class="btn btn-primary w-100 fw-bold d-flex align-items-center justify-content-center" style="height: 42px;">
                        <i class="bi bi-funnel-fill me-1"></i> Filter
                    </button>
                    <button type="button" id="btnFilterReset" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" style="height: 42px; width: 44px; flex-shrink: 0;" title="Reset Filters">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- GIS MAP CONTAINER --}}
    <div class="map-wrapper mb-4">
        <div id="map"></div>

        {{-- Map Loading Spinner --}}
        <div id="mapLoader" class="map-loading-overlay">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Loading route...</span>
            </div>
            <span class="fw-bold text-dark" id="loaderText">Loading vehicle collection route...</span>
        </div>

        {{-- Toggle Drawer Button --}}
        <button type="button" id="btnToggleDrawer" class="btn-toggle-drawer">
            <i class="bi bi-list-ol text-primary"></i> <span id="btnDrawerLabel">Stops Timeline</span>
        </button>

        {{-- Sliding Route Timeline Drawer --}}
        <div id="routeDrawer" class="route-drawer">
            <div class="drawer-header">
                <div>
                    <h6 class="mb-0 fw-bold"><i class="bi bi-signpost-split me-1 text-primary"></i> Stops Sequence</h6>
                    <small class="text-muted" id="drawerVehicleLabel">No vehicle selected</small>
                </div>
                <button type="button" class="btn-close" id="btnCloseDrawer" aria-label="Close"></button>
            </div>
            <div class="drawer-body" id="drawerStopsList">
                <div class="text-center text-muted py-5">
                    <i class="bi bi-info-circle display-6 text-secondary d-block mb-2"></i>
                    Please select a vehicle and date to view stops sequence.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-polylinedecorator@1.6.0/dist/leaflet.polylineDecorator.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6.5.0/turf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            /* =====================================================
             * DEMO / MOCK DATA  (frontend only - no backend calls)
             * Replace these later with real AJAX responses.
             * ===================================================== */

            function todayDDMMYYYY() {
                const d = new Date();
                const dd = String(d.getDate()).padStart(2, '0');
                const mm = String(d.getMonth() + 1).padStart(2, '0');
                return `${dd}-${mm}-${d.getFullYear()}`;
            }
            const DEFAULT_DATE = todayDDMMYYYY();
            $('#filter_date').val(DEFAULT_DATE);

            // Category keys match the <select id="filter_waste_type"> option values
            const CATEGORY_LABELS = {
                Furniture: 'Furniture',
                Clothes: 'Clothes & Shoes',
                Household: 'Household Appliances'
            };
            const CATEGORY_ITEM_LABEL = {
                Furniture: 'Furniture Items',
                Clothes: 'Clothes & Shoes',
                Household: 'Appliances'
            };
            // Weight multiplier per category (demo only)
            const CATEGORY_WEIGHT_FACTOR = { Furniture: 1.8, Clothes: 0.4, Household: 1.2 };

            const MOCK_VEHICLES = [
                { id: 1, corp: 1, number: 'KA-01-AB-1234', category: 'Furniture', driver_name: 'Ramesh Kumar' },
                { id: 2, corp: 1, number: 'KA-01-CD-5678', category: 'Clothes',   driver_name: 'Suresh Gowda' },
                { id: 3, corp: 2, number: 'KA-05-EF-9012', category: 'Household', driver_name: 'Manjunath S' },
                { id: 4, corp: 2, number: 'KA-05-GH-3456', category: 'Furniture', driver_name: 'Prakash Reddy' },
                { id: 5, corp: 3, number: 'KA-02-JK-7788', category: 'Household', driver_name: 'Imran Pasha' }
            ];

            // Shop names per category
            const SHOP_NAMES = {
                Furniture: ['Royal Wood Furniture', 'Sri Sai Sofa Works', 'Urban Living Interiors', 'Modern Cot & Mattress', 'Elite Office Furniture', 'Classic Teak House', 'Home Decor Hub', 'Sagar Furniture Mart', 'Green Valley Woodcraft', 'Kaveri Furniture Store'],
                Clothes:   ['Fashion Hub Garments', 'Sri Lakshmi Textiles', 'Trendy Shoe Palace', 'Urban Threads', 'Kids Wear Corner', 'City Footwear Mart', 'Royal Readymades', 'Style Street Boutique', 'Comfort Sole Shoes', 'Kaveri Cloth Centre'],
                Household: ['Sharma Electronics', 'Sri Balaji Appliances', 'Home Needs Electricals', 'Cool Breeze ACs & Coolers', 'Kitchen King Appliances', 'Vijay Home Appliances', 'Digital World Electronics', 'Bharath Refrigeration', 'Sagar Home Care', 'Kaveri Electricals']
            };

            // Base stops (Bengaluru). Each vehicle gets a shifted copy of these.
            const BASE_STOPS = [
                { uid: 'SHP-1001', ward: 'Shivajinagar',  wno: 78,  lat: 12.9857, lng: 77.6057, status: 'collected', qty: 6,  kg: 14.5, amount: 725,  time: '06:12 AM' },
                { uid: 'SHP-1002', ward: 'Shivajinagar',  wno: 78,  lat: 12.9838, lng: 77.6011, status: 'collected', qty: 9,  kg: 22.0, amount: 1100, time: '06:34 AM' },
                { uid: 'SHP-1003', ward: 'Commercial St', wno: 92,  lat: 12.9822, lng: 77.6079, status: 'closed',    qty: 0,  kg: 0,    amount: 0,    time: '06:51 AM' },
                { uid: 'SHP-1004', ward: 'Richmond Town', wno: 110, lat: 12.9663, lng: 77.6002, status: 'collected', qty: 7,  kg: 18.3, amount: 915,  time: '07:15 AM' },
                { uid: 'SHP-1005', ward: 'Richmond Town', wno: 110, lat: 12.9612, lng: 77.5949, status: 'collected', qty: 4,  kg: 11.2, amount: 560,  time: '07:38 AM' },
                { uid: 'SHP-1006', ward: 'Jayanagar',     wno: 168, lat: 12.9308, lng: 77.5838, status: 'collected', qty: 11, kg: 27.6, amount: 1380, time: '08:05 AM' },
                { uid: 'SHP-1007', ward: 'Jayanagar',     wno: 168, lat: 12.9250, lng: 77.5936, status: 'closed',    qty: 0,  kg: 0,    amount: 0,    time: '08:29 AM' },
                { uid: 'SHP-1008', ward: 'BTM Layout',    wno: 176, lat: 12.9166, lng: 77.6101, status: 'collected', qty: 8,  kg: 16.9, amount: 845,  time: '08:57 AM' },
                { uid: 'SHP-1009', ward: 'HSR Layout',    wno: 174, lat: 12.9116, lng: 77.6389, status: 'collected', qty: 10, kg: 20.4, amount: 1020, time: '09:22 AM' },
                { uid: 'SHP-1010', ward: 'HSR Layout',    wno: 174, lat: 12.9081, lng: 77.6476, status: 'collected', qty: 5,  kg: 13.7, amount: 685,  time: '09:48 AM' }
            ];

            // Mock ward polygons (lat,lng | lat,lng ...) - same format as backend "boundry"
            const MOCK_WARDS = [
                { name: 'Shivajinagar',  number: 78,  corp_name: 'Bruhat Bengaluru Mahanagara Palike',
                  boundry: '12.9950,77.5950|12.9950,77.6120|12.9780,77.6120|12.9780,77.5950' },
                { name: 'Richmond Town', number: 110, corp_name: 'Bruhat Bengaluru Mahanagara Palike',
                  boundry: '12.9780,77.5950|12.9780,77.6120|12.9560,77.6120|12.9560,77.5950' },
                { name: 'Jayanagar',     number: 168, corp_name: 'Bengaluru West Corporation',
                  boundry: '12.9400,77.5750|12.9400,77.6000|12.9180,77.6000|12.9180,77.5750' },
                { name: 'BTM Layout',    number: 176, corp_name: 'Bengaluru East Corporation',
                  boundry: '12.9280,77.6000|12.9280,77.6250|12.9080,77.6250|12.9080,77.6000' },
                { name: 'HSR Layout',    number: 174, corp_name: 'Bengaluru East Corporation',
                  boundry: '12.9280,77.6250|12.9280,77.6550|12.9000,77.6550|12.9000,77.6250' }
            ];

            // Build a mock route response for a vehicle + date
            function buildMockRoute(vehicleId, date) {
                const veh = MOCK_VEHICLES.find(v => String(v.id) === String(vehicleId));
                if (!veh) return { success: false, message: 'Vehicle not found.' };

                const vehInfo = {
                    number: veh.number,
                    category: veh.category,
                    category_label: CATEGORY_LABELS[veh.category],
                    driver_name: veh.driver_name
                };

                // Demo rule: vehicle 5 has no collections -> shows empty state
                if (veh.id === 5) {
                    return { success: false, message: 'No collections on this date.', vehicle: vehInfo };
                }

                const shift = (veh.id - 1) * 0.0035;
                const count = 6 + (veh.id % 5);           // 7 to 10 stops
                const factor = CATEGORY_WEIGHT_FACTOR[veh.category] || 1;
                const names = SHOP_NAMES[veh.category];

                const stops = BASE_STOPS.slice(0, Math.min(count, BASE_STOPS.length)).map((s, i) => ({
                    sequence: i + 1,
                    shop_id: 100 + i,
                    shop_name: names[i],
                    shop_unique_id: s.uid,
                    ward_name: s.ward,
                    ward_number: s.wno,
                    lat: s.lat + shift,
                    lng: s.lng + shift,
                    status: s.status,
                    status_label: s.status === 'collected' ? 'Collected' : 'Shop Closed',
                    time: s.time,
                    category_label: CATEGORY_LABELS[veh.category],
                    item_label: CATEGORY_ITEM_LABEL[veh.category],
                    qty: s.qty,
                    weight: s.status === 'collected' ? +(s.kg * factor).toFixed(1) : 0,
                    amount: s.amount,
                    driver_name: veh.driver_name,
                    image_url: (s.status === 'collected' && i % 2 === 0)
                        ? 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=800' : ''
                }));

                // Simple path: connect stops with a slight bend to look like roads
                const polyline = [];
                stops.forEach((s, i) => {
                    polyline.push([s.lat, s.lng]);
                    if (i < stops.length - 1) polyline.push([s.lat, stops[i + 1].lng]);
                });

                return { success: true, date: date, vehicle: vehInfo, stops: stops, polyline: polyline };
            }

            /* =====================================================
             * UI SETUP
             * ===================================================== */

            $('.select2-filter').select2({ width: '100%' });

            // Datepicker init
            $('#filter_date').datepicker({
                language: 'en',
                dateFormat: 'dd-mm-yyyy',
                autoClose: true,
                maxDate: new Date(),
                onSelect: function(formattedDate) {
                    if (formattedDate) $('#filter_date').val(formattedDate);
                    setTimeout(triggerRouteFetch, 50);
                }
            });
            $('#filter_date').on('change', function() { triggerRouteFetch(); });

            // --- Leaflet Map Setup ---
            const defaultCenter = [12.9716, 77.5946];
            const map = L.map('map', { preferCanvas: true, zoomControl: false, attributionControl: false }).setView(defaultCenter, 12);
            L.control.zoom({ position: 'topleft' }).addTo(map);
            L.control.attribution({ prefix: false, position: 'bottomright' }).addTo(map);

            // Basemaps (no API key required)
            const streetMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri',
                maxZoom: 19
            }).addTo(map);

            const osmStandard = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            });

            const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri',
                maxZoom: 19
            });

            // Layer Groups
            const wardBoundariesLayer = L.layerGroup().addTo(map);
            const corpBoundariesLayer = L.layerGroup().addTo(map);
            const routePathLayer = L.layerGroup().addTo(map);
            const stopsMarkerLayer = L.layerGroup().addTo(map);

            L.control.layers({
                "Street Map": streetMap,
                "OpenStreetMap": osmStandard,
                "Satellite": satellite
            }, {
                "Ward Boundaries": wardBoundariesLayer,
                "Corporation Boundaries": corpBoundariesLayer,
                "Vehicle Route & Arrows": routePathLayer,
                "Sequential Stops (1, 2, 3...)": stopsMarkerLayer
            }, { position: 'topleft', collapsed: true }).addTo(map);

            // Status Badge Control on Map
            const InfoBadgeControl = L.Control.extend({
                options: { position: 'bottomleft' },
                onAdd: function() {
                    const div = L.DomUtil.create('div', 'map-glass-control');
                    div.id = 'mapStatusBadge';
                    div.innerHTML = '<i class="bi bi-info-circle-fill text-primary me-1"></i> Select a vehicle and click <b>Filter</b>.';
                    L.DomEvent.disableClickPropagation(div);
                    return div;
                }
            });
            map.addControl(new InfoBadgeControl());

            // Legend control
            const LegendControl = L.Control.extend({
                options: { position: 'bottomright' },
                onAdd: function() {
                    const div = L.DomUtil.create('div', 'map-glass-control map-legend');
                    div.innerHTML = `
                        <span><i class="dot" style="background:#10b981"></i>Collected</span>
                        <span><i class="dot" style="background:#f43f5e"></i>Closed</span>
                        <span><i class="bi bi-arrow-right-short text-primary"></i>Direction</span>
                    `;
                    L.DomEvent.disableClickPropagation(div);
                    return div;
                }
            });
            map.addControl(new LegendControl());

            function setMapStatus(html) {
                const el = document.getElementById('mapStatusBadge');
                if (el) el.innerHTML = html;
            }

            // --- Boundaries ---
            const corpGeometries = {};
            const cityBounds = L.latLngBounds();

            function parseBoundary(boundaryStr) {
                if (!boundaryStr || typeof boundaryStr !== 'string') return null;
                if (boundaryStr.indexOf('{') === 0) {
                    try { return JSON.parse(boundaryStr); } catch (e) { return null; }
                }
                if (boundaryStr.includes('|') && boundaryStr.includes(',')) {
                    try {
                        const coords = boundaryStr.split('|').map(p => {
                            const parts = p.trim().split(',');
                            if (parts.length < 2) return null;
                            const lat = parseFloat(parts[0].trim());
                            const lng = parseFloat(parts[1].trim());
                            if (isNaN(lat) || isNaN(lng)) return null;
                            return [lng, lat];
                        }).filter(c => c !== null);
                        if (coords.length > 0) {
                            const first = coords[0], last = coords[coords.length - 1];
                            if (first[0] !== last[0] || first[1] !== last[1]) coords.push([first[0], first[1]]);
                            return { type: 'Polygon', coordinates: [coords] };
                        }
                    } catch (e) { console.error(e); }
                }
                return null;
            }

            function plotBoundaries() {
                wardBoundariesLayer.clearLayers();
                corpBoundariesLayer.clearLayers();

                MOCK_WARDS.forEach(ward => {
                    const geo = parseBoundary(ward.boundry);
                    if (!geo) return;

                    const wardPoly = L.geoJSON(geo, {
                        style: { color: '#94a3b8', weight: 1.2, dashArray: '4,4', fillColor: '#3b82f6', fillOpacity: 0.04 }
                    }).bindTooltip(`<b>Ward: ${ward.name}</b> (#${ward.number})<br><small>${ward.corp_name || ''}</small>`, { sticky: true });

                    wardBoundariesLayer.addLayer(wardPoly);
                    cityBounds.extend(wardPoly.getBounds());

                    const cName = ward.corp_name || 'Corporation';
                    if (!corpGeometries[cName]) corpGeometries[cName] = [];
                    corpGeometries[cName].push(turf.feature(geo));
                });

                Object.keys(corpGeometries).forEach(corpName => {
                    const features = corpGeometries[corpName];
                    if (!features || features.length === 0) return;
                    let merged = features[0];
                    for (let i = 1; i < features.length; i++) {
                        try { merged = turf.union(merged, features[i]); } catch (e) {}
                    }
                    if (merged) {
                        const corpPoly = L.geoJSON(merged.geometry, {
                            style: { color: '#4f46e5', weight: 2.2, opacity: 0.85, fillColor: '#4f46e5', fillOpacity: 0.05 }
                        }).bindTooltip(`<b>Corporation: ${corpName}</b>`, { sticky: true });
                        corpBoundariesLayer.addLayer(corpPoly);
                    }
                });

                if (cityBounds.isValid()) map.fitBounds(cityBounds, { padding: [20, 20] });
            }
            plotBoundaries();

            // --- Drawer Logic ---
            const routeDrawer = $('#routeDrawer');
            $('#btnToggleDrawer').on('click', function() { routeDrawer.toggleClass('active'); });
            $('#btnCloseDrawer').on('click', function() { routeDrawer.removeClass('active'); });

            // --- Vehicle dropdown (client-side filtering of mock data) ---
            function refreshVehiclesList() {
                const corpId = $('#filter_corporation').val();
                const wasteType = $('#filter_waste_type').val();
                const currentVehId = $('#filter_vehicle').val();

                const filtered = MOCK_VEHICLES.filter(v =>
                    (!corpId || String(v.corp) === String(corpId)) &&
                    (!wasteType || v.category === wasteType)
                );

                let options = '<option value="">-- Choose Vehicle --</option>';
                let matched = false;
                filtered.forEach(v => {
                    const selected = (String(v.id) === String(currentVehId)) ? 'selected' : '';
                    if (selected) matched = true;
                    options += `<option value="${v.id}" ${selected}>${v.number} (${CATEGORY_LABELS[v.category]}) - ${v.driver_name}</option>`;
                });

                $('#filter_vehicle').html(options).trigger('change.select2');

                if (matched && currentVehId) triggerRouteFetch();
                else if (currentVehId && !matched) clearRouteLayers();
            }

            $('#filter_corporation, #filter_waste_type').on('change', refreshVehiclesList);

            $('#filter_vehicle').on('change', function() {
                if ($(this).val()) triggerRouteFetch();
            });

            $('#btnFilterApply').on('click', function() { triggerRouteFetch(); });

            $('#btnFilterReset').on('click', function() {
                $('#filter_corporation').val('').trigger('change.select2');
                $('#filter_waste_type').val('').trigger('change.select2');
                $('#filter_date').val(DEFAULT_DATE);
                $('#filter_vehicle').val('').trigger('change.select2');
                clearRouteLayers();
                refreshVehiclesList();
                setMapStatus('<i class="bi bi-info-circle-fill text-primary me-1"></i> Filters reset. Select a vehicle.');
                if (cityBounds.isValid()) map.fitBounds(cityBounds, { padding: [20, 20] });
            });

            function clearRouteLayers() {
                routePathLayer.clearLayers();
                stopsMarkerLayer.clearLayers();
                $('#drawerStopsList').html('<div class="text-center text-muted py-5"><i class="bi bi-info-circle display-6 text-secondary d-block mb-2"></i> No active route loaded.</div>');
                $('#drawerVehicleLabel').text('No vehicle selected');
            }

            let stopMarkersMap = {};

            // --- Route fetch (simulated delay, mock data) ---
            function triggerRouteFetch() {
                const vehicleId = $('#filter_vehicle').val();
                const date = $('#filter_date').val();

                if (!vehicleId) {
                    clearRouteLayers();
                    setMapStatus('<i class="bi bi-exclamation-triangle-fill text-warning me-1"></i> Please select a vehicle from the dropdown.');
                    return;
                }

                $('#mapLoader').addClass('active');
                $('#loaderText').text('Loading collection path & sequence...');

                setTimeout(function() {
                    const resp = buildMockRoute(vehicleId, date);

                    $('#mapLoader').removeClass('active');
                    clearRouteLayers();
                    stopMarkersMap = {};

                    if (!resp.success || !resp.stops || resp.stops.length === 0) {
                        setMapStatus(`<i class="bi bi-info-circle-fill text-secondary me-1"></i> ${resp.message || 'No collections on this date.'}`);
                        $('#drawerStopsList').html(`<div class="text-center text-muted py-5"><i class="bi bi-calendar-x display-6 text-secondary d-block mb-2"></i> ${resp.message || 'No visits found.'}</div>`);
                        if (resp.vehicle) $('#drawerVehicleLabel').text(`${resp.vehicle.number} (${resp.vehicle.category_label})`);
                        return;
                    }

                    if (resp.vehicle) {
                        const dateLabel = resp.date ? ` (${resp.date})` : '';
                        $('#drawerVehicleLabel').text(`${resp.vehicle.number} - Driver: ${resp.vehicle.driver_name}${dateLabel}`);
                    }

                    renderSequentialRoute(resp.stops, resp.polyline, resp.vehicle, resp.date);
                    routeDrawer.addClass('active');
                }, 600);
            }

            function renderSequentialRoute(stops, polylineCoords, vehicle, routeDate) {
                const routeBounds = L.latLngBounds();
                let drawerHtml = '';
                const totalStops = stops.length;

                // Summary numbers
                const collectedCount = stops.filter(s => s.status === 'collected').length;
                const closedCount = totalStops - collectedCount;
                const totalKg = stops.reduce((a, s) => a + (s.status === 'collected' ? Number(s.weight) : 0), 0).toFixed(1);

                stops.forEach((stop) => {
                    const isCollected = (stop.status === 'collected');
                    const seq = stop.sequence;
                    const isStart = (seq === 1);
                    const isEnd = (seq === totalStops && totalStops > 1);

                    let badgeClass = isCollected ? 'stop-collected' : 'stop-closed';
                    if (isStart) badgeClass += ' stop-start-pulse';
                    else if (isEnd) badgeClass += ' stop-end-pulse';

                    const stopIcon = L.divIcon({
                        className: 'custom-stop-div-icon',
                        html: `<div class="stop-marker-badge ${badgeClass}" title="Stop #${seq}: ${stop.shop_name}">${seq}</div>`,
                        iconSize: [32, 32],
                        iconAnchor: [16, 16],
                        popupAnchor: [0, -18]
                    });

                    const popupHtml = `
                        <div style="font-family: 'Inter', sans-serif; min-width: 250px;">
                            <div class="stop-popup-header">
                                <span class="stop-seq-badge"><i class="bi bi-geo-alt-fill"></i> Stop #${seq}</span>
                                <span class="badge ${isCollected ? 'bg-success' : 'bg-danger'} text-white text-uppercase" style="font-size:11px;">
                                    ${stop.status_label}
                                </span>
                            </div>

                            <h6 style="font-weight:700; color:#0f172a; margin:0 0 4px 0;">${stop.shop_name}</h6>
                            <div style="font-size:12px; color:#64748b; margin-bottom:10px;">
                                <i class="bi bi-hash"></i> ${stop.shop_unique_id} &bull; Ward: ${stop.ward_name} (#${stop.ward_number})
                            </div>

                            <table class="table table-sm table-bordered mb-2" style="font-size:12px;">
                                <tbody>
                                    <tr>
                                        <td class="bg-light text-muted">Visit Time</td>
                                        <td class="fw-bold">${stop.time}</td>
                                    </tr>
                                    ${isCollected ? `
                                        <tr>
                                            <td class="bg-light text-muted">Category</td>
                                            <td class="fw-bold text-primary">${stop.category_label}</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light text-muted">${stop.item_label}</td>
                                            <td class="fw-bold text-secondary">${stop.qty} pcs</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light text-muted">Total Weight</td>
                                            <td class="fw-bold text-dark">${stop.weight} kg</td>
                                        </tr>
                                        <tr>
                                            <td class="bg-light text-muted">Amount Paid</td>
                                            <td class="fw-bold text-success">₹ ${stop.amount}</td>
                                        </tr>
                                    ` : `
                                        <tr>
                                            <td class="bg-light text-muted">Status Note</td>
                                            <td class="fw-bold text-danger">Shop was closed during visit</td>
                                        </tr>
                                    `}
                                    <tr>
                                        <td class="bg-light text-muted">Driver</td>
                                        <td>${stop.driver_name}</td>
                                    </tr>
                                </tbody>
                            </table>

                            ${stop.image_url ? `
                                <div class="mb-2 text-center">
                                    <a href="${stop.image_url}" target="_blank" class="btn btn-xs btn-outline-primary w-100" style="font-size:11px;">
                                        <i class="bi bi-image"></i> View Collection Photo
                                    </a>
                                </div>
                            ` : ''}

                            <div class="mt-2 text-end">
                                <a href="#" class="btn btn-sm btn-info text-white w-100" style="font-size:12px; padding:4px 8px;">
                                    <i class="bi bi-shop"></i> View Shop Profile
                                </a>
                            </div>
                        </div>
                    `;

                    const marker = L.marker([stop.lat, stop.lng], { icon: stopIcon }).bindPopup(popupHtml);
                    stopsMarkerLayer.addLayer(marker);
                    routeBounds.extend([stop.lat, stop.lng]);
                    stopMarkersMap[seq] = marker;

                    marker.on('popupopen', function() {
                        $('.timeline-stop-item').removeClass('active-stop');
                        $(`.timeline-stop-item[data-seq="${seq}"]`).addClass('active-stop');
                    });

                    drawerHtml += `
                        <div class="timeline-stop-item" data-seq="${seq}" onclick="focusStop(${seq})">
                            <div class="timeline-num ${isCollected ? 'bg-success' : 'bg-danger'}">${seq}</div>
                            <div style="flex:1; overflow:hidden;">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold text-dark text-truncate" style="max-width:180px;">${stop.shop_name}</span>
                                    <small class="badge ${isCollected ? 'bg-success-light text-success' : 'bg-danger-light text-danger'}" style="font-size:10px;">
                                        ${stop.status_label}
                                    </small>
                                </div>
                                <div class="d-flex justify-content-between text-muted" style="font-size:11px;">
                                    <span><i class="bi bi-clock"></i> ${stop.time}</span>
                                    ${isCollected ? `<span><b class="text-primary">${stop.qty} pcs</b> &bull; ${stop.weight} kg &bull; ₹${stop.amount}</span>` : '<span class="text-danger">Closed</span>'}
                                </div>
                            </div>
                        </div>
                    `;
                });

                const summaryHtml = `
                    <div class="drawer-summary">
                        <div class="sum-box"><b>${collectedCount}</b><span>Collected</span></div>
                        <div class="sum-box"><b>${closedCount}</b><span>Closed</span></div>
                        <div class="sum-box"><b>${totalKg} kg</b><span>Total</span></div>
                    </div>
                `;
                $('#drawerStopsList').html(summaryHtml + drawerHtml);

                // Polyline + direction arrows
                if (polylineCoords && polylineCoords.length > 1) {
                    const routePolyline = L.polyline(polylineCoords, {
                        color: '#2563eb', weight: 4.5, opacity: 0.85, lineJoin: 'round', dashArray: null
                    });
                    routePathLayer.addLayer(routePolyline);

                    if (typeof L.polylineDecorator === 'function') {
                        const arrowDecorator = L.polylineDecorator(routePolyline, {
                            patterns: [
                                {
                                    offset: 35, repeat: 75,
                                    symbol: L.Symbol.arrowHead({
                                        pixelSize: 12, headAngle: 55, polygon: false,
                                        pathOptions: { stroke: true, weight: 2.5, color: '#ffffff', opacity: 0.95 }
                                    })
                                },
                                {
                                    offset: 35, repeat: 75,
                                    symbol: L.Symbol.arrowHead({
                                        pixelSize: 12, headAngle: 55, polygon: false,
                                        pathOptions: { stroke: true, weight: 2.5, color: '#1d4ed8', opacity: 0.95 }
                                    })
                                }
                            ]
                        });
                        routePathLayer.addLayer(arrowDecorator);
                    }
                }

                if (routeBounds.isValid()) map.fitBounds(routeBounds, { padding: [50, 50], maxZoom: 16 });

                setMapStatus(`
                    <i class="bi bi-check2-circle text-success me-1"></i>
                    <b>${vehicle ? vehicle.number : 'Vehicle'}</b>${routeDate ? ` (${routeDate})` : ''}: Loaded <b>${totalStops}</b> visited stops (Collected / Closed) in sequence (1 &rarr; ${totalStops}).
                `);
            }

            // Focus a stop from drawer click
            window.focusStop = function(seq) {
                const marker = stopMarkersMap[seq];
                if (marker) {
                    map.setView(marker.getLatLng(), 17, { animate: true, duration: 1 });
                    marker.openPopup();
                }
            };

            // Populate vehicle dropdown on load
            refreshVehiclesList();
        });
    </script>
@endsection