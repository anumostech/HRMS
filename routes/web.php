<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Artisan;

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetCode'])->name('password.email');
Route::get('/reset-password/{email}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/upload', [AttendanceController::class, 'create'])->name('attendance.upload');
    Route::post('/attendance/upload', [AttendanceController::class, 'store'])->name('attendance.store');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'changePassword'])->name('profile.password');
});



Route::get('/run-migrations', function () {
    Artisan::call('migrate:fresh', ['--force' => true]);
    return 'Migration runned successfully';
});


Route::get('/run-seeder', function () {
    Artisan::call('db:seed', ['--force' => true]);
    return 'Database seeded successfully';
});

Route::get('/optimize-clear', function () {
    Artisan::call('optimize:clear');
    return 'Optimization cache cleared';
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return 'Storage linked';
});