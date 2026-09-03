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
                        <a href="{{ route('admin.dashboard') }}">
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
                        <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;">System Users</h4>
                        <a href="{{ route('admin.masters.users.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus me-1"></i> Add User</a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="display datatables" id="usersTable">
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $index => $user)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><strong>{{ $user->name }}</strong></td>
                                            <td>
                                                <span class="badge bg-primary text-uppercase">
                                                    {{ $user->roles->first()?->name ?? 'User' }}
                                                </span>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->mobile_number }}</td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('admin.masters.users.show', $user->id) }}" class="btn btn-info btn-sm text-white" title="View"><i class="fa fa-eye"></i></a>
                                                    <a href="{{ route('admin.masters.users.edit', $user->id) }}" class="btn btn-warning btn-sm text-white" title="Edit"><i class="fa fa-pencil"></i></a>
                                                    <form action="{{ route('admin.masters.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm text-white" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No users found. Click <strong>Add User</strong> to create one.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(method_exists($users, 'links'))
                            <div class="d-flex justify-content-end mt-3">
                                {{ $users->links() }}
                            </div>
                        @endif
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
        if ($('#usersTable').length) {
            $('#usersTable').DataTable();
        }
    });
</script>
@endsection
