<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\HealthController;

Route::get('health', HealthController::class);


Route::post('/test-validation', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'email' => ['required', 'email']
    ]);

    return response()->json();
});


Route::get('/test-500', function () {
    throw new RuntimeException('Testing internal server error');
});