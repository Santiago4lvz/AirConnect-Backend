<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Model\User;
// Cambia este

use Tests\TestCase;

    class integrationTest extends TestCase
    {

        use DatabaseTransactions;
       /* protected function setUp(): void{
            parent::setup();

            User::where('email', 'test_integration@example.com')->forceDelete();
        }
            */



        public function test_example(): void {
        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => fake()->unique()->email(),
            'password' => bcrypt('password'),
        ]);  
        $this->assertDatabaseHas('users', [
            'email' => 'test_integration@example.com'
        ]);
        }
    }
