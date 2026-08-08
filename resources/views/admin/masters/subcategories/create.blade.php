@extends('admin.layout.app')

@section('title', 'Add Subcategory')

@section('content')
<div class="content-body">

 <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        Subcategories
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Subcategories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-3">
        <div class="row">
            
                
                <div class="card" >
                    <div class="card-body">
                        <form id="subcategoryForm" class="needs-validation" novalidate onsubmit="handleFormSubmit(event)">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                <select class="form-select" id="categoryId" required>
                                    <option value="" selected disabled>Select Category</option>
                                    <option value="1">Electronics</option>
                                    <option value="2">Furniture</option>
                                    <option value="3">Appliances</option>
                                </select>
                                <div class="invalid-feedback">Please select a category.</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Subcategory Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="subcategoryName" placeholder="Enter Subcategory Name" required>
                                <div class="invalid-feedback">Please enter the subcategory name.</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Icon <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="subcategoryIcon" accept="image/*" required>
                                <div class="invalid-feedback">Please upload an icon for the subcategory.</div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleFormSubmit(event) {
        event.preventDefault();
        const form = document.getElementById('subcategoryForm');
        
        if (!form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        // Simulating form submission
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Subcategory has been added successfully.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    }
</script>
@endsection
