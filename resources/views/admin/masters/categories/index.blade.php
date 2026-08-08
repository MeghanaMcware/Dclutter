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
                    <h3>
                        Categorys
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">
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
                <div class="card" style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                    <div class="card-body p-3">
                        <div class="table-responsive">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 font-weight-bold" style="color: #1e293b; font-weight: 700;"></h4>
                    <a href="{{ url('admin/masters/categories/create') }}" class="btn btn-primary"><i class="fa fa-plus me-1"></i> Add Category</a>
                </div>
                            <table class="table table-bordered table-striped  text-center align-middle" id="data-source-1">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="text-start">Category Name</th>
                                        <th>Icon</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-start fw-bold">Electronics</td>
                                        <td><img src="/theme/images/icons/electronics.png" alt="icon" width="30" height="30" onerror="this.src='https://placehold.co/30x30'"></td>
                                        <td>
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" checked>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/masters/categories/edit') }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-bold">Furniture</td>
                                        <td><img src="/theme/images/icons/furniture.png" alt="icon" width="30" height="30" onerror="this.src='https://placehold.co/30x30'"></td>
                                        <td>
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" checked>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/masters/categories/edit') }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-start fw-bold">Appliances</td>
                                        <td><img src="/theme/images/icons/appliances.png" alt="icon" width="30" height="30" onerror="this.src='https://placehold.co/30x30'"></td>
                                        <td>
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox">
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('admin/masters/categories/edit') }}" class="btn btn-primary" title="Edit"><i class="fa fa-edit"></i></a>
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
</div>
@endsection
