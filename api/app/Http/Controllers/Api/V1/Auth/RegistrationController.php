<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Resources\CurrentUserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Hash;

class RegistrationController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 1;

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        if(!config('auth.registration')){
            ValidationException::withMessages([
                'email'    => ['Registration is closed for new users']
            ]);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $this->incrementLoginAttempts($request);

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

        return (new CurrentUserResource($user))
            ->response()
            ->setStatusCode(201);
    }
}
