<?php

namespace Tests\Feature\Controllers\Api\Auth;

use App\Http\Resources\CurrentUserResource;
use App\Models\User;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * GET Collection
     */
    public function testShow()
    {
        $user = factory(User::class)
            ->states(['withRoles'])
            ->create();
        auth()->login($user);

        $this->getJson(route('auth.user.show'))
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $user->id])
            ->assertJsonFragment(['id' => $user->roles->first()->id])
            ->assertJsonFragment(['id' => $user->getAllPermissions()->first()->id]);
    }
}
