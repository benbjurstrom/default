<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Mail\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Mail;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('throttle:5,5');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'email'     => 'required|string|email|max:255'
        ]);

        $user = (new User)
            ->where('email', $data['email'])
            ->first();

        // silently fail if the user is not found for privacy reasons
        if(!$user){
            return response()
                ->json(null, 202);
        }

        $this->broker()->deleteToken($user);
        $token = $this
            ->broker()
            ->createToken($user);

        Mail::to($user)
            ->queue(new PasswordReset($user, $token));

        return response()
            ->json(null, 202);
    }
}
