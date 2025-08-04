<?php

namespace App\Http\Controllers\AuthNew;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            // Redirect to intended page or home
            return redirect()->intended('home');
        }

        $user = auth()->user();

        // If login fails, redirect back with an error message
        //return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        return response()->json([
            'user' => $user,
            'message' => 'Invalid credentials',
            'status' => 'error',
        ], 401);
    }
}
