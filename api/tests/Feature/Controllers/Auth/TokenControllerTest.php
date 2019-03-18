<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TokenControllerTest extends TestCase
{
    /**
     * POST
     */
    public function testStore()
    {
        $password = str_random(12);
        $user = factory(User::class)
            ->create([
                'password' => bcrypt($password)
            ]);

        $this->postJson(route('auth.token.store'), [
            'email' => $user->email,
            'password' => $password
        ])
            ->assertStatus(201)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    /**
     * POST
     */
    public function testStoreIncorrectPassword()
    {
        $password = str_random(12);
        $user = factory(User::class)
            ->create([
                'password' => bcrypt($password)
            ]);

        $this->postJson(route('auth.token.store'), [
                'email' => $user->email,
                'password' => $password . '1'
            ])
            ->assertStatus(422)
            ->assertJsonFragment(['email' => ['The provided credentials are incorrect']]);
    }

    /**
     * PATCH
     */
    public function testUpdate()
    {
        $user = factory(User::class)
            ->create();
        auth()->login($user);

        $this->patchJson(route('auth.token.update'))
            ->assertStatus(200)
            ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    /**
     * DELETE
     */
    public function testDestroy()
    {
        $user = factory(User::class)
            ->create();
        auth()->login($user);

        $this->assertNotNull(auth()->user());

        $this->deleteJson(route('auth.token.destroy'))
            ->assertStatus(204);

        $this->assertNull(auth()->user());
    }
}
