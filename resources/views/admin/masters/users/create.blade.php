@extends('admin.layout.app')

@section('title', 'Add User')

@section('style')
<style>
    /* Select2 Alignment & Validation Fixes */
    .select2-container {
        width: 100% !important;
    }
    .select2-container .select2-selection--multiple {
        min-height: 38px !important;
        border: 1px solid #dee2e6 !important;
        border-radius: 0.375rem !important;
        padding: 2px 6px !important;
    }
    .select2-container .select2-search--inline .select2-search__field {
        margin-top: 0 !important;
        height: 24px !important;
    }
    
    /* Validation styles */
    .was-validated .form-select:invalid + .select2-container .select2-selection {
        border-color: #dc3545 !important;
        padding-right: 2.25rem !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(.375em + .1875rem) center;
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }
    .was-validated .form-select:valid + .select2-container .select2-selection {
        border-color: #198754 !important;
        padding-right: 2.25rem !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(.375em + .1875rem) center;
        background-size: calc(.75em + .375rem) calc(.75em + .375rem);
    }
    .was-validated .form-select:invalid ~ .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>Add User</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.masters.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Add User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="userForm" action="{{ route('admin.masters.users.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name" required>
                                    <div class="invalid-feedback">Please enter the name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="phone">Phone Number <span class="text-danger">*</span></label>
<<<<<<< HEAD
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number" pattern="[0-9]{10}" maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
=======
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter 10-digit Phone Number" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" required>
>>>>>>> 3e1e6a40921ecc474287b43b7318a85b0f881cbd
                                    <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Email" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter Password" required>
                                    <div class="invalid-feedback">Please enter a password.</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-bold" for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select Role</option>
                                        <option value="agm" {{ old('role') == 'agm' ? 'selected' : '' }}>AGM (Additional General Manager)</option>
                                        <option value="dgm" {{ old('role') == 'dgm' ? 'selected' : '' }}>DGM (Deputy General Manager)</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a user role.</div>
                                </div>
                            </div>
                            
                            <!-- Dynamic Jurisdiction Scoping Row -->
                            <div class="row mb-3">
<<<<<<< HEAD
                              <div class="col-md-6">
                                    <label class="form-label fw-bold" for="constituency">Corporation </label>
                                    <select class="form-select select2-search" id="constituency" name="constituency[]" multiple="multiple" >
                                        <!-- Populate options from database in controller -->
                                        <option value="1">West</option>
                                        <option value="2">North</option>
                                    </select>
                                   
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="constituency">Constituency </label>
                                    <select class="form-select select2-search" id="constituency" name="constituency[]" multiple="multiple" >
                                        <!-- Populate options from database in controller -->
                                        <option value="1">Constituency 1</option>
                                        <option value="2">Constituency 2</option>
                                    </select>
                                   
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="" disabled selected>Select Role</option>
                                        <option value="DGM">DGM</option>
                                        <option value="AGM">AGM</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a role.</div>
=======
                                <div class="col-md-6" id="corporationCol" style="display: none;">
                                    <label class="form-label fw-bold" for="corporation">Corporation (DGM Jurisdiction) <span class="text-danger">*</span></label>
                                    <select class="form-select select2" id="corporation" name="corporation[]" multiple="multiple">
                                        @foreach($corporations as $corp)
                                            <option value="{{ $corp->id }}" {{ is_array(old('corporation')) && in_array($corp->id, old('corporation')) ? 'selected' : '' }}>
                                                {{ $corp->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select at least one corporation for DGM.</div>
                                </div>
                                <div class="col-md-6" id="constituencyCol" style="display: none;">
                                    <label class="form-label fw-bold" for="constituency">Constituency (AGM Jurisdiction) <span class="text-danger">*</span></label>
                                    <select class="form-select select2-search" id="constituency" name="constituency[]" multiple="multiple">
                                        @foreach($constituencies as $const)
                                            <option value="{{ $const->id }}" {{ is_array(old('constituency')) && in_array($const->id, old('constituency')) ? 'selected' : '' }}>
                                                {{ $const->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select at least one constituency for AGM.</div>
>>>>>>> 3e1e6a40921ecc474287b43b7318a85b0f881cbd
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('admin.masters.users.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4"><i class="fa fa-save me-1"></i> Submit</button>
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
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Corporation",
            closeOnSelect: true
        });
        $('.select2-search').select2({
            placeholder: "Search Constituency",
            allowClear: true,
            closeOnSelect: true
        });

        // Prevent opening if all options are already selected
        $('.select2, .select2-search').on('select2:opening', function (e) {
            var $select = $(this);
            // check if it is a multiple select
            if ($select.prop('multiple')) {
                var availableOptions = $select.find('option').not(':selected').not('[value=""]').length;
                if (availableOptions === 0) {
                    e.preventDefault();
                }
            }
        });

        function updateJurisdictionFields() {
            const selectedRole = $('#role').val();
            const corpCol = $('#corporationCol');
            const constCol = $('#constituencyCol');
            const corpSelect = $('#corporation');
            const constSelect = $('#constituency');

            if (selectedRole === 'dgm') {
                corpCol.show();
                corpSelect.prop('required', true);
                constCol.hide();
                constSelect.prop('required', false);
            } else if (selectedRole === 'agm') {
                constCol.show();
                constSelect.prop('required', true);
                corpCol.hide();
                corpSelect.prop('required', false);
            } else {
                corpCol.hide();
                corpSelect.prop('required', false);
                constCol.hide();
                constSelect.prop('required', false);
            }
        }

        $('#role').on('change', updateJurisdictionFields);
        updateJurisdictionFields(); // Initial call
    });

    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection
