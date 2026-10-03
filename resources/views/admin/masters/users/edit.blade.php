@extends('admin.layout.app')

@section('title', 'Edit User')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.select2-container {
    width: 100% !important;
}

.select2-container .select2-selection--multiple {
    min-height: 38px !important;
    border: 1px solid #ced4da !important;
    border-radius: 0.375rem !important;
    padding: 2px 6px !important;
}

.select2-container .select2-search--inline .select2-search__field {
    margin-top: 0 !important;
    height: 26px !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: 4px;
    padding: 2px 8px;
    font-size: 13px;
    color: #2c3e50;
}

.form-label {
    color: #2c3e50 !important;
    font-weight: 600;
    margin-bottom: 4px;
}

.is-invalid + .select2-container .select2-selection {
    border-color: #dc3545 !important;
}
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>Edit User</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.masters.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Edit User</li>
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

                        @php
                            $userRole = old('role', $user->roles->first()?->name ?? '');
                            $userCorpIds = array_map('intval', (array) old('corporation', $user->corporation_ids ?? []));
                            $userConstIds = array_map('intval', (array) old('constituency', $user->constituency_ids ?? []));
                        @endphp

                        <form id="userForm" action="{{ route('admin.masters.users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Enter Full Name" required>
                                    <div class="invalid-feedback">Please enter the user's name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="phone">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $user->mobile_number) }}"
                                        placeholder="Enter 10-digit Mobile Number" pattern="[0-9]{10}" maxlength="10"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" required>
                                    <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="email">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter Email Address" required>
                                    <div class="invalid-feedback">Please enter a valid email address.</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Leave blank to keep unchanged" minlength="6">
                                    <div class="form-text text-muted" style="font-size: 12px;">Leave blank to retain current password.</div>
                                </div>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label" for="role">User Role <span class="text-danger">*</span></label>
                                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                        <option value="" disabled {{ $userRole ? '' : 'selected' }}>Select Role</option>
                                        <option value="agm" {{ $userRole == 'agm' ? 'selected' : '' }}>AGM (Additional General Manager - Constituency Scope)</option>
                                        <option value="dgm" {{ $userRole == 'dgm' ? 'selected' : '' }}>DGM (Deputy General Manager - Corporation Scope)</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a role for this user.</div>
                                </div>

                                <div class="col-md-6" id="corporationCol" style="display: none;">
                                    <label class="form-label" for="corporation">Assigned Corporations <span class="text-danger">*</span></label>
                                    <select class="form-select select2-corp" id="corporation" name="corporation[]" multiple="multiple">
                                        @foreach($corporations as $corp)
                                        <option value="{{ $corp->id }}" {{ in_array((int)$corp->id, $userCorpIds) ? 'selected' : '' }}>
                                            {{ $corp->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="corpFeedback">Please select at least one corporation for DGM.</div>
                                </div>

                                <div class="col-md-6" id="constituencyCol" style="display: none;">
                                    <label class="form-label" for="constituency">Assigned Constituencies <span class="text-danger">*</span></label>
                                    <select class="form-select select2-const" id="constituency" name="constituency[]" multiple="multiple">
                                        @foreach($constituencies as $const)
                                        <option value="{{ $const->id }}" {{ in_array((int)$const->id, $userConstIds) ? 'selected' : '' }}>
                                            {{ $const->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="constFeedback">Please select at least one constituency for AGM.</div>
                                </div>
                            </div>

                            <div class="text-center mt-4 pt-2">
                                <a href="{{ route('admin.masters.users.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fa fa-save me-1"></i> Update User
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-corp').select2({
        placeholder: "Select Corporation(s)",
        width: '100%',
        closeOnSelect: false
    });

    $('.select2-const').select2({
        placeholder: "Select Constituency / Constituencies",
        width: '100%',
        closeOnSelect: false
    });

    function updateJurisdictionFields(resetValues = false) {
        const selectedRole = $('#role').val();
        const corpCol = $('#corporationCol');
        const constCol = $('#constituencyCol');
        const corpSelect = $('#corporation');
        const constSelect = $('#constituency');

        if (selectedRole === 'dgm') {
            corpCol.show();
            constCol.hide();
            if (resetValues) {
                constSelect.val(null).trigger('change');
            }
        } else if (selectedRole === 'agm') {
            constCol.show();
            corpCol.hide();
            if (resetValues) {
                corpSelect.val(null).trigger('change');
            }
        } else {
            corpCol.hide();
            constCol.hide();
        }
    }

    $('#role').on('change', function() {
        updateJurisdictionFields(true);
    });
    updateJurisdictionFields(false); // Initial load without clearing current values

    // Form submission validation
    $('#userForm').on('submit', function(e) {
        const form = this;
        const role = $('#role').val();
        let valid = form.checkValidity();

        if (role === 'dgm') {
            const corps = $('#corporation').val();
            if (!corps || corps.length === 0) {
                $('#corporation').addClass('is-invalid');
                $('#corpFeedback').show();
                valid = false;
            } else {
                $('#corporation').removeClass('is-invalid');
                $('#corpFeedback').hide();
            }
        } else if (role === 'agm') {
            const consts = $('#constituency').val();
            if (!consts || consts.length === 0) {
                $('#constituency').addClass('is-invalid');
                $('#constFeedback').show();
                valid = false;
            } else {
                $('#constituency').removeClass('is-invalid');
                $('#constFeedback').hide();
            }
        }

        if (!valid) {
            e.preventDefault();
            e.stopPropagation();
        }

        $(form).addClass('was-validated');
    });

    $('#corporation, #constituency').on('change', function() {
        const val = $(this).val();
        if (val && val.length > 0) {
            $(this).removeClass('is-invalid');
            $(this).closest('.col-md-6').find('.invalid-feedback').hide();
        }
    });
});
</script>
@endsection
