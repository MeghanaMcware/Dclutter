@extends('admin.layout.app')

@section('title', 'Edit Subcategory')

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
                <h3>Edit Subcategory</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.masters.subcategories.index') }}">Subcategories</a></li>
                    <li class="breadcrumb-item active">Edit Subcategory</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-sm-12 col-lg-12">
                
                
                <div class="card" style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                    <div class="card-body">
                        <form id="subcategoryEditForm" action="{{ route('admin.masters.subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation @if($errors->any()) was-validated @endif" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label  mb-0" for="categoryId"><b>Category</b> <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="categoryId" name="category_id" required>
                                    <option value="" disabled>Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please select a category.</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label  mb-0" for="subcategoryName"><b>Subcategory Name</b> <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="subcategoryName" name="name" value="{{ old('name', $subcategory->name) }}" placeholder="Enter Subcategory Name" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the subcategory name.</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold" for="subcategoryIcon">Icon / Image</label>
                                @if($subcategory->icon)
                                    @php
                                        $icon = $subcategory->icon;
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
                                <input type="file" class="form-control @error('icon') is-invalid @enderror" id="subcategoryIcon" name="icon" accept="image/*">
                                <small class="text-muted">Upload a new image to replace the current icon, or leave empty.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label  mb-0" for="subcategoryStatus"><b>Status</b> <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="subcategoryStatus" name="status" required>
                                    <option value="1" {{ old('status', $subcategory->status) ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !old('status', $subcategory->status) ? 'selected' : '' }}>Inactive</option>
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
