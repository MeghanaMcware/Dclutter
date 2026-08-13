@extends('admin.layout.app')

@section('title', 'Create Dump Location')

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
    }

    .dump-form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.08);
    }

    textarea.dump-form-control {
        min-height: 110px;
        resize: vertical;
    }

    .btn-submit-dump {
        min-width: 120px;
        font-weight: 600;
    }
</style>
@endsection


@section('content')

<div class="container-fluid">

    {{-- Page Title --}}
    <div class="page-title">
        <div class="row">

            <div class="col-12 col-sm-6">
                <h3>Create Dump Location</h3>
            </div>

            <div class="col-12 col-sm-6">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Create Dump Location
                    </li>

                </ol>

            </div>

        </div>
    </div>

</div>


<div class="content-body">

    <div class="container-fluid pt-3">

        <div class="row">

            <div class="col-sm-12">

                <div class="card dump-form-card">

                    <div class="card-body">

                        <div class="mb-4">

                            <h5 class="mb-1">
                                Add Dump Location
                            </h5>

                            <p class="text-muted mb-0">
                                Enter the details of the dump location.
                            </p>

                        </div>


                        {{-- FRONTEND ONLY FORM --}}

                        <form
                            id="dumpForm"
                            class="needs-validation"
                            novalidate
                        >

                            @csrf


                            {{-- ==========================================
                                 CONSTITUENCY
                            =========================================== --}}

                            <div class="mb-3">

                                <label
                                    for="constituency"
                                    class="dump-form-label"
                                >
                                    Constituency
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    id="constituency"
                                    name="constituency"
                                    class="dump-form-control"
                                    required
                                >

                                    <option
                                        value=""
                                        selected
                                        disabled
                                    >
                                        Select Constituency
                                    </option>

                                    {{-- Replace these static values
                                         with actual constituencies later --}}

                                    <option value="Bommanahalli">
                                        Bommanahalli
                                    </option>

                                    <option value="BTM Layout">
                                        BTM Layout
                                    </option>

                                    <option value="Jayanagar">
                                        Jayanagar
                                    </option>

                                    <option value="Koramangala">
                                        Koramangala
                                    </option>

                                    <option value="Shanthinagar">
                                        Shanthinagar
                                    </option>

                                    <option value="Vijayanagar">
                                        Vijayanagar
                                    </option>

                                    <option value="Yeshwanthpur">
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
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="dump_location_name"
                                    name="dump_location_name"
                                    class="dump-form-control"
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
                                    <span class="text-danger">*</span>
                                </label>

                                <textarea
                                    id="dump_address"
                                    name="dump_address"
                                    class="dump-form-control"
                                    placeholder="Enter dump place address"
                                    required
                                ></textarea>

                                <div class="invalid-feedback">
                                    Please enter the dump place address.
                                </div>

                            </div>


                            {{-- ==========================================
                                 BUTTONS
                            =========================================== --}}

                            <div class="text-center">

                                <button
                                    type="button"
                                    class="btn btn-secondary me-2"
                                    onclick="history.back()"
                                >
                                    Cancel
                                </button>

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-submit-dump"
                                >
                                    <i class="fa fa-save me-1"></i>
                                    Submit
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

document.addEventListener('DOMContentLoaded', function () {

    const form =
        document.getElementById('dumpForm');


    form.addEventListener('submit', function (event) {

        event.preventDefault();
        event.stopPropagation();


        /* ==========================================
           FRONTEND VALIDATION
        =========================================== */

        if (!form.checkValidity()) {

            form.classList.add('was-validated');

            return;

        }


        /* ==========================================
           GET FORM VALUES
        =========================================== */

        const constituency =
            document.getElementById('constituency').value;

        const locationName =
            document.getElementById('dump_location_name').value;

        const address =
            document.getElementById('dump_address').value;


        /* ==========================================
           SWEETALERT SUCCESS
        =========================================== */

        Swal.fire({

            icon: 'success',

            title: 'Dump Location Created Successfully!',

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

            confirmButtonText: 'OK',

            confirmButtonColor: '#0d6efd',

            allowOutsideClick: false

        }).then(function () {

            /*
             * For now this is frontend-only.
             *
             * After clicking OK, clear the form.
             */

            form.reset();

            form.classList.remove('was-validated');

        });

    });

});

</script>

@endsection