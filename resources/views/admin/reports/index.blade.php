@extends('admin.layout.app')

@section('title', 'Reports')

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

.status-in-progress {
    background-color: #fff4e5;
    color: #ff9800;
    border: 1px solid #ffcc80;
}

.status-assigned {
    background-color: #e3f2fd;
    color: #2196f3;
    border: 1px solid #90caf9;
}

.status-pending {
    background-color: #ffebee;
    color: #f44336;
    border: 1px solid #ef9a9a;
}

.status-completed {
    background-color: #e8f5e9;
    color: #4caf50;
    border: 1px solid #a5d6a7;
}

.action-btn {
    width: 28px;
    height: 28px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    color: #6c757d;
    background: transparent;
    transition: all 0.2s;
}

.action-btn:hover {
    background: #f8f9fa;
    color: #212529;
}

.filter-section {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #eaebf0;
}

.filter-input {
    font-size: 13px;
    border-radius: 4px;
    border: 1px solid #ced4da;
}

.btn-export {
    background-color: #198754;
    color: white;
    font-size: 13px;
    padding: 6px 16px;
    border-radius: 4px;
    border: none;
}

.btn-export:hover {
    background-color: #157347;
    color: white;
}

/* Table styling to match the screenshot */
table.dataTable thead th {
    font-size: 12px;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
    border-bottom: 2px solid #eaebf0;
    padding: 12px 10px;
}

table.dataTable tbody td {
    font-size: 13px;
    color: #212529;
    vertical-align: middle;
    padding: 12px 10px;
    border-bottom: 1px solid #eaebf0;
}
</style>
@endsection

@section('content')
<div class="container-fluid pt-3">
    <div class="row">
        <!-- Main Content Section -->
        <div class="col-sm-12">
            <h4 class="mb-3 font-weight-bold" style="color: #1e293b; font-weight: 700;">Reports</h4>

            <div class="card"
                style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                <div class="card-body p-3">
                    <div class="d-flex flex-column align-items-end justify-content-end">
                        <button class="btn btn-export w-auto"><i class="fa fa-download me-1"></i> Export</button>
                    </div>
                    <!-- Top Filters matching screenshot -->
                    <div class="row gx-2 mb-3 align-items-center">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="col-form-label mb-0"><b>Request Id</b></label>
                                <select class="js-example-basic-single col-sm-12">
                                    <optgroup label="Request Id">
                                        <option value="RequestId" disabled selected>Select Request Id</option>
                                        <option value="DCL-2026-000022">DCL-2026-000022</option>
                                        <option value="DCL-2026-000023">DCL-2026-000023</option>
                                        <option value="DCL-2026-000024">DCL-2026-000024</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="col-form-label mb-0"><b>Corporation</b></label>
                                <select class="js-example-basic-single col-sm-12">
                                    <optgroup label="Corporation">
                                        <option value="Corporation" disabled selected>Select Corporation</option>
                                        <option value="WY">South</option>
                                        <option value="WY">North</option>
                                        <option value="WY">West</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="col-form-label mb-0"><b>Constituency</b></label>
                                <select class="js-example-basic-single col-sm-12">
                                    <optgroup label="Constituency">
                                        <option value="Constituency" disabled selected>Select Constituency</option>
                                        <option value="Padmanabanagar">Padmanabanagar</option>
                                        <option value="Shivajinagar">Shivajinagar</option>
                                        <option value="Padmanabanagar">Padmanabanagar</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="col-form-label mb-0"><b>Category</b></label>
                                <select class="js-example-basic-single col-sm-12">
                                    <optgroup label="Category">
                                        <option value="SelectCategory" disabled selected>Select Category</option>
                                        <option value="Chairs">Chairs</option>
                                        <option value="Table">Table</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="col-form-label mb-0"><b>Status</b></label>
                                <select class="js-example-basic-single col-sm-12">
                                    <optgroup label="Status">
                                        <option value="Status" disabled selected>Select Status</option>
                                        <option value="Approved">Approved</option>
                                        <option value="Rejected">Rejected</option>
                                        <option value="Pending">Pending</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>



                    </div>

                    <div class="table-responsive">
                        <div class="table-responsive">
                            <table class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th class="text-dark">Request Id</th>
                                        <th class="text-dark">Corporation</th>
                                        <th class="text-dark">Constituency</th>
                                        <th class="text-dark">Category</th>
                                        <th class="text-dark">Status</th>
                                        <th class="text-dark">Pickup Date</th>
                                        <th class="text-dark">Dump Date</th>
                                        <th class="text-dark">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>DCL-2026-000022</td>
                                        <td>South</td>
                                        <td>Padmanabanagar</td>
                                        <td>Chair</td>
                                        <td>Approved</td>
                                        <td>14-0-2026</td>
                                        <td>16-0-2026</td>
                                        <td>
                                            <a href="{{ url('/report/show') }}" class="btn btn-primary">View</a>
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
<!-- Container-fluid Ends-->
@endsection

@section('script')

@endsection