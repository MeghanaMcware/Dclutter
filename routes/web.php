<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Citizen\CitizenRequestController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Vehicle\VehicleAuthController;
use App\Http\Controllers\Vehicle\VehiclePwaController;

/*
|--------------------------------------------------------------------------
| Public / Citizen Portal Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('frontend.home');
});

Route::get('/report-request', [CitizenRequestController::class, 'create'])->name('citizen.report');
Route::post('/report-request', [CitizenRequestController::class, 'store'])->name('citizen.report.store');
Route::get('/request-submitted', [CitizenRequestController::class, 'success'])->name('citizen.success');
Route::get('/lookup-ward', [CitizenRequestController::class, 'lookupWardByCoords'])->name('citizen.lookup-ward');
Route::get('/track-request', [CitizenRequestController::class, 'trackRequest'])->name('citizen.track');
Route::get('/request-details', [CitizenRequestController::class, 'requestDetails'])->name('citizen.details');

/*
|--------------------------------------------------------------------------
| Admin Portal Routes Group
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth Routes
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Requests Management
    Route::prefix('requests')->name('requests.')->group(function () {
        Route::get('/', [AdminRequestController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminRequestController::class, 'show'])->name('show');
        Route::post('/{id}/assign-vehicle', [AdminRequestController::class, 'assignVehicle'])->name('assign-vehicle');
    });

    // Masters Management (Categories, Subcategories, Users)
    Route::prefix('masters')->name('masters.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        Route::resource('subcategories', SubcategoryController::class);
        Route::patch('subcategories/{subcategory}/toggle-status', [SubcategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');

        Route::resource('users', UserController::class);
    });

    // Vehicles Resource Routes
    Route::patch('vehicles/{id}/toggle-status', [AdminVehicleController::class, 'toggleStatus'])->name('vehicles.toggle-status');
    Route::resource('vehicles', AdminVehicleController::class);
});

/*
|--------------------------------------------------------------------------
| DCLUTTER Vehicle PWA Routes
|--------------------------------------------------------------------------
*/
Route::prefix('vehicle')->name('vehicle.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('vehicle.login');
    });
    Route::get('/showcase', function () {
        return view('vehiclepwa.showcase');
    })->name('showcase');
    
    // Auth Routes
    Route::get('/login', [VehicleAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [VehicleAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [VehicleAuthController::class, 'logout'])->name('logout');
    Route::get('/register', [VehicleAuthController::class, 'showRegistrationForm'])->name('register');

    // PWA Navigation & Dashboards
    Route::get('/dashboard', [VehiclePwaController::class, 'dashboard'])->name('dashboard');
    Route::get('/requests', [VehiclePwaController::class, 'requests'])->name('requests');
    Route::get('/route', [VehiclePwaController::class, 'route'])->name('route');
    Route::get('/stop-details/{id?}', [VehiclePwaController::class, 'stopDetails'])->name('stop_details');
    Route::get('/trip-progress', [VehiclePwaController::class, 'tripProgress'])->name('trip_progress');
    Route::get('/trip-summary', [VehiclePwaController::class, 'tripSummary'])->name('trip_summary');
    Route::get('/profile', [VehiclePwaController::class, 'profile'])->name('profile_settings');
    Route::get('/notifications', [VehiclePwaController::class, 'notifications'])->name('notifications');

    // Step 1: Before Pickup
    Route::get('/before-pickup/{id?}', [VehiclePwaController::class, 'beforePickup'])->name('before_pickup');
    Route::post('/before-pickup/{id}', [VehiclePwaController::class, 'storeBeforePickup'])->name('store_before_pickup');

    // Step 2: After Pickup
    Route::get('/after-pickup/{id?}', [VehiclePwaController::class, 'afterPickup'])->name('after_pickup');
    Route::post('/after-pickup/{id}', [VehiclePwaController::class, 'storeAfterPickup'])->name('store_after_pickup');
});
