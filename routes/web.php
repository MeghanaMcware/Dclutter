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
use App\Http\Controllers\Vehicle\VehicleDashboardController;
use App\Http\Controllers\Vehicle\VehicleRequestController;

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
Route::view('/showcase', 'vehiclepwa.showcase');
Route::view('/registration', 'vehiclepwa.auth.registration');

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
| DCLUTTER Driver / Vehicle PWA Routes
|--------------------------------------------------------------------------
*/
Route::prefix('driver')->name('driver.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('driver.login');
    });
    Route::get('/showcase', function () {
        return view('vehiclepwa.showcase');
    })->name('showcase');
    Route::get('/login', [VehicleAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [VehicleAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [VehicleAuthController::class, 'logout'])->name('logout');
    Route::get('/register', [VehicleAuthController::class, 'showRegistrationForm'])->name('register');

    Route::get('/dashboard', [VehicleDashboardController::class, 'index'])->name('dashboard');
    Route::get('/trip-progress', [VehicleDashboardController::class, 'tripProgress'])->name('trip_progress');
    Route::get('/trip-summary', [VehicleDashboardController::class, 'tripSummary'])->name('trip_summary');
    Route::get('/profile', [VehicleDashboardController::class, 'profile'])->name('profile_settings');
    Route::get('/notifications', [VehicleDashboardController::class, 'notifications'])->name('notifications');

    Route::get('/requests', [VehicleRequestController::class, 'index'])->name('requests');
    Route::get('/route', [VehicleRequestController::class, 'route'])->name('route');
    Route::get('/stop-details', [VehicleRequestController::class, 'stopDetails'])->name('stop_details');
    Route::get('/collect-waste', [VehicleRequestController::class, 'collectWaste'])->name('collect_waste');
    Route::get('/after_pickup', [VehicleRequestController::class, 'afterPickup'])->name('after_pickup');
    Route::get('/update-status', [VehicleRequestController::class, 'updateStatus'])->name('update_status');
});

Route::get('/requests', function () {
    return view('vehiclepwa.requests.index');
});

// Vehicle login submit fallback route
Route::match(['get', 'post'], '/vehicle/login-submit', function () {
    return redirect()->route('driver.dashboard');
})->name('vehicle.login.submit');



Route::get('/admin/requests', [AdminRequestController::class, 'index'])->name('admin.requests.index');
Route::get('/admin/requests/{id}', [AdminRequestController::class, 'show'])->name('admin.requests.show');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

// Admin Vehicle Route



// Admin Masters Resource Routes
Route::prefix('admin/masters')->name('admin.masters.')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

    Route::resource('subcategories', SubcategoryController::class);
    Route::patch('subcategories/{subcategory}/toggle-status', [SubcategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');
});
  


