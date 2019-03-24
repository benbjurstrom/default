<?php

namespace Tests\Feature\Controllers\Auth\Email;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use URL;

class ChangeControllerTest extends TestCase
{
    /**
     * PATCH
     */
    public function testStore()
    {
        $email = $this->faker->email;
        $password = str_random(10);

        $user = factory(User::class)
            ->states(['withAgreements'])
            ->create(['password' => bcrypt($password)]);
        auth()->login($user);

        $this->postJson(route('auth.email.change.store'), [
                'email' => $email,
                'password' => $password
            ]
        )->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $user->email,
            'email_pending' => $email
        ]);
    }

    /**
     * PATCH
     */
    public function testUpdate()
    {
        $email = $this->faker->email;
        $user  = factory(User::class)
            ->states(['withAgreements'])
            ->create(['email_pending' => $email]);
        auth()->login($user);

        $route = URL::signedRoute('auth.email.change.update', [
            'id' => $user->id,
            'email_pending' => $email
        ]);

        $this->patchJson($route)->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => $email
        ]);
    }
}
