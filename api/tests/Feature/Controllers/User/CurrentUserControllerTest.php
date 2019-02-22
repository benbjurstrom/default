<?php

namespace Tests\Feature\Controllers\Api\User;

use App\Http\Resources\CurrentUserResource;
use App\Models\User;
use Tests\TestCase;

class CurrentUserControllerTest extends TestCase
{
    /**
     * GET Collection
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();
        auth()->login($user);

        $this->getJson(route('currentUser'))
            ->assertStatus(200)
            ->assertJsonFragment((new CurrentUserResource($user))->toArray());
    }
}
