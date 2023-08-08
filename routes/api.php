<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\GoogleAuth\GoogleRedirectController;
use \App\Http\Controllers\GoogleAuth\CallbackGoogleController;
use \App\Http\Controllers\Post\CreatePostController;
use \App\Http\Controllers\Post\UpdatePostController;
use \App\Http\Controllers\Post\DeletePostController;
use \App\Http\Controllers\GetCategoryController;
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
    Route::post('/post/create', CreatePostController::class);
    Route::patch('/post/update/{post}', UpdatePostController::class);
    Route::delete('/post/{id}', DeletePostController::class);
    Route::get('/categories',GetCategoryController::class)->name('categories');

});


Route::group(['middleware' => ['web']], function () {
    Route::get('auth/google',GoogleRedirectController::class);
    Route::get('/auth/google/callback', CallbackGoogleController::class);
});
