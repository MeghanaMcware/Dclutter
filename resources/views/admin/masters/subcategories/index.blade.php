@extends('admin.layout.app')

@section('title', 'Subcategory Master')

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
                    <h3>Subcategories</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('admin/dashboard') }}">
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
                                <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;">Subcategory List</h4>
                                <a href="{{ route('admin.masters.subcategories.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus me-1"></i> Add Subcategory
                                </a>
                            </div>
                            <table class="table table-bordered table-striped text-center align-middle" id="data-source-1">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="text-start">Subcategory Name</th>
                                        <th class="text-start">Category</th>
                                        <th>Icon</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($subcategories as $subcategory)
                                        <tr>
                                            <td class="text-start fw-bold">{{ $subcategory->name }}</td>
                                            <td class="text-start">{{ $subcategory->category?->name ?? 'Unassigned' }}</td>
                                            <td>
                                                @if($subcategory->icon)
                                                    <img src="{{ str_starts_with($subcategory->icon, 'http') || str_starts_with($subcategory->icon, '/') ? $subcategory->icon : asset('storage/' . $subcategory->icon) }}" alt="{{ $subcategory->name }}" width="30" height="30" class="rounded object-fit-cover" onerror="this.src='https://placehold.co/30x30'">
                                                @else
                                                    <img src="https://placehold.co/30x30" alt="No Icon" width="30" height="30" class="rounded">
                                                @endif
                                            </td>
                                            <td>
                                                <div class="form-check form-switch d-flex justify-content-center">
                                                    <input class="form-check-input toggle-subcategory-status" 
                                                           type="checkbox" 
                                                           data-url="{{ route('admin.masters.subcategories.toggle-status', $subcategory->id) }}" 
                                                           {{ $subcategory->status ? 'checked' : '' }}>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('admin.masters.subcategories.edit', $subcategory->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.masters.subcategories.destroy', $subcategory->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcategory?');" class="d-inline">
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
                                            <td colspan="5" class="text-muted py-4">No subcategories found. Click "Add Subcategory" to create one.</td>
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
        // Toggle Subcategory Status via AJAX
        $('.toggle-subcategory-status').on('change', function() {
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
                        text: 'Failed to update subcategory status.'
                    });
                }
            });
        });
    });
</script>
@endsection
