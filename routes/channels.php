<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Post;
use \App\Models\User;
use \App\Models\Comment;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('like-channel.{postId}', function (User $user, $postId) {
    return (int) $user->id === (int) Post::findOrNew($postId)->user_id;
});

Broadcast::channel('comment-channel.{postId}', function (User $user, $postId) {
    return (int) $user->id === (int) Post::findOrNew($postId)->user_id;
});


