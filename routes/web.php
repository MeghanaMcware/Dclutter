<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Citizen\CitizenRequestController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminRequestController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubcategoryController;

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

    // Masters Management (Categories & Subcategories)
    Route::prefix('masters')->name('masters.')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        Route::resource('subcategories', SubcategoryController::class);
        Route::patch('subcategories/{subcategory}/toggle-status', [SubcategoryController::class, 'toggleStatus'])->name('subcategories.toggle-status');
    });

    // Vehicles Resource Routes
    Route::patch('vehicles/{id}/toggle-status', [AdminVehicleController::class, 'toggleStatus'])->name('vehicles.toggle-status');
    Route::resource('vehicles', AdminVehicleController::class);
});

/*
|--------------------------------------------------------------------------
| DCLUTTER Driver PWA Routes (All 10 Screens)
|--------------------------------------------------------------------------
*/
Route::prefix('driver')->group(function () {
    Route::get('/', function () {
        return redirect()->route('driver.login');
    });
    Route::get('/showcase', function () {
        return view('vehiclepwa.showcase');
    })->name('driver.showcase');
    Route::get('/login', function () {
        return view('vehiclepwa.auth.login');
    })->name('driver.login');

    Route::get('/registration', function () {
        return view('vehiclepwa.auth.registration');
    })->name('auth.registration');

    Route::get('/register', function () {
        return view('vehiclepwa.register');
    })->name('driver.register');
    Route::get('/dashboard', function () {
        return view('vehiclepwa.dashboard');
    })->name('driver.dashboard');
    Route::get('/route', function () {
        return view('vehiclepwa.route');
    })->name('driver.route');
    Route::get('/stop-details', function () {
        return view('vehiclepwa.stop_details');
    })->name('driver.stop_details');
    Route::get('/collect-waste', function () {
        return view('vehiclepwa.collect_waste');
    })->name('driver.collect_waste');
    Route::get('/after_pickup', function () {
        return view('vehiclepwa.updated.after_pickup');
    })->name('driver.after_pickup');
    Route::get('/update-status', function () {
        return view('vehiclepwa.updated.update_status');
    })->name('driver.update_status');
    Route::get('/trip-progress', function () {
        return view('vehiclepwa.trip_progress');
    })->name('driver.trip_progress');
    Route::get('/trip-summary', function () {
        return view('vehiclepwa.trip_summary');
    })->name('driver.trip_summary');
    Route::get('/requests', function () {
        return view('vehiclepwa.requests.index');
    })->name('driver.requests');
    Route::get('/notifications', function () {
        return view('vehiclepwa.notifications');
    })->name('driver.notifications');
    Route::get('/profile', function () {
        return view('vehiclepwa.profile_settings');
    })->name('driver.profile_settings');
});

Route::get('/requests', function () {
    return view('vehiclepwa.requests.index');
});

// Vehicle login submit fallback route
Route::match(['get', 'post'], '/vehicle/login-submit', function () {
    return redirect()->route('driver.dashboard');
})->name('vehicle.login.submit');