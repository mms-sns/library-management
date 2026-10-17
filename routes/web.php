<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SaaSPackageController;
use App\Http\Controllers\Admin\TenantLibraryController;
use App\Http\Controllers\Admin\TenantSubscriptionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IDCardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KioskController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\SeatMapController;
use App\Http\Controllers\SeatTypeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Library Tenant & Settings
    Route::get('/library', [LibraryController::class, 'show'])->name('library.show');
    Route::get('/library/edit', [LibraryController::class, 'edit'])->name('library.edit');
    Route::put('/library', [LibraryController::class, 'update'])->name('library.update');

    // Branch Management
    Route::resource('branches', BranchController::class)->except(['show']);

    // Student Management (Phase 2)
    Route::get('/students/{student}/print-id-card', [StudentController::class, 'printIdCard'])->name('students.print-id-card');
    Route::resource('students', StudentController::class);

    // Physical Library & Seat Management (Phase 3)
    Route::get('/seats/map', [SeatMapController::class, 'index'])->name('seats.map');
    Route::post('/seats/bulk-generate', [SeatController::class, 'generateBulk'])->name('seats.bulk-generate');
    Route::patch('/seats/{seat}/status', [SeatController::class, 'updateStatus'])->name('seats.update-status');
    Route::resource('seats', SeatController::class);
    Route::resource('seat-types', SeatTypeController::class)->only(['index', 'store', 'update']);

    // Membership & Plans Management (Phase 4)
    Route::post('/memberships/{membership}/renew', [MembershipController::class, 'renew'])->name('memberships.renew');
    Route::post('/memberships/{membership}/cancel', [MembershipController::class, 'cancel'])->name('memberships.cancel');
    Route::resource('memberships', MembershipController::class);
    Route::resource('membership-plans', MembershipPlanController::class)->only(['index', 'store', 'update']);

    // Fees & Financial Management (Phase 5)
    Route::prefix('fees')->group(function () {
        Route::resource('invoices', InvoiceController::class);
        Route::resource('payments', PaymentController::class)->only(['index', 'store', 'show']);
    });

    // ID Cards & QR Generation (Phase 6)
    Route::get('/id-cards/batch-print', [IDCardController::class, 'batchPrint'])->name('id-cards.batch-print');
    Route::post('/id-cards/{id_card}/revoke', [IDCardController::class, 'revoke'])->name('id-cards.revoke');
    Route::resource('id-cards', IDCardController::class)->only(['index', 'create', 'store', 'show']);

    // Attendance & Kiosk Check-In (Phase 7)
    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::patch('/attendances/{attendance}/check-out', [AttendanceController::class, 'checkOut'])->name('attendances.check-out');

    Route::get('/kiosk', [KioskController::class, 'index'])->name('kiosk.index');
    // SaaS Super Admin Platform Management Portal
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::patch('/libraries/{library}/toggle-status', [TenantLibraryController::class, 'toggleStatus'])->name('libraries.toggle-status');
        Route::resource('libraries', TenantLibraryController::class);
        Route::resource('saas-packages', SaaSPackageController::class);
        Route::resource('tenant-subscriptions', TenantSubscriptionController::class)->only(['index', 'store']);
    });

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
