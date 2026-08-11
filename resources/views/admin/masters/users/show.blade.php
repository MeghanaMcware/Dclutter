@extends('admin.layout.app')

@section('title', 'View User')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>View User</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('admin/dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('masters.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">View User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
           

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $user->name ?? 'John Doe' }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email ?? 'john@example.com' }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $user->phone ?? '1234567890' }}</td>
                                </tr>
                                <tr>
                                    <th>Corporations</th>
                                    <td>
                                        <!-- Iterate over corporations -->
                                        <span class="badge bg-primary">Corporation 1</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Constituencies</th>
                                    <td>
                                        <!-- Iterate over constituencies -->
                                        <span class="badge bg-secondary">Constituency 1</span>
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
@endsection
