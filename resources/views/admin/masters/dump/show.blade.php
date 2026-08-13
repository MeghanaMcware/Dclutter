@extends('admin.layout.app')

@section('title', 'View Dump Location')


@section('content')

<div class="container-fluid">

    {{-- ==========================================
         PAGE TITLE
    =========================================== --}}

    <div class="page-title">

        <div class="row">

            <div class="col-12 col-sm-6">

                <h3>
                    View Dump Location Details
                </h3>

            </div>


            <div class="col-12 col-sm-6">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="{{ route('admin.dashboard') }}">

                            <i class="bi bi-house"></i>

                        </a>

                    </li>


                    <li class="breadcrumb-item">

                        <a href="{{ route('admin.masters.dump.index') }}">

                            Dump Locations

                        </a>

                    </li>


                    <li class="breadcrumb-item active">

                        View Dump Location

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

            <div class="col-sm-12 col-xl-8 offset-xl-2">


                {{-- ==========================================
                     HEADER
                =========================================== --}}

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h4
                        class="mb-0 font-weight-bold"
                        style="color:#1e293b; font-weight:700;"
                    >

                        Dump Location Details

                    </h4>


                    <a
                        href="{{ route('admin.masters.dump.index') }}"
                        class="btn btn-light btn-sm"
                    >

                        <i class="fa fa-arrow-left me-1"></i>

                        Back

                    </a>

                </div>



                {{-- ==========================================
                     DETAILS CARD
                =========================================== --}}

                <div class="card">

                    <div class="card-body">


                        <table class="table table-bordered table-striped">

                            <tbody>


                                {{-- ==========================================
                                     CONSTITUENCY
                                =========================================== --}}

                                <tr>

                                    <th width="35%">

                                        Constituency

                                    </th>

                                    <td>

                                        <span
                                            class="badge bg-primary"
                                            style="font-size:13px;"
                                        >

                                            Bommanahalli

                                        </span>

                                    </td>

                                </tr>



                                {{-- ==========================================
                                     DUMP LOCATION NAME
                                =========================================== --}}

                                <tr>

                                    <th>

                                        Dump Location Name

                                    </th>

                                    <td>

                                        <strong>

                                            Bommanahalli Dump Site

                                        </strong>

                                    </td>

                                </tr>



                                {{-- ==========================================
                                     DUMP PLACE ADDRESS
                                =========================================== --}}

                                <tr>

                                    <th>

                                        Dump Place Address

                                    </th>

                                    <td>

                                        Near Begur Road,
                                        Bommanahalli,
                                        Bengaluru,
                                        Karnataka - 560068

                                    </td>

                                </tr>



                                {{-- ==========================================
                                     STATUS
                                =========================================== --}}

                                <tr>

                                    <th>

                                        Status

                                    </th>

                                    <td>

                                        <span
                                            class="badge bg-success"
                                            style="font-size:12px;"
                                        >

                                            <i class="fa fa-check-circle me-1"></i>

                                            Active

                                        </span>

                                    </td>

                                </tr>


                            </tbody>

                        </table>



                        {{-- ==========================================
                             ACTION BUTTONS
                        =========================================== --}}

                        <div class="mt-4 text-center">


                            {{-- EDIT --}}

                            <a
                                href="{{ route('admin.masters.dump.edit') }}"
                                class="btn btn-warning btn-sm text-white me-2"
                            >

                                <i class="fa fa-pencil me-1"></i>

                                Edit Dump Location

                            </a>



                            {{-- CLOSE --}}

                            <a
                                href="{{ route('admin.masters.dump.index') }}"
                                class="btn btn-secondary btn-sm"
                            >

                                Close

                            </a>


                        </div>


                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection