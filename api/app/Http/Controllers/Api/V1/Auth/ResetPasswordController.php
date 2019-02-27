<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Services\PasswordService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Mail;

class ResetPasswordController extends Controller
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
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  PasswordService $ps
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function index(Request $request, PasswordService $ps)
    {
        $data = $this->validate($request, [
            'email'     => 'required|string|email|max:255',
            'token'     => 'required|string|size:64',
        ]);

        $user = $ps->getTokenUser($data['email'], $data['token']);

        return response()
            ->json(null, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  PasswordService $ps
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function update(Request $request, PasswordService $ps)
    {
        $data = $this->validate($request, [
            'email'     => 'required|string|email|max:255',
            'token'     => 'required|string|size:64',
            'password'  => 'required|string|min:8',
        ]);

        $user = $ps->updatePasswordFromToken($data);

        return response()
            ->json(null, 200);
    }
}
