<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\GoogleAuth\GoogleRedirectController;
use \App\Http\Controllers\GoogleAuth\CallbackGoogleController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    })->name('user');
});




Route::middleware(['web'])->group(function () {
    Route::get('auth/google',GoogleRedirectController::class);
    Route::get('/auth/google/callback', CallbackGoogleController::class);
});
