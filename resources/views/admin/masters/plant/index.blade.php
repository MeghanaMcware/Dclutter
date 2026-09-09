@extends('admin.layout.app')

@section('title', 'Plant Locations')

@section('style')

<style>

    /* ==========================================
       TABLE
    =========================================== */

    .dump-table-name {
        font-weight: 600;
        color: #1e293b;
    }

    .dump-address {
        max-width: 350px;
        white-space: normal;
        line-height: 1.5;
        color: #475569;
    }


    /* ==========================================
       CONSTITUENCY & CORPORATION BADGE
    =========================================== */

    .constituency-badge {
        background-color: #e8f1ff;
        color: #0d6efd;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        display: inline-block;
    }

    .corporation-badge {
        background-color: #e6f4ea;
        color: #0e7a43;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        display: inline-block;
    }


    /* ==========================================
       STATUS TOGGLE
    =========================================== */

    .status-switch {
        position: relative;
        display: inline-block;
        width: 42px;
        height: 22px;
        vertical-align: middle;
    }

    .status-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .status-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #adb5bd;
        transition: 0.3s;
        border-radius: 30px;
    }

    .status-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 3px;
        top: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.2);
    }

    .status-switch input:checked + .status-slider {
        background-color: #198754;
    }

    .status-switch input:checked + .status-slider:before {
        transform: translateX(20px);
    }


    /* ==========================================
       STATUS TEXT
    =========================================== */

    .status-text {
        font-size: 12px;
        font-weight: 600;
        margin-left: 7px;
        vertical-align: middle;
    }

    .status-active {
        color: #198754;
    }

    .status-inactive {
        color: #dc3545;
    }


    /* ==========================================
       ACTION BUTTONS
    =========================================== */

    .action-btn {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }


.card .card-header{
    padding:10px 20px !important;
}
.card .card-body{
    
    padding:10px 20px !important;
}
</style>

@endsection


@section('content')


{{-- ==========================================
     PAGE TITLE
=========================================== --}}

<div class="container-fluid">

    <div class="page-title">

        <div class="row">

            <div class="col-12 col-sm-6">

                <h3>
                    Plant Locations
                </h3>

            </div>


            <div class="col-12 col-sm-6">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="{{ route('admin.dashboard') }}">

                            <i class="bi bi-house"></i>

                        </a>

                    </li>

                    <li class="breadcrumb-item active">

                        Plant Locations

                    </li>

                </ol>

            </div>

        </div>

    </div>

</div>



{{-- ==========================================
     CONTENT
=========================================== --}}

<div class="content-body">

    <div class="container-fluid pt-3">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">

            <div class="col-sm-12">

                <div class="card">


                    {{-- ==========================================
                         CARD HEADER
                    =========================================== --}}

                    <div class="card-header d-flex justify-content-end align-items-center">



                        <a
                            href="{{ route('admin.masters.plants.create') }}"
                            class="btn btn-primary btn-sm"
                        >

                            <i class="fa fa-plus me-1"></i>

                            Add Plant Location

                        </a>

                    </div>



                    {{-- ==========================================
                         CARD BODY
                    =========================================== --}}

                    <div class="card-body">


                        <div class="table-responsive">

                            <table
                                class="display datatables"
                                id="dumpLocationsTable"
                            >

                                <thead>

                                    <tr>

                                        <th>
                                            Sl.no
                                        </th>

                                        <th>
                                            Corporation
                                        </th>

                                        <th>
                                            Constituency
                                        </th>

                                        <th>
                                            Plant Location Name
                                        </th>

                                        <th>
                                            Plant Place Address
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Action
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($plants as $index => $plant)
                                        <tr>

                                            <td>
                                                {{ $index + 1 }}
                                            </td>

                                            <td>
                                                <span class="corporation-badge">
                                                    {{ $plant->corporation?->name ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <td>
                                                <span class="constituency-badge">
                                                    {{ $plant->constituency?->name ?? 'N/A' }}
                                                </span>
                                            </td>

                                            <td>
                                                <strong class="dump-table-name d-block">
                                                    {{ $plant->name }}
                                                </strong>
                                                @if($plant->latitude && $plant->longitude)
                                                    <a href="https://www.google.com/maps?q={{ $plant->latitude }},{{ $plant->longitude }}" target="_blank" class="text-primary small text-decoration-none d-inline-flex align-items-center mt-1" style="font-size: 11px;" title="View on Map">
                                                        <i class="fa fa-map-marker-alt me-1 text-danger"></i> {{ round($plant->latitude, 4) }}, {{ round($plant->longitude, 4) }}
                                                    </a>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="dump-address">
                                                    {{ $plant->address }}
                                                </div>
                                            </td>

                                            {{-- STATUS --}}
                                            <td>
                                                <label class="status-switch">
                                                    <input
                                                        type="checkbox"
                                                        {{ $plant->status ? 'checked' : '' }}
                                                        onchange="toggleStatus(this)"
                                                    >
                                                    <span class="status-slider"></span>
                                                </label>

                                                <!-- <span class="status-text {{ $plant->status ? 'status-active' : 'status-inactive' }}">
                                                    {{ $plant->status ? 'Active' : 'Inactive' }}
                                                </span> -->
                                            </td>

                                            {{-- ACTION --}}
                                            <td>
                                                <div class="d-flex gap-1">

                                                    {{-- VIEW --}}
                                                    <a
                                                        href="{{ route('admin.masters.plants.show', $plant->id) }}"
                                                        class="btn btn-info btn-sm text-white action-btn"
                                                        title="View"
                                                    >
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    {{-- EDIT --}}
                                                    <a
                                                        href="{{ route('admin.masters.plants.edit', $plant->id) }}"
                                                        class="btn btn-warning btn-sm text-white action-btn"
                                                        title="Edit"
                                                    >
                                                        <i class="fa fa-pencil"></i>
                                                    </a>

                                                    {{-- DELETE --}}
                                                    <form action="{{ route('admin.masters.plants.destroy', $plant->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this plant location?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm text-white action-btn" title="Delete">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>

                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                <i class="fa-solid fa-industry fa-2x mb-2" style="color: #cbd5e1;"></i>
                                                <div>No plant locations found. Click <strong>Add Plant Location</strong> to add one.</div>
                                            </td>
                                        </tr>
                                    @endforelse

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

$(document).ready(function () {

    /* DATATABLE INITIALIZATION */
    if ($('#dumpLocationsTable').length) {
        $('#dumpLocationsTable').DataTable({
            pageLength: 10,
            ordering: true,
            searching: true,
            lengthChange: true,
            responsive: true
        });
    }

});

/* STATUS TOGGLE */
function toggleStatus(toggle) {
    const statusText = toggle.closest('td').querySelector('.status-text');

    if (toggle.checked) {
        statusText.textContent = 'Active';
        statusText.classList.remove('status-inactive');
        statusText.classList.add('status-active');
    } else {
        statusText.textContent = 'Inactive';
        statusText.classList.remove('status-active');
        statusText.classList.add('status-inactive');
    }
}

</script>

@endsection