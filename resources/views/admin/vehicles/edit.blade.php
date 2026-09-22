@extends('admin.layout.app')

@section('title', 'Edit Vehicle')

@section('style')
<style>
    .form-section-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eaebf0;
    }
    .card-custom {
        border: 1px solid #eaebf0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border-radius: 8px;
    }


    .form-label {
    color: #2c3e50 !important;
    opacity: inherit !important;

}

.form-select {
    color: #2125299e !important;
}

.select2-container .select2-selection--single {
    border-color: #c5cbd2 !important;
}
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        Edit Vehicle
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Edit Vehicle</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card card-custom">
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

                        <form class="needs-validation" novalidate action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Vehicle Information -->
                            <h5 class="form-section-title mt-2 d-flex flex-row gap-1"><span>  <i class="bi bi-truck me-2"></i></span><span>Vehicle Information</span></h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="constituency_id"><b>Constituency</b> <span class="text-danger">*</span></label>
                                    <select class="js-example-basic-single form-select col-sm-12 @error('constituency_id') is-invalid @enderror" id="constituency_id" name="constituency_id" required>
                                        <option value="" disabled {{ old('constituency_id', $vehicle->constituency_id) ? '' : 'selected' }}>Select Constituency</option>
                                        @foreach($corporations as $corp)
                                            @if($corp->constituencies && $corp->constituencies->isNotEmpty())
                                                <optgroup label="{{ $corp->name }}">
                                                    @foreach($corp->constituencies as $constituency)
                                                        <option value="{{ $constituency->id }}" {{ old('constituency_id', $vehicle->constituency_id) == $constituency->id ? 'selected' : '' }}>
                                                            {{ $constituency->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        @endforeach
                                        @php
                                            $assignedIds = $corporations->pluck('constituencies')->flatten()->pluck('id')->all();
                                            $otherConstituencies = $constituencies->whereNotIn('id', $assignedIds);
                                        @endphp
                                        @if($otherConstituencies->isNotEmpty())
                                            <optgroup label="Other Constituencies">
                                                @foreach($otherConstituencies as $constituency)
                                                    <option value="{{ $constituency->id }}" {{ old('constituency_id', $vehicle->constituency_id) == $constituency->id ? 'selected' : '' }}>
                                                        {{ $constituency->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endif
                                    </select>
                                    @error('constituency_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please select a constituency.</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="vehicleNumber"><b>Vehicle Number</b> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror" id="vehicleNumber" name="vehicle_number" value="{{ old('vehicle_number', $vehicle->vehicle_number) }}" required>
                                    <div class="invalid-feedback">Please enter the vehicle number.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="vehicleType"><b>Vehicle Type</b> <span class="text-danger">*</span></label>
                                    <select class="form-select form-control @error('vehicle_type') is-invalid @enderror" id="vehicleType" name="vehicle_type" required>
                                        <option value="" disabled>Select Type</option>
                                        @php $currentType = old('vehicle_type', $vehicle->vehicle_type); @endphp
                                        <option value="Truck" {{ $currentType == 'Truck' ? 'selected' : '' }}>Truck</option>
                                        <option value="Van" {{ $currentType == 'Van' ? 'selected' : '' }}>Van</option>
                                        <option value="Mini-Truck" {{ $currentType == 'Mini-Truck' ? 'selected' : '' }}>Mini-Truck</option>
                                        <option value="Tractor" {{ $currentType == 'Tractor' ? 'selected' : '' }}>Tractor</option>
                                        <option value="Compactor" {{ $currentType == 'Compactor' ? 'selected' : '' }}>Compactor</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a vehicle type.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="capacity"><b>Capacity (in kg)</b> <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="capacity" name="capacity" value="{{ old('capacity', $vehicle->capacity_tons ? (float)$vehicle->capacity_tons * 1000 : 1000) }}" min="1" required>
                                    <div class="invalid-feedback">Please enter a valid capacity.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="vehiclePhoto"><b>Vehicle Photo</b> (Leave blank to keep current)</label>
                                    <input type="file" class="form-control @error('vehicle_photo') is-invalid @enderror" id="vehiclePhoto" name="vehicle_photo" accept="image/*">
                                    @if($vehicle->vehicle_photo)
                                        <small class="text-muted d-block mt-1">Current: <a href="{{ asset('storage/' . $vehicle->vehicle_photo) }}" target="_blank">View Photo</a></small>
                                    @endif
                                </div>
                            </div>

                            <!-- Documents -->
                            <h5 class="form-section-title mt-4">Documents</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="rcDocument"><b>RC Document</b> (Leave blank to keep current)</label>
                                    <input type="file" class="form-control @error('rc_document') is-invalid @enderror" id="rcDocument" name="rc_document" accept="image/*,.pdf">
                                    @if($vehicle->rc_document)
                                        <small class="text-muted d-block mt-1">Current: <a href="{{ asset('storage/' . $vehicle->rc_document) }}" target="_blank">View RC</a></small>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="fitnessDocument"><b>Fitness Certificate</b> (Leave blank to keep current)</label>
                                    <input type="file" class="form-control @error('fitness_document') is-invalid @enderror" id="fitnessDocument" name="fitness_document" accept="image/*,.pdf">
                                    @if($vehicle->fitness_document)
                                        <small class="text-muted d-block mt-1">Current: <a href="{{ asset('storage/' . $vehicle->fitness_document) }}" target="_blank">View Certificate</a></small>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="insuranceDocument"><b>Insurance Document</b> (Leave blank to keep current)</label>
                                    <input type="file" class="form-control @error('insurance_document') is-invalid @enderror" id="insuranceDocument" name="insurance_document" accept="image/*,.pdf">
                                    @if($vehicle->insurance_document)
                                        <small class="text-muted d-block mt-1">Current: <a href="{{ asset('storage/' . $vehicle->insurance_document) }}" target="_blank">View Insurance</a></small>
                                    @endif
                                </div>
                            </div>

                            <!-- Owner Details -->
                            <h5 class="form-section-title mt-4">Vehicle Owner Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="ownerName"><b>Owner Name</b> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('owner_name') is-invalid @enderror" id="ownerName" name="owner_name" value="{{ old('owner_name', $vehicle->owner?->name ?? $vehicle->driver_name) }}" required>
                                    <div class="invalid-feedback">Please enter the owner's name.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="ownerPhone"><b>Owner Phone Number</b> <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('owner_phone') is-invalid @enderror" id="ownerPhone" name="owner_phone" value="{{ old('owner_phone', $vehicle->owner?->mobile_number ?? $vehicle->driver_phone) }}" placeholder="Enter owner phone number" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" required>
                                    <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                                </div>
                            </div>

                            <!-- Driver Details -->
                            <h5 class="form-section-title mt-4">Driver Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="driverName"><b>Driver Name</b> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('driver_name') is-invalid @enderror" id="driverName" name="driver_name" value="{{ old('driver_name', $vehicle->driver_name) }}" required>
                                    <div class="invalid-feedback">Please enter the driver's name.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="driverPhone"><b>Driver Phone Number</b> <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control @error('driver_phone') is-invalid @enderror" id="driverPhone" name="driver_phone" value="{{ old('driver_phone', $vehicle->driver_phone) }}" placeholder="Enter driver phone number" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" required>
                                    <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="licenseNumber"><b>License Number</b> <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('license_number') is-invalid @enderror" id="licenseNumber" name="license_number" value="{{ old('license_number', $vehicle->license_number) }}" required>
                                    <div class="invalid-feedback">Please enter the license number.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label mb-0" for="licensePhoto"><b>License Photo</b> (Leave blank to keep current)</label>
                                    <input type="file" class="form-control @error('license_photo') is-invalid @enderror" id="licensePhoto" name="license_photo" accept="image/*">
                                    @if($vehicle->license_photo)
                                        <small class="text-muted d-block mt-1">Current: <a href="{{ asset('storage/' . $vehicle->license_photo) }}" target="_blank">View License</a></small>
                                    @endif
                                </div>
                            </div>
                            
                            <hr class="mt-4 mb-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.vehicles.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Vehicle</button>
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
(function() {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
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
