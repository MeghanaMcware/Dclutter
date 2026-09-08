@extends('admin.layout.app')

@section('title', 'View Plant Location')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>View Plant Location Details</h3>
            </div>
            <div class="col-12 col-sm-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bi bi-house"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.masters.plants.index') }}">Plant Locations</a></li>
                    <li class="breadcrumb-item active">View Plant Location</li>
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
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="35%">Corporation</th>
                                    <td><span class="badge bg-success" style="font-size:13px;">{{ $plant->corporation?->name ?? 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Constituency</th>
                                    <td><span class="badge bg-primary" style="font-size:13px;">{{ $plant->constituency?->name ?? 'N/A' }}</span></td>
                                </tr>
                                <tr>
                                    <th>Plant Location Name</th>
                                    <td><strong>{{ $plant->name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Plant Place Address</th>
                                    <td>{{ $plant->address }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-success" style="font-size:12px;">
                                            <i class="fa fa-check-circle me-1"></i> {{ $plant->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.masters.plants.edit', $plant->id) }}" class="btn btn-warning btn-sm text-white me-2">
                                <i class="fa fa-pencil me-1"></i> Edit Plant Location
                            </a>
                            <a href="{{ route('admin.masters.plants.index') }}" class="btn btn-secondary btn-sm">Close</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection