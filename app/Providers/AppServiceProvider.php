<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Visitor;
use App\Models\Vehicle;
use App\Models\Request as WasteRequest;
use App\Models\Dump;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Share visitor count with all views (Direct DB query without cache)
        View::composer('*', function ($view) {
            try {
                $visitorCount = Schema::hasTable('visitors') ? Visitor::count() : 0;
            } catch (\Throwable $e) {
                $visitorCount = 0;
            }
            $view->with('visitorCount', $visitorCount);
        });

        // Share vehicle navigation badges with all vehiclepwa views
        View::composer(['vehiclepwa.*', 'vehiclepwa.layout.*'], function ($view) {
            $navVehicleRequestsCount = 0;
            $navVehiclePendingDumpsCount = 0;
            $navVehicleTotalDumpsCount = 0;
            $navVehicleDumpsCount = 0;

            try {
                if (Auth::check()) {
                    $user = Auth::user();
                    $vehicle = Vehicle::where('user_id', $user->id)
                        ->orWhere('driver_phone', $user->mobile_number)
                        ->first();

                    if ($vehicle) {
                        $vehicleId = $vehicle->id;

                        // Assigned requests pending pickup (assigned + rescheduled)
                        $navVehicleRequestsCount = WasteRequest::where('vehicle_id', $vehicleId)
                            ->whereIn('status', ['assigned', 'not_available', 'rescheduled'])
                            ->count();

                        // Requests picked up waiting to be dumped at the plant
                        $navVehiclePendingDumpsCount = WasteRequest::where('vehicle_id', $vehicleId)
                            ->where('status', 'picked_up')
                            ->count();

                        // Total dump events completed by this vehicle
                        $navVehicleTotalDumpsCount = Dump::where('vehicle_id', $vehicleId)->count();

                        // Dump badge count: show pending dumps if any, otherwise total completed dumps
                        $navVehicleDumpsCount = $navVehiclePendingDumpsCount > 0
                            ? $navVehiclePendingDumpsCount
                            : $navVehicleTotalDumpsCount;
                    }
                }
            } catch (\Throwable $e) {
                // Fail-safe default
            }

            $view->with([
                'navVehicleRequestsCount' => $navVehicleRequestsCount,
                'navVehiclePendingDumpsCount' => $navVehiclePendingDumpsCount,
                'navVehicleTotalDumpsCount' => $navVehicleTotalDumpsCount,
                'navVehicleDumpsCount' => $navVehicleDumpsCount,
            ]);
        });
    }
}