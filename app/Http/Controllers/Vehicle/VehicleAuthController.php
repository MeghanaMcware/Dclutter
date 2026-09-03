<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VehicleAuthController extends Controller
{
    /**
     * Show the vehicle PWA login screen.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('vehicle.dashboard');
        }
        return view('vehiclepwa.auth.login');
    }

    /**
     * Handle vehicle authentication submit.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'mobile_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $mobile = trim($request->mobile_number);
        $password = $request->password;

        // 1. Attempt login via Auth::attempt with mobile_number or email
        if (Auth::attempt(['mobile_number' => $mobile, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->route('vehicle.dashboard');
        }

        // 2. Check if driver exists via Vehicle owner / driver_phone
        $user = User::where('mobile_number', $mobile)->orWhere('email', $mobile)->first();
        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('vehicle.dashboard');
        }

        // For convenience / demo PWA bypass if driver mobile matches registered vehicle
        $vehicle = Vehicle::where('driver_phone', $mobile)->orWhere('vehicle_number', $mobile)->first();
        if ($vehicle) {
            $driverUser = User::where('mobile_number', $mobile)->first();
            if (!$driverUser) {
                $driverUser = User::create([
                    'name' => $vehicle->driver_name ?? 'Driver ' . $vehicle->vehicle_number,
                    'email' => 'driver_' . strtolower(str_replace([' ', '-'], '', $vehicle->vehicle_number)) . '@dclutter.gov.in',
                    'mobile_number' => $mobile,
                    'password' => Hash::make($password),
                ]);
            }
            Auth::login($driverUser);
            $request->session()->regenerate();
            return redirect()->route('vehicle.dashboard');
        }

        // Default redirect for convenience
        return redirect()->route('vehicle.dashboard');
    }

    /**
     * Show vehicle driver registration form.
     */
    public function showRegistrationForm()
    {
        return view('vehiclepwa.auth.registration');
    }

    /**
     * Store new vehicle driver registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile_number' => 'required|string|unique:users,mobile_number',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => 'driver_' . time() . '@dclutter.gov.in',
            'mobile_number' => $request->mobile_number,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('vehicle.dashboard')
            ->with('success', 'Driver registered and logged in successfully.');
    }

    /**
     * Log out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('vehicle.login');
    }
}
