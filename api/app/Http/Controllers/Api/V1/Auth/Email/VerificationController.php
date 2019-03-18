<?php

namespace App\Http\Controllers\Api\V1\Auth\Email;

use App\Services\AuthService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class VerificationController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('signed')->only('update');
    }

    /**
     * Resend the email verification notification.
     *
     * @param  AuthService  $as
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function index(AuthService $as)
    {
        $user = auth()->user();
        $as->sendVerificationEmail($user);

        return response()->json(null, 201);
    }


    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  AuthService  $as
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(AuthService $as)
    {
        $user = auth()->user();
        if (!$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(null, 200);
    }
}
