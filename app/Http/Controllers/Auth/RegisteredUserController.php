<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar la vista de registro.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Manejar el registro de un nuevo usuario (WEB).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'last_name'  => ['required', 'string', 'max:100', 'regex:/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/'],
            'username'   => ['required', 'string', 'max:50', 'unique:users'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'id_role'  => 2, // rol por defecto (cliente/usuario normal)
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard'); 
    }

    /**
     * 🚀 NUEVO: Registro desde Ionic (API)
     * POST /api/register-mobile
     */
    public function mobileRegister(Request $request)
    {
        // Validación para mobile (más flexible)
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // Crear usuario
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->email, // Usar email como username temporal
            'id_role'  => 2, // rol por defecto
        ]);

        // Generar token manual (usando remember_token)
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
                'email' => $user->email,
            ]
        ], 201);
    }
}