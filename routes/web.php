<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PasswordChangeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\IndigencyController;
use App\Http\Controllers\ResidencyController;
use App\Http\Controllers\BarangayIdController;
use App\Http\Controllers\BarangayServiceController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Landing\DocumentRequestController;
use App\Http\Controllers\Auth\CustomAuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;


// Public Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// PASSWORD CHANGE ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/password/change', [PasswordChangeController::class, 'edit'])->name('password.change');
    Route::post('/password/change', [PasswordChangeController::class, 'update'])->name('password.update');
});

// EMAIL VERIFICATION ROUTES
Route::middleware('auth')->group(function () {
    // Show verification notice page
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    // Handle verification when user clicks link in email
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard');
    })->middleware('signed')->name('verification.verify');

    // ✅ Resend verification email (fixed session key)
    Route::post('/email/verification-notification', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended('/dashboard');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent'); // ✅ FIXED HERE
    })->middleware('throttle:6,1')->name('verification.send');
});

// DASHBOARD REDIRECTION
Route::middleware(['auth', 'verified', 'ensure.password.changed'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return match (true) {
            // $user->hasRole('superadmin') => redirect()->route('superadmin.dashboard'),
            $user->hasRole('admin') => redirect()->route('admin.dashboard'),
            $user->hasRole('user') => redirect()->route('user.dashboard'),
            default => abort(403),
        };
    })->name('dashboard');
});

// Route::post('/login', [CustomAuthenticatedSessionController::class, 'store']);
Route::post('/login', [LoginController::class, 'login'])->name('login.perform');


// ADMIN DASHBOARD (Requires password.changed middleware)
Route::middleware(['auth', 'ensure.password.changed'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// // SUPERADMIN DASHBOARD
// Route::middleware(['auth'])->group(function () {
//     Route::get('/superadmin/dashboard', fn() => view('superadmin.dashboard'))->name('superadmin.dashboard');
// });

// USER DASHBOARD
Route::middleware(['auth', 'ensure.password.changed'])->group(function () {
    Route::get('/user/dashboard', fn() => view('user.dashboard'))->name('user.dashboard');
});

// USER MANAGEMENT ROUTES
Route::get('/role-management', [UserManagementController::class, 'index'])->name('role-management.index');
Route::post('/addUser', [UserManagementController::class, 'addUser'])->name('addUser');
Route::put('/updateUser/{id}', [UserManagementController::class, 'UpdateUser'])->name('UpdateUser');
Route::get('/userDetails', [UserManagementController::class, 'userDetails'])->name('userDetails');
Route::get('/getRoles', [UserManagementController::class, 'getRoles'])->name('getRoles');
Route::delete('/deleteUser/{id}', [UserManagementController::class, 'deleteUser'])->name('deleteUser');
Route::post('/restoreUser/{id}', [UserManagementController::class, 'restoreUser'])->name('restoreUser');
Route::get('/activity-logs', [UserManagementController::class, 'activityLogs'])->name('activity-logs');


// FEEDBACK
Route::get('/getFeedback', [FeedbackController::class, 'getFeedback'])->name('getFeedback');
Route::get('/feedbacks', [FeedbackController::class, 'index'])->name('feedbacks');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::delete('/feedback/{id}', [FeedbackController::class, 'destroy']);
Route::post('/feedback/bulk-delete', [FeedbackController::class, 'bulkDelete']);

// INDIGENCY
Route::get('/indigency', [IndigencyController::class, 'index'])->name('indigency.index');
Route::post('/addIndigency', [IndigencyController::class, 'addIndigency'])->name('addIndigency');
Route::get('/getIndigencies', [IndigencyController::class, 'getIndigencies'])->name('getIndigencies');
Route::post('/indigency/{id}/delete', [IndigencyController::class, 'delete']);
Route::post('/deleteSelectedIndigencies', [IndigencyController::class, 'deleteSelected'])->name('deleteSelectedIndigencies');
Route::post('/restoreIndigencies', [IndigencyController::class, 'restore'])->name('restoreIndigencies');
Route::put('/updateIndigency/{id}', [IndigencyController::class, 'updateIndigency'])->name('updateIndigency');
Route::get('/indigency/pdf/{id}', [IndigencyController::class, 'showIndigencyPdf'])->name('indigency.pdf');
Route::post('/indigency/{id}/approve', [IndigencyController::class, 'approveIndigency']);
Route::post('/approvedIndigency/{id}', [IndigencyController::class, 'approvedIndigency'])->name('approvedIndigency');

// RESIDENCY
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

// BARANGAY ID
Route::get('/main', [BarangayIdController::class, 'main'])->name('barangayId.index');
Route::post('/addBarangayId', [BarangayIdController::class, 'addBarangayId'])->name('addBarangayId');
Route::get('/list', [BarangayIdController::class, 'getBarangayIdList']);
Route::get('/getBarangayIdInformation/{id}', [BarangayIdController::class, 'getBarangayIdInformation'])->name('getBarangayIdInformation');
Route::post('barangay-id/{id}/approve', [BarangayIdController::class, 'approvedBarangayId'])->name('barangay-id.approve');
Route::post('barangay-id/update/{id}', [BarangayIdController::class, 'updateBarangayId'])->name('barangay-id.update');
Route::post('barangay-id/delete/{id}', [BarangayIdController::class, 'delete'])->name('barangay-id.delete');
Route::post('/deleteSelected', [BarangayIdController::class, 'deleteSelected'])->name('deleteSelected');
Route::post('barangay-id/restore', [BarangayIdController::class, 'restore'])->name('barangay-id.restore');
Route::get('barangayPdf/{id}', [BarangayIdController::class, 'barangayPdf'])->name('barangayPdf');

// TRACKING SERVICE
Route::get('/track/{trackingNumber}', [BarangayServiceController::class, 'trackRequest']);
