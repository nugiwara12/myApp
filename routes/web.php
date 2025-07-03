<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
