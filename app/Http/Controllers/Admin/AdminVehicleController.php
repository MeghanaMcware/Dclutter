<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class AdminVehicleController extends Controller
{
    /**
     * Display a listing of all registered vehicles.
     */
    public function index()
    {
        $vehicles = Vehicle::with('owner')->latest()->get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store a newly created vehicle and owner user account in database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehicle_number' => 'required|string|max:255|unique:vehicles,vehicle_number',
            'vehicle_type' => 'required|string|max:255',
            'capacity' => 'required|numeric|min:1',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|regex:/^[0-9]{10}$/',
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'required|string|regex:/^[0-9]{10}$/',
            'license_number' => 'required|string|max:255',
            'vehicle_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'rc_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'fitness_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'insurance_document' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:5120',
            'license_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // 1. Create or update User account for Vehicle Owner/Driver
        $ownerUser = User::where('mobile_number', $request->owner_phone)->first();
        if (!$ownerUser) {
            $ownerUser = User::create([
                'name' => $request->owner_name,
                'mobile_number' => $request->owner_phone,
                'email' => $request->owner_phone . '@dclutter.com',
                'password' => bcrypt('1234'),
            ]);
        } else {
            $ownerUser->update(['name' => $request->owner_name]);
        }

        // Assign Spatie 'vehicle' role to the owner user
        if (class_exists(Role::class)) {
            $vehicleRole = Role::firstOrCreate(['name' => 'vehicle', 'guard_name' => 'web']);
            if (!$ownerUser->hasRole('vehicle')) {
                $ownerUser->assignRole($vehicleRole);
            }
        }

        // 2. Handle File Uploads
        $filePaths = [];
        $fileFields = ['vehicle_photo', 'rc_document', 'fitness_document', 'insurance_document', 'license_photo'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $filePaths[$field] = $request->file($field)->store('vehicles/docs', 'public');
            } else {
                $filePaths[$field] = null;
            }
        }

        // Capacity conversion (if > 100 assumed kg, convert to tons)
        $capacityKg = (float) $request->capacity;
        $capacityTons = $capacityKg > 50 ? round($capacityKg / 1000, 2) : $capacityKg;

        // 3. Create Vehicle Record
        $vehicle = Vehicle::create([
            'vehicle_number' => strtoupper(trim($request->vehicle_number)),
            'user_id' => $ownerUser->id,
            'vehicle_type' => $request->vehicle_type,
            'capacity_tons' => $capacityTons,
            'vehicle_photo' => $filePaths['vehicle_photo'],
            'rc_document' => $filePaths['rc_document'],
            'fitness_document' => $filePaths['fitness_document'],
            'insurance_document' => $filePaths['insurance_document'],
            'driver_name' => $request->driver_name,
            'driver_phone' => $request->driver_phone,
            'license_number' => $request->license_number,
            'license_photo' => $filePaths['license_photo'],
            'status' => true,
        ]);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle and Owner account created successfully!');
    }

    /**
     * Display the specified vehicle.
     */
    public function show($id)
    {
        $vehicle = Vehicle::with('owner')->findOrFail($id);
        return view('admin.vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit($id)
    {
        $vehicle = Vehicle::with('owner')->findOrFail($id);
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'vehicle_number' => 'required|string|max:255|unique:vehicles,vehicle_number,' . $id,
            'vehicle_type' => 'required|string|max:255',
            'capacity' => 'required|numeric|min:1',
            'owner_name' => 'required|string|max:255',
            'owner_phone' => 'required|string|regex:/^[0-9]{10}$/',
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'required|string|regex:/^[0-9]{10}$/',
            'license_number' => 'required|string|max:255',
        ]);

        // Update owner user name if changed
        if ($vehicle->owner) {
            $vehicle->owner->update([
                'name' => $request->owner_name,
                'mobile_number' => $request->owner_phone,
            ]);
        }

        // Capacity conversion
        $capacityKg = (float) $request->capacity;
        $capacityTons = $capacityKg > 50 ? round($capacityKg / 1000, 2) : $capacityKg;

        $updateData = [
            'vehicle_number' => strtoupper(trim($request->vehicle_number)),
            'vehicle_type' => $request->vehicle_type,
            'capacity_tons' => $capacityTons,
            'driver_name' => $request->driver_name,
            'driver_phone' => $request->driver_phone,
            'license_number' => $request->license_number,
        ];

        // Process updated files if uploaded
        $fileFields = ['vehicle_photo', 'rc_document', 'fitness_document', 'insurance_document', 'license_photo'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $updateData[$field] = $request->file($field)->store('vehicles/docs', 'public');
            }
        }

        $vehicle->update($updateData);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully!');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle removed successfully!');
    }

    /**
     * Toggle active/inactive status for the specified vehicle.
     */
    public function toggleStatus($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->status = !$vehicle->status;
        $vehicle->save();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'status' => $vehicle->status,
                'message' => 'Vehicle status updated successfully!'
            ]);
        }

        return back()->with('success', 'Vehicle status updated successfully!');
    }
}
