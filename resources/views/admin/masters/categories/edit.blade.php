@extends('admin.layout.app')

@section('title', 'Edit Category')

@section('content')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>Edit Category</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.masters.categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active">Edit Category</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-sm-12 col-xl-6 offset-xl-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;">Edit Category</h4>
                    <a href="{{ route('admin.masters.categories.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left me-1"></i> Back</a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form id="categoryEditForm" action="{{ route('admin.masters.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation @if($errors->any()) was-validated @endif" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label fw-bold" for="categoryName">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="categoryName" name="name" value="{{ old('name', $category->name) }}" placeholder="Enter Category Name" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the category name.</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold" for="categoryIcon">Icon</label>
                                @if($category->icon)
                                    <div class="mb-2">
                                        <img src="{{ str_starts_with($category->icon, 'http') || str_starts_with($category->icon, '/') ? $category->icon : asset('storage/' . $category->icon) }}" alt="Current Icon" width="50" height="50" class="border rounded p-1 object-fit-cover" onerror="this.src='https://placehold.co/50x50'">
                                        <span class="ms-2 text-muted small">Current Icon</span>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('icon') is-invalid @enderror" id="categoryIcon" name="icon" accept="image/*">
                                <small class="text-muted">Upload a new image to replace the current icon, or leave empty.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="categoryStatus">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="categoryStatus" name="status" required>
                                    <option value="1" {{ old('status', $category->status) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !old('status', $category->status) ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
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
