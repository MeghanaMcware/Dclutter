@extends('admin.layout.app')

@section('title', 'Create Plant Location')

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
                <h3>Create Plant Location</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.masters.plants.index') }}">Plant Locations</a></li>
                    <li class="breadcrumb-item active">Create Plant Location</li>
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
                            <h5 class="mb-1">Add Plant Location</h5>
                            <p class="text-muted mb-0">Enter the details of the waste processing plant location.</p>
                        </div>

                        <form id="plantForm" action="{{ route('admin.masters.plants.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <!-- Dynamic Corporation -->
                            <div class="mb-3">
                                <label for="corporation_id" class="dump-form-label">Corporation <span class="text-danger">*</span></label>
                                <select id="corporation_id" name="corporation_id" class="dump-form-control" required>
                                    <option value="" selected disabled>Select Corporation</option>
                                    @foreach($corporations as $corp)
                                        <option value="{{ $corp->id }}">{{ $corp->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a corporation.</div>
                            </div>

                            <!-- Dynamic Constituency -->
                            <div class="mb-3">
                                <label for="constituency_id" class="dump-form-label">Constituency <span class="text-danger">*</span></label>
                                <select id="constituency_id" name="constituency_id" class="dump-form-control" required>
                                    <option value="" selected disabled>Select Constituency</option>
                                    @foreach($constituencies as $const)
                                        <option value="{{ $const->id }}" data-corp="{{ $const->corporation_id }}">{{ $const->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select a constituency.</div>
                            </div>

                            <!-- Plant Name -->
                            <div class="mb-3">
                                <label for="name" class="dump-form-label">Plant Location Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="dump-form-control" placeholder="Enter plant location name (e.g., Kannahalli Plant)" required>
                                <div class="invalid-feedback">Please enter the plant location name.</div>
                            </div>

                            <!-- Plant Address -->
                            <div class="mb-4">
                                <label for="address" class="dump-form-label">Plant Place Address <span class="text-danger">*</span></label>
                                <textarea id="address" name="address" class="dump-form-control" placeholder="Enter full plant location address" required></textarea>
                                <div class="invalid-feedback">Please enter the plant place address.</div>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('admin.masters.plants.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-submit-dump">
                                    <i class="fa fa-save me-1"></i> Submit
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
    const corpSelect = document.getElementById('corporation_id');
    const constSelect = document.getElementById('constituency_id');
    const constOptions = Array.from(constSelect.options);

    corpSelect.addEventListener('change', function() {
        const corpId = this.value;
        constSelect.innerHTML = '<option value="" selected disabled>Select Constituency</option>';

        constOptions.forEach(opt => {
            if (opt.value && opt.dataset.corp == corpId) {
                constSelect.appendChild(opt.cloneNode(true));
            }
        });
    });

    const form = document.getElementById('plantForm');
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