<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use App\Http\Middleware\AuthenticatedJWT;
use Illuminate\Foundation\Configuration\Middleware;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware -> alias(['jwt.check' => \App\Http\Middleware\CheckJWT::class,]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
    
 

