@extends('vehiclepwa.layout.app')

@section('title') Dumped History @endsection
@section('heading') Dumped History @endsection

@section('style')
<style>
    :root {
        --primary-green: #0e7a43;
        --primary-green-dark: #095930;
        --primary-green-light: #e6f4ea;
        --border-color: #e2e8f0;
    }

    .history-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .history-card:hover {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.07);
    }

    .top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        flex-wrap: wrap;
        gap: 6px;
    }

    .req-badge {
        background: var(--primary-green-light);
        color: var(--primary-green);
        font-weight: 800;
        font-size: 13.5px;
        padding: 6px 12px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.3px;
    }

    .status-badge {
        font-weight: 700;
        font-size: 11.5px;
        padding: 5px 10px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-transform: uppercase;
    }

    .status-dumped, .status-completed {
        background: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .status-picked_up {
        background: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .status-not_available {
        background: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .status-assigned {
        background: #f1f5f9;
        color: #334155;
        border: 1px solid #cbd5e1;
    }

    .info-grid {
        display: flex;
        flex-direction: column;
        gap: 8px;
        font-size: 13.5px;
        color: #334155;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .info-item i {
        color: var(--primary-green);
        margin-top: 3px;
        width: 16px;
        text-align: center;
        flex-shrink: 0;
    }

    .info-label {
        font-weight: 700;
        color: #0f172a;
        margin-right: 4px;
    }

    .info-value {
        color: #475569;
        word-break: break-word;
    }

    .category-tag {
        display: inline-block;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-size: 11.5px;
        font-weight: 600;
        padding: 3px 8px;
        border-radius: 6px;
        margin-right: 4px;
        margin-bottom: 4px;
    }

    .photo-strip {
        display: flex;
        gap: 6px;
        overflow-x: auto;
        padding: 6px 0;
        margin-top: 8px;
    }

    .photo-thumb {
        width: 54px;
        height: 54px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        flex-shrink: 0;
    }

    .card-actions {
        display: flex;
        gap: 8px;
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .btn-view-details {
        flex: 1;
        background: var(--primary-green);
        color: #ffffff !important;
        border: none;
        padding: 9px 12px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 13.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(14, 122, 67, 0.2);
    }

    .btn-view-details:hover {
        background: var(--primary-green-dark);
        color: #ffffff !important;
    }

    .btn-directions {
        background: #ffffff;
        color: #334155 !important;
        border: 1px solid #cbd5e1;
        padding: 9px 12px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13.5px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
    }

    .btn-directions:hover {
        background: #f8fafc;
        border-color: #94a3b8;
    }

</style>
@endsection

@section('content')
<div class="container py-2" style="max-width: 460px; margin: 0 auto;">

    <!-- Search Form -->
    <div class="mb-3">
        <form method="GET" action="{{ route('vehicle.history') }}">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search ID, Name, Mobile or Area" value="{{ request('search') }}" style="border-radius: 10px 0 0 10px; border-color: #cbd5e1; font-size: 13.5px;">
                <button class="btn btn-primary" type="submit" style="background: var(--primary-green); border-color: var(--primary-green); border-radius: 0 10px 10px 0; padding: 0 16px;">
                    <i class="fa-solid fa-search text-white"></i>
                </button>
                @if(request('search'))
                    <a href="{{ route('vehicle.history') }}" class="btn btn-outline-secondary" style="border-color: #cbd5e1;">
                        <i class="fa-solid fa-times"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Requests Listing -->
    @forelse($requests as $req)
        @php
            $statusLower = strtolower($req->status ?? 'assigned');
            $statusClass = 'status-' . $statusLower;
            $statusLabel = match($statusLower) {
                'picked_up' => 'PICKED UP',
                'dumped', 'completed' => 'DUMPED',
                'not_available' => 'RESCHEDULED',
                'assigned' => 'ASSIGNED',
                default => strtoupper(str_replace('_', ' ', $statusLower))
            };
            $statusIcon = match($statusLower) {
                'picked_up' => 'fa-solid fa-truck-ramp-box',
                'dumped', 'completed' => 'fa-solid fa-check-double',
                'not_available' => 'fa-solid fa-calendar-xmark',
                default => 'fa-solid fa-clock'
            };

            $categories = is_array($req->category_ids) ? implode(', ', $req->category_ids) : ($req->category_ids ?: null);
            $subcategories = is_array($req->subcategory_ids) ? implode(', ', array_map(fn($s) => Str::contains($s, ': ') ? explode(': ', $s)[1] : $s, $req->subcategory_ids)) : ($req->subcategory_ids ?: null);

            // Collect preview images
            $previewImages = [];
            if (is_array($req->picked_up_images)) {
                $previewImages = array_merge($previewImages, $req->picked_up_images);
            }
            if (is_array($req->before_pickup_images)) {
                $previewImages = array_merge($previewImages, $req->before_pickup_images);
            }
            if (is_array($req->waste_images)) {
                $previewImages = array_merge($previewImages, $req->waste_images);
            }
            $dumpObj = $req->dump ?: $req->dumpRecord;
            if ($dumpObj && is_array($dumpObj->dump_images)) {
                $previewImages = array_merge($previewImages, $dumpObj->dump_images);
            }
            $previewImages = array_slice($previewImages, 0, 4);
        @endphp

        <div class="history-card">
            <div class="top-row">
                <div class="req-badge">
                    <i class="fa-solid fa-recycle"></i> {{ $req->request_number }}
                </div>
                <span class="status-badge {{ $statusClass }}">
                    <i class="{{ $statusIcon }}"></i> {{ $statusLabel }}
                </span>
            </div>

            <div class="info-grid">
                <!-- Applicant Contact -->
                <div class="info-item">
                    <i class="fa-solid fa-user"></i>
                    <div>
                        <span class="info-label">Applicant:</span>
                        <span class="info-value fw-bold text-dark">{{ $req->applicant_name ?: 'N/A' }}</span>
                        @if($req->mobile_number)
                            <a href="tel:{{ $req->mobile_number }}" class="ms-1 text-decoration-none text-success fw-bold">
                                <i class="fa-solid fa-phone font-11"></i> {{ $req->mobile_number }}
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Location Address -->
                <div class="info-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <div>
                        <span class="info-label">Address:</span>
                        <span class="info-value">
                            @if($req->house_no)#{{ $req->house_no }}, @endif
                            @if($req->floor_no || $req->floor)Floor {{ $req->floor_no ?: $req->floor }}, @endif
                            {{ $req->address }}
                            @if($req->pincode) - {{ $req->pincode }}@endif
                        </span>
                    </div>
                </div>

                <!-- Ward & Constituency -->
                @if($req->ward || $req->constituency)
                <div class="info-item">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <div>
                        <span class="info-label">Ward / Zone:</span>
                        <span class="info-value">
                            {{ $req->ward?->name ?? 'Ward' }}
                            @if($req->constituency) | {{ $req->constituency->name }} @endif
                            @if($req->corporation) ({{ $req->corporation->name }}) @endif
                        </span>
                    </div>
                </div>
                @endif

                <!-- Items Requested -->
                @if($categories || $subcategories)
                <div class="info-item">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    <div>
                        <span class="info-label">Items:</span>
                        @if($categories)
                            <span class="category-tag">{{ $categories }}</span>
                        @endif
                        @if($subcategories)
                            <span class="category-tag" style="background:#e8f5ed; color:#0e7a43; border-color:#bce4c8;">{{ $subcategories }}</span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Weight Info -->
                @if($req->approx_weight_kg || ($dumpObj && $dumpObj->dump_weight))
                <div class="info-item">
                    <i class="fa-solid fa-weight-scale"></i>
                    <div>
                        <span class="info-label">Weight:</span>
                        @if($req->approx_weight_kg)
                            <span class="badge bg-light text-dark border me-1">Picked Up: <strong>{{ $req->approx_weight_kg }} kg</strong></span>
                        @endif
                        @if($dumpObj && $dumpObj->dump_weight)
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Dumped: <strong>{{ $dumpObj->dump_weight }} kg</strong></span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Timestamps & Status Specifics -->
                @if($statusLower === 'picked_up' && $req->picked_up_at)
                    <div class="info-item" style="color: #0369a1;">
                        <i class="fa-regular fa-clock text-info"></i>
                        <div>
                            <span class="info-label text-info">Picked Up:</span>
                            <span class="info-value fw-semibold">{{ \Carbon\Carbon::parse($req->picked_up_at)->format('d M Y, h:i A') }}</span>
                        </div>
                    </div>
                @elseif(in_array($statusLower, ['dumped', 'completed']) && $dumpObj && $dumpObj->dumped_at)
                    <div class="info-item" style="color: #15803d;">
                        <i class="fa-regular fa-calendar-check text-success"></i>
                        <div>
                            <span class="info-label text-success">Dumped At:</span>
                            <span class="info-value fw-semibold">{{ \Carbon\Carbon::parse($dumpObj->dumped_at)->format('d M Y, h:i A') }} ({{ $dumpObj->plant_name ?: 'Facility' }})</span>
                        </div>
                    </div>
                @elseif($statusLower === 'not_available')
                    <div class="info-item" style="color: #92400e;">
                        <i class="fa-solid fa-calendar-days text-warning"></i>
                        <div>
                            <span class="info-label" style="color: #92400e;">Rescheduled:</span>
                            <span class="info-value fw-semibold">{{ $req->next_pickup_date ? \Carbon\Carbon::parse($req->next_pickup_date)->format('d M Y (l)') : 'Next Sunday' }}</span>
                            @if($req->not_available_reason)
                                <div class="small text-muted mt-1">Reason: {{ $req->not_available_reason }}</div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="info-item">
                        <i class="fa-regular fa-calendar"></i>
                        <div>
                            <span class="info-label">Date:</span>
                            <span class="info-value">{{ $req->created_at ? $req->created_at->format('d M Y') : 'N/A' }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Thumbnail Preview Strip -->
            @if(count($previewImages) > 0)
                <div class="photo-strip">
                    @foreach($previewImages as $img)
                        <img src="{{ Str::startsWith($img, 'http') ? $img : asset('storage/' . $img) }}" alt="Photo" class="photo-thumb" onerror="this.style.display='none'">
                    @endforeach
                </div>
            @endif

            <!-- Card Actions -->
            <div class="card-actions">
                @if($req->latitude && $req->longitude)
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $req->latitude }},{{ $req->longitude }}" target="_blank" class="btn-directions">
                        <i class="fa-solid fa-diamond-turn-right text-primary"></i> Map
                    </a>
                @endif
                <a href="{{ route('vehicle.history.show', $req->id) }}" class="btn-view-details">
                    <i class="fa-solid fa-eye"></i> View Full Details
                </a>
            </div>
        </div>
    @empty
        <div class="text-center py-5 card border-0 rounded-4 shadow-sm bg-white p-4">
            <i class="fa-solid fa-clock-rotate-left fa-3x text-muted mb-3"></i>
            <h5 class="fw-bold">No Dumped History Found</h5>
            <p class="text-muted small mb-0">
                @if(request('search'))
                    No dumped requests match your search criteria. Try clearing your search.
                @else
                    You have no completed dump records in your history yet.
                @endif
            </p>
            @if(request('search'))
                <div class="mt-3">
                    <a href="{{ route('vehicle.history') }}" class="btn btn-sm btn-outline-success">
                        <i class="fa-solid fa-rotate-left me-1"></i> Clear Search
                    </a>
                </div>
            @endif
        </div>
    @endforelse
    
    @if($requests->total() > 0)
    <div class="mt-4 mb-4 pb-4">
        <div class="d-flex flex-column align-items-center justify-content-center text-center">
            <div class="text-muted small mb-2 fw-bold w-100">
                Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of {{ $requests->total() }} entries
            </div>
            <div class="w-100 d-flex justify-content-center" style="overflow-x: auto;">
                {{ $requests->appends(request()->query())->links('vendor.pagination.circle') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
