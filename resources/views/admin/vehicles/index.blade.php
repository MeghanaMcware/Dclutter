@extends('admin.layout.app')

@section('title', 'Vehicle Details')

@section('style')
<style>
    .status-badge {
        padding: 5px 12px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        min-width: 80px;
        text-align: center;
    }
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.25em;
        cursor: pointer;
    }
    .form-switch .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .action-btn {
        width: 28px;
        height: 28px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
        color: #fff;
        background: transparent;
        transition: all 0.2s;
    }
    .action-btn:hover {
        background: #f8f9fa;
        color: #fff;
    }
    
    .filter-section {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #eaebf0;
    }
    
    .filter-input {
        font-size: 13px;
        border-radius: 4px;
        border: 1px solid #ced4da;
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
                        Vehicle Details
                    </h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.html">
                                <i class="bi bi-house"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">Vehicle Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
        
        

        <!-- Table Data -->
        <div class="row">
            <div class="container-fluid">
                <div class="card" >
                    <div class="card-body">
                         <div class="col-md-3 mt-3 mb-3 mt-md-0 text-md-end text-start ms-auto">
                    <a href="{{ url('vehicles/create') }}" class="btn btn-primary" style="font-size: 13px; font-weight: 500; padding: 8px 16px;">
                        <i class="fa fa-plus me-1"></i> Add New Vehicle
                    </a>
                </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped  text-center align-middle" id="data-source-1" style="font-size: 13px;">
                                <thead style="background: #f8f9fa;">
                                    <tr>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #495057; border-bottom: 2px solid #eaebf0; border-top: none;">Vehicle No.</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #495057; border-bottom: 2px solid #eaebf0; border-top: none;">Type</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #495057; border-bottom: 2px solid #eaebf0; border-top: none;">Capacity</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #495057; border-bottom: 2px solid #eaebf0; border-top: none;">Owner</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #495057; border-bottom: 2px solid #eaebf0; border-top: none;">Driver</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #495057; border-bottom: 2px solid #eaebf0; border-top: none;">Status</th>
                                        <th style="padding: 12px 20px; font-weight: 600; color: #495057; border-bottom: 2px solid #eaebf0; border-top: none; text-align: right;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="border-bottom: 1px solid #eaebf0;">
                                        <td style="padding: 15px 20px; vertical-align: middle;">
                                            <span style="font-weight: 600; color: #2c3e50;">KA-01-AB-1234</span>
                                        </td>
                                        <td style="padding: 15px 20px; vertical-align: middle; color: #5a5a5a;">Medium Truck</td>
                                        <td style="padding: 15px 20px; vertical-align: middle; color: #5a5a5a;">1000 kg</td>
                                        <td style="padding: 15px 20px; vertical-align: middle; color: #5a5a5a;">John Doe</td>
                                        <td style="padding: 15px 20px; vertical-align: middle; color: #5a5a5a;">Jane Smith</td>
                                        <td style="padding: 15px 20px; vertical-align: middle;">
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox" checked>
                                            </div>
                                        </td>
                                        <td style="padding: 15px 20px; vertical-align: middle; text-align: right;">
                                            <div class="d-flex justify-content-end gap-1">
                                                <a href="{{ url('vehicles/view') }}" class="btn btn-info text-white" title="View" style="background: #e3f2fd; color: #2196f3;">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ url('vehicles/edit') }}" class="btn btn-warning text-white" title="Edit" style="background: #fff3e0; color: #ff9800;">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                               
                                            </div>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eaebf0;">
                                        <td style="padding: 15px 20px; vertical-align: middle;">
                                            <span style="font-weight: 600; color: #2c3e50;">MH-12-XY-9876</span>
                                        </td>
                                        <td style="padding: 15px 20px; vertical-align: middle; color: #5a5a5a;">Small Van</td>
                                        <td style="padding: 15px 20px; vertical-align: middle; color: #5a5a5a;">500 kg</td>
                                        <td style="padding: 15px 20px; vertical-align: middle; color: #5a5a5a;">Ali Khan</td>
                                        <td style="padding: 15px 20px; vertical-align: middle; color: #5a5a5a;">Mohd Ravi</td>
                                        <td style="padding: 15px 20px; vertical-align: middle;">
                                            <div class="form-check form-switch d-flex justify-content-center">
                                                <input class="form-check-input" type="checkbox">
                                            </div>
                                        </td>
                                        <td style="padding: 15px 20px; vertical-align: middle; text-align: right;">
                                            <div class="d-flex justify-content-end gap-1">
                                                <a href="{{ url('vehicles/view') }}" class="btn btn-info text-white" title="View" style="background: #e3f2fd; color: #2196f3;">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ url('vehicles/edit') }}" class="btn btn-warning text-white" title="Edit" style="background: #fff3e0; color: #ff9800;">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                              
                                            </div>
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
    // Mock delete action
    document.querySelectorAll('.fa-trash').forEach(item => {
        item.closest('button').addEventListener('click', function() {
            if(confirm('Are you sure you want to delete this vehicle?')) {
                alert('Vehicle deleted successfully');
            }
        });
    });
</script>
@endsection
