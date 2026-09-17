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
        return view('vehiclepwa.auth.login');
    }

    /**
     * Handle vehicle authentication submit.
     */
    public function login(Request $request)
    {
        $mobile = trim($request->input('mobile_number') ?: $request->input('mobile', ''));
        $password = $request->input('password') ?: $request->input('password_emp', '');

        if (empty($mobile) || empty($password)) {
            return back()->withInput()->withErrors([
                'mobile' => 'Please enter both mobile number and password.',
            ]);
        }

        // If currently authenticated as another user, log out old session to allow switching
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $matchedUser = null;

        // 1. Check if user exists with this mobile number or email and verify password
        $user = User::where('mobile_number', $mobile)->orWhere('email', $mobile)->first();
        if ($user && Hash::check($password, $user->password)) {
            $matchedUser = $user;
        }

        // 2. If not matched directly, check if input matches vehicle number or driver_phone
        if (!$matchedUser) {
            $vehicle = Vehicle::where('driver_phone', $mobile)
                ->orWhere('vehicle_number', $mobile)
                ->first();

            if ($vehicle) {
                // Check if driver has a user account
                $driverUser = User::where('mobile_number', $vehicle->driver_phone)->first();
                if ($driverUser && Hash::check($password, $driverUser->password)) {
                    $matchedUser = $driverUser;
                } elseif ($vehicle->user_id) {
                    // Check if owner user exists and password matches
                    $owner = User::find($vehicle->user_id);
                    if ($owner && Hash::check($password, $owner->password)) {
                        $matchedUser = $owner;
                    }
                }

                if (!$matchedUser) {
                    return back()->withInput()->withErrors([
                        'mobile' => 'Invalid password for this vehicle or driver.',
                    ]);
                }
            }
        }

        // If credentials did not match any user
        if (!$matchedUser) {
            return back()->withInput()->withErrors([
                'mobile' => 'Invalid mobile number or password. Please check your credentials.',
            ]);
        }

        // 3. Strict Check: User MUST have the 'vehicle' role
        if (!$matchedUser->hasRole('vehicle')) {
            return back()->withInput()->withErrors([
                'mobile' => 'Access denied. Your account does not have the vehicle role.',
            ]);
        }

        // 4. Log in and redirect to dashboard
        Auth::login($matchedUser);
        $request->session()->regenerate();
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

        if (class_exists(\Spatie\Permission\Models\Role::class)) {
            $vehicleRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'vehicle', 'guard_name' => 'web']);
            $user->assignRole($vehicleRole);
        }

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
