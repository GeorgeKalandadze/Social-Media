<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserInformationController extends Controller
{
    public function __invoke(User $user): JsonResponse
    {
        $posts = $user->posts;
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'bg_image' => $user->bg_image,
            'profile_image' => $user->profile_image,
            'posts' => $posts,
        ];

        return response()->json(['user' => $userData]);
    }
}
