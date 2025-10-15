<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\FactController;

// adding rate limiting of 2 requests per second
Route::middleware('throttle:2,1')->group(function () {
    Route::get('/me', [FactController::class, 'index']);
});

Route::fallback(function(){
    return response()->json([
        'status' => 'error',
        'message' => 'Endpoint not found. Please refer to the API documentation for valid endpoints.'
    ], 404);
});
