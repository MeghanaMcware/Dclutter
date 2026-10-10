@extends('vehiclepwa.layout.app')

@section('title') Dump Waste List @endsection
@section('heading') Waste Picked Up @endsection

@section('style')
<style>
    :root {
        --primary-brand: #0e7a43;
        --primary-brand-dark: #095930;
        --primary-brand-light: #e8f5e9;
        --bg-canvas: #f8fafc;
        --border-color: #e2e8f0;
    }

    body {
        background: var(--bg-canvas);
    }

    .dump-card {
        background: #ffffff;
        border: 1.5px solid var(--border-color);
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 14px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
        transition: all 0.2s ease;
        position: relative;
        cursor: pointer;
    }

    .dump-card.selected {
        border-color: var(--primary-brand);
        background-color: #f7fdf9;
        box-shadow: 0 4px 12px rgba(14, 122, 67, 0.12);
    }

    .dump-card:active {
        transform: scale(0.99);
    }

    .req-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .req-badge {
        background: var(--primary-brand-light);
        color: var(--primary-brand-dark);
        font-weight: 800;
        font-size: 13px;
        padding: 5px 11px;
        border-radius: 8px;
    }

    .status-badge-picked {
        background: #d1e7dd;
        color: #0f5132;
        font-weight: 700;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 20px;
    }

    .info-row {
        font-size: 13px;
        color: #334155;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .info-row i {
        color: var(--primary-brand);
        width: 16px;
    }

    .btn-dump-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: var(--primary-brand);
        color: #ffffff;
        font-weight: 800;
        font-size: 13.5px;
        border-radius: 10px;
        padding: 9px;
        text-decoration: none;
        margin-top: 12px;
        border: none;
        transition: all 0.2s ease;
    }

    .btn-dump-action:hover, .btn-dump-action:focus {
        background: var(--primary-brand-dark);
        color: #ffffff;
    }

    /* Custom Checkbox Styling */
    .custom-check-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .custom-dump-checkbox {
        width: 22px;
        height: 22px;
        cursor: pointer;
        accent-color: var(--primary-brand);
        border-radius: 6px;
    }

    /* Select All Control Bar */
    .selection-bar {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 10px 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.03);
    }

    /* Sticky Bottom Bulk Bar */
    .sticky-bulk-bar {
        position: fixed;
        bottom: 60px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 24px);
        max-width: 440px;
        background: #111827;
        color: #ffffff;
        border-radius: 14px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.25);
        z-index: 1050;
        animation: slideUp 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translate(-50%, 20px);
        }
        to {
            opacity: 1;
            transform: translate(-50%, 0);
        }
    }

    .btn-bulk-proceed {
        background: linear-gradient(135deg, #0e7a43 0%, #0a5f33 100%);
        color: #ffffff;
        border: none;
        border-radius: 9px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
        box-shadow: 0 4px 10px rgba(14, 122, 67, 0.35);
        white-space: nowrap;
    }

    .btn-bulk-proceed:hover {
        background: var(--primary-brand-dark);
        color: #ffffff;
    }
</style>
@endsection

@section('content')

<div class="container py-2" style="max-width:440px; margin:0 auto; padding-bottom:120px;">

    <div class="mb-3">
        <h6 class="fw-bold text-dark mb-1">Items Ready for Dump Disposal</h6>
        <p class="small text-muted mb-0">Select one or multiple picked up requests to dump together.</p>
    </div>

    @if($dumpRequests->total() > 0)
        <!-- Multi-select header bar -->
        <div class="selection-bar">
            <label class="d-flex align-items-center gap-2 mb-0 cursor-pointer" style="cursor: pointer;">
                <input type="checkbox" id="selectAllCheckbox" class="custom-dump-checkbox">
                <span class="fw-bold text-dark" style="font-size: 13px;">Select All (<span id="totalItemsCount">{{ $dumpRequests->total() }}</span>)</span>
            </label>
            <div id="selectedCountBadge" class="badge bg-light text-secondary border" style="font-size: 11.5px;">
                0 selected
            </div>
        </div>
    @endif

    @forelse($dumpRequests as $req)
        <div class="dump-card" data-request-id="{{ $req->id }}" onclick="toggleCardSelection(event, {{ $req->id }})">
            <div class="req-header">
                <div class="custom-check-wrap">
                    <input type="checkbox" 
                           class="custom-dump-checkbox request-item-checkbox" 
                           value="{{ $req->id }}" 
                           data-pickup-id="{{ $req->request_number ?? ('REQ-' . str_pad($req->id, 5, '0', STR_PAD_LEFT)) }}"
                           onclick="event.stopPropagation(); handleCheckboxChange();">
                    <span class="req-badge">
                        <i class="fa-solid fa-recycle me-1"></i>
                        {{ $req->request_number ?? ('REQ-' . str_pad($req->id, 5, '0', STR_PAD_LEFT)) }}
                    </span>
                </div>

                <span class="status-badge-picked">
                    <i class="fa-solid fa-circle-check me-1"></i> Picked Up
                </span>
            </div>

            <div class="info-row">
                <i class="fa-solid fa-user"></i>
                <span class="fw-bold text-dark">{{ $req->applicant_name ?? 'N/A' }}</span>
                @if(!empty($req->mobile_number))
                    <span class="text-muted">({{ $req->mobile_number }})</span>
                @endif
            </div>

            <div class="info-row">
                <i class="fa-solid fa-location-dot"></i>
                <span>{{ \Illuminate\Support\Str::limit($req->address ?? 'Address not specified', 65) }}</span>
            </div>

            @if(!empty($req->ward?->name) || !empty($req->ward_name_no))
                <div class="info-row">
                    <i class="fa-solid fa-map"></i>
                    <span class="text-secondary">Ward: {{ $req->ward?->name ?? $req->ward_name_no }}</span>
                </div>
            @endif

            <a href="{{ route('vehicle.dumpform', ['pickup_id' => ($req->request_number ?? ('REQ-' . str_pad($req->id, 5, '0', STR_PAD_LEFT))), 'id' => $req->id]) }}" 
               class="btn-dump-action"
               onclick="event.stopPropagation();">
                <i class="fa-solid fa-truck-ramp-box"></i>
                Proceed to Dump
            </a>
        </div>
    @empty
        <div class="text-center py-5">
            <i class="fa-solid fa-truck-ramp-box fa-3x text-muted mb-3"></i>
            <h6 class="fw-bold text-secondary">No Picked Up Items Found</h6>
            <p class="small text-muted mb-3">Items marked as "Picked Up" will appear here for dump disposal.</p>
            <a href="{{ route('vehicle.history', ['status' => 'dumped']) }}" class="btn btn-sm btn-outline-success rounded-pill px-3">
                <i class="fa-solid fa-clock-rotate-left me-1"></i> View Dumped History
            </a>
        </div>
    @endforelse
    
    @if($dumpRequests->total() > 0)
    <div class="mt-4 mb-4 pb-4">
        <div class="d-flex flex-column align-items-center justify-content-center text-center">
            <div class="text-muted small mb-2 fw-bold w-100">
                Showing {{ $dumpRequests->firstItem() ?? 0 }} to {{ $dumpRequests->lastItem() ?? 0 }} of {{ $dumpRequests->total() }} entries
            </div>
            <div class="w-100 d-flex justify-content-center" style="overflow-x: auto;">
                {{ $dumpRequests->appends(request()->query())->links('vendor.pagination.circle') }}
            </div>
        </div>
    </div>
    @endif

</div>

<!-- Sticky Bottom Floating Bar for Multiple Dump Action -->
<div id="stickyBulkBar" class="sticky-bulk-bar" style="display: none;">
    <div>
        <div class="fw-bold" style="font-size: 13.5px;">
            <span id="bulkSelectedNumber" class="text-success fw-bolder">0</span> Selected
        </div>
        <div class="text-muted" style="font-size: 11px;">Ready to dump together</div>
    </div>
    <button type="button" class="btn-bulk-proceed" id="btnBulkDumpProceed" onclick="proceedToBulkDump()">
        <i class="fa-solid fa-truck-ramp-box"></i>
        <span>Dump Selected</span>
    </button>
</div>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const itemCheckboxes = document.querySelectorAll('.request-item-checkbox');
    const stickyBulkBar = document.getElementById('stickyBulkBar');
    const bulkSelectedNumber = document.getElementById('bulkSelectedNumber');
    const selectedCountBadge = document.getElementById('selectedCountBadge');

    window.toggleCardSelection = function(event, id) {
        // Prevent toggle if clicking links or buttons
        if (event.target.closest('a') || event.target.closest('button')) {
            return;
        }

        const checkbox = document.querySelector(`.request-item-checkbox[value="${id}"]`);
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
            handleCheckboxChange();
        }
    };

    window.handleCheckboxChange = function() {
        let selectedCount = 0;
        itemCheckboxes.forEach(cb => {
            const card = cb.closest('.dump-card');
            if (cb.checked) {
                selectedCount++;
                if (card) card.classList.add('selected');
            } else {
                if (card) card.classList.remove('selected');
            }
        });

        if (bulkSelectedNumber) bulkSelectedNumber.textContent = selectedCount;
        if (selectedCountBadge) {
            selectedCountBadge.textContent = selectedCount + ' selected';
            if (selectedCount > 0) {
                selectedCountBadge.className = 'badge bg-success text-white';
            } else {
                selectedCountBadge.className = 'badge bg-light text-secondary border';
            }
        }

        // Show/hide sticky bulk bar
        if (stickyBulkBar) {
            stickyBulkBar.style.display = selectedCount > 0 ? 'flex' : 'none';
        }

        // Update Select All checkbox state
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = (selectedCount > 0 && selectedCount === itemCheckboxes.length);
            selectAllCheckbox.indeterminate = (selectedCount > 0 && selectedCount < itemCheckboxes.length);
        }
    };

    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checked = this.checked;
            itemCheckboxes.forEach(cb => {
                cb.checked = checked;
                const card = cb.closest('.dump-card');
                if (card) {
                    if (checked) card.classList.add('selected');
                    else card.classList.remove('selected');
                }
            });
            handleCheckboxChange();
        });
    }

    window.proceedToBulkDump = function() {
        const selectedIds = [];
        itemCheckboxes.forEach(cb => {
            if (cb.checked) {
                selectedIds.push(cb.value);
            }
        });

        if (selectedIds.length === 0) {
            alert('Please select at least one request to dump.');
            return;
        }

        const url = "{{ route('vehicle.dumpform') }}?ids=" + selectedIds.join(',');
        window.location.href = url;
    };
});
</script>
@endsection
