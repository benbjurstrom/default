<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Password;

class ResetPasswordControllerTest extends TestCase
{
    /**
     * GET
     */
    public function testIndex()
    {
        $user       = factory(User::class)->create();
        $token      = Password::createToken($user);

        $this->getJson(route('auth.password.validate', [
            'email'     => $user->email,
            'token'     => $token,
        ]))->assertStatus(200);
    }

    /**
     * POST
     */
    public function testStore()
    {
        app()->make('config')->set('mail.driver', 'log');
        $user       = factory(User::class)->create();
        $token      = Password::createToken($user);
        $password   = str_random(12);

        $this->patchJson(route('auth.password.reset'), [
            'email'     => $user->email,
            'token'     => $token,
            'password'  => $password,
        ])->assertStatus(200);

        $token = auth()->attempt([
            'email'     => $user->email,
            'password'  => $password,
        ]);

        $this->assertNotNull($token);
    }
}