<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateUserProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'bg_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
        ]);

        if ($request->hasFile('bg_img')) {
            $bgImage = $request->file('bg_img');
            $bgImageName = time().$bgImage->getClientOriginalName();
            $bgImage->storeAs('bg_images', $bgImageName );
            $data['bg_img'] = env('APP_URL').Storage::url('bg_images/' . $bgImageName);
        }

        if ($request->hasFile('profile_img')) {
            $profileImage = $request->file('profile_img');
            $imageName = time().$profileImage->getClientOriginalName();
            $profileImage->storeAs('bg_images', $imageName );
            $data['profile_img'] = env('APP_URL').Storage::url('bg_images/' . $imageName);;
        }

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
