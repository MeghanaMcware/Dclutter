@extends('admin.layout.app')

@section('title', 'Edit Category')

@section('content')
<div class="content-body">

 <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        Edit Category
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Categories</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-3">
        <div class="row">
            
                
                <div class="card" >
                    <div class="card-body">
                        <form id="categoryEditForm" class="needs-validation" novalidate onsubmit="handleFormSubmit(event)">
                            <div class="mb-4">
                                <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="categoryName" value="Electronics" placeholder="Enter Category Name" required>
                                <div class="invalid-feedback">Please enter the category name.</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Icon</label>
                                <div class="mb-2">
                                    <img src="/theme/images/icons/electronics.png" alt="Current Icon" width="50" height="50" class="border rounded p-1" onerror="this.src='https://placehold.co/50x50'">
                                    <span class="ms-2 text-muted small">Current Icon</span>
                                </div>
                                <input type="file" class="form-control" id="categoryIcon" accept="image/*">
                                <small class="text-muted">Upload a new image to replace the current icon, or leave empty.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="categoryStatus" required>
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
        const form = document.getElementById('categoryEditForm');
        
        if (!form.checkValidity()) {
            event.stopPropagation();
            form.classList.add('was-validated');
            return;
        }
        
        // Simulating form submission
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Category has been updated successfully.',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    }
</script>
@endsection
