<?php

use App\Http\Controllers\Comment\CreateCommentController;
use App\Http\Controllers\Comment\UpdateCommentController;
use App\Http\Controllers\GetCategoryController;
use App\Http\Controllers\GoogleAuth\CallbackGoogleController;
use App\Http\Controllers\GoogleAuth\GoogleRedirectController;
use App\Http\Controllers\Post\CreatePostController;
use App\Http\Controllers\Post\DeletePostController;
use App\Http\Controllers\Post\DeletePostImageController;
use App\Http\Controllers\Post\GetPostController;
use App\Http\Controllers\Post\UpdatePostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Comment\DeleteCommentController;
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

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    $user = $request->user();
    $user['roles'] = $user->getRoleNames()->toArray();
    return $user;
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/posts', GetPostController::class);
    Route::post('/post/create', CreatePostController::class);
    Route::post('/post/update/{id}', UpdatePostController::class);
    Route::delete('/post/{id}', DeletePostController::class);
    Route::delete('/posts/{postId}/images/{imageId}', DeletePostImageController::class)->name('delete.post.image');
    Route::put('comment/{comment}', UpdateCommentController::class);
    Route::delete('/comment/{id}', DeleteCommentController::class);
    Route::post('/comment/create', CreateCommentController::class);
    Route::get('/categories',GetCategoryController::class)->name('categories');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('auth/google',GoogleRedirectController::class);
    Route::get('/auth/google/callback', CallbackGoogleController::class);
});
