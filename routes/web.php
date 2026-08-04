<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('frontend.home');
});

Route::view('/report-request', 'frontend.report_request')->name('citizen.report');
Route::view('/track-request', 'frontend.track_request')->name('citizen.track');
Route::view('/request-details', 'frontend.request_details')->name('citizen.details');
Route::view('/request-submitted', 'frontend.request_submitted')->name('citizen.success');
Route::view('/showcase', 'vehiclepwa.showcase');

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
    Route::get('/update-status', function () {
        return view('vehiclepwa.update_status');
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

