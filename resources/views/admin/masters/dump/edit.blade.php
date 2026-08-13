@extends('admin.layout.app')

@section('title', 'Edit Dump Location')

@section('style')
<style>
    .dump-form-card {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }

    .dump-form-label {
        font-weight: 600;
        font-size: 14px;
        color: #374151;
        margin-bottom: 7px;
    }

    .dump-form-control {
        width: 100%;
        min-height: 42px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 14px;
        outline: none;
        background: #fff;
    }

    .dump-form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.08);
    }

    textarea.dump-form-control {
        min-height: 110px;
        resize: vertical;
    }

    .btn-update-dump {
        min-width: 130px;
        font-weight: 600;
    }
</style>
@endsection


@section('content')

{{-- ================================
     PAGE TITLE
================================= --}}

<div class="container-fluid">

    <div class="page-title">

        <div class="row">

            <div class="col-12 col-sm-6">

                <h3>
                    Edit Dump Location
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

                        Dump Locations

                    </li>


                    <li class="breadcrumb-item active">

                        Edit Dump Location

                    </li>

                </ol>

            </div>

        </div>

    </div>

</div>


{{-- ================================
     CONTENT
================================= --}}

<div class="content-body">

    <div class="container-fluid pt-3">

        <div class="row">

            <div class="col-sm-12 col-xl-10 offset-xl-1">


                {{-- Header --}}

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h4
                        class="mb-0"
                        style="color:#1e293b; font-weight:700;"
                    >
                        Edit Dump Location Details
                    </h4>


                    <a
                        href="{{ url('/admin/masters/dump') }}"
                        class="btn btn-light btn-sm"
                    >

                        <i class="fa fa-arrow-left me-1"></i>

                        Back

                    </a>

                </div>


                {{-- Card --}}

                <div class="card dump-form-card">

                    <div class="card-body">


                        {{-- ==========================================
                             FRONTEND ONLY FORM
                        =========================================== --}}

                        <form
                            id="dumpEditForm"
                            class="needs-validation"
                            novalidate
                        >


                            {{-- ==========================================
                                 CONSTITUENCY
                            =========================================== --}}

                            <div class="mb-3">

                                <label
                                    for="constituency"
                                    class="dump-form-label"
                                >

                                    Constituency

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <select
                                    id="constituency"
                                    name="constituency"
                                    class="dump-form-control"
                                    required
                                >

                                    <option
                                        value=""
                                        disabled
                                    >
                                        Select Constituency
                                    </option>


                                    <option
                                        value="Bommanahalli"
                                    >
                                        Bommanahalli
                                    </option>


                                    <option
                                        value="BTM Layout"
                                    >
                                        BTM Layout
                                    </option>


                                    <option
                                        value="Jayanagar"
                                    >
                                        Jayanagar
                                    </option>


                                    <option
                                        value="Koramangala"
                                        selected
                                    >
                                        Koramangala
                                    </option>


                                    <option
                                        value="Shanthinagar"
                                    >
                                        Shanthinagar
                                    </option>


                                    <option
                                        value="Vijayanagar"
                                    >
                                        Vijayanagar
                                    </option>


                                    <option
                                        value="Yeshwanthpur"
                                    >
                                        Yeshwanthpur
                                    </option>

                                </select>


                                <div class="invalid-feedback">

                                    Please select a constituency.

                                </div>

                            </div>


                            {{-- ==========================================
                                 DUMP LOCATION NAME
                            =========================================== --}}

                            <div class="mb-3">

                                <label
                                    for="dump_location_name"
                                    class="dump-form-label"
                                >

                                    Dump Location Name

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <input
                                    type="text"
                                    id="dump_location_name"
                                    name="dump_location_name"
                                    class="dump-form-control"
                                    value="Koramangala Dump Site"
                                    placeholder="Enter dump location name"
                                    required
                                >


                                <div class="invalid-feedback">

                                    Please enter the dump location name.

                                </div>

                            </div>


                            {{-- ==========================================
                                 DUMP PLACE ADDRESS
                            =========================================== --}}

                            <div class="mb-4">

                                <label
                                    for="dump_address"
                                    class="dump-form-label"
                                >

                                    Dump Place Address

                                    <span class="text-danger">
                                        *
                                    </span>

                                </label>


                                <textarea
                                    id="dump_address"
                                    name="dump_address"
                                    class="dump-form-control"
                                    placeholder="Enter dump place address"
                                    required
                                >5th Block, Koramangala, Bengaluru, Karnataka - 560034</textarea>


                                <div class="invalid-feedback">

                                    Please enter the dump place address.

                                </div>

                            </div>


                            {{-- ==========================================
                                 BUTTONS
                            =========================================== --}}

                            <div class="text-center mt-4">

                                <a
                                    href="{{ url('/admin/masters/dump') }}"
                                    class="btn btn-secondary me-2"
                                >

                                    Cancel

                                </a>


                                <button
                                    type="submit"
                                    class="btn btn-primary btn-update-dump px-4"
                                >

                                    <i class="fa fa-save me-1"></i>

                                    Update Dump

                                </button>

                            </div>


                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@section('script')

{{-- SweetAlert2 --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {


        const form =
            document.getElementById(
                'dumpEditForm'
            );


        form.addEventListener(
            'submit',
            function (event) {


                event.preventDefault();

                event.stopPropagation();


                /* ==========================================
                   VALIDATION
                =========================================== */

                if (!form.checkValidity()) {

                    form.classList.add(
                        'was-validated'
                    );

                    return;

                }


                /* ==========================================
                   GET UPDATED VALUES
                =========================================== */

                const constituency =
                    document.getElementById(
                        'constituency'
                    ).value;


                const locationName =
                    document.getElementById(
                        'dump_location_name'
                    ).value;


                const address =
                    document.getElementById(
                        'dump_address'
                    ).value;


                /* ==========================================
                   SWEETALERT
                =========================================== */

                Swal.fire({

                    icon: 'success',

                    title:
                        'Dump Location Updated Successfully!',

                    html:

                        '<div style="text-align:left;">' +

                        '<strong>Constituency:</strong> ' +

                        constituency +

                        '<br><br>' +

                        '<strong>Dump Location:</strong> ' +

                        locationName +

                        '<br><br>' +

                        '<strong>Address:</strong> ' +

                        address +

                        '</div>',

                    confirmButtonText:
                        'OK',

                    confirmButtonColor:
                        '#0d6efd',

                    allowOutsideClick:
                        false

                }).then(
                    function () {

                        /*
                         * Frontend only.
                         *
                         * Return to dump list.
                         */

                        window.location.href =
                            "{{ url('/admin/masters/dump') }}";

                    }
                );

            }
        );

    }
);

</script>

@endsection