<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/', [AuthenticatedSessionController::class, 'store']);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/attendances/{id}/print', [AttendanceController::class, 'print'])->name('attendances.print');
    Route::get('/attendances/export/pdf', [AttendanceController::class, 'exportPdf'])->name('attendances.export.pdf');
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::resource('/attendances', AttendanceController::class);
    Route::resource('/mobils', MobilController::class);
    Route::resource('/users', UserController::class);
});

Route::middleware(['auth', 'role:supir'])->prefix('supir')->group(function () {
    Route::get('/dashboard', [AttendanceController::class, 'supirDashboard'])
        ->name('supir.dashboard');

    Route::get('attendances', [AttendanceController::class, 'supirIndex'])
        ->name('supir.attendances.index');

    Route::get('attendances/{attendance}/edit', [AttendanceController::class, 'supirEdit'])
        ->name('supir.attendances.edit');

    Route::patch('attendances/{attendance}', [AttendanceController::class, 'supirUpdate'])
        ->name('supir.attendances.update');

});

require __DIR__ . '/auth.php';
