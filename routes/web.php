<?php

use App\Http\Controllers\DashbardController;
use App\Http\Controllers\KGajiController;
use App\Http\Controllers\KKontrakController;
use App\Http\Controllers\KProjectController;
use App\Http\Controllers\KUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\AutoLogout;
use Illuminate\Support\Facades\Route;

// Routes for authentication
Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


//auto Logout
Route::middleware([AutoLogout::class])->group(function () {

    //Profile
    Route::prefix('profile')->group(function () {
        Route::get('{id}',[ProfileController::class,'index'])->name('profile');
        Route::put('/update',[ProfileController::class,'update'])->name('profile.update');
    });

    Route::group(['prefix' => 'pegawai', 'middleware' => ['pegawai'], 'as' => 'pegawai.'], function () {
        //Dashboard
        Route::get('/', [DashbardController::class, 'pegawai'])->name('dashboard'); //not same

    });

    // Admin routes group with middleware and prefix
    Route::group(['prefix' => 'hc', 'middleware' => ['hc'], 'as' => 'hc.'], function () {
        // Dashboard
        Route::get('/', [DashbardController::class, 'hc'])->name('dashboard'); //not same

        // Manage Employees
        Route::prefix('k-user')->group(function () {
            Route::get('/',[KUserController::class,'index'])->name('kelola-user');
            Route::get('/add',[KUserController::class,'add'])->name('kelola-user.add');
            Route::post('/store',[KUserController::class,'store'])->name('kelola-user.store');
            Route::get('/active/{id}',[KUserController::class,'active'])->name('kelola-user.active');
            Route::get('/nonactive/{id}',[KUserController::class,'nonactive'])->name('kelola-user.nonactive');
            Route::put('/update/{id}',[KUserController::class,'update'])->name('kelola-user.update');
            Route::delete('/delete/{id}',[KUserController::class,'delete'])->name('kelola-user.delete');
        });
        
        //K Project
        Route::prefix('k-project')->group(function () {
            Route::get('/',[KProjectController::class,'index'])->name('kelola-project');
            Route::get('/add',[KProjectController::class,'add'])->name('kelola-project.add');
            Route::post('/store',[KProjectController::class,'store'])->name('kelola-project.store');
            Route::put('/update/{id}',[KProjectController::class,'update'])->name('kelola-project.update');
            Route::delete('/delete/{id}',[KProjectController::class,'delete'])->name('kelola-project.delete');

        });
        //K Gaji
        Route::prefix('k-gaji')->group(function () {
            Route::get('/',[KGajiController::class,'index'])->name('kelola-gaji');
        });
        Route::prefix('k-kontrak')->group(function () {
            Route::get('/',[KKontrakController::class,'index'])->name('kelola-kontrak');
        });
    });

    
    Route::group(['prefix' => 'manajerhc', 'middleware' => ['manajerhc'], 'as' => 'manajerhc.'], function () {
        Route::get('/', [DashbardController::class, 'manajerhc'])->name('dashboard'); //not same
        
    });

    Route::group(['prefix' => 'kapro', 'middleware' => ['kapro'], 'as' => 'kapro.'], function () {
        Route::get('/', [DashbardController::class, 'kapro'])->name('dashboard'); //not same

        // Manage Employees
        Route::prefix('k-user')->group(function () {
            Route::get('/',[KUserController::class,'index'])->name('kelola-user');
            Route::get('/add',[KUserController::class,'add'])->name('kelola-user.add');
            Route::post('/store',[KUserController::class,'store'])->name('kelola-user.store');
            Route::get('/active/{id}',[KUserController::class,'active'])->name('kelola-user.active');
            Route::get('/nonactive/{id}',[KUserController::class,'nonactive'])->name('kelola-user.nonactive');
            Route::put('/update/{id}',[KUserController::class,'update'])->name('kelola-user.update');
            Route::delete('/delete/{id}',[KUserController::class,'delete'])->name('kelola-user.delete');
        });
        Route::prefix('project')->group(function () {
            Route::get('/',[ProjectController::class,'index'])->name('project');
            Route::get('/detail/{id}',[ProjectController::class,'detail'])->name('project.detail');
            Route::post('/addUser',[ProjectController::class,'addUser'])->name('project.addUser');
            Route::post('/activate/{id}',[ProjectController::class,'activate'])->name('project.activate');
            Route::post('/complete/{id}',[ProjectController::class,'complete'])->name('project.complete');
        });
        
    });

    Route::group(['prefix' => 'pusat', 'middleware' => ['pusat'], 'as' => 'pusat.'], function () {
        Route::get('/', [DashbardController::class, 'pusat'])->name('dashboard'); //not same
        
    });
    
});