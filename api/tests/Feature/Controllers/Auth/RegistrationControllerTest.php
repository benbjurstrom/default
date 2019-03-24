<?php

namespace Tests\Feature\Controllers\Auth;

use App\Mail\EmailVerification;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mail;

class RegistrationControllerTest extends TestCase
{
    /**
     * POST
     */
    public function testStore()
    {
        Mail::fake();

        $password = str_random(12);
        $user = factory(User::class)->make([
            'password' => bcrypt($password)
        ]);

        $this->postJson(route('auth.register'), [
            'name'          => $user->name,
            'email'         => $user->email,
            'password'      => $password,
            'terms'         => true,
            'agreements'    => [
                'privacy'   => 'fb16d59f04146c120200640ab11f04abc651ed1f',
                'terms'     => '99be19567be21c4d1034baa834432fe5f2306afe'
            ],
        ])->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        Mail::assertQueued(EmailVerification::class);
    }
}