<?php

namespace App\Services;

use App\Models\Dump;
use App\Models\Request as WasteRequest;
use App\Models\Vehicle;
use App\Models\Ward;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class WasteRequestService
{
    // Status Constants (Single Source of Truth)
    public const STATUS_PENDING       = 'pending';
    public const STATUS_ASSIGNED      = 'assigned';
    public const STATUS_PICKED_UP     = 'picked_up';
    public const STATUS_NOT_AVAILABLE = 'not_available';
    public const STATUS_DUMPED        = 'dumped';
    public const STATUS_REJECTED      = 'rejected';

    public function __construct(
        protected WhatsAppService $whatsAppService,
        protected OtpService $otpService
    ) {}

    /**
     * Resolve Ward, Constituency, and Corporation geographic hierarchy.
     */
    public function resolveGeoHierarchy(?int $wardId = null, ?float $latitude = null, ?float $longitude = null): array
    {
        $resolvedWardId = null;
        $constituencyId = null;
        $corporationId = null;

        if ($wardId) {
            $ward = Ward::with('constituency.corporation')->find($wardId);
            if ($ward) {
                $resolvedWardId = $ward->id;
                $constituencyId = $ward->constituency_id;
                $corporationId = $ward->constituency?->corporation_id;
            }
        } elseif ($latitude && $longitude) {
            $ward = Ward::findWardByLatLng($latitude, $longitude);
            if ($ward) {
                $resolvedWardId = $ward->id;
                $constituencyId = $ward->constituency_id;
                $corporationId = $ward->constituency?->corporation_id;
            }
        }

        return [
            'ward_id' => $resolvedWardId,
            'constituency_id' => $constituencyId,
            'corporation_id' => $corporationId,
        ];
    }

    /**
     * 1. Create a new waste pickup request (Used by Citizen Web & User PWA).
     */
    public function createRequest(array $data, array $images = [], string $source = 'citizen'): WasteRequest
    {
        // 1. Process uploaded waste images
        $uploadedPaths = [];
        foreach ($images as $image) {
            if ($image instanceof UploadedFile && $image->isValid()) {
                $uploadedPaths[] = $image->store('waste_images', 'public');
            } elseif (is_string($image)) {
                $uploadedPaths[] = $image;
            }
        }

        // 2. Resolve Geographic Hierarchy
        $geo = $this->resolveGeoHierarchy(
            $data['ward_id'] ?? null,
            isset($data['latitude']) ? (float)$data['latitude'] : null,
            isset($data['longitude']) ? (float)$data['longitude'] : null
        );

        // 3. Generate Request Number
        $requestNumber = WasteRequest::generateRequestNumber();

        // 4. Create Waste Request Record in Transaction
        $wasteRequest = DB::transaction(function () use ($data, $uploadedPaths, $geo, $requestNumber, $source) {
            return WasteRequest::create([
                'request_number' => $requestNumber,
                'source' => $source,
                'user_id' => $data['user_id'] ?? (auth()->check() ? auth()->id() : null),
                'applicant_name' => $data['applicant_name'] ?: 'Citizen',
                'mobile_number' => $data['mobile_number'],
                'category_ids' => $data['pickup_items'] ?? ($data['category_ids'] ?? []),
                'subcategory_ids' => $data['pickup_subitems'] ?? ($data['subcategory_ids'] ?? []),
                'waste_images' => $uploadedPaths,
                'house_no' => $data['house_no'] ?? '',
                'floor_no' => $data['floor_no'] ?? ($data['floor'] ?? null),
                'address' => $data['address'] ?? '',
                'landmark' => $data['landmark'] ?? null,
                'pincode' => $data['pincode'] ?? '',
                'latitude' => $data['latitude'] ?? null,
                'longitude' => $data['longitude'] ?? null,
                'corporation_id' => $geo['corporation_id'] ?? ($data['corporation_id'] ?? null),
                'constituency_id' => $geo['constituency_id'] ?? ($data['constituency_id'] ?? null),
                'ward_id' => $geo['ward_id'] ?? ($data['ward_id'] ?? null),
                'preferred_pickup_date' => $data['preferred_pickup_date'] ?? null,
                'terms_accepted' => !empty($data['terms_accepted']) ? 1 : 0,
                'status' => self::STATUS_PENDING,
            ]);
        });

        // 5. Trigger WhatsApp Registration Confirmation
        try {
            $this->whatsAppService->sendRegistrationConfirmation(
                $wasteRequest->mobile_number,
                $wasteRequest->applicant_name,
                $wasteRequest->request_number
            );
        } catch (\Throwable $e) {
            Log::error('WhatsApp Confirmation Exception in Service: ' . $e->getMessage());
        }

        return $wasteRequest;
    }

    /**
     * 2. Assign Vehicle to Request (Used by Admin / AGM / ADM).
     * 
     * Edge Cases Handled:
     * - Cannot assign if status is DUMPED or COMPLETED.
     * - Cannot re-assign if status is already PICKED_UP (waste is already on the vehicle).
     * - Validates vehicle exists, is active (status == 1), and operates in constituency.
     * - Transitions status from 'pending' or 'not_available' -> 'assigned'.
     */
    public function assignVehicle(WasteRequest|int $wasteRequest, int $vehicleId, ?string $remarks = null): WasteRequest
    {
        $request = $wasteRequest instanceof WasteRequest ? $wasteRequest : WasteRequest::findOrFail($wasteRequest);

        // EDGE CASE 1: Cannot assign if already dumped/completed
        if (in_array($request->status, [self::STATUS_DUMPED, 'completed'], true)) {
            throw new InvalidArgumentException("Cannot assign vehicle. Request #{$request->request_number} has already been dumped and completed.");
        }

        // EDGE CASE 2: Cannot re-assign if already picked up
        if ($request->status === self::STATUS_PICKED_UP) {
            throw new InvalidArgumentException("Cannot re-assign vehicle. Request #{$request->request_number} has already been picked up and is in transit.");
        }

        // EDGE CASE 3: Vehicle Validation & Constituency Check
        $vehicle = Vehicle::findOrFail($vehicleId);
        if (!$vehicle->status) {
            throw new InvalidArgumentException("Vehicle {$vehicle->vehicle_number} is currently marked inactive and cannot be assigned.");
        }

        if ($request->constituency_id) {
            $vehicleConstIds = (array) ($vehicle->constituency_ids ?? []);
            $vehicleConstIds = array_map('intval', array_filter($vehicleConstIds));
            if (!empty($vehicleConstIds) && !in_array((int)$request->constituency_id, $vehicleConstIds, true)) {
                $constName = $request->constituency?->name ?? 'this constituency';
                throw new InvalidArgumentException("Vehicle {$vehicle->vehicle_number} does not operate in {$constName}.");
            }
        }

        // Assign vehicle and transition status
        DB::transaction(function () use ($request, $vehicleId, $remarks) {
            $request->vehicle_id = $vehicleId;
            $request->assigned_at = now();
            if ($remarks !== null) {
                $request->remarks = $remarks;
            }

            // Transition status: pending or rescheduled (not_available) -> assigned
            if (in_array($request->status, [self::STATUS_PENDING, self::STATUS_NOT_AVAILABLE], true)) {
                $request->status = self::STATUS_ASSIGNED;
            }

            $request->save();
        });

        // Trigger WhatsApp assignment notifications to Driver and Citizen
        $request->load('vehicle.owner');
        if ($request->vehicle) {
            $driverName = $request->vehicle->driver_name ?? $request->vehicle->owner?->name ?? 'Driver';
            $driverPhone = $request->vehicle->driver_phone ?? $request->vehicle->owner?->mobile_number ?? '9999999999';
            $vehicleNo = $request->vehicle->vehicle_number;

            try {
                // 1. Notify Driver
                $this->whatsAppService->sendVehicleAssignmentToDriver(
                    $driverPhone,
                    $driverName,
                    $vehicleNo,
                    $request->request_number,
                    $request->address
                );

                // 2. Notify Citizen User
                $this->whatsAppService->sendVehicleAssignmentToUser(
                    $request->mobile_number,
                    $request->applicant_name,
                    $request->request_number,
                    $vehicleNo,
                    $driverName,
                    $driverPhone
                );
            } catch (\Throwable $e) {
                Log::error('WhatsApp Assignment Notification Exception: ' . $e->getMessage());
            }
        }

        return $request;
    }

    /**
     * 3. Record Before-Pickup Details (Used by Vehicle Driver PWA).
     * 
     * Edge Cases:
     * - Blocked if already dumped.
     */
    public function recordBeforePickup(WasteRequest|int $wasteRequest, array $data, array $beforePhotos = []): WasteRequest
    {
        $request = $wasteRequest instanceof WasteRequest ? $wasteRequest : WasteRequest::findOrFail($wasteRequest);

        if (in_array($request->status, [self::STATUS_DUMPED, 'completed'], true)) {
            throw new InvalidArgumentException("Cannot record before-pickup. Request #{$request->request_number} is already dumped.");
        }

        $existingBefore = is_array($request->before_pickup_images) ? $request->before_pickup_images : [];
        foreach ($beforePhotos as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $existingBefore[] = $file->store('requests/before', 'public');
            } elseif (is_string($file)) {
                $existingBefore[] = $file;
            }
        }

        $request->before_pickup_images = $existingBefore;
        if (isset($data['approx_weight_kg'])) {
            $request->approx_weight_kg = $data['approx_weight_kg'];
        }
        if (!empty($data['latitude'])) {
            $request->before_pickup_latitude = $data['latitude'];
        }
        if (!empty($data['longitude'])) {
            $request->before_pickup_longitude = $data['longitude'];
        }
        $request->save();

        return $request;
    }

    /**
     * 4. Record After-Pickup & Mark Picked Up (Used by Vehicle Driver PWA).
     * 
     * Edge Cases:
     * - Blocked if already dumped.
     * - Sets status to 'picked_up' and records timestamp.
     * - Triggers WhatsApp collection completion notification.
     */
    public function markPickedUp(WasteRequest|int $wasteRequest, array $data, array $afterPhotos = []): WasteRequest
    {
        $request = $wasteRequest instanceof WasteRequest ? $wasteRequest : WasteRequest::findOrFail($wasteRequest);

        if (in_array($request->status, [self::STATUS_DUMPED, 'completed'], true)) {
            throw new InvalidArgumentException("Cannot mark picked up. Request #{$request->request_number} is already dumped.");
        }

        $existingAfter = is_array($request->picked_up_images) ? $request->picked_up_images : [];
        foreach ($afterPhotos as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $existingAfter[] = $file->store('requests/after', 'public');
            } elseif (is_string($file)) {
                $existingAfter[] = $file;
            }
        }

        $request->picked_up_images = $existingAfter;
        if (!empty($data['latitude'])) {
            $request->after_pickup_latitude = $data['latitude'];
        }
        if (!empty($data['longitude'])) {
            $request->after_pickup_longitude = $data['longitude'];
        }
        $request->picked_up_at = now();
        $request->status = self::STATUS_PICKED_UP;
        $request->save();

        // Trigger WhatsApp Collection Notification
        try {
            $this->whatsAppService->sendCollectionCompletedToUser(
                $request->mobile_number,
                $request->applicant_name,
                $request->request_number
            );
        } catch (\Throwable $e) {
            Log::error('WhatsApp Pickup Completion Notification Exception: ' . $e->getMessage());
        }

        return $request;
    }

    /**
     * 5. Reschedule Request / Citizen Not Available (Used by Driver PWA).
     * 
     * Edge Cases Handled:
     * - Cannot reschedule if already DUMPED.
     * - Cannot reschedule if already PICKED_UP (waste is already on vehicle).
     * - Ensures next_pickup_date is an upcoming Sunday.
     */
    public function reschedule(WasteRequest|int $wasteRequest, string $reason, ?string $nextDate = null): WasteRequest
    {
        $request = $wasteRequest instanceof WasteRequest ? $wasteRequest : WasteRequest::findOrFail($wasteRequest);

        if (in_array($request->status, [self::STATUS_DUMPED, 'completed'], true)) {
            throw new InvalidArgumentException("Cannot reschedule. Request #{$request->request_number} is already dumped and completed.");
        }

        if ($request->status === self::STATUS_PICKED_UP) {
            throw new InvalidArgumentException("Cannot reschedule. Request #{$request->request_number} is already picked up and in transit.");
        }

        $sundayDate = null;
        if (!empty($nextDate)) {
            $parsed = Carbon::parse($nextDate);
            if (!$parsed->isSunday()) {
                throw new InvalidArgumentException("The next pickup date must be a Sunday.");
            }
            $sundayDate = $parsed->toDateString();
        } else {
            // Default to next upcoming Sunday
            $sundayDate = Carbon::now()->next(Carbon::SUNDAY)->toDateString();
        }

        $request->status = self::STATUS_NOT_AVAILABLE;
        $request->not_available_reason = $reason;
        $request->next_pickup_date = $sundayDate;
        $request->not_available_at = now();
        $request->save();

        return $request;
    }

    /**
     * 6. Log Dump & Complete Disposal (Used by Driver PWA / Facility).
     * 
     * Edge Cases Handled:
     * - Cannot dump again if already dumped (prevents duplicate dump records).
     * - Updates request status to 'dumped' and sets dumped_at.
     */
    public function markDumped(WasteRequest|int $wasteRequest, array $dumpData, array $dumpImages = []): Dump
    {
        $request = $wasteRequest instanceof WasteRequest ? $wasteRequest : WasteRequest::findOrFail($wasteRequest);

        // EDGE CASE: If already dumped, return existing dump or prevent duplicate
        if ($request->dump_id && $request->dump) {
            return $request->dump;
        }

        $uploadedDumpImages = [];
        foreach ($dumpImages as $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $uploadedDumpImages[] = $file->store('dumps', 'public');
            } elseif (is_string($file)) {
                $uploadedDumpImages[] = $file;
            }
        }

        $dump = DB::transaction(function () use ($request, $dumpData, $uploadedDumpImages) {
            $dumpRecord = Dump::create([
                'vehicle_id' => $dumpData['vehicle_id'] ?? $request->vehicle_id,
                'request_id' => $request->id,
                'pickup_number' => $request->request_number,
                'plant_name' => $dumpData['plant_name'] ?? 'Municipal Waste Processing Facility',
                'dump_weight' => $dumpData['dump_weight'] ?? ($request->approx_weight_kg ? $request->approx_weight_kg / 1000 : null),
                'dump_images' => $uploadedDumpImages,
                'dump_latitude' => $dumpData['latitude'] ?? null,
                'dump_longitude' => $dumpData['longitude'] ?? null,
                'dumped_at' => now(),
                'remarks' => $dumpData['remarks'] ?? null,
            ]);

            $request->dump_id = $dumpRecord->id;
            $request->status = self::STATUS_DUMPED;
            $request->save();

            return $dumpRecord;
        });

        return $dump;
    }
}
