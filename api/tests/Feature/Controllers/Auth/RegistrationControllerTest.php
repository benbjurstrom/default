<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationControllerTest extends TestCase
{
    /**
     * POST
     */
    public function testStore()
    {
        $password = str_random(12);
        $user = factory(User::class)->make([
            'password' => bcrypt($password)
        ]);

        $this->postJson(route('auth.register'), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password
        ])->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}