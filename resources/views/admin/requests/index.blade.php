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
                    <div class="row gx-2 mb-3 align-items-center">
                        <div class="col-md-3">
                            <input type="text" class="form-control filter-input" placeholder="Search Request ID, Location...">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select filter-input">
                                <option value="">All Categories</option>
                                <option value="unmanned">Unmanned Debris</option>
                                <option value="cd">C&D Waste Pickup</option>
                                <option value="bulk">Bulk Waste Pickup</option>
                                <option value="overflow">Overflowing Bin</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select filter-input">
                                <option value="">All Status</option>
                                <option value="in-progress">In-Progress</option>
                                <option value="assigned">Assigned</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select filter-input">
                                <option value="">All Wards</option>
                                <option value="112">112</option>
                                <option value="95">95</option>
                                <option value="150">150</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input class="form-control filter-input" type="text" placeholder="Date Range">
                        </div>
                        <div class="col-md-1 text-end">
                            <button class="btn btn-export w-100"><i class="fa fa-download me-1"></i> Export</button>
                        </div>
                    </div>

                    <!-- Table Data -->
                    <div class="table-responsive">
                        <table class="table" id="requests-table">
                            <thead>
                                <tr>
                                    <th>Request ID</th>
                                    <th>Category</th>
                                    <th>Location</th>
                                    <th>Ward</th>
                                    <th>Status</th>
                                    <th>Assigned To</th>
                                    <th>Submitted On</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-primary">#DCL-2025-001256</td>
                                    <td>Unmanned Debris</td>
                                    <td>12th Cross, BTM Layout</td>
                                    <td>112</td>
                                    <td><span class="status-badge status-in-progress">In-Progress</span></td>
                                    <td>Ramesh B.</td>
                                    <td>23 May 2025, 10:30 AM</td>
                                    <td class="text-center">
                                        <a href="#" class="action-btn" title="View"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">#DCL-2025-001255</td>
                                    <td>C&D Waste Pickup</td>
                                    <td>HSR Layout, 3rd Main Road</td>
                                    <td>95</td>
                                    <td><span class="status-badge status-assigned">Assigned</span></td>
                                    <td>Mahesh K.</td>
                                    <td>23 May 2025, 10:15 AM</td>
                                    <td class="text-center">
                                        <a href="#" class="action-btn" title="View"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">#DCL-2025-001254</td>
                                    <td>Bulk Waste Pickup</td>
                                    <td>Indiranagar, 100ft Road</td>
                                    <td>150</td>
                                    <td><span class="status-badge status-in-progress">In-Progress</span></td>
                                    <td>Suresh P.</td>
                                    <td>23 May 2025, 09:45 AM</td>
                                    <td class="text-center">
                                        <a href="#" class="action-btn" title="View"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">#DCL-2025-001253</td>
                                    <td>Overflowing Bin</td>
                                    <td>Jayanagar 4th Block</td>
                                    <td>112</td>
                                    <td><span class="status-badge status-completed">Completed</span></td>
                                    <td>Mahesh K.</td>
                                    <td>23 May 2025, 09:30 AM</td>
                                    <td class="text-center">
                                        <a href="#" class="action-btn" title="View"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">#DCL-2025-001252</td>
                                    <td>Dead Animal</td>
                                    <td>Koramangala, 8th Block</td>
                                    <td>95</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>-</td>
                                    <td>23 May 2025, 09:20 AM</td>
                                    <td class="text-center">
                                        <a href="#" class="action-btn" title="View"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">#DCL-2025-001251</td>
                                    <td>Street Sweeping</td>
                                    <td>Ejipura Main Road</td>
                                    <td>144</td>
                                    <td><span class="status-badge status-assigned">Assigned</span></td>
                                    <td>Ramesh B.</td>
                                    <td>23 May 2025, 09:10 AM</td>
                                    <td class="text-center">
                                        <a href="#" class="action-btn" title="View"><i class="fa fa-eye"></i></a>
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
