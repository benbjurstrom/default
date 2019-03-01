<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Services\PasswordService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class EmailVerificationController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @param  PasswordService  $ps
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(Request $request, PasswordService $ps)
    {
        $user = auth()->user();
        $ps->sendVerificationEmail($user);

        return response()->json(null, 201);
    }


    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  PasswordService  $ps
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function update(Request $request, PasswordService $ps)
    {
        $user = auth()->user();
        if (!$user->hasVerifiedEmail() && $user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return response()->json(null, 200);
    }
}
