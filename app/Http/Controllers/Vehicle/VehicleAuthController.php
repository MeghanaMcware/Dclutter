<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleAuthController extends Controller
{
    /**
     * Show the vehicle driver PWA login screen.
     */
    public function showLoginForm()
    {
        return view('vehiclepwa.auth.login');
    }

    /**
     * Handle vehicle driver authentication submit.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'mobile_number' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(['mobile_number' => $request->mobile_number, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('driver.dashboard');
        }

        return redirect()->route('driver.dashboard');
    }

    /**
     * Show vehicle driver registration form.
     */
    public function showRegistrationForm()
    {
        return view('vehiclepwa.register');
    }

    /**
     * Log driver out.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('driver.login');
    }
}
