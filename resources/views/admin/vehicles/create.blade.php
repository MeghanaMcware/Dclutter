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
                    <h3>
                        Add New Vehicle
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item"> Add New Vehicle</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
        
        <div class="row">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <form class="needs-validation" novalidate action="#" method="POST" enctype="multipart/form-data">
                          
                            
                            <!-- Vehicle Information -->
                            <h5 class="form-section-title mt-2">Vehicle Information</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="vehicleNumber">Vehicle Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="vehicleNumber" name="vehicle_number" placeholder="e.g. MH-12-AB-1234" required>
                                    <div class="invalid-feedback">Please enter the vehicle number.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="vehicleType">Vehicle Type <span class="text-danger">*</span></label>
                                    <select class="form-select form-control" id="vehicleType" name="vehicle_type" required>
                                        <option value="" disabled selected>Select Type</option>
                                        <option value="Truck">Truck</option>
                                        <option value="Van">Van</option>
                                        <option value="Mini-Truck">Mini-Truck</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a vehicle type.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="capacity">Capacity (in kg) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="capacity" name="capacity" placeholder="e.g. 1000" min="1" required>
                                    <div class="invalid-feedback">Please enter a valid capacity.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="vehiclePhoto">Vehicle Photo <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="vehiclePhoto" name="vehicle_photo" accept="image/*" required>
                                    <div class="invalid-feedback">Please upload a photo of the vehicle.</div>
                                </div>
                            </div>

                            <!-- Documents -->
                            <h5 class="form-section-title mt-4">Documents</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="rcDocument">RC Document <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="rcDocument" name="rc_document" accept="image/*,.pdf" required>
                                    <div class="invalid-feedback">Please upload the RC document.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="fitnessDocument">Fitness Certificate <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="fitnessDocument" name="fitness_document" accept="image/*,.pdf" required>
                                    <div class="invalid-feedback">Please upload the fitness certificate.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="insuranceDocument">Insurance Document <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="insuranceDocument" name="insurance_document" accept="image/*,.pdf" required>
                                    <div class="invalid-feedback">Please upload the insurance document.</div>
                                </div>
                            </div>

                            <!-- Owner Details -->
                            <h5 class="form-section-title mt-4">Vehicle Owner Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="ownerName">Owner Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="ownerName" name="owner_name" placeholder="Enter owner name" required>
                                    <div class="invalid-feedback">Please enter the owner's name.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="ownerPhone">Owner Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="ownerPhone" name="owner_phone" placeholder="Enter owner phone number" pattern="[0-9]{10}" required>
                                    <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                                </div>
                            </div>

                            <!-- Driver Details -->
                            <h5 class="form-section-title mt-4">Driver Details</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="driverName">Driver Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="driverName" name="driver_name" placeholder="Enter driver name" required>
                                    <div class="invalid-feedback">Please enter the driver's name.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="driverPhone">Driver Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="driverPhone" name="driver_phone" placeholder="Enter driver phone number" pattern="[0-9]{10}" required>
                                    <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="licenseNumber">License Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="licenseNumber" name="license_number" placeholder="Enter license number" required>
                                    <div class="invalid-feedback">Please enter the license number.</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="licensePhoto">License Photo <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" id="licensePhoto" name="license_photo" accept="image/*" required>
                                    <div class="invalid-feedback">Please upload the license photo.</div>
                                </div>
                            </div>
                            
                            <hr class="mt-4 mb-4">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ url('admin/vehicles') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Save Vehicle</button>
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
    // Bootstrap validation script
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
