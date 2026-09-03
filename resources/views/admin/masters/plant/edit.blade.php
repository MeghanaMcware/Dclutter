@extends('admin.layout.app')

@section('title', 'Edit Plant Location')

@section('style')
<style>
    .dump-form-card { border-radius: 12px; border: 1px solid #e5e7eb; }
    .dump-form-label { font-weight: 600; font-size: 14px; color: #374151; margin-bottom: 7px; }
    .dump-form-control { width: 100%; min-height: 42px; border: 1px solid #ced4da; border-radius: 6px; padding: 8px 12px; font-size: 14px; outline: none; }
    .dump-form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.08); }
    textarea.dump-form-control { min-height: 110px; resize: vertical; }
    .btn-submit-dump { min-width: 120px; font-weight: 600; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>Edit Plant Location</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.masters.plants.index') }}">Plant Locations</a></li>
                    <li class="breadcrumb-item active">Edit Plant Location</li>
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
                            <h5 class="mb-1">Edit Plant Location Details</h5>
                            <p class="text-muted mb-0">Update information for {{ $plant->name }}.</p>
                        </div>

                        <form id="plantEditForm" action="{{ route('admin.masters.plants.update', $plant->id) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Dynamic Corporation -->
                            <div class="mb-3">
                                <label for="corporation_id" class="dump-form-label">Corporation <span class="text-danger">*</span></label>
                                <select id="corporation_id" name="corporation_id" class="dump-form-control" required>
                                    <option value="" disabled>Select Corporation</option>
                                    @foreach($corporations as $corp)
                                        <option value="{{ $corp->id }}" {{ $plant->corporation_id == $corp->id ? 'selected' : '' }}>{{ $corp->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a corporation.</div>
                            </div>

                            <!-- Dynamic Constituency -->
                            <div class="mb-3">
                                <label for="constituency_id" class="dump-form-label">Constituency <span class="text-danger">*</span></label>
                                <select id="constituency_id" name="constituency_id" class="dump-form-control" required>
                                    <option value="" disabled>Select Constituency</option>
                                    @foreach($constituencies as $const)
                                        <option value="{{ $const->id }}" {{ $plant->constituency_id == $const->id ? 'selected' : '' }}>{{ $const->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a constituency.</div>
                            </div>

                            <!-- Plant Name -->
                            <div class="mb-3">
                                <label for="name" class="dump-form-label">Plant Location Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="dump-form-control" value="{{ old('name', $plant->name) }}" required>
                                <div class="invalid-feedback">Please enter the plant location name.</div>
                            </div>

                            <!-- Plant Address -->
                            <div class="mb-4">
                                <label for="address" class="dump-form-label">Plant Place Address <span class="text-danger">*</span></label>
                                <textarea id="address" name="address" class="dump-form-control" required>{{ old('address', $plant->address) }}</textarea>
                                <div class="invalid-feedback">Please enter the plant place address.</div>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('admin.masters.plants.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-submit-dump">
                                    <i class="fa fa-save me-1"></i> Update Location
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('plantEditForm');
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
        }
    });
});
</script>
@endsection