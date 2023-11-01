<?php

use App\Http\Controllers\Comment\CreateCommentController;
use App\Http\Controllers\Comment\DeleteCommentController;
use App\Http\Controllers\Comment\GetCommentController;
use App\Http\Controllers\Comment\LikeCommentController;
use App\Http\Controllers\Comment\UpdateCommentController;
use App\Http\Controllers\GetCategoryController;
use App\Http\Controllers\GoogleAuth\CallbackGoogleController;
use App\Http\Controllers\GoogleAuth\GoogleRedirectController;
use App\Http\Controllers\Post\CreatePostController;
use App\Http\Controllers\Post\DeletePostController;
use App\Http\Controllers\Post\DeletePostImageController;
use App\Http\Controllers\Post\GetFavoritePostController;
use App\Http\Controllers\Post\GetPostController;
use App\Http\Controllers\Post\LikePostController;
use App\Http\Controllers\Post\ToggleFavoritePostController;
use App\Http\Controllers\Post\UpdatePostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \Illuminate\Support\Facades\Broadcast;
use \App\Http\Controllers\GetNotificationController;
use \App\Http\Controllers\MarkAsReadController;
use \App\Http\Controllers\MarkAsAllReadController;
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
})->name('user.profile');

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::prefix('notifications')->group(function () {
        Route::get('/', GetNotificationController::class)->name('notifications.index');
        Route::put('/{notification}', MarkAsReadController::class)->name('notifications.markRead');
        Route::patch('/markAllAsRead', MarkAsAllReadController::class)->name('notifications.markAllRead');
    });

    Route::get('/posts', GetPostController::class)->name('posts.index');
    Route::get('/favorites', GetFavoritePostController::class)->name('posts.favorite');
    Route::post('/posts/{post}/favorite', ToggleFavoritePostController::class)->name('posts.toggleFavorite');

    Route::prefix('post')->group(function () {
        Route::post('/create', CreatePostController::class)->name('post.create');
        Route::post('/update/{id}', UpdatePostController::class)->name('post.update');
        Route::delete('/{id}', DeletePostController::class)->name('post.delete');
        Route::post('/upvote/{post_id}', LikePostController::class)->name('post.upvote');
    });

    Route::delete('/posts/{postId}/images/{imageId}', DeletePostImageController::class)->name('post.image.delete');

    Route::prefix('comment')->group(function () {
        Route::post('/upvote/{comment_id}', LikeCommentController::class)->name('comment.upvote');
        Route::get('/{post}', GetCommentController::class)->name('comment.get');
        Route::put('/{comment}', UpdateCommentController::class)->name('comment.update');
        Route::delete('/{id}', DeleteCommentController::class)->name('comment.delete');
        Route::post('/create', CreateCommentController::class)->name('comment.create');
    });

    Route::get('/categories', GetCategoryController::class)->name('categories.index');
});

Route::group(['middleware' => ['web']], function () {
    Route::get('auth/google', GoogleRedirectController::class)->name('auth.google.redirect');
    Route::get('/auth/google/callback', CallbackGoogleController::class)->name('auth.google.callback');
});

