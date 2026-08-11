@extends('admin.layout.app')

@section('title', 'Users')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>Users</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;"></h4>
                        <a href="{{ route('masters.users.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i> Add User</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display datatables" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Populate from database -->
                                    <tr>
                                        <td>1</td>
                                        <td>John Doe</td>
                                        <td>john@example.com</td>
                                        <td>1234567890</td>
                                        <td>
                                            <a href="{{ route('masters.users.show')  }}" class="btn btn-info btn-sm" title="View"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('masters.users.edit')  }}" class="btn btn-warning btn-sm" title="Edit"><i class="fa fa-edit"></i></a>
                                            
                                        </td>
                                    </tr>
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
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable();
    });

    function simulateDelete(btn) {
        Swal.fire({
            icon: 'warning',
            title: 'Delete this record?',
            text: 'This action cannot be undone.',
            showCancelButton: true,
            confirmButtonColor: '#c0392b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Delete',
        }).then((result) => {
            if (result.isConfirmed) {
                $(btn).closest('tr').remove();
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'The user has been deleted.',
                    confirmButtonColor: '#198754'
                });
            }
        });
    }
</script>
@endsection
