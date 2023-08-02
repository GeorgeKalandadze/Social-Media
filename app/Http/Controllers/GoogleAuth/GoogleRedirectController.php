<?php

namespace App\Http\Controllers\GoogleAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;

class GoogleRedirectController extends Controller
{
    public function __invoke()
    {
        $url = Socialite::driver('google')->redirect()->getTargetUrl();
            return response()->json([
                'url' => $url
        ]);
//        return Socialite::driver('google')->redirect();
    }
}
