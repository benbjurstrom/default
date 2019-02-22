<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\CurrentUserResource;
use Illuminate\Http\JsonResponse;

class CurrentUserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $user = auth()->user();
        $user->load(['roles', 'permissions']);
        return (new CurrentUserResource($user))
            ->response()
            ->setStatusCode(200);
    }
}

