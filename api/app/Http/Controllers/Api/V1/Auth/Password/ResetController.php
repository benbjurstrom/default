<?php

namespace App\Http\Controllers\Api\V1\Auth\Password;

use App\Services\AuthService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Mail;

class ResetController extends Controller
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
     * @param  AuthService $as
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function index(Request $request, AuthService $as)
    {
        $data = $this->validate($request, [
            'email'     => 'required|string|email|max:255',
            'token'     => 'required|string|size:64',
        ]);

        $user = $as->getTokenUser($data['email'], $data['token']);

        return response()
            ->json(null, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  AuthService $as
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function store(Request $request, AuthService $as)
    {
        $data = $this->validate($request, [
            'email'     => 'required|string|email|max:255'
        ]);

        $user = (new User)->where('email', $data['email'])->first();

        // silently skip if the user is not found for privacy reasons
        if($user) {
            $as->sendForgotPasswordEmail($user);
        }

        return response()->json(null, 202);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  AuthService $as
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     * @throws \Throwable
     */
    public function update(Request $request, AuthService $as)
    {
        $data = $this->validate($request, [
            'email'     => 'required|string|email|max:255',
            'token'     => 'required|string|size:64',
            'password'  => 'required|string|min:8',
        ]);

        $user = $as->updatePasswordFromToken($data);

        return response()
            ->json(null, 200);
    }
}
