<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleDashboardController extends Controller
{
    /**
     * Display the vehicle driver PWA dashboard screen.
     */
    public function index()
    {
        return view('vehiclepwa.dashboard');
    }

    /**
     * Display trip progress screen.
     */
    public function tripProgress()
    {
        return view('vehiclepwa.trip_progress');
    }

    /**
     * Display trip summary screen.
     */
    public function tripSummary()
    {
        return view('vehiclepwa.trip_summary');
    }

    /**
     * Display driver profile settings.
     */
    public function profile()
    {
        return view('vehiclepwa.profile_settings');
    }

    /**
     * Display driver notifications.
     */
    public function notifications()
    {
        return view('vehiclepwa.notifications');
    }
}
