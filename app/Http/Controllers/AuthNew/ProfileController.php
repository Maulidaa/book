<?php

namespace App\Http\Controllers\AuthNew;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // Logic to display user profile
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }

    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . auth()->id(),
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'nullable|exists:roles,id',
            'password' => 'nullable|string|min:6|confirmed',
        ]);
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Ensure $user is an instance of the User model
        if (!($user instanceof User)) {
            $user = User::find($user->id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }
        }

        $user->update($validatedData);
        return response()->json(['message' => 'User profile updated successfully']);
    }
}
