<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TODAapplicationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/toda-applications/{id}', [TODAapplicationController::class, 'get']);

Route::get('/toda-applications', [TODAapplicationController::class, 'getAll']);

// In routes/api.php
Route::post('/sms-callback', function(Request $request) {
    \Log::info('SMS Delivery Report:', $request->all());
    return response()->json(['success' => true]);
});


