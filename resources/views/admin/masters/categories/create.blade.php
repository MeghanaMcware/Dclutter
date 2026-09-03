@extends('admin.layout.app')

@section('title', 'Add Category')

@section('content')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>Add Category</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.masters.categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active">Add Category</li>
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
                    <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;">Add Category</h4>
                    <a href="{{ route('admin.masters.categories.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left me-1"></i> Back</a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <form id="categoryForm" action="{{ route('admin.masters.categories.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation @if($errors->any()) was-validated @endif" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-bold" for="categoryName">Category Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="categoryName" name="name" value="{{ old('name') }}" placeholder="Enter Category Name" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the category name.</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold" for="categoryIcon">Icon</label>
                                <input type="file" class="form-control @error('icon') is-invalid @enderror" id="categoryIcon" name="icon" accept="image/*">
                                @error('icon')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <small class="text-muted">Upload an icon image (PNG, JPG, SVG, WebP).</small>
                                @enderror
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
