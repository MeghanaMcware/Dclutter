@extends('admin.layout.app')

@section('title', 'Dump Locations')

@section('style')

<style>

    /* ==========================================
       TABLE
    =========================================== */

    .dump-table-name {
        font-weight: 600;
        color: #1e293b;
    }

    .dump-address {
        max-width: 350px;
        white-space: normal;
        line-height: 1.5;
        color: #475569;
    }


    /* ==========================================
       CONSTITUENCY BADGE
    =========================================== */

    .constituency-badge {
        background-color: #e8f1ff;
        color: #0d6efd;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        display: inline-block;
    }


    /* ==========================================
       STATUS TOGGLE
    =========================================== */

    .status-switch {
        position: relative;
        display: inline-block;
        width: 42px;
        height: 22px;
        vertical-align: middle;
    }

    .status-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .status-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #adb5bd;
        transition: 0.3s;
        border-radius: 30px;
    }

    .status-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 3px;
        top: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .status-switch input:checked + .status-slider {
        background-color: #198754;
    }

    .status-switch input:checked + .status-slider:before {
        transform: translateX(20px);
    }


    /* ==========================================
       STATUS TEXT
    =========================================== */

    .status-text {
        font-size: 12px;
        font-weight: 600;
        margin-left: 7px;
        vertical-align: middle;
    }

    .status-active {
        color: #198754;
    }

    .status-inactive {
        color: #dc3545;
    }


    /* ==========================================
       ACTION BUTTONS
    =========================================== */

    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

</style>

@endsection


@section('content')


{{-- ==========================================
     PAGE TITLE
=========================================== --}}

<div class="container-fluid">

    <div class="page-title">

        <div class="row">

            <div class="col-12 col-sm-6">

                <h3>
                    Dump Locations
                </h3>

            </div>


            <div class="col-12 col-sm-6">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="{{ route('admin.dashboard') }}">

                            <i class="bi bi-house"></i>

                        </a>

                    </li>

                    <li class="breadcrumb-item active">

                        Dump Locations

                    </li>

                </ol>

            </div>

        </div>

    </div>

</div>



{{-- ==========================================
     CONTENT
=========================================== --}}

<div class="content-body">

    <div class="container-fluid pt-3">

        <div class="row">

            <div class="col-sm-12">

                <div class="card">


                    {{-- ==========================================
                         CARD HEADER
                    =========================================== --}}

                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h4
                            class="mb-0"
                            style="color:#1e293b; font-weight:700;"
                        >
                            Dump Locations
                        </h4>


                        <a
                            href="{{ route('admin.masters.dump.create') }}"
                            class="btn btn-primary btn-sm"
                        >

                            <i class="fa fa-plus me-1"></i>

                            Add Dump Location

                        </a>

                    </div>



                    {{-- ==========================================
                         CARD BODY
                    =========================================== --}}

                    <div class="card-body">


                        <div class="table-responsive">

                            <table
                                class="display datatables"
                                id="dumpLocationsTable"
                            >

                                <thead>

                                    <tr>

                                        <th>
                                            Sl.no
                                        </th>

                                        <th>
                                            Constituency
                                        </th>

                                        <th>
                                            Dump Location Name
                                        </th>

                                        <th>
                                            Dump Place Address
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>


                                    {{-- ==========================================
                                         ROW 1
                                    =========================================== --}}

                                    <tr>

                                        <td>
                                            1
                                        </td>


                                        <td>

                                            <span class="constituency-badge">

                                                Bommanahalli

                                            </span>

                                        </td>


                                        <td>

                                            <strong class="dump-table-name">

                                                Bommanahalli Dump Site

                                            </strong>

                                        </td>


                                        <td>

                                            <div class="dump-address">

                                                Near Begur Road,
                                                Bommanahalli,
                                                Bengaluru,
                                                Karnataka - 560068

                                            </div>

                                        </td>


                                        {{-- STATUS --}}

                                        <td>

                                            <label class="status-switch">

                                                <input
                                                    type="checkbox"
                                                    checked
                                                    onchange="toggleStatus(this)"
                                                >

                                                <span class="status-slider"></span>

                                            </label>

                                            <span class="status-text status-active">
                                                Active
                                            </span>

                                        </td>


                                        {{-- ACTION --}}

                                        <td>

                                            <div class="d-flex gap-1">


                                                {{-- VIEW --}}

                                                <a
                                                    href="{{ route('admin.masters.dump.show') }}"
                                                    class="btn btn-info btn-sm text-white action-btn"
                                                    title="View"
                                                >

                                                    <i class="fa fa-eye"></i>

                                                </a>


                                                {{-- EDIT --}}

                                                <a
                                                    href="{{ route('admin.masters.dump.edit') }}"
                                                    class="btn btn-warning btn-sm text-white action-btn"
                                                    title="Edit"
                                                >

                                                    <i class="fa fa-pencil"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>



                                    {{-- ==========================================
                                         ROW 2
                                    =========================================== --}}

                                    <tr>

                                        <td>
                                            2
                                        </td>


                                        <td>

                                            <span class="constituency-badge">

                                                BTM Layout

                                            </span>

                                        </td>


                                        <td>

                                            <strong class="dump-table-name">

                                                BTM Dump Yard

                                            </strong>

                                        </td>


                                        <td>

                                            <div class="dump-address">

                                                2nd Stage,
                                                BTM Layout,
                                                Bengaluru,
                                                Karnataka - 560076

                                            </div>

                                        </td>


                                        <td>

                                            <label class="status-switch">

                                                <input
                                                    type="checkbox"
                                                    checked
                                                    onchange="toggleStatus(this)"
                                                >

                                                <span class="status-slider"></span>

                                            </label>

                                            <span class="status-text status-active">
                                                Active
                                            </span>

                                        </td>


                                        <td>

                                            <div class="d-flex gap-1">

                                                <a
                                                    href="{{ route('admin.masters.dump.show') }}"
                                                    class="btn btn-info btn-sm text-white action-btn"
                                                    title="View"
                                                >

                                                    <i class="fa fa-eye"></i>

                                                </a>


                                                <a
                                                    href="{{ route('admin.masters.dump.edit') }}"
                                                    class="btn btn-warning btn-sm text-white action-btn"
                                                    title="Edit"
                                                >

                                                    <i class="fa fa-pencil"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>



                                    {{-- ==========================================
                                         ROW 3
                                    =========================================== --}}

                                    <tr>

                                        <td>
                                            3
                                        </td>


                                        <td>

                                            <span class="constituency-badge">

                                                Koramangala

                                            </span>

                                        </td>


                                        <td>

                                            <strong class="dump-table-name">

                                                Koramangala Dump Site

                                            </strong>

                                        </td>


                                        <td>

                                            <div class="dump-address">

                                                5th Block,
                                                Koramangala,
                                                Bengaluru,
                                                Karnataka - 560034

                                            </div>

                                        </td>


                                        <td>

                                            <label class="status-switch">

                                                <input
                                                    type="checkbox"
                                                    checked
                                                    onchange="toggleStatus(this)"
                                                >

                                                <span class="status-slider"></span>

                                            </label>

                                            <span class="status-text status-active">
                                                Active
                                            </span>

                                        </td>


                                        <td>

                                            <div class="d-flex gap-1">

                                                <a
                                                    href="{{ route('admin.masters.dump.show') }}"
                                                    class="btn btn-info btn-sm text-white action-btn"
                                                    title="View"
                                                >

                                                    <i class="fa fa-eye"></i>

                                                </a>


                                                <a
                                                    href="{{ route('admin.masters.dump.edit') }}"
                                                    class="btn btn-warning btn-sm text-white action-btn"
                                                    title="Edit"
                                                >

                                                    <i class="fa fa-pencil"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>



                                    {{-- ==========================================
                                         ROW 4
                                    =========================================== --}}

                                    <tr>

                                        <td>
                                            4
                                        </td>


                                        <td>

                                            <span class="constituency-badge">

                                                Jayanagar

                                            </span>

                                        </td>


                                        <td>

                                            <strong class="dump-table-name">

                                                Jayanagar Waste Dump Point

                                            </strong>

                                        </td>


                                        <td>

                                            <div class="dump-address">

                                                4th Block,
                                                Jayanagar,
                                                Bengaluru,
                                                Karnataka - 560041

                                            </div>

                                        </td>


                                        <td>

                                            <label class="status-switch">

                                                <input
                                                    type="checkbox"
                                                    checked
                                                    onchange="toggleStatus(this)"
                                                >

                                                <span class="status-slider"></span>

                                            </label>

                                            <span class="status-text status-active">
                                                Active
                                            </span>

                                        </td>


                                        <td>

                                            <div class="d-flex gap-1">

                                                <a
                                                    href="{{ route('admin.masters.dump.show') }}"
                                                    class="btn btn-info btn-sm text-white action-btn"
                                                    title="View"
                                                >

                                                    <i class="fa fa-eye"></i>

                                                </a>


                                                <a
                                                    href="{{ route('admin.masters.dump.edit') }}"
                                                    class="btn btn-warning btn-sm text-white action-btn"
                                                    title="Edit"
                                                >

                                                    <i class="fa fa-pencil"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>



                                    {{-- ==========================================
                                         ROW 5
                                    =========================================== --}}

                                    <tr>

                                        <td>
                                            5
                                        </td>


                                        <td>

                                            <span class="constituency-badge">

                                                Vijayanagar

                                            </span>

                                        </td>


                                        <td>

                                            <strong class="dump-table-name">

                                                Vijayanagar Dump Location

                                            </strong>

                                        </td>


                                        <td>

                                            <div class="dump-address">

                                                Vijayanagar,
                                                Bengaluru,
                                                Karnataka - 560040

                                            </div>

                                        </td>


                                        <td>

                                            <label class="status-switch">

                                                <input
                                                    type="checkbox"
                                                    checked
                                                    onchange="toggleStatus(this)"
                                                >

                                                <span class="status-slider"></span>

                                            </label>

                                            <span class="status-text status-active">
                                                Active
                                            </span>

                                        </td>


                                        <td>

                                            <div class="d-flex gap-1">

                                                <a
                                                    href="{{ route('admin.masters.dump.show') }}"
                                                    class="btn btn-info btn-sm text-white action-btn"
                                                    title="View"
                                                >

                                                    <i class="fa fa-eye"></i>

                                                </a>


                                                <a
                                                    href="{{ route('admin.masters.dump.edit') }}"
                                                    class="btn btn-warning btn-sm text-white action-btn"
                                                    title="Edit"
                                                >

                                                    <i class="fa fa-pencil"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>


                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


@endsection



@section('script')

<script>

$(document).ready(function () {


    /* ==========================================
       DATATABLE
    =========================================== */

    if ($('#dumpLocationsTable').length) {

        $('#dumpLocationsTable').DataTable({

            pageLength: 10,

            ordering: true,

            searching: true,

            lengthChange: true,

            responsive: true

        });

    }

});



/* ==========================================
   STATUS TOGGLE
=========================================== */

function toggleStatus(toggle) {

    const statusText =
        toggle
            .closest('td')
            .querySelector('.status-text');


    if (toggle.checked) {

        statusText.textContent = 'Active';

        statusText.classList.remove(
            'status-inactive'
        );

        statusText.classList.add(
            'status-active'
        );

    } else {

        statusText.textContent = 'Inactive';

        statusText.classList.remove(
            'status-active'
        );

        statusText.classList.add(
            'status-inactive'
        );

    }

}

</script>

@endsection