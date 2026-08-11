<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleRequestController extends Controller
{
    /**
     * Display assigned waste requests and map screen for vehicle driver.
     */
    public function index()
    {
        return view('vehiclepwa.requests.index');
    }

    /**
     * Display route navigation map.
     */
    public function route()
    {
        return view('vehiclepwa.route');
    }

    /**
     * Display stop details.
     */
    public function stopDetails()
    {
        return view('vehiclepwa.stop_details');
    }

    /**
     * Display collect waste screen.
     */
    public function collectWaste()
    {
        return view('vehiclepwa.collect_waste');
    }

    /**
     * Display after pickup screen.
     */
    public function afterPickup()
    {
        return view('vehiclepwa.updated.after_pickup');
    }

    /**
     * Display update status screen.
     */
    public function updateStatus()
    {
        return view('vehiclepwa.updated.update_status');
    }
}
