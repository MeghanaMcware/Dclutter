@extends('admin.layout.app')

@section('title', 'Report Details')

@section('style')
<style>
    .section-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eaebf0;
    }
    .detail-label {
        font-size: 13px;
        color: #6c757d;
        font-weight: 500;
        margin-bottom: 4px;
    }
    .detail-value {
        font-size: 14px;
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 15px;
    }
    .card-custom {
        border: 1px solid #eaebf0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border-radius: 8px;
    }
    .img-preview {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        border: 1px solid #eaebf0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
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
                        Report Details
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Report Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
        <div class="row">
            <div class="">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                       <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="35%">Request Id</th>
                                    <td><span class="" style="font-size:13px;">DCL-2026-000010</span></td>
                                </tr>
                                <tr>
                                    <th>Corporation</th>
                                    <td><span class="" style="font-size:13px;">South</span></td>
                                </tr>
                                <tr>
                                    <th>Constituency</th>
                                    <td><span class="" style="font-size:13px;">Padmanabanagar</span></td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td><span class="" style="font-size:13px;">Chair</span></td>
                                </tr>
                               
                                
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-success" style="font-size:12px;">
                                            <i class="fa fa-check-circle me-1"></i> Approved
                                        </span>
                                    </td>
                                </tr>

                                 <tr>
                                    <th>Vehicle No</th>
                                    <td><span class="" style="font-size:13px;">KA-07-2026</span></td>
                                </tr>
                                 <tr>
                                    <th>Pickup Date</th>
                                    <td><span class="" style="font-size:13px;">14-09-2026</span></td>
                                </tr>
                                 <tr>
                                    <th>Dump Date</th>
                                    <td><span class="" style="font-size:13px;">16-09-2026</span></td>
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
