<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminAuth;
use App\Http\Middleware\NormalUserAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::get('/register', [AuthController::class, 'showregister'])->name('register');
Route::post('/register-user', [AuthController::class, 'registerUsers'])->name('addUsers');
Route::post('/login-user', [AuthController::class, 'loginUsers'])->name('loginProcess');

Route::get('/forgot', [AuthController::class, 'showForgotPasswordForm'])->name('forgotPassword');
Route::post('/forgot', [AuthController::class, 'sendResetLink'])->name('forgotPasswordProcess');

Route::get('/reset_password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('resetPasswordForm');
Route::post('/reset_password', [AuthController::class, 'resetPassword'])->name('resetPasswordProcess');

Route::middleware(NormalUserAuth::class)->get('/profile', function () {
    $user = Auth::user();
    return view('profile', compact('user'));
})->name('profile');


Route::post('/profile-user', [AuthController::class, 'updateProfile'])->name('updateProfile');
Route::post('/logout', [AuthController::class, 'userLogout'])->name('userLogout');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'adminshowLogin'])->name('adminshowLogin');
    Route::post('/login', [AdminController::class, 'adminloginProcess'])->name('adminloginProcess');
    Route::post('/logout', [AdminController::class, 'adminlogout'])->name('adminlogout');

    // Admin user management routes - Protected by AdminAuth middleware
    Route::middleware(AdminAuth::class)->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'adminusers'])->name('adminusers');
        Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
        Route::post('/users', [AdminController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit');
        Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
        Route::put('users/{user}', [AdminController::class, 'update'])->name('users.update');
    });
});
