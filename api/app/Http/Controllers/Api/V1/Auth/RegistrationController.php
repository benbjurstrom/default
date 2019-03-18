<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Resources\CurrentUserResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Hash;

class RegistrationController extends Controller
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
     * @param  AuthService $as
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request, AuthService $as)
    {
        if(!config('auth.registration')){
            ValidationException::withMessages([
                'email'    => ['Registration is closed for new users']
            ]);
        }

        $data = $this->validate($request, [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $as->sendVerificationEmail($user);

        return (new CurrentUserResource($user))
            ->response()
            ->setStatusCode(201);
    }
}
