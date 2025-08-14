<?php

namespace App\Http\Controllers\AuthNew;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class ProfileController extends Controller
{
    public function index()
    {
        // This method can be used to redirect to the profile view or handle other logic
        // return redirect()->route('profile.show');
    }
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $roles = \App\Role::all();
        $breadcrumb = [
                ['title' => 'Dashboard', 'url' => route('dashboard')],
                ['title' => 'Profile', 'url' => route('profile.update')],
            ];
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }
        return view('auth.update', compact('user', 'breadcrumb', 'roles'));
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

        if ($request->hasFile('picture')) {
            $picturePath = $request->file('picture')->store('profile_pictures', 'public');
            $validatedData['picture'] = $picturePath;
        }

        $user->update($validatedData);
        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
