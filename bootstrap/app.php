<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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


        $exceptions->render(
            function (ValidationException $e, Request $request) {
                if (!$request->is('api/*')) {
                    return null;
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors(),
                ], 422);
            }
        );

        $exceptions->render(
            function (NotFoundHttpException $e, Request $request) {
                if (!$request->is('api/*')) {
                    return null;
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found',
                ], 404);
            }
        );

        $exceptions->render(
            function (HttpException $e, Request $request) {
                if (!$request->is('api/*')) {
                    return null;
                }
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'HTTP Error',
                ], $e->getStatusCode());
            }
        );

        $exceptions->render(
            function (\Throwable $e, Request $request) {
                if (!$request->is('api/*')) {
                    return null;
                }

                return response()->json([
                    'success' => false,
                    'message' => config('app.debug')
                        ? $e->getMessage()
                        : 'Internal server error',
                ], 500);
            }
        );
        
    })->create();
