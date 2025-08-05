<?php

namespace App\Http\Controllers\AuthNew;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request to login a user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $user = \App\User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Email atau Password Anda salah');
        }

        // Cek email sudah diverifikasi
        if (is_null($user->email_verified_at)) {
            return redirect()->back()->with('error', 'Silakan verifikasi email Anda terlebih dahulu.');
        }

        // Login user (session based)
        auth()->login($user);

        // Redirect ke dashboard/index
        return redirect()->route('dashboard');
    }

    public function index()
    {
        // Logic to show the login form
        return view('auth.login');
    }
}
