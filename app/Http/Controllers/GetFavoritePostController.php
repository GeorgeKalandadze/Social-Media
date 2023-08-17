<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetFavoritePostController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        $favorites = $user->favorites()->with('user')->get();

        return response()->json(['favorites' => $favorites]);
    }
}
