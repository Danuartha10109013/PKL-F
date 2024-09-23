<?php

use App\Http\Controllers\DashbardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AutoLogout;
use Illuminate\Support\Facades\Route;

// Routes for authentication
Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


//auto Logout
Route::middleware([AutoLogout::class])->group(function () {

    // Admin routes group with middleware and prefix
    Route::group(['prefix' => 'admin', 'middleware' => ['admin'], 'as' => 'admin.'], function () {
        // Dashboard
        Route::get('/', [DashbardController::class, 'admin'])->name('dashboard'); //not same

        // Manage Employees
        Route::prefix('managepegawai.kelolapegawai')->group(function () {
            
        });
    });
    Route::group(['prefix' => 'pegawai', 'middleware' => ['pegawai'], 'as' => 'pegawai.'], function () {
        //Dashboard
        Route::get('/', [DashbardController::class, 'pegawai'])->name('dashboard'); //not same

        Route::prefix('profile')->group(function () {
            Route::get('/{id}',[ProfileController::class,'index'])->name('profile');
            Route::put('/update',[ProfileController::class,'update'])->name('profile.update');
        });
    });
    
});