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
@endsection


@section('content')

<div class="container py-2" style="max-width: 440px; margin: 0 auto;">

    {{-- SEARCH--}}
    <div class="search-box-wrap">

        <i class="fa-solid fa-magnifying-glass"></i>

        <input
            type="text"
            id="pickup-search"
            placeholder="Search by Pickup ID, Category or Sub Category..."
            autocomplete="off">

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

<script>
    /*  STATIC PICKUP DATA */

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

    ];


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