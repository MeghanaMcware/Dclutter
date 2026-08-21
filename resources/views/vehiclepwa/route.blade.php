@extends('vehiclepwa.layout.app')

@section('title') Dump @endsection
@section('heading') Dump @endsection

@section('style')
<style>
    :root {
        --primary-brand: #0e7a43;
        --primary-brand-dark: #095930;
        --primary-brand-light: #e8f5e9;
        --status-yellow: #ffc107;
        --bg-canvas: #f8fafc;
        --border-color: #e2e8f0;
    }

    body {
        background: var(--bg-canvas);
    }

    /*Search*/
    .search-box-wrap {
        position: relative;
        margin-bottom: 16px;
    }

    .search-box-wrap input {
        width: 100%;
        height: 44px;
        padding-left: 42px;
        padding-right: 14px;
        border-radius: 10px;
        font-size: 13.5px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
    }

<<<<<<< HEAD
    .search-box-wrap input:focus {
        border-color: var(--primary-brand);
        box-shadow: 0 0 0 3px rgba(14, 122, 67, 0.08);
    }

    .search-box-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }

    /* Request Card */
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

    /* Pickup ID Badge*/
    .badge-pickup-id {
        background-color: var(--primary-brand);
        color: #ffffff !important;
        font-size: 13.5px;
        font-weight: 800;
        padding: 5px 12px;
        border-radius: 8px;
        display: inline-block;
        letter-spacing: 0.3px;
    }

    /* Pickup Status Badge */
    .badge-pickup {
        background-color: #ffc107;
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

    /* Divider */
    .card-divider {
        border: 0;
        border-top: 1px solid #e5e7eb;
        margin: 14px 0;
    }

    /* Card Information*/
    .card-info-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #374151;
        margin-bottom: 6px;
    }

    .card-info-label {
        color: #4b5563;
        font-weight: 500;
    }

    .card-info-value {
        color: #111827;
        font-weight: 800;
    }

    /*  Dump Button */
    .btn-dump-card {
        background-color: var(--primary-brand);
        color: #ffffff !important;
        font-size: 13.5px;
        font-weight: 800;
        padding: 7px 20px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 6px rgba(14, 122, 67, 0.25);
        cursor: pointer;
        text-decoration: none;
        margin-top: 8px;
    }

    .btn-dump-card:hover {
        background-color: var(--primary-brand-dark);
        color: #ffffff !important;
    }

    /* No Results*/
    .no-results {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 35px 20px;
        text-align: center;
        display: none;
    }

    .no-results i {
        font-size: 32px;
        color: #94a3b8;
        margin-bottom: 10px;
    }

    .no-results h6 {
        font-weight: 800;
        color: #475569;
        margin-bottom: 5px;
    }

    .no-results p {
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 0;
    }
</style>
=======
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
            box-shadow: 0 0 0 3px rgba(37,99,235,0.4);
        }

        /* Leaflet popup customization */
        .leaflet-popup-content-wrapper { border-radius: 12px; padding: 4px; box-shadow: 0 4px 14px rgba(0,0,0,0.12); }
        .badge-cwd-id { background-color: #e2e8f0; color: #334155; font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px; display: inline-block; }
        .btn-get-directions { display: inline-flex; align-items: center; gap: 4px; background: #0f763b; color: #fff; text-decoration: none; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; margin-top: 6px; }
        .btn-get-directions:hover { color: #fff; background: #0b592c; }
    </style>
>>>>>>> babb5b76a934b6036e746621f3d8b97585e98391
@endsection


@section('content')

<<<<<<< HEAD
<div class="container py-2" style="max-width: 440px; margin: 0 auto;">

    {{-- SEARCH--}}
    <div class="search-box-wrap">
=======
        <!-- Trip Details Card -->
        <div class="trip-info-card">
            <div class="trip-header-row">
                <div>
                    <span style="font-size: 11px; color:#64748b; font-weight:600;">Trip ID</span>
                    <h3>TRP-{{ date('Y-m-d') }}-01</h3>
                    <p>{{ date('h:i A') }} Active Route</p>
                </div>
                <span class="badge-in-progress">In Progress</span>
            </div>

            <div class="stats-summary-row">
                <span>{{ $assignedRequests->count() }} Pickup Stops Assigned</span>
                <a href="{{ route('vehicle.stop_details') }}">View List</a>
            </div>
        </div>
>>>>>>> babb5b76a934b6036e746621f3d8b97585e98391

        <i class="fa-solid fa-magnifying-glass"></i>

<<<<<<< HEAD
        <input
            type="text"
            id="pickup-search"
            placeholder="Search by Pickup ID, Category or Sub Category..."
            autocomplete="off">
=======
        <!-- Start Navigation Button -->
        @if($assignedRequests->count() > 0)
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $assignedRequests->first()->latitude ?? 12.9716 }},{{ $assignedRequests->first()->longitude ?? 77.5946 }}" target="_blank" class="btn-end-trip">
                <i class="fa-solid fa-location-arrow"></i>
                <span>Start Turn-by-Turn Navigation</span>
            </a>
        @else
            <a href="{{ route('vehicle.requests') }}" class="btn-end-trip">
                <i class="fa-solid fa-list-check"></i>
                <span>View Assigned Requests</span>
            </a>
        @endif
>>>>>>> babb5b76a934b6036e746621f3d8b97585e98391

    </div>


    {{-- LIST OF PICKUP ITEMS --}}
    <div id="cards-container"></div>


    {{-- NO RESULTS--}}
    <div id="no-results-msg" class="no-results">

        <i class="fa-solid fa-box-open"></i>

        <h6>No Pickup Found</h6>

        <p>
            No pickup ID, category or sub category matches your search.
        </p>

    </div>

</div>

@endsection


@section('script')
<<<<<<< HEAD

<script>
    /*  STATIC PICKUP DATA */
=======
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const allRequestData = [
                @foreach($assignedRequests as $req)
                {
                    id: {{ $req->id }},
                    ref: '{{ $req->request_number }}',
                    applicant: '{{ addslashes($req->applicant_name) }}',
                    category: '{{ is_array($req->category_ids) ? implode(", ", $req->category_ids) : ($req->category_ids ?? "N/A") }}',
                    subCategory: '{{ is_array($req->subcategory_ids) ? implode(", ", $req->subcategory_ids) : ($req->subcategory_ids ?? "N/A") }}',
                    location: '{{ addslashes($req->address) }}',
                    lat: {{ $req->latitude ?? 12.9716 }},
                    lng: {{ $req->longitude ?? 77.5946 }}
                },
                @endforeach
            ];

            const centerLat = allRequestData.length ? allRequestData[0].lat : 12.9716;
            const centerLng = allRequestData.length ? allRequestData[0].lng : 77.5946;
>>>>>>> babb5b76a934b6036e746621f3d8b97585e98391

    const allPickupData = [

        {
            id: 4177,
            ref: 'DCL-2025-000123',
            status: 'PICKUP',
            category: 'Furniture',
            subCategory: 'Cots, Sofas',
            applicant: 'Ramesh Kumar',
            mobile: '9876543210',
            date: '09-Aug-2026',
            houseNo: '#123',
            ward: 'Ward 150',
            constituency: 'Bommanahalli',
            pincode: '560102',
            location: 'BTM Layout 2nd Stage, Bengaluru'
        },

        {
            id: 4178,
            ref: 'DCL-2025-000124',
            status: 'PICKUP',
            category: 'Electronics',
            subCategory: 'Laptops, Mobile Phones',
            applicant: 'AE Spot Officer - Ward 174',
            mobile: '9123456780',
            date: '16-Aug-2026',
            houseNo: 'Opp. Park',
            ward: 'Ward 174',
            constituency: 'HSR Layout',
            pincode: '560102',
            location: 'Silk Board Flyover Dump Site'
        },

        {
            id: 4179,
            ref: 'DCL-2025-000125',
            status: 'PICKUP',
            category: 'Mattresses & Cushions',
            subCategory: 'Double Mattress',
            applicant: 'Suresh Reddy (Commercial Complex)',
            mobile: '9988776655',
            date: '23-Aug-2026',
            houseNo: '#45, Ground Floor',
            ward: 'Ward 151',
            constituency: 'Koramangala',
            pincode: '560034',
            location: 'Koramangala 5th Block'
        }

<<<<<<< HEAD
    ];
=======
            allRequestData.forEach((item, index) => {
                const markerNumber = index + 1;
                const iconHtml = `<div class="route-marker-green">${markerNumber}</div>`;
>>>>>>> babb5b76a934b6036e746621f3d8b97585e98391


    /* RENDER PICKUP CARDS */

    function renderPickupCards(data = allPickupData) {

        const cardsContainer =
            document.getElementById('cards-container');

        const noResults =
            document.getElementById('no-results-msg');


        /* NO RESULTS */

        if (data.length === 0) {

            cardsContainer.innerHTML = '';

            noResults.style.display = 'block';

            return;
        }


        noResults.style.display = 'none';


        /* CREATE CARDS */

        cardsContainer.innerHTML = data.map((item) => {

            return `

                <div class="request-card">

                    {{-- CARD HEADER --}}
                    <div class="d-flex justify-content-between align-items-center">

                        <span class="badge-pickup-id">
                            ${item.ref}
                        </span>

                        <span class="badge-pickup">

                            <i class="fa-solid fa-truck-pickup"></i>

                            PICKUP

                        </span>

                    </div>


                    <hr class="card-divider">


                    {{-- CARD INFORMATION --}}
                    <div>

                        {{-- CATEGORY --}}
                        <div class="card-info-item">

                            <i class="fa-solid fa-recycle text-success"></i>

                            <span class="card-info-label">
                                Category:
                            </span>

                            <span class="card-info-value">
                                ${item.category}
                            </span>

                        </div>


                        {{-- SUB CATEGORY --}}
                        <div
                            class="card-info-item"
                            style="margin-top: 5px;"
                        >

                            <i class="fa-solid fa-list-ul text-info"></i>

                            <span class="card-info-label">
                                Sub Category:
                            </span>

                            <span class="card-info-value">
                                ${item.subCategory}
                            </span>

                        </div>

                    </div>


                    {{-- DUMP BUTTON --}}
                    <div class="text-end">

                        <a
    href="{{ url('/driver/vehicle/dumpform') }}?pickup_id=${encodeURIComponent(item.ref)}"
    class="btn-dump-card"
>
    <i class="fa-solid fa-trash-can"></i>
    Dump
</a>

                    </div>

                </div>

            `;

        }).join('');

    }


    /* SEARCH*/

    function filterPickupItems() {

        const searchInput =
            document.getElementById('pickup-search');

        const searchValue =
            searchInput.value
            .toLowerCase()
            .trim();


        const filteredData =
            allPickupData.filter(item => {

                const reference =
                    String(item.ref).toLowerCase();

                const id =
                    String(item.id).toLowerCase();

                const category =
                    String(item.category).toLowerCase();

                const subCategory =
                    String(item.subCategory).toLowerCase();


                return (

                    reference.includes(searchValue) ||

                    id.includes(searchValue) ||

                    category.includes(searchValue) ||

                    subCategory.includes(searchValue)

                );

            });


        renderPickupCards(filteredData);

    }


    /* PAGE LOAD */

    document.addEventListener(
        'DOMContentLoaded',
        function() {

            /* Show all pickup cards initially */

            renderPickupCards();


            /* Search */

            const searchInput =
                document.getElementById('pickup-search');

            searchInput.addEventListener(
                'input',
                filterPickupItems
            );

        }
    );
</script>

@endsection