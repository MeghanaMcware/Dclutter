@extends('vehiclepwa.layout.app')

@section('title') Master Transit Permit - {{ $pickup->permit_number }} @endsection
@section('heading', 'Permit')

@section('style')
<style>
    .audit-img-thumb {
        width: 75px;
        height: 75px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        cursor: pointer;
    }
    .photo-section-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 14px;
    }
    .border-bottom{
        border-bottom: 1px solid #00000052 !important;
    }

    .border-top{
         border-top: 1px solid #00000052 !important;
    }
</style>
@endsection

@section('content')
<div class="container py-3">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show py-2 px-3 mb-3" role="alert">
            <small><strong>✅ Success:</strong> {{ session('success') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show py-2 px-3 mb-3" role="alert">
            <small><strong>⚠️ Capacity Alert:</strong> {{ session('error') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Master Transit Permit Card --}}
    <div class="card border-0 shadow-sm rounded-3 mb-4 overflow-hidden border-top border-4 border-primary">
        <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-0 fw-bold"><i class="bi bi-shield-check me-2"></i> Permit</h6>
                
            </div>
            <span class="badge {{ $pickup->status === 'in_transit' ? 'bg-warning text-dark' : 'bg-success' }} px-3 py-2 fw-bold text-uppercase" style="background: #3f8f23 !important;border-radius:5px !important">
                {{ str_replace('_', ' ', $pickup->status) }}
            </span>
        </div>
        <div class="card-body p-2">

            {{-- QR Code & Permit Header --}}
            <div class="row align-items-center pb-3 mb-3 gap-3 border-bottom">
                <div class="col-4 text-center">
                    <a href="{{ route('permit.public_verify', $pickup->permit_number) }}" target="_blank">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=140x140&data={{ urlencode(route('permit.public_verify', $pickup->permit_number)) }}" 
                             alt="Permit QR Code" 
                             class="img-fluid p-1 border rounded bg-white shadow-sm" style="max-width: 120px;">
                    </a>
                    <small class="d-block text-muted mt-1 font-10">Scan to Verify</small>
                </div>
                <div class=" col-7">
                    <small class="text-muted text-uppercase fw-bold d-block" style="color: black !important;">Permit No.</small>
                    <h5 class="fw-bold text-primary mb-1">{{ $pickup->permit_number }}</h5>
                    <small class="text-muted d-block"><span style="color: black !important;"><b>Issued:</b></span> <span style="color: black !important;">{{ $pickup->created_at->format('d M Y') }}</span></small>
                    <small class="text-muted d-block"><span style="color: black !important;"><b>Vehicle:</b></span> <span style="color: black !important;"> {{ $vehicle->vehicle_number }}</span></small>
                </div>
            </div>

            {{-- Assigned Processing Plant Facility --}}
            @php
                $assignedPlant = $pickup->plant ?? ($pickup->wasteTask->plant ?? ($pickup->citizenRequest->plant ?? \App\Models\Plant::findNearest($pickup->latitude, $pickup->longitude)));
            @endphp
            @if($assignedPlant)
                <div class="p-2 mb-3 bg-white border border-success border-2 rounded-3 text-center">
                    <small class="text-success text-uppercase fw-bold font-10 d-block"><i class="bi bi-building me-1"></i>Assigned Processing Plant Facility</small>
                    <strong class="text-dark font-13">{{ $assignedPlant->name }}</strong>
                    <small class="text-muted d-block font-11">{{ $assignedPlant->address }}</small>
                </div>
            @endif

            {{-- Vehicle Load Status --}}
            @php
                $maxCap = (float)($vehicle->capacity ?? 10.0);
                $currWt = (float)$pickup->calculated_weight;
                $pct    = min(100, round(($currWt / $maxCap) * 100, 1));
            @endphp
            <div class="p-3 bg-light rounded-3 mb-3 border">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="small fw-bold text-secondary text-uppercase">Truck Capacity Filled</span>
                    <strong class="fs-6 text-primary">{{ $currWt }} Tons / {{ $maxCap }} Tons Max</strong>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar {{ $pct >= 90 ? 'bg-danger' : ($pct >= 70 ? 'bg-warning' : 'bg-success') }}" 
                         role="progressbar" 
                         style="width: {{ $pct }}%;border-radius:5px"></div>
                </div>
                <small class="text-muted d-block text-end mt-1 font-10">{{ $pct }}% Truck Capacity Filled</small>
            </div>

            {{-- Itemized Picked Up Waste ("What picked up from where") --}}
            <h6 class="fw-bold text-dark mb-2">
                 Picked Up Waste Details
            </h6>

            @if(empty($pickup->items))
                @php
                    $lat = $pickup->latitude ?? '12.9716';
                    $lng = $pickup->longitude ?? '77.5946';
                    $addrRaw = $pickup->citizenRequest->address ?? ($pickup->wasteTask->description ?? 'Direct Site Pickup');
                @endphp
                <div class="p-3 bg-light rounded-3 border mb-3">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Waste Pickup Item</strong><br>
                            <small class="text-muted">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $lat }},{{ $lng }}" target="_blank" class="text-danger text-decoration-none me-1" title="Navigate in Google Maps">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </a>
                                {{ \Illuminate\Support\Str::words($addrRaw, 4, '...') }}
                            </small>
                        </div>
                        <span class="badge bg-secondary">{{ $pickup->calculated_weight }} T</span>
                    </div>
                </div>
            @else
                <div class="list-group mb-3">
                    @foreach($pickup->items as $idx => $item)
                        @php
                            $itemLat = $item['latitude'] ?? ($pickup->latitude ?? '12.9716');
                            $itemLng = $item['longitude'] ?? ($pickup->longitude ?? '77.5946');
                            $itemAddr = $item['source_address'] ?? 'Site Location';
                        @endphp
                        <div class="list-group-item list-group-item-action p-3 mb-2 border rounded-3">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div>
                                    <span class="badge bg-primary me-1 font-11" style="border-radius:5px !important">Item #{{ $idx + 1 }}</span>
                                    <strong class="text-dark ">{{ $item['source_name'] ?? 'Pickup' }}</strong>
                                </div>
                                <span class="badge bg-success fs-6" style="border-radius:5px !important;font-size:11px !important">{{ $item['weight'] ?? 0 }} Tons</span>
                            </div>
                            <small class="text-muted d-block mb-1">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $itemLat }},{{ $itemLng }}" target="_blank" class="text-danger text-decoration-none me-1" title="Navigate in Google Maps">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </a>
                                <strong>Location:</strong> {{ \Illuminate\Support\Str::words($itemAddr, 4, '...') }}
                            </small>
                            <small class="text-secondary font-11 d-block mb-2">
                                <i class="fas fa-ruler-combined text-primary me-1"></i> Size (L × B × H): {{ $item['length'] ?? '-' }}m × {{ $item['breadth'] ?? '-' }}m × {{ $item['height'] ?? '-' }}m
                                &bull; Picked at: {{ isset($item['timestamp']) ? \Carbon\Carbon::parse($item['timestamp'])->format('h:i A') : '' }}
                            </small>
                            @if(!empty($item['pickup_images']))
                                <div class="mt-2 pt-2 border-top">
                                    <small class="fw-bold text-primary font-11 d-block mb-1">📷 Pickup Site Photos:</small>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($item['pickup_images'] as $imgUrl)
                                            <a href="{{ asset($imgUrl) }}" target="_blank">
                                                <img src="{{ asset($imgUrl) }}" class="audit-img-thumb" alt="Pickup Photo">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- PHOTO GALLERY BY ROLE --}}

            {{-- 1. Citizen / AE Request Photos --}}
    <!--        @php-->
    <!--            $citizenImages = $pickup->citizenRequest->images ?? [];-->
    <!--            $aeImages      = $pickup->wasteTask->images ?? [];-->
    <!--            $requestImages = array_merge((array)$citizenImages, (array)$aeImages);-->
    <!--        @endphp-->
    <!--        <div class="photo-section-card">-->
    <!--            <h6 class="fw-bold text-primary font-12 mb-2">-->
    <!--                <i class="bi bi-person-bounding-box me-1"></i>Citizen / AE Officer Request Photos-->
    <!--            </h6>-->
    <!--            @if(empty($requestImages))-->
    <!--                <small class="text-muted d-block font-11">No initial request photos.</small>-->
    <!--            @else-->
    <!--                <div class="d-flex flex-wrap gap-2">-->
    <!--                    @foreach($requestImages as $imgUrl)-->
    <!--                        <a href="{{ asset($imgUrl) }}" target="_blank">-->
    <!--                            <img src="{{ asset($imgUrl) }}" class="audit-img-thumb" alt="Request Photo">-->
    <!--                        </a>-->
    <!--                    @endforeach-->
    <!--                </div>-->
    <!--            @endif-->
    <!--        </div>-->

    <!--        {{-- 2. Vehicle Driver Pickup Photos --}}-->
    <!--        @php-->
    <!--            $driverImages = (array) ($pickup->pickup_images ?? []);-->
    <!--        @endphp-->
    <!--        <div class="photo-section-card">-->
    <!--            <h6 class="fw-bold text-success font-12 mb-2">-->
    <!--                <i class="bi bi-truck me-1"></i>Vehicle Driver Pickup Photos-->
    <!--            </h6>-->
    <!--            @if(empty($driverImages))-->
    <!--                <small class="text-muted d-block font-11">No driver pickup photos.</small>-->
    <!--            @else-->
    <!--                <div class="d-flex flex-wrap gap-2">-->
    <!--                    @foreach($driverImages as $imgUrl)-->
    <!--                        <a href="{{ asset($imgUrl) }}" target="_blank">-->
    <!--                            <img src="{{ asset($imgUrl) }}" class="audit-img-thumb" alt="Driver Pickup Photo">-->
    <!--                        </a>-->
    <!--                    @endforeach-->
    <!--                </div>-->
    <!--            @endif-->
    <!--        </div>-->

    <!--        {{-- 3. Plant Operator Unload Photos --}}-->
    <!--        @php-->
    <!--            $plantImages = [];-->
    <!--            foreach($pickup->logs as $l) {-->
    <!--                if (!empty($l->images)) {-->
    <!--                    $plantImages = array_merge($plantImages, (array)$l->images);-->
    <!--                }-->
    <!--            }-->
    <!--        @endphp-->
    <!--        <div class="photo-section-card">-->
    <!--            <h6 class="fw-bold text-danger font-12 mb-2">-->
    <!--                <i class="bi bi-building me-1"></i>Plant Operator Unload Verification Photos-->
    <!--            </h6>-->
    <!--            @if(empty($plantImages))-->
    <!--                <small class="text-muted d-block font-11">No plant unload photos uploaded yet.</small>-->
    <!--            @else-->
    <!--                <div class="d-flex flex-wrap gap-2">-->
    <!--                    @foreach($plantImages as $imgUrl)-->
    <!--                        <a href="{{ asset($imgUrl) }}" target="_blank">-->
    <!--                            <img src="{{ asset($imgUrl) }}" class="audit-img-thumb" alt="Plant Unload Photo">-->
    <!--                        </a>-->
    <!--                    @endforeach-->
    <!--                </div>-->
    <!--            @endif-->
    <!--        </div>-->

    <!--        <div class="d-flex gap-2 mt-3">-->
    <!--            <a href="{{ route('vehicle.pickup.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">-->
    <!--                Back to Pickup List-->
    <!--            </a>-->
    <!--            <a href="{{ route('vehicle.dump.index') }}" class="btn btn-primary btn-sm flex-fill">-->
    <!--                View Dump Console-->
    <!--            </a>-->
    <!--        </div>-->

    <!--    </div>-->
    <!--</div>-->

    {{-- Audit Log Steps --}}
    <!--<h6 class="fw-bold text-secondary mb-2">Permit Audit History</h6>-->
    <!--<div class="card border-0 shadow-sm rounded-3">-->
    <!--    <div class="card-body p-3">-->
    <!--        @if($pickup->logs->isEmpty())-->
    <!--            <p class="text-muted small mb-0">No log entries yet.</p>-->
    <!--        @else-->
    <!--            <ul class="list-unstyled mb-0">-->
    <!--                @foreach($pickup->logs as $log)-->
    <!--                    <li class="pb-2 mb-2 border-bottom">-->
    <!--                        <strong class="text-primary">{{ str_replace('_', ' ', strtoupper($log->step_key)) }}</strong>-->
    <!--                        <small class="text-muted float-end">-->
    <!--                            {{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('h:i A') : '' }}-->
    <!--                        </small>-->
    <!--                        <small class="d-block text-secondary">{{ $log->remarks ?? 'Action logged' }}</small>-->
    <!--                    </li>-->
    <!--                @endforeach-->
    <!--            </ul>-->
    <!--        @endif-->
    <!--    </div>-->
    <!--</div>-->

</div>
</div>
</div>
@endsection