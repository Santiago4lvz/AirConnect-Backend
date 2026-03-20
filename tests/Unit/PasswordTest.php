<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_hashes_password_correctly()
    {
        // se crea una contraseña plana
        $password = '123456';
        // se crea un uusario con esa contraseña
        $user = User::factory()->make(['password' => $password]);

        // se asegura que la contraseña no se guarda en texto plano
        $this->assertNotEquals($password, $user->password);
        // se verifica que la contraseña se ha hasheado correctamente
        $this->assertTrue(Hash::check($password, $user->password));
    }
}
