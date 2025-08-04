<?php

namespace App\Http\Controllers\AuthNew;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Log the user in
        auth()->login($user);

        // Redirect to intended page or home
        // return redirect()->intended('home');
        return response()->json([
            'user' => $user,
            'message' => 'Registration successful',
            'status' => 'success',
        ]);
    }
}
