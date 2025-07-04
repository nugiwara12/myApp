<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request; // ✅ this one


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Shared dashboard redirect
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return match (true) {
            $user->hasRole('admin') => redirect()->route('admin.dashboard'),
            $user->hasRole('user') => redirect()->route('user.dashboard'),
            $user->hasRole('staff') => redirect()->route('staff.dashboard'),
            $user->hasRole('encoder') => redirect()->route('encoder.dashboard'),
            default => abort(403),
        };
    })->name('dashboard');

    // Individual role dashboards
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/user/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');

    Route::get('/staff/dashboard', function () {
        return view('staff.dashboard');
    })->name('staff.dashboard');

    Route::get('/encoder/dashboard', function () {
        return view('encoder.dashboard');
    })->name('encoder.dashboard');
});


// Add this outside of your 'auth' middleware group
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
