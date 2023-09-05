<?php

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class UpdateUserProfile extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // Validate the request data
        $data = $request->validate([
            'bg_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
        ]);

        if ($user->google_id !== null) {
            $user->update($data);
            return response()->json(['message' => 'Profile updated successfully']);
        }


        $emailValidationRule = 'nullable|email|unique:users,email,' . $user->id;
        $passwordValidationRule = 'nullable|min:8|confirmed';
        $data = $request->validate([
                'email' => $emailValidationRule,
                'password' => $passwordValidationRule,
            ] + $data);

        $user->update($data);
        return response()->json(['message' => 'Profile updated successfully']);
    }
}

