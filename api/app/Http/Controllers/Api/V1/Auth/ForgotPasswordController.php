<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mail;

class ForgotPasswordController extends Controller
{

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
     * @param  PasswordService $ps
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function store(Request $request, PasswordService $ps)
    {
        $data = $this->validate($request, [
            'email'     => 'required|string|email|max:255'
        ]);

        $user = (new User)->where('email', $data['email'])->first();

        // silently skip if the user is not found for privacy reasons
        if($user) {
            $ps->sendForgotPasswordEmail($user);
        }

        return response()->json(null, 202);
    }
}
