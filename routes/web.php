<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request; // ✅ this one
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\IndigencyController;
use App\Http\Controllers\ClearanceController;
use App\Http\Controllers\ResidencyController;
use App\Http\Controllers\BarangayIdController;


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
            // $user->hasRole('staff') => redirect()->route('staff.dashboard'),
            // $user->hasRole('encoder') => redirect()->route('encoder.dashboard'),
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

    // Route::get('/staff/dashboard', function () {
    //     return view('staff.dashboard');
    // })->name('staff.dashboard');

    // Route::get('/encoder/dashboard', function () {
    //     return view('encoder.dashboard');
    // })->name('encoder.dashboard');
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


// User Management
Route::get('/role-management', [UserManagementController::class, 'index'])->name('role-management.index');
Route::post('/addUser', [UserManagementController::class, 'addUser'])->name('addUser');
Route::put('/updateUser/{id}', [UserManagementController::class, 'UpdateUser'])->name('UpdateUser');
Route::get('/userDetails', [UserManagementController::class, 'userDetails'])->name('userDetails');
Route::get('/getRoles', [UserManagementController::class, 'getRoles'])->name('getRoles');
Route::delete('/deleteUser/{id}', [UserManagementController::class, 'deleteUser'])->name('deleteUser');
Route::post('/restoreUser/{id}', [UserManagementController::class, 'restoreUser'])->name('restoreUser');
Route::get('/activity-logs', [UserManagementController::class, 'activityLogs'])->name('activity-logs');


// FeedBack
Route::get('/getFeedback', [FeedbackController::class, 'getFeedback'])->name('getFeedback');
Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy']);
Route::post('/feedback/bulk-delete', [FeedbackController::class, 'bulkDelete']);

// Indigency
Route::get('/indigency', [IndigencyController::class, 'index'])->name('indigency.index');
Route::post('/addIndigency', [IndigencyController::class, 'addIndigency'])->name('addIndigency');
Route::get('/getIndigencies', [IndigencyController::class, 'getIndigencies'])->name('getIndigencies');
Route::post('/indigency/{id}/delete', [IndigencyController::class, 'delete']);
Route::post('/deleteSelectedIndigencies', [IndigencyController::class, 'deleteSelected'])->name('deleteSelectedIndigencies');
Route::post('/restoreIndigencies', [IndigencyController::class, 'restore'])->name('restoreIndigencies');
Route::put('/updateIndigency/{id}', [IndigencyController::class, 'updateIndigency'])->name('updateIndigency');
Route::get('/indigency/pdf/{id}', [IndigencyController::class, 'showIndigencyPdf'])->name('indigency.pdf');
Route::post('/indigency/{id}/approve', [IndigencyController::class, 'approveIndigency']);
Route::post('/barangay-indigency/{id}/approve', [IndigencyController::class, 'approvedIndigency'])->name('barangay-indigency.approve');


// clearance
// Route::get('/clearance', [ClearanceController::class, 'index'])->name('clearance.index');
// Route::post('/addClearance', [ClearanceController::class, 'addClearance'])->name('addClearance');
// Route::get('/getIndClearance', [ClearanceController::class, 'getIndClearance'])->name('getIndClearance');
// Route::put('/updateClearance/{id}', [ClearanceController::class, 'updateClearance'])->name('updateClearance');
// Route::get('/getClearanceById/{id}', [ClearanceController::class, 'getClearanceById'])->name('getClearanceById');
// Route::post('/clearance/{id}/approve', [ClearanceController::class, 'approveClearance']);

// Route::post('/clearance/{id}/delete', [ClearanceController::class, 'delete']);
// Route::post('/deleteSelectedClearance', [ClearanceController::class, 'deleteSelected'])->name('deleteSelectedClearance');
// Route::post('/restoreClearance', [ClearanceController::class, 'restore'])->name('restoreClearance');
// Route::get('/clearance/pdf/{id}', [ClearanceController::class, 'showClearancePdf'])->name('clearance.pdf');


// Residence
Route::get('/residence', [ResidencyController::class, 'index'])->name('residence.index');
Route::post('/addResidence', [ResidencyController::class, 'addResidence'])->name('addResidence');
Route::put('/updateResidence/{id}', [ResidencyController::class, 'updateResidence'])->name('updateResidence');
Route::delete('/residence/{id}', [ResidencyController::class, 'destroy'])->name('residence.destroy');
Route::get('/getResidenceInformation/{id?}', [ResidencyController::class, 'getResidenceInformation'])->name('getResidenceInformation');
Route::post('/residency/{id}/approve', [ResidencyController::class, 'approveResidence']);
Route::post('/residency/{id}/delete', [ResidencyController::class, 'delete']);
Route::post('/residency/delete-selected', [ResidencyController::class, 'deleteSelected'])->name('deleteSelectedResidencies');
Route::post('/residency/restore', [ResidencyController::class, 'restore'])->name('restoreResidencies');
Route::get('/residencePdf/{id}', [ResidencyController::class, 'residencePdf'])->name('residencePdf');
Route::post('/approvedFIle/{id}', [ResidencyController::class, 'approvedFIle'])->name('approvedFIle');


// Barangay ID
Route::get('/barangayId/main', [BarangayIdController::class, 'main'])->name('barangayId.index');
Route::post('/addBarangayId', [BarangayIdController::class, 'addBarangayId'])->name('addBarangayId');
Route::get('/getBarangayIdList', [BarangayIdController::class, 'getBarangayIdList']);
Route::post('/barangay-id/{id}/approve', [BarangayIdController::class, 'approvedBarangayId'])->name('barangay-id.approve');
Route::post('/barangay-id/update/{id}', [BarangayIdController::class, 'updateBarangayId'])->name('barangay-id.update');
Route::get('/getBarangayIdInformation/{id}', [BarangayIdController::class, 'getBarangayIdInformation']);

Route::post('/barangay-id/delete/{id}', [BarangayIdController::class, 'delete'])->name('barangay-id.delete');
Route::post('/barangay-id/delete-selected', [BarangayIdController::class, 'deleteSelected'])->name('barangay-id.deleteSelected');
Route::post('/barangay-id/restore', [BarangayIdController::class, 'restore'])->name('barangay-id.restore');
Route::get('/barangayPdf/{id}', [BarangayIdController::class, 'barangayPdf'])->name('barangayPdf');
