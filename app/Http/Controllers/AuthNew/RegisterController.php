<?php

namespace App\Http\Controllers\AuthNew;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificatioMail;

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
            'role_id' => 3
        ]);

        // Generate token verifikasi
        $token = Str::random(64);
        $user->email_verification_token = $token;
        $user->save();

        // Buat URL verifikasi
        $verificationUrl = url('/api/auth/verification?token=' . $token . '&email=' . $user->email);

        // Kirim email verifikasi
        Mail::to($user->email)->send(new VerificatioMail($verificationUrl));

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    public function verification(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('email_verification_token', $request->token)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Token tidak valid'], 400);
        }

        $user->email_verified_at = now();
        $user->email_verification_token = null;
        $user->save();

        return view('auth.verification', [
            'message' => 'Email berhasil diverifikasi. Silakan login.',
            'status' => 'success',
        ]);
    }

    public function index()
    {
        // Logic to show the registration form
        return view('auth.register');
    }
}

