<?php

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckHC;
use App\Http\Middleware\CheckKapro;
use App\Http\Middleware\CheckManajerHC;
use App\Http\Middleware\CheckPegawai;
use App\Http\Middleware\CheckPusat;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('hc', [
            CheckHC::class,
            
        ]);
        $middleware->appendToGroup('pegawai', [
            CheckPegawai::class,
            
        ]);
        $middleware->appendToGroup('manajerhc', [
            CheckManajerHC::class,
            
        ]);
        $middleware->appendToGroup('kapro', [
            CheckKapro::class,
            
        ]);
        $middleware->appendToGroup('pusat', [
            CheckPusat::class,
            
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
