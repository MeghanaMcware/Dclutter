@extends('admin.layout.app')

@section('title', 'View User')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>View User Details</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-house"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.masters.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">View User</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <div class="container-fluid pt-3">
        <div class="row">
            <div class="col-sm-12 col-xl-8 offset-xl-2">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;">User Details</h4>
                    <a href="{{ route('admin.masters.users.index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left me-1"></i> Back</a>
                </div>

                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="30%">Name</th>
                                    <td><strong>{{ $user->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone Number</th>
                                    <td>{{ $user->mobile_number }}</td>
                                </tr>
                                <tr>
                                    <th>Role</th>
                                    <td>
                                        @php
                                            $roleName = $user->roles->first()?->name ?? 'user';
                                        @endphp
                                        <span class="badge bg-primary text-uppercase">{{ $roleName }}</span>
                                    </td>
                                </tr>
                                @if($roleName === 'dgm')
                                    <tr>
                                        <th>Assigned Corporations</th>
                                        <td>
                                            @forelse($user->assigned_corporations as $corp)
                                                <span class="badge bg-success me-1">{{ $corp->name }}</span>
                                            @empty
                                                <span class="text-muted">No corporations assigned</span>
                                            @endforelse
                                        </td>
                                    </tr>
                                @elseif($roleName === 'agm')
                                    <tr>
                                        <th>Assigned Constituencies</th>
                                        <td>
                                            @forelse($user->assigned_constituencies as $const)
                                                <span class="badge bg-info text-white me-1">{{ $const->name }}</span>
                                            @empty
                                                <span class="text-muted">No constituencies assigned</span>
                                            @endforelse
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <th>Jurisdiction Scope</th>
                                        <td><span class="text-muted">Global Access / Not Applicable</span></td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Registered On</th>
                                    <td>{{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.masters.users.edit', $user->id) }}" class="btn btn-warning btn-sm text-white me-2">
                                <i class="fa fa-pencil me-1"></i> Edit User
                            </a>
                            <a href="{{ route('admin.masters.users.index') }}" class="btn btn-secondary btn-sm">
                                Close
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
