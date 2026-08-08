@extends('admin.layout.app')

@section('title', 'All Requests')

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
    .status-in-progress { background-color: #fff4e5; color: #ff9800; border: 1px solid #ffcc80; }
    .status-assigned { background-color: #e3f2fd; color: #2196f3; border: 1px solid #90caf9; }
    .status-pending { background-color: #ffebee; color: #f44336; border: 1px solid #ef9a9a; }
    .status-completed { background-color: #e8f5e9; color: #4caf50; border: 1px solid #a5d6a7; }

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
            <h4 class="mb-3 font-weight-bold" style="color: #1e293b; font-weight: 700;">All Requests</h4>
            
            <div class="card" style="border: 1px solid #eaebf0; box-shadow: 0 2px 10px rgba(0,0,0,0.02); border-radius: 8px;">
                <div class="card-body p-3">
                    
                    <!-- Top Filters matching screenshot -->
                    <!-- Top Filters matching screenshot -->
                    <div class="row gx-3 mb-4 align-items-end">
                        <div class="col-md-2">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #6c757d;">Status</label>
                            <select class="form-select filter-input">
                                <option value="">All Status</option>
                                <option value="in-progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #6c757d;">Constituency</label>
                            <select class="form-select filter-input">
                                <option value="">All Constituencies</option>
                                <option value="vasanth-nagar">Vasanth Nagar</option>
                                <option value="jp-nagar">JP Nagar</option>
                                <option value="koramangala">Koramangala</option>
                                <option value="btm-layout">BTM Layout</option>
                                <option value="hsr-layout">HSR Layout</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #6c757d;">From Date</label>
                            <input class="form-control filter-input" type="date" placeholder="Select Date">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label" style="font-size: 12px; font-weight: 600; color: #6c757d;">To Date</label>
                            <input class="form-control filter-input" type="date" placeholder="Select Date">
                        </div>
                       
                        <div class="col-md-2 text-end">
                            <button class="btn btn-export w-100 d-flex align-items-center justify-content-center gap-1"><i class="fa fa-download"></i> Export</button>
                        </div>
                    </div>

                    <!-- Table Data -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped  text-center align-middle" id="data-source-1">
                            <thead>
                                <tr>
                                    <th class="text-start">Request ID</th>
                                    <th class="text-start">Category</th>
                                    <th class="text-start">Pickup Location</th>
                                    <th class="text-start">Constituency</th>
                                    <th class="text-start">Requested By</th>
                                    <th class="text-start">Mobile</th>
                                    <th>Status</th>
                                    <th class="text-start">Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-start text-dark fw-bold">#REQ-000128</td>
                                    <td class="text-start">Furniture</td>
                                    <td class="text-start">30th Main Road, Banashankari</td>
                                    <td class="text-start">Vasanth Nagar</td>
                                    <td class="text-start">Ramesh Kumar</td>
                                    <td class="text-start">6361457263</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td class="text-start">09 Aug 2026</td>
                                    <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ url('admin/requests/show') }}" 
           class="btn btn-primary" 
           title="View">
            <i class="fa fa-eye"></i>
        </a>

        <a href="#" 
           class="btn btn-success" 
           title="Edit">
            <i class="fa fa-edit"></i>
        </a>
    </div>
</td>
                                </tr>
                                <tr>
                                    <td class="text-start text-dark fw-bold">#REQ-000127</td>
                                    <td class="text-start">Appliances</td>
                                    <td class="text-start">14th Cross, JP Nagar</td>
                                    <td class="text-start">JP Nagar</td>
                                    <td class="text-start">Anita Sharma</td>
                                    <td class="text-start">9845012345</td>
                                    <td><span class="status-badge status-assigned">In Progress</span></td>
                                    <td class="text-start">09 Aug 2026</td>
                                    <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ url('admin/requests/show') }}" 
           class="btn btn-primary" 
           title="View">
            <i class="fa fa-eye"></i>
        </a>

        <a href="#" 
           class="btn btn-success" 
           title="Edit">
            <i class="fa fa-edit"></i>
        </a>
    </div>
</td>
                                </tr>
                                <tr>
                                    <td class="text-start text-dark fw-bold">#REQ-000126</td>
                                    <td class="text-start">Mattresses</td>
                                    <td class="text-start">7th Block, Koramangala</td>
                                    <td class="text-start">Koramangala</td>
                                    <td class="text-start">Suresh Babu</td>
                                    <td class="text-start">9008123456</td>
                                    <td><span class="status-badge status-completed">Completed</span></td>
                                    <td class="text-start">09 Aug 2026</td>
                                    <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ url('admin/requests/show') }}" 
           class="btn btn-primary" 
           title="View">
            <i class="fa fa-eye"></i>
        </a>

        <a href="#" 
           class="btn btn-success" 
           title="Edit">
            <i class="fa fa-edit"></i>
        </a>
    </div>
</td>
                                </tr>
                                <tr>
                                    <td class="text-start text-dark fw-bold">#REQ-000125</td>
                                    <td class="text-start">Furniture</td>
                                    <td class="text-start">1st Stage, BTM Layout</td>
                                    <td class="text-start">BTM Layout</td>
                                    <td class="text-start">Priya N</td>
                                    <td class="text-start">6367788990</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td class="text-start">08 Aug 2026</td>
                                   <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ url('admin/requests/show') }}" 
           class="btn btn-primary" 
           title="View">
            <i class="fa fa-eye"></i>
        </a>

        <a href="#" 
           class="btn btn-success" 
           title="Edit">
            <i class="fa fa-edit"></i>
        </a>
    </div>
</td>
                                </tr>
                                <tr>
                                    <td class="text-start text-dark fw-bold">#REQ-000124</td>
                                    <td class="text-start">Electronics</td>
                                    <td class="text-start">5th Block, HSR Layout</td>
                                    <td class="text-start">HSR Layout</td>
                                    <td class="text-start">Vikram Singh</td>
                                    <td class="text-start">7890123456</td>
                                    <td><span class="status-badge status-rejected" style="background-color: #ffebee; color: #f44336; border: 1px solid #ef9a9a;">Rejected</span></td>
                                    <td class="text-start">08 Aug 2026</td>
                                    <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ url('admin/requests/show') }}" 
           class="btn btn-primary" 
           title="View">
            <i class="fa fa-eye"></i>
        </a>

        <a href="#" 
           class="btn btn-success" 
           title="Edit">
            <i class="fa fa-edit"></i>
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
<!-- Container-fluid Ends-->
@endsection

@section('script')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#requests-table')) {
            $('#requests-table').DataTable().destroy();
        }
        $('#requests-table').DataTable({
            "order": [], // Disable initial sorting to keep the dummy data order
            "pageLength": 10,
            "lengthChange": false, // Hide "show x entries" as per screenshot
            "searching": false,    // Hide default datatable search since we have custom filters
            "info": true,          // Show "Showing 1 to 10 of x entries"
            "language": {
                "paginate": {
                    "previous": "<",
                    "next": ">"
                }
            }
        });
    });
</script>
@endsection
