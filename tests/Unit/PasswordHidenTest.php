<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class PasswordHidenTest extends TestCase
{
    public function test_example(): void
    {
        $user = User::factory()->make(['password' => '123456']);

        $array = $user->toArray();

        // Verificar que la no este en la array resulatnate
        $this->assertArrayNotHasKey('password', $array);

        $this->assertStringNotContainsString('password', $user->toJson());
    }
}
