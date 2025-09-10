<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e) {
            return \App\Support\ApiResponse::error('Dữ liệu không hợp lệ', 422, $e->errors());
        });
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e) {
            return \App\Support\ApiResponse::error('Không được phép', 401);
        });
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return \App\Support\ApiResponse::error($e->getMessage() ?: 'Lỗi', $e->getStatusCode());
        });
    })->create();
