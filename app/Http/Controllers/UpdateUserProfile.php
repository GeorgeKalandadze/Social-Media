<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UpdateUserProfile extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
//        $data = $request->validate()
    }
}
