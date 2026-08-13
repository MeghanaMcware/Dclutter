@extends('vehiclepwa.layout.app')

@section('title') Today's Route @endsection
@section('heading') Today's Route @endsection

@section('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root { --primary-green: #0e7a43; --primary-dark: #095930; }

        .trip-info-card { background: #0e7a430f; border-radius: 16px; padding: 16px; border: 1px solid #0e7a43; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 14px; }
        .trip-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; }
        .trip-header-row h3 { font-size: 15px; font-weight: 800; color: #0f172a; margin: 0; }
        .trip-header-row p { font-size: 12px; color: #64748b; margin: 2px 0 0; }
        .badge-in-progress { background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; }
        .stats-summary-row { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; margin-top: 12px; padding-top: 10px; }
        .stats-summary-row span { font-size: 13px; font-weight: 700; color: #334155; }
        .stats-summary-row a { font-size: 12px; color: var(--primary-green); font-weight: 600; text-decoration: none; }

        .map-box { background: #e2e8f0; border-radius: 16px; height: 350px; position: relative; overflow: hidden; border: 1px solid #cbd5e1; box-shadow: inset 0 2px 6px rgba(0,0,0,0.05); }

        .btn-end-trip { width: 100%; height: 50px; background: var(--primary-green); color: #fff; border: none; border-radius: 14px; font-size: 16px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(14,122,67,0.3); }
        .btn-end-trip:hover { background: var(--primary-dark); color: #fff; }

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

        /* Popup Styles */
        .badge-cwd-id {
            background-color: #166534;
            color: #ffffff !important;
            font-size: 12.5px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-block;
        }
        .btn-get-directions {
            background-color: #ffffff;
            color: #0284c7 !important;
            border: 1.5px solid #166534;
            font-size: 13px;
            font-weight: 700;
            border-radius: 6px;
            display: inline-block;
            text-decoration: none;
            padding: 4px 12px;
            margin-top: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="container py-2" style="max-width: 440px; margin: 0 auto;">

        <!-- Trip Details Card -->
        <div class="trip-info-card">
            <div class="trip-header-row">
                <div>
                    <span style="font-size: 11px; color:#64748b; font-weight:600;">Trip ID</span>
                    <h3>TRP-2025-05-24-01</h3>
                    <p>6:00 AM - 11:00 AM</p>
                </div>
                <span class="badge-in-progress">In Progress</span>
            </div>

            <div class="stats-summary-row">
                <span>35 Stops • 8.7 km</span>
                <a href="{{ route('driver.stop_details') }}">View List</a>
            </div>
        </div>

        <!-- Interactive Map Graphic -->
        <div id="route-map" class="map-box mb-4"></div>

        <!-- Start Navigation Button -->
        <a href="{{ route('driver.requests') }}" class="btn-end-trip">
            <i class="fa-solid fa-location-arrow"></i>
            <span>Start Navigation</span>
        </a>

    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const allRequestData = [
                {
                    id: 4177,
                    ref: 'DCL-2025-000123',
                    applicant: 'Ramesh Kumar',
                    category: 'Furniture',
                    subCategory: 'Cots, Sofas',
                    location: 'BTM Layout 2nd Stage, Bengaluru',
                    lat: 12.9166,
                    lng: 77.6101
                },
                {
                    id: 4178,
                    ref: 'DCL-2025-000124',
                    applicant: 'AE Spot Officer - Ward 174',
                    category: 'Electronics',
                    subCategory: 'Laptops, Mobile Phones',
                    location: 'Silk Board Flyover Dump Site',
                    lat: 12.9172,
                    lng: 77.6228
                },
                {
                    id: 4179,
                    ref: 'DCL-2025-000125',
                    applicant: 'Suresh Reddy (Commercial Complex)',
                    category: 'Mattresses & Cushions',
                    subCategory: 'Double Mattress',
                    location: 'Koramangala 5th Block',
                    lat: 12.9352,
                    lng: 77.6245
                }
            ];

            const centerLat = allRequestData.length ? allRequestData[0].lat : 12.9166;
            const centerLng = allRequestData.length ? allRequestData[0].lng : 77.6101;

            const mapInstance = L.map('route-map').setView([centerLat, centerLng], 13);

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

                const popupHtml = `
                    <div style="min-width:210px; padding:2px;">
                        <span class="badge-cwd-id">${item.ref}</span>
                        <div style="font-size:13.5px; font-weight:700; color:#111827; margin-top:8px;">${item.applicant}</div>
                        <div style="font-size:12.5px; color:#6b7280; margin-bottom:12px;">${item.location}</div>
                        
                        <div style="font-size:12.5px; color:#4b5563; margin-bottom:4px;"><strong>Category:</strong> ${item.category}</div>
                        <div style="font-size:12.5px; color:#4b5563; margin-bottom:12px;"><strong>Sub Category:</strong> ${item.subCategory}</div>
                        
                        <a href="https://www.google.com/maps/search/?api=1&query=${item.lat},${item.lng}" target="_blank" class="btn-get-directions">
                            <i class="fa-solid fa-diamond-turn-right"></i> Navigate
                        </a>
                    </div>
                `;

                L.marker([item.lat, item.lng], { icon: customIcon }).bindPopup(popupHtml).addTo(mapInstance);
                bounds.push([item.lat, item.lng]);
            });

            if (bounds.length > 0) {
                mapInstance.fitBounds(bounds, { padding: [30, 30] });
            }
        });
    </script>
@endsection
