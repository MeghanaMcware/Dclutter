@extends('admin.layout.app')

@section('title', 'Add User')

@section('style')
<style>
    /* Select2 Alignment & Validation Fixes */
    .select2-container {
        width: 100% !important;
        display: block;
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
                        <a href="{{ url('admin/dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('masters.users.index') ?? '#' }}">Users</a></li>
                    <li class="breadcrumb-item active">Add User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
           

                <div class="card">
                    <div class="card-body">
                        <form id="userForm" action="#" method="POST" class="needs-validation" novalidate>
                           

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter Name" required>
                                    <div class="invalid-feedback">Please enter the name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="phone">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number" required>
                                    <div class="invalid-feedback">Please enter the phone number.</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter Email" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="password">Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                                    <div class="invalid-feedback">Please enter a password.</div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="corporation">Corporation <span class="text-danger">*</span></label>
                                    <select class="form-select select2" id="corporation" name="corporation[]" multiple="multiple" required>
                                        <!-- Populate options from database in controller -->
                                        <option value="1">Corporation 1</option>
                                        <option value="2">Corporation 2</option>
                                    </select>
                                    <div class="invalid-feedback">Please select at least one corporation.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold" for="constituency">Constituency <span class="text-danger">*</span></label>
                                    <select class="form-select select2-search" id="constituency" name="constituency[]" multiple="multiple" required>
                                        <!-- Populate options from database in controller -->
                                        <option value="1">Constituency 1</option>
                                        <option value="2">Constituency 2</option>
                                    </select>
                                    <div class="invalid-feedback">Please select at least one constituency.</div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
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
            placeholder: "Select Corporation"
        });
        $('.select2-search').select2({
            placeholder: "Search Constituency",
            allowClear: true
        });
    });

    // Bootstrap validation inline code
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        event.preventDefault();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'User created successfully!',
                            confirmButtonColor: '#198754'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('masters.users.index') }}";
                            }
                        });
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection
