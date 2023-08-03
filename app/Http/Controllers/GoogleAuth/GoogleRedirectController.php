<?php

namespace App\Http\Controllers\GoogleAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;

class GoogleRedirectController extends Controller
{
    public function __invoke()
    {
        return Socialite::driver('google')->redirect();
    }
}
