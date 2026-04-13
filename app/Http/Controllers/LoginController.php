<?php
// app/Http/Controllers/LoginController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function mobileLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Generar token único
            $token = Str::random(60);
            
            // Guardar token en la columna remember_token de tu tabla users
            $user->remember_token = hash('sha256', $token);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Login exitoso',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'last_name' => $user->last_name
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ], 401);
    }

    public function getUserProfile(Request $request)
    {
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'No autorizado'], 401);
        }
        
        // Buscar usuario por el token (hasheado)
        $hashedToken = hash('sha256', $token);
        $user = User::where('remember_token', $hashedToken)->first();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Token inválido'], 401);
        }
        
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'last_name' => $user->last_name
            ]
        ]);
    }

    public function mobileLogout(Request $request)
    {
        $token = $request->bearerToken();
        
        if ($token) {
            $hashedToken = hash('sha256', $token);
            $user = User::where('remember_token', $hashedToken)->first();
            
            if ($user) {
                $user->remember_token = null;
                $user->save();
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente'
        ]);
    }

    public function mobileRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Generar token para el nuevo usuario
        $token = Str::random(60);
        $user->remember_token = hash('sha256', $token);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Registro exitoso',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ], 201);
    }
}