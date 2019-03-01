<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \Illuminate\Support\Facades\URL;

class EmailVerificationControllerTest extends TestCase
{
    /**
     * POST
     */
    public function testStore()
    {
        app()->make('config')->set('mail.driver', 'log');
        $user = factory(User::class)->create([
            'email_verified_at' => null
        ]);

        auth()->login($user);

        $this->postJson(route('auth.email.resend'))
            ->assertStatus(201);
    }

    /**
     * PATCH
     */
    public function testVerifyWhereUnverified()
    {
        $user = factory(User::class)->create([
            'email_verified_at' => null
        ]);
        $this->assertFalse($user->hasVerifiedEmail());

        auth()->login($user);
        $route = URL::signedRoute('auth.email.verify', ['id' => $user->id]);

        $this->patchJson($route)
            ->assertStatus(200);

        $this->assertTrue($user->refresh()->hasVerifiedEmail());
    }
}