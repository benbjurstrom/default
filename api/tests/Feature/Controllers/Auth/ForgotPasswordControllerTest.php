<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordControllerTest extends TestCase
{
    /**
     * POST
     */
    public function testStore()
    {
        app()->make('config')->set('mail.driver', 'log');
        $user = factory(User::class)->create();
        $this->postJson(route('auth.password.email'), [
            'email' => $user->email
        ])->assertStatus(202);

        $this->assertDatabaseHas('password_resets', [
            'email' => $user->email
        ]);
    }
}