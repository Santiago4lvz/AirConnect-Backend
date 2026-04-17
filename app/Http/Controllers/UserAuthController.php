<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();



        if (! $user || ! \Hash::check($request->password, $user->password)) {
            Log::warning('Intento de login fallido', ['email' => $request->email, 'ip' => $request->ip()]);
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
            
        }

        if ($user == null){
            return response()->json([
                'message' => 'User not found',
            ], 404);    
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function userProfile(Request $request)
    {
        return response()->json([
            'message' => 'Datos del usuario recuperados',
            'userData' => $request->user(),
        ], 200);
    }
}
