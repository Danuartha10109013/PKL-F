<?php

use App\Events\NotifikasiBaru;
use App\Http\Controllers\DashbardController;
use App\Http\Controllers\DataMasterController;
use App\Http\Controllers\KGajiController;
use App\Http\Controllers\KKontrakController;
use App\Http\Controllers\KProjectController;
use App\Http\Controllers\KUserController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajerHcController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PerpanjangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\AutoLogout;
use App\Models\NotifM;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Routes for authentication
Route::get('/', [LoginController::class, 'index'])->name('auth.login');
Route::post('/login-proses', [LoginController::class, 'login_proses'])->name('login-proses');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/notif/mark-selected', function (Request $request) {
    $ids = $request->input('ids', []);
    if (!empty($ids)) {
        NotifM::whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->update(['status' => 1]);
    }
    return response()->json(['success' => true]);
});


Route::post('/notif/clear-selected', function (Request $request) {
    $ids = $request->input('ids', []);
    
    if (!empty($ids)) {
        \App\Models\NotifM::whereIn('id', $ids)
            ->where('user_id', auth()->id())
            ->update(['status' => 2]);
    }
    
    return response()->json(['success' => true]);
});



//auto Logout
Route::middleware([AutoLogout::class])->group(function () {

    //Profile
    Route::prefix('profile')->group(function () {
        Route::get('{id}',[ProfileController::class,'index'])->name('profile');
        Route::put('/update',[ProfileController::class,'update'])->name('profile.update');
    });

    Route::group(['prefix' => 'pegawai', 'middleware' => ['pegawai'], 'as' => 'pegawai.'], function () {
        //Dashboard
        Route::get('/', [DashbardController::class, 'pegawai'])->name('dashboard'); 
        Route::prefix('project')->group(function () {
            Route::get('/', [PegawaiController::class, 'project'])->name('project'); 
            Route::get('/laporan/{id}', [PegawaiController::class, 'laporan'])->name('project.laporan'); 
            Route::get('/detail/{id}', [PegawaiController::class, 'detail'])->name('project.detail'); 
            Route::put('/update/{id}', [PegawaiController::class, 'update'])->name('project.update'); 
        
        });
        Route::prefix('kontrak')->group(function () {
            Route::get('/', [PegawaiController::class, 'kontrak'])->name('kontrak'); 
            Route::get('/show/{id}', [PegawaiController::class, 'kontrak_show'])->name('kontrak.show'); 
            Route::get('/print/{id}',[KKontrakController::class,'print'])->name('kontrak.print');
        });

    });

    // Admin routes group with middleware and prefix
    Route::group(['prefix' => 'hc', 'middleware' => ['hc'], 'as' => 'hc.'], function () {
        // Dashboard
        Route::get('/', [DashbardController::class, 'hc'])->name('dashboard'); //not same

        // Manage Employees
        Route::prefix('k-user')->group(function () {
            Route::get('/',[KUserController::class,'index'])->name('kelola-user');
            // Route::get('/add',[KUserController::class,'add'])->name('kelola-user.add');
            Route::post('/store',[KUserController::class,'store'])->name('kelola-user.store');
            Route::get('/active/{id}',[KUserController::class,'active'])->name('kelola-user.active');
            Route::get('/nonactive/{id}',[KUserController::class,'nonactive'])->name('kelola-user.nonactive');
            Route::post('/perpanjang/{id}',[KUserController::class,'perpanjang'])->name('kelola-user.perpanjang');
            Route::put('/update/{id}',[KUserController::class,'update'])->name('kelola-user.update');
            Route::delete('/delete/{id}',[KUserController::class,'delete'])->name('kelola-user.delete');
            Route::get('/export',[KUserController::class,'export'])->name('kelola-user.export');
        });
        
        //K Project
        Route::prefix('k-project')->group(function () {
            Route::get('/',[KProjectController::class,'index'])->name('kelola-project');
            Route::get('/add',[KProjectController::class,'add'])->name('kelola-project.add');
            Route::post('/store',[KProjectController::class,'store'])->name('kelola-project.store');
            Route::get('/detail/{id}',[ProjectController::class,'detail'])->name('kelola-project.detail');
            Route::put('/update/{id}',[KProjectController::class,'update'])->name('kelola-project.update');
            Route::delete('/delete/{id}',[KProjectController::class,'delete'])->name('kelola-project.delete');
            Route::get('/laporan/{id}/{id1}/{m}',[LaporanController::class,'laporan'])->name('project.laporan');
            Route::get('/laporan/kapro/karpo/{id}',[LaporanController::class,'laporankapro'])->name('project.laporan.ketua.project');
            Route::get('/print/{id}',[ProjectController::class,'print'])->name('project.print');
        });
        //K Gaji
        Route::prefix('k-gaji')->group(function () {
            Route::get('/',[KGajiController::class,'index'])->name('kelola-gaji');
        });
        Route::prefix('k-kontrak')->group(function () {
            Route::get('/',[KKontrakController::class,'index'])->name('kelola-kontrak');
            Route::get('/export',[KKontrakController::class,'export'])->name('kelola-kontrak.export');
            Route::get('/show/{id}',[KKontrakController::class,'show'])->name('kelola-kontrak.show');
            Route::get('/print/{id}',[KKontrakController::class,'print'])->name('kelola-kontrak.print');
        });
        Route::prefix('k-data-master')->group(function () {
            Route::get('/',[DataMasterController::class,'index'])->name('k-data-master');
            Route::post('/{type}/store', [DataMasterController::class, 'store'])->name('k-data-master.store');
            Route::put('/{id}/edit', [DataMasterController::class, 'edit'])->name('k-data-master.edit');
            Route::delete('/{id}/delete', [DataMasterController::class, 'delete'])->name('k-data-master.delete');
        });
    });

    
    Route::group(['prefix' => 'manajerhc', 'middleware' => ['manajerhc'], 'as' => 'manajerhc.'], function () {
        Route::get('/', [DashbardController::class, 'manajerhc'])->name('dashboard'); //not same

        Route::prefix('laporan')->group(function () {
            Route::get('/',[ManajerHcController::class,'index'])->name('project');
            Route::get('/project/{id}',[ManajerHcController::class,'detail'])->name('project.detail');
            Route::get('/project/laporan/{id}',[ManajerHcController::class,'laporankapro'])->name('project.laporan');
            Route::get('/project/laporan/pegawai/{id}/{id1}/{m}',[LaporanController::class,'laporan'])->name('project.laporanpegawai');
            Route::get('/print/{id}',[ProjectController::class,'print'])->name('project.print');
            
        });
        Route::prefix('kontrak')->group(function () {
            Route::get('/',[KKontrakController::class,'index'])->name('kontrak');
            Route::get('/export',[KKontrakController::class,'export'])->name('kontrak.export');
            Route::get('/show/{id}',[KKontrakController::class,'show'])->name('kontrak.show');
            Route::get('/print/{id}',[KKontrakController::class,'print'])->name('kontrak.print');

            
        });
        Route::prefix('history-kontrak')->group(function () {
            Route::get('/',[ManajerHcController::class,'history'])->name('history-kontrak');

        });

        Route::prefix('perpanjang')->group(function () {
            Route::get('/',[PerpanjangController::class,'index'])->name('perpanjang');
            Route::post('/perpanjang/{id}',[KUserController::class,'perpanjang'])->name('perpanjang.post');
        });
        
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
            Route::get('/complete/{id}',[ProjectController::class,'complete'])->name('project.complete');
            Route::delete('/delete/{id}/{pid}',[ProjectController::class,'delete_user'])->name('project.delete.user');
            Route::post('/nilaiUser/{id}/{pid}/{m}',[ProjectController::class,'nilaiUser'])->name('project.nilaiUser');
            Route::get('/laporan/{id}/{id1}/{m}',[LaporanController::class,'laporan'])->name('project.laporan');
            Route::get('/isilaporan/{id}', [ProjectController::class, 'isilaporan'])->name('project.laporan.isi'); 
            Route::put('/update/{id}', [ProjectController::class, 'isiupdate'])->name('project.update.isi'); 
            Route::get('/print/{id}',[ProjectController::class,'print'])->name('project.print');

        });
        
    });

    Route::group(['prefix' => 'pusat', 'middleware' => ['pusat'], 'as' => 'pusat.'], function () {
        Route::get('/', [DashbardController::class, 'pusat'])->name('dashboard'); //not same
        
    });
    
});

Route::fallback(function () {
    abort(404);
});
