@extends('admin.layout.app')

@section('title', 'Create Plant Location')

@section('style')
<style>
    .dump-form-card { border-radius: 12px; border: 1px solid #e5e7eb; }
    .dump-form-label { font-weight: 600; font-size: 14px; color: #000 !important; margin-bottom: 0px !important;opacity: inherit !important; }
    .dump-form-control { width: 100%;    color: #2c3e50; min-height: 42px; border: 1px solid #ced4da; border-radius: 6px; padding: 8px 12px; font-size: 14px; outline: none; }
    .dump-form-control:focus { border-color: #0d6efd; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.08); }
    textarea.dump-form-control { min-height: 110px; resize: vertical; }
    .btn-submit-dump { min-width: 120px; font-weight: 600; }
    .form-label {
    color: #2c3e50 !important;
    opacity: inherit !important;

}
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
                        

                        <form id="plantForm" action="{{ route('admin.masters.plants.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
<div class="d-flex row m-0">
                            <!-- Dynamic Corporation -->
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="corporation_id" class="dump-form-label mb-0">Corporation <span class="text-danger">*</span></label>
                                <select id="corporation_id" name="corporation_id" class="dump-form-control @error('corporation_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Select Corporation</option>
                                    @foreach($corporations as $corp)
                                        <option value="{{ $corp->id }}" {{ old('corporation_id') == $corp->id ? 'selected' : '' }}>{{ $corp->name }}</option>
                                    @endforeach
                                </select>
                                @error('corporation_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please select a corporation.</div>
                                @enderror
                            </div>

                            <!-- Dynamic Constituency -->
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="constituency_id" class="dump-form-label mb-0">Constituency <span class="text-danger">*</span></label>
                                <select id="constituency_id" name="constituency_id" class="dump-form-control @error('constituency_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Select Constituency</option>
                                    @foreach($constituencies as $const)
                                        <option value="{{ $const->id }}" data-corp="{{ $const->corporation_id }}" {{ old('constituency_id') == $const->id ? 'selected' : '' }}>{{ $const->name }}</option>
                                    @endforeach
                                </select>
                                @error('constituency_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please select a constituency.</div>
                                @enderror
                            </div>

                            <!-- Plant Name -->
                            <div class="mb-3 col-lg-12 col-md-12 col-12">
                                <label for="name" class="dump-form-label mb-0">Plant Location Name <span class="text-danger">*</span></label>
                                <input type="text" id="name" name="name" class="dump-form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter plant location name (e.g., Kannahalli Plant)" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the plant location name.</div>
                                @enderror
                            </div>

                            <!-- Plant Latitude -->
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="latitude" class="dump-form-label mb-0">Latitude</label>
                                    <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2" style="font-size: 11px;" onclick="getLocation()">
                                        <i class="fa fa-crosshairs me-1"></i> Current Location
                                    </button>
                                </div>
                                <input type="number" step="any" id="latitude" name="latitude" class="dump-form-control @error('latitude') is-invalid @enderror" value="{{ old('latitude') }}" placeholder="e.g. 12.971598">
                                @error('latitude')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Plant Longitude -->
                            <div class="mb-3 col-lg-6 col-md-6 col-12">
                                <label for="longitude" class="dump-form-label mb-1">Longitude</label>
                                <input type="number" step="any" id="longitude" name="longitude" class="dump-form-control @error('longitude') is-invalid @enderror" value="{{ old('longitude') }}" placeholder="e.g. 77.594566">
                                @error('longitude')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Plant Address -->
                            <div class="mb-4 col-12">
                                <label for="address" class="dump-form-label mb-0">Plant Place Address <span class="text-danger">*</span></label>
                                <textarea id="address" name="address" class="dump-form-control @error('address') is-invalid @enderror" placeholder="Enter full plant location address" required>{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the plant place address.</div>
                                @enderror
                            </div>
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
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude.toFixed(8);
            document.getElementById('longitude').value = position.coords.longitude.toFixed(8);
        }, function(error) {
            alert('Unable to retrieve your location. Error: ' + error.message);
        });
    } else {
        alert('Geolocation is not supported by your browser.');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const corpSelect = document.getElementById('corporation_id');
    const constSelect = document.getElementById('constituency_id');
    const constOptions = Array.from(constSelect.options);

    function filterConstituencies() {
        const corpId = corpSelect.value;
        const currentVal = constSelect.value;
        constSelect.innerHTML = '<option value="" selected disabled>Select Constituency</option>';

        constOptions.forEach(opt => {
            if (opt.value && opt.dataset.corp == corpId) {
                const clone = opt.cloneNode(true);
                if (clone.value === currentVal) {
                    clone.selected = true;
                }
                constSelect.appendChild(clone);
            }
        });
    }

    corpSelect.addEventListener('change', filterConstituencies);

    if (corpSelect.value) {
        filterConstituencies();
    }

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