<?php

namespace App\Http\Controllers\AuthNew;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required'
        ]);

        //if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        // Cek email sudah diverifikasi
        if (is_null($user->email_verified_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan verifikasi email Anda terlebih dahulu.'
            ], 403);
        }

        // Jika sudah diverifikasi, login dan generate token
        if (!$token = auth()->guard('api')->attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        //if auth success
        return response()->json([
            'success' => true,
            'user'    => $user,    
            'token'   => $token   
        ], 200);
    }
}
