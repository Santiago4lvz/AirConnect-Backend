<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AuthApi
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token no proporcionado'
            ], 401);
        }
        
        $hashedToken = hash('sha256', $token);
        $user = User::where('remember_token', $hashedToken)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Token inválido'
            ], 401);
        }
        
        // Autenticar al usuario
        auth()->login($user);
        
        return $next($request);
    }
}