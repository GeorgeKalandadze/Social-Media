<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUserProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // Define the validation rules
        $rules = [
            'bg_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
        ];

        // If the user has a Google ID, don't require email validation
        if ($user->google_id === null) {
            $rules['email'] = [
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ];
        }

        // Validate the request data
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Process the validated data
        $data = $validator->validated();

        if ($request->hasFile('bg_img')) {
            // Handle background image upload and storage
            $bgImage = $request->file('bg_img');
            $bgImageName = time() . $bgImage->getClientOriginalName();
            $bgImage->storeAs('bg_images', $bgImageName);
            $data['bg_img'] = env('APP_URL') . Storage::url('bg_images/' . $bgImageName);
        }

        if ($request->hasFile('profile_img')) {
            // Handle profile image upload and storage
            $profileImage = $request->file('profile_img');
            $imageName = time() . $profileImage->getClientOriginalName();
            $profileImage->storeAs('profile_images', $imageName);
            $data['profile_img'] = env('APP_URL') . Storage::url('profile_images/' . $imageName);
        }

        // Update the user's profile
        $user->update($data);

        return response()->json(['message' => 'Profile updated successfully']);
    }
}
