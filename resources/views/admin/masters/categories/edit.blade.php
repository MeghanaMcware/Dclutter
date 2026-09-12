@extends('admin.layout.app')

@section('title', 'Edit Category')

@section('style')
<style>
    .form-label {
    color: #2c3e50 !important;
    opacity: inherit !important;

}
    </style>
@endsection

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
            <div class="col-sm-12 col-lg-12">
                

                <div class="card">
                    <div class="card-body">
                        <form id="categoryEditForm" action="{{ route('admin.masters.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation @if($errors->any()) was-validated @endif" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label  mb-0" for="categoryName"><b>Category Name</b> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="categoryName" name="name" value="{{ old('name', $category->name) }}" placeholder="Enter Category Name" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the category name.</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold" for="categoryIcon">Icon / Image</label>
                                @if($category->icon)
                                    @php
                                        $icon = $category->icon;
                                        $isImage = $icon && (str_contains($icon, '/') || preg_match('/\.(jpg|jpeg|png|gif|svg|webp)$/i', $icon) || str_starts_with($icon, 'http'));
                                    @endphp
                                    <div class="mb-2 d-flex align-items-center gap-2">
                                        @if($isImage)
                                            <img src="{{ str_starts_with($icon, 'http') || str_starts_with($icon, '/') ? $icon : asset('storage/' . $icon) }}" alt="Current Icon" width="50" height="50" class="border rounded p-1 object-fit-cover shadow-sm" onerror="this.onerror=null;this.src='https://placehold.co/50x50?text=Icon';">
                                        @else
                                            <span class="border rounded p-2 bg-light d-inline-flex align-items-center justify-content-center text-primary shadow-sm" style="width:50px; height:50px; font-size:22px;">
                                                <i class="{{ str_starts_with($icon, 'fa-') ? 'fa-solid ' . $icon : (str_starts_with($icon, 'fa ') || str_starts_with($icon, 'fas ') || str_starts_with($icon, 'fa-solid ') || str_starts_with($icon, 'bi-') ? $icon : 'fa-solid fa-' . $icon) }}"></i>
                                            </span>
                                        @endif
                                        <span class="text-muted small">Current Icon</span>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('icon') is-invalid @enderror" id="categoryIcon" name="icon" accept="image/*">
                                <small class="text-muted">Upload a new image to replace the current icon, or leave empty.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label  mb-0" for="categoryStatus"><b>Status</b> <span class="text-danger">*</span></label>
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
