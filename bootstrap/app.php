<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ApiResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        using: function() {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth.multi' => \App\Http\Middleware\AuthenticateMultipleGuards::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('*')) {
                return ApiResponse::notFound("Not Found.");
            }
        });

        // handle JWT Exceptions
        $exceptions->render(function (TokenExpiredException $e, Request $request) {
            return ApiResponse::unauthorized("Token sudah kedaluwarsa.");
        });

        $exceptions->render(function (TokenInvalidException $e, Request $request) {
            return ApiResponse::unauthorized("Token sudah tidak berlaku.");
        });

        $exceptions->render(function (JWTException $e, Request $request) {
            return ApiResponse::unauthorized("Token sudah tidak valid atau tidak tersedia.");
        });
    })->create();
