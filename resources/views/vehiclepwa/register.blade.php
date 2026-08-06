@extends('vehiclepwa.layout.app')

@section('title') Driver Registration @endsection
@section('heading') Driver Registration @endsection

@section('style')
    <style>
        :root { 
            --primary-green: #10b981; 
            --primary-dark: #059669; 
            --primary-light: #ecfdf5;
            --bg-color: #f0fdf4;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #cbd5e1;
            --card-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            background-color: var(--bg-color);
            background-image: radial-gradient(at 100% 0%, rgba(16, 185, 129, 0.15) 0px, transparent 50%),
                              radial-gradient(at 0% 100%, rgba(16, 185, 129, 0.1) 0px, transparent 50%);
            background-attachment: fixed;
            font-family: 'Inter', sans-serif;
            color: var(--text-main);
        }

        .container {
            padding-top: 40px !important;
            padding-bottom: 40px !important;
        }

        .page-header {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .page-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .section-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--primary-dark);
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section-title i {
            background: var(--primary-light);
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            font-size: 14px;
        }

        .form-card { 
            background: var(--card-bg); 
            backdrop-filter: blur(10px);
            border-radius: 20px; 
            padding: 28px 24px; 
            border: 1px solid rgba(255,255,255,0.5); 
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.02); 
            margin-bottom: 32px; 
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-card:hover {
            box-shadow: 0 15px 50px -10px rgba(16, 185, 129, 0.1), 0 1px 3px rgba(0,0,0,0.02);
        }

        .form-group { 
            margin-bottom: 24px; 
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label { 
            font-size: 13px; 
            font-weight: 600; 
            color: var(--text-main); 
            margin-bottom: 8px; 
            display: block; 
        }
        
        .form-control, .form-select { 
            width: 100%; 
            border: 1.5px solid var(--border-color); 
            border-radius: 12px; 
            padding: 14px 16px; 
            font-size: 15px; 
            outline: none; 
            background: #ffffff; 
            color: var(--text-main);
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.01) inset;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus, .form-select:focus { 
            border-color: var(--primary-green); 
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
            background: #ffffff;
        }

        input[type="file"] {
            padding: 8px;
            background: #f8fafc;
            color: var(--text-muted);
            border: 1.5px dashed var(--border-color);
            cursor: pointer;
        }

        input[type="file"]:hover {
            border-color: var(--primary-green);
            background: var(--primary-light);
        }

        input[type="file"]::file-selector-button {
            background: var(--text-main);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            margin-right: 16px;
            transition: all 0.2s ease;
        }

        input[type="file"]::file-selector-button:hover {
            background: var(--primary-green);
            transform: translateY(-1px);
        }

        .btn-submit { 
            width: 100%; 
            height: 56px; 
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
            color: #fff; 
            border: none; 
            border-radius: 16px; 
            font-size: 16px; 
            font-weight: 700; 
            letter-spacing: 0.5px;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 12px; 
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.4); 
            cursor: pointer; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin-top: 16px;
        }

        .btn-submit:hover { 
            transform: translateY(-2px);
            box-shadow: 0 15px 35px -5px rgba(16, 185, 129, 0.5); 
        }
        
        .btn-submit:active {
            transform: translateY(1px);
        }

        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* Success screen styling */
        #successSection {
            display: none;
            text-align: center;
            padding: 60px 20px;
            background: var(--card-bg);
            border-radius: 24px;
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
        }
        .check-circle { 
            width: 90px; 
            height: 90px; 
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
            color: #fff; 
            border-radius: 50%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            margin: 0 auto 32px; 
            font-size: 40px; 
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3); 
            animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }
        
        @keyframes scaleIn {
            0% { transform: scale(0); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        .success-title { font-size: 26px; font-weight: 800; color: var(--text-main); margin-bottom: 12px; letter-spacing: -0.5px; }
        .success-sub { font-size: 16px; color: var(--text-muted); margin-bottom: 40px; line-height: 1.6; }
        .btn-home { 
            width: 100%; 
            height: 56px; 
            background: var(--text-main); 
            color: #fff; 
            border: none; 
            border-radius: 16px; 
            font-size: 16px; 
            font-weight: 700; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            text-decoration: none; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.15); 
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            background: #0f172a;
            transform: translateY(-2px);
            color: white;
        }
    </style>
@endsection

@section('content')
    <div class="container py-4" style="max-width: 500px; margin: 0 auto;">
        
        <div id="formSection">
            <p class="text-muted text-center mb-4" style="font-size: 14px;">Fill in your details below to register as a driver on the platform.</p>

            <form id="driverRegistrationForm" onsubmit="submitRegistration(event)">
                
                <!-- Vehicle Details -->
                <h5 class="section-title"><i class="fa-solid fa-truck"></i> Vehicle Details</h5>
                <div class="form-card">
                    <div class="form-group">
                        <label>Vehicle Number<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="vehicleNumber" placeholder="e.g. AP 09 AB 1234" required>
                        <div class="invalid-feedback">Please enter the vehicle number.</div>
                    </div>

                    <div class="grid-2">
                        <div class="form-group">
                            <label>Vehicle Type<span class="text-danger">*</span></label>
                            <select class="form-select form-control" id="vehicleType" required>
                                <option value="" disabled selected>Select Type</option>
                                <option value="mini_truck">Mini Truck</option>
                                <option value="pickup">Pickup</option>
                                <option value="large_truck">Large Truck</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Capacity (kg)<span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="vehicleCapacity" placeholder="e.g. 1000" min="0" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Vehicle Photo<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="vehiclePhoto" accept="image/*" required>
                    </div>
                </div>

                <!-- Documentation -->
                <h5 class="section-title"><i class="fa-solid fa-file-contract"></i> Vehicle Documentation</h5>
                <div class="form-card">
                    <div class="form-group">
                        <label>RC Copy<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="rcCopy" accept="image/*,.pdf" required>
                    </div>
                    <div class="form-group">
                        <label>Fitness Certificate<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="fitnessCert" accept="image/*,.pdf" required>
                    </div>
                    <div class="form-group">
                        <label>Insurance Copy<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="insuranceCopy" accept="image/*,.pdf" required>
                    </div>
                </div>

                <!-- Owner Details -->
                <h5 class="section-title"><i class="fa-solid fa-user-tie"></i> Owner Details</h5>
                <div class="form-card">
                    <div class="form-group">
                        <label>Vehicle Owner Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ownerName" placeholder="Enter owner's full name" required>
                    </div>
                    <div class="form-group">
                        <label>Owner Phone Number<span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="ownerPhone" placeholder="Enter owner's phone number" pattern="[0-9]{10}" required>
                    </div>
                </div>

                <!-- Driver Details -->
                <h5 class="section-title"><i class="fa-solid fa-id-card"></i> Driver Details</h5>
                <div class="form-card">
                    <div class="form-group">
                        <label>Driver Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="driverName" placeholder="Enter driver's full name" required>
                    </div>
                    <div class="form-group">
                        <label>Driver Phone Number<span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="driverPhone" placeholder="Enter driver's phone number" pattern="[0-9]{10}" required>
                    </div>
                    <div class="form-group">
                        <label>License Number<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="licenseNumber" placeholder="Enter driving license number" required>
                    </div>
                    <div class="form-group">
                        <label>License Photo<span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="licensePhoto" accept="image/*" required>
                    </div>
                </div>

                <button type="submit" id="submitBtn" class="btn-submit mb-5">
                    <span>Submit Registration</span> <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
        </div>

        <!-- Success Section -->
        <div id="successSection">
            <div class="check-circle">
                <i class="fa-solid fa-check"></i>
            </div>
            <h2 class="success-title">Registration Submitted!</h2>
            <p class="success-sub">Your details have been successfully submitted for review. Our team will verify your documents shortly.</p>
            
            <a href="#" onclick="window.location.reload(); return false;" class="btn-home">
                Back to Home
            </a>
        </div>

    </div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Bootstrap-style live validation mapping
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', function() {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });
            
            // For file inputs specifically
            if(input.type === 'file') {
                input.addEventListener('change', function() {
                    if (this.files.length > 0) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                });
            }
        });
    });

    function submitRegistration(event) {
        event.preventDefault(); // Prevent default form submission

        const form = document.getElementById('driverRegistrationForm');
        const submitBtn = document.getElementById('submitBtn');

        // Check overall form validity
        if (!form.checkValidity()) {
            // Trigger the live validation UI for all fields
            form.querySelectorAll('input, select').forEach(input => {
                if (!input.checkValidity()) {
                    input.classList.add('is-invalid');
                }
            });
            Swal.fire('Incomplete Form', 'Please fill in all required fields correctly.', 'warning');
            return;
        }

        // Simulate API call and loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Submitting...</span>';

        setTimeout(() => {
            // Hide form and show success screen
            document.getElementById('formSection').style.display = 'none';
            const successSection = document.getElementById('successSection');
            successSection.style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }, 1500);
    }
</script>
@endsection
