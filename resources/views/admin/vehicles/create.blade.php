@extends('admin.layout.app')

@section('title', 'Add New Vehicle')

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
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Add New Vehicle</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.vehicles.index') }}">Vehicles</a></li>
                        <li class="breadcrumb-item active">Add New Vehicle</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
        
    <div class="row">
        <div class="container-fluid">
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

                    <form class="needs-validation" novalidate action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Vehicle Information -->
                        <h5 class="form-section-title mt-2">Vehicle Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="vehicleNumber">Vehicle Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror" 
                                       id="vehicleNumber" name="vehicle_number" placeholder="e.g. KA-01-AB-1234" 
                                       value="{{ old('vehicle_number') }}" required>
                                <div class="invalid-feedback">Please enter the vehicle number.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="vehicleType">Vehicle Type <span class="text-danger">*</span></label>
                                <select class="form-select form-control @error('vehicle_type') is-invalid @enderror" 
                                        id="vehicleType" name="vehicle_type" required>
                                    <option value="" disabled {{ old('vehicle_type') ? '' : 'selected' }}>Select Type</option>
                                    <option value="Truck" {{ old('vehicle_type') == 'Truck' ? 'selected' : '' }}>Truck</option>
                                    <option value="Van" {{ old('vehicle_type') == 'Van' ? 'selected' : '' }}>Van</option>
                                    <option value="Mini-Truck" {{ old('vehicle_type') == 'Mini-Truck' ? 'selected' : '' }}>Mini-Truck</option>
                                    <option value="Tractor" {{ old('vehicle_type') == 'Tractor' ? 'selected' : '' }}>Tractor</option>
                                    <option value="Compactor" {{ old('vehicle_type') == 'Compactor' ? 'selected' : '' }}>Compactor</option>
                                </select>
                                <div class="invalid-feedback">Please select a vehicle type.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="capacity">Capacity (in kg) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror" 
                                       id="capacity" name="capacity" placeholder="e.g. 1000" min="1" 
                                       value="{{ old('capacity') }}" required>
                                <div class="invalid-feedback">Please enter a valid capacity in kg.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="vehiclePhoto">Vehicle Photo</label>
                                <input type="file" class="form-control @error('vehicle_photo') is-invalid @enderror" 
                                       id="vehiclePhoto" name="vehicle_photo" accept="image/*">
                            </div>
                        </div>

                        <!-- Documents -->
                        <h5 class="form-section-title mt-4">Documents</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="rcDocument">RC Document</label>
                                <input type="file" class="form-control @error('rc_document') is-invalid @enderror" 
                                       id="rcDocument" name="rc_document" accept="image/*,.pdf">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="fitnessDocument">Fitness Certificate</label>
                                <input type="file" class="form-control @error('fitness_document') is-invalid @enderror" 
                                       id="fitnessDocument" name="fitness_document" accept="image/*,.pdf">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="insuranceDocument">Insurance Document</label>
                                <input type="file" class="form-control @error('insurance_document') is-invalid @enderror" 
                                       id="insuranceDocument" name="insurance_document" accept="image/*,.pdf">
                            </div>
                        </div>

                        <!-- Owner Details -->
                        <h5 class="form-section-title mt-4">Vehicle Owner Details (User Account)</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="ownerName">Owner Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('owner_name') is-invalid @enderror" 
                                       id="ownerName" name="owner_name" placeholder="Enter owner name" 
                                       value="{{ old('owner_name') }}" required>
                                <div class="invalid-feedback">Please enter the owner's name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="ownerPhone">Owner Phone Number (User Login) <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('owner_phone') is-invalid @enderror" 
                                       id="ownerPhone" name="owner_phone" placeholder="Enter 10-digit mobile number" 
                                       pattern="[0-9]{10}" maxlength="10" 
                                       value="{{ old('owner_phone') }}"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" required>
                                <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                            </div>
                        </div>

                        <!-- Driver Details -->
                        <h5 class="form-section-title mt-4">Driver Details</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="driverName">Driver Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('driver_name') is-invalid @enderror" 
                                       id="driverName" name="driver_name" placeholder="Enter driver name" 
                                       value="{{ old('driver_name') }}" required>
                                <div class="invalid-feedback">Please enter the driver's name.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="driverPhone">Driver Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('driver_phone') is-invalid @enderror" 
                                       id="driverPhone" name="driver_phone" placeholder="Enter driver phone number" 
                                       pattern="[0-9]{10}" maxlength="10" 
                                       value="{{ old('driver_phone') }}"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" required>
                                <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="licenseNumber">License Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('license_number') is-invalid @enderror" 
                                       id="licenseNumber" name="license_number" placeholder="Enter license number" 
                                       value="{{ old('license_number') }}" required>
                                <div class="invalid-feedback">Please enter the license number.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="licensePhoto">License Photo</label>
                                <input type="file" class="form-control @error('license_photo') is-invalid @enderror" 
                                       id="licensePhoto" name="license_photo" accept="image/*">
                            </div>
                        </div>
                        
                        <hr class="mt-4 mb-4">
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save Vehicle</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
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
