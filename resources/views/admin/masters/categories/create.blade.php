@extends('admin.layout.app')

@section('title', 'Add Category')

@section('content')

<div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        Add Category
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Add Category</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
           
                
                <div class="card" >
                    <div class="card-body">
                        <form id="categoryForm" class="needs-validation" novalidate onsubmit="handleFormSubmit(event)">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="categoryName" placeholder="Enter Category Name" required>
                                <div class="invalid-feedback">Please enter the category name.</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Icon <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="categoryIcon" accept="image/*" required>
                                <div class="invalid-feedback">Please upload an icon for the category.</div>
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
        const form = document.getElementById('categoryForm');
        
        if (!form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        // Simulating form submission
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Category has been added successfully.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    }
</script>
@endsection
