@extends('admin.layout.app')

@section('title', 'Edit Subcategory')

@section('content')
<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-sm-12 col-xl-6 offset-xl-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;">Edit Subcategory</h4>
                    <a href="{{ url('admin/masters/subcategories') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left me-1"></i> Back</a>
                </div>
                
                <div class="card" style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                    <div class="card-body">
                        <form id="subcategoryEditForm" class="needs-validation" novalidate onsubmit="handleFormSubmit(event)">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="categoryId" required>
                                    <option value="1" selected>Electronics</option>
                                    <option value="2">Furniture</option>
                                    <option value="3">Appliances</option>
                                </select>
                                <div class="invalid-feedback">Please select a category.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Subcategory Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subcategoryName" value="Television" placeholder="Enter Subcategory Name" required>
                                <div class="invalid-feedback">Please enter the subcategory name.</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Icon</label>
                                <div class="mb-2">
                                    <img src="/theme/images/icons/tv.png" alt="Current Icon" width="50" height="50" class="border rounded p-1" onerror="this.src='https://placehold.co/50x50'">
                                    <span class="ms-2 text-muted small">Current Icon</span>
                                </div>
                                <input type="file" class="form-control" id="subcategoryIcon" accept="image/*">
                                <small class="text-muted">Upload a new image to replace the current icon, or leave empty.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="subcategoryStatus" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            
                            <div class="text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4"><i class="fa fa-save me-1"></i> Update</button>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleFormSubmit(event) {
        event.preventDefault();
        const form = document.getElementById('subcategoryEditForm');
        
        if (!form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        // Simulating form submission
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Subcategory has been updated successfully.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    }
</script>
@endsection
