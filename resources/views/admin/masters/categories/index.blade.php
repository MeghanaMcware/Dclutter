@extends('admin.layout.app')

@section('title', 'Category Master')

@section('style')
<style>
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.25em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>
@endsection

@section('content')
<div class="content-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Categories</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/dashboard') }}">
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
            <div class="container-fluid">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card" style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;">Category List</h4>
                                <a href="{{ route('admin.masters.categories.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus me-1"></i> Add Category
                                </a>
                            </div>
                            <table class="table table-bordered table-striped text-center align-middle" id="data-source-1">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="text-start">Category Name</th>
                                        <th>Icon</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                        <tr>
                                            <td class="text-start fw-bold">{{ $category->name }}</td>
                                            <td>
                                                @if($category->icon)
                                                    <img src="{{ str_starts_with($category->icon, 'http') || str_starts_with($category->icon, '/') ? $category->icon : asset('storage/' . $category->icon) }}" alt="{{ $category->name }}" width="30" height="30" class="rounded object-fit-cover" onerror="this.src='https://placehold.co/30x30'">
                                                @else
                                                    <img src="https://placehold.co/30x30" alt="No Icon" width="30" height="30" class="rounded">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input class="form-check-input toggle-category-status" 
                                                           type="checkbox" 
                                                           data-url="{{ route('admin.masters.categories.toggle-status', $category->id) }}" 
                                                           {{ $category->status ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.masters.categories.edit', $category->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.masters.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?');" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-muted py-4">No categories found. Click "Add Category" to create one.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
    $(document).ready(function() {
        // Toggle Category Status via AJAX
        $('.toggle-category-status').on('change', function() {
            const toggleInput = $(this);
            const url = toggleInput.data('url');
            const isChecked = toggleInput.is(':checked');

            $.ajax({
                url: url,
                type: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                error: function(xhr) {
                    toggleInput.prop('checked', !isChecked);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update category status.'
                    });
                }
            });
        });
    });
</script>
@endsection
