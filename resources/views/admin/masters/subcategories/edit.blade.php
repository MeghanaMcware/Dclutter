@extends('admin.layout.app')

@section('title', 'Edit Subcategory')

@section('content')
<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-sm-12 col-xl-6 offset-xl-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;">Edit Subcategory</h4>
                    <a href="{{ route('admin.masters.subcategories.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left me-1"></i> Back</a>
                </div>
                
                <div class="card" style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                    <div class="card-body">
                        <form id="subcategoryEditForm" action="{{ route('admin.masters.subcategories.update', $subcategory->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation @if($errors->any()) was-validated @endif" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label fw-bold" for="categoryId">Category <span class="text-danger">*</span></label>
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
                                <label class="form-label fw-bold" for="subcategoryName">Subcategory Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="subcategoryName" name="name" value="{{ old('name', $subcategory->name) }}" placeholder="Enter Subcategory Name" required>
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @else
                                    <div class="invalid-feedback">Please enter the subcategory name.</div>
                                @enderror
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold" for="subcategoryIcon">Icon</label>
                                @if($subcategory->icon)
                                    <div class="mb-2">
                                        <img src="{{ str_starts_with($subcategory->icon, 'http') || str_starts_with($subcategory->icon, '/') ? $subcategory->icon : asset('storage/' . $subcategory->icon) }}" alt="Current Icon" width="50" height="50" class="border rounded p-1 object-fit-cover" onerror="this.src='https://placehold.co/50x50'">
                                        <span class="ms-2 text-muted small">Current Icon</span>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('icon') is-invalid @enderror" id="subcategoryIcon" name="icon" accept="image/*">
                                <small class="text-muted">Upload a new image to replace the current icon, or leave empty.</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold" for="subcategoryStatus">Status <span class="text-danger">*</span></label>
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
