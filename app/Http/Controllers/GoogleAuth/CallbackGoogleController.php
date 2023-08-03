<?php

namespace App\Http\Controllers\GoogleAuth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class CallbackGoogleController extends Controller
{
    public function __invoke()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();
            if (!$user) {
                $new_user = User::create([
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'google_id' => $google_user->getId()
                ]);

                Auth::login($new_user);
                return redirect('http://localhost:5173/home');
            } else {
                Auth::login($user);
                return redirect('http://localhost:5173/home');
            }
        } catch (\Throwable $throwable) {
            dd('Something went wrong!' . $throwable);
        }
    }
}
