<?php

namespace Tests\Feature\Controllers\Auth\Password;

use App\Mail\PasswordChange;
use App\Mail\PasswordReset;
use App\Models\User;
use Tests\TestCase;
use Password;
use Mail;

class ResetControllerTest extends TestCase
{
    /**
     * GET
     */
    public function testIndex()
    {
        $user       = factory(User::class)->create();
        $token      = Password::createToken($user);

        $this->getJson(route('auth.password.reset.index', [
            'email'     => $user->email,
            'token'     => $token,
        ]))->assertStatus(200);
    }

    /**
     * POST
     */
    public function testStore()
    {
        Mail::fake();

        $user = factory(User::class)->create();

        $this->postJson(route('auth.password.reset.store'), [
            'email'     => $user->email,
        ])->assertStatus(202);

        Mail::assertQueued(PasswordReset::class);
    }

    /**
     * POST
     */
    public function testStoreUnknownEmail()
    {
        Mail::fake();

        $this->postJson(route('auth.password.reset.store'), [
            'email'     => $this->faker->email,
        ])->assertStatus(202);

        Mail::assertNotQueued(PasswordReset::class);
    }

    /**
     * PATCH
     */
    public function testUpdate()
    {
        Mail::fake();

        $user       = factory(User::class)->create();
        $token      = Password::createToken($user);
        $password   = str_random(12);

        $this->patchJson(route('auth.password.reset.update'), [
            'email'     => $user->email,
            'token'     => $token,
            'password'  => $password,
        ])->assertStatus(200);

        $token = auth()->attempt([
            'email'     => $user->email,
            'password'  => $password,
        ]);

        $this->assertNotNull($token);

        Mail::assertQueued(PasswordChange::class);
    }

    /**
     * PATCH
     */
    public function testUpdateIncorrectToken()
    {
        $user1      = factory(User::class)->create();
        $user2      = factory(User::class)->create();
        $token      = Password::createToken($user2);

        $this->patchJson(route('auth.password.reset.update'), [
            'email'     => $user1->email,
            'token'     => $token,
            'password'  => str_random(12),
        ])
            ->assertStatus(422)
            ->assertJsonFragment(['token' => ['The given credentials are incorrect']]);
    }
}