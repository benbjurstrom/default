<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Resources\CurrentUserResource;
use App\Models\User;
use App\Models\UserAgreement;
use App\Services\AuthService;
use App\Services\TermsService;
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
     * @param  TermsService $ts
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request, AuthService $as, TermsService $ts)
    {
        if(!config('auth.registration')){
            ValidationException::withMessages([
                'email'    => ['Registration is closed for new users']
            ]);
        }

        $data = $this->validate($request, [
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:8',
            'terms'         => 'required|boolean|accepted',
            'agreements'    => 'required|array',
            'agreements.privacy' => 'required|size:40',
            'agreements.terms'   => 'required|size:40'
        ]);

        $user = \DB::transaction(function() use ($data, $as, $ts) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $terms_sha = $ts->getTermsAgreement()->sha;
            throw_unless($data['agreements']['terms'] === $terms_sha, ValidationException::withMessages([
                'agreements'    => ['The given terms hash does not match the latest agreement.']
            ]));
            $ua = new UserAgreement();
            $ua->user_id = $user->id;
            $ua->sha = $terms_sha;
            $ua->ip = request()->ip();
            $ua->save();

            $privacy_sha = $ts->getPrivacyAgreement()->sha;
            throw_unless($data['agreements']['privacy'] === $privacy_sha, ValidationException::withMessages([
                'agreements'    => ['The given privacy hash does not match the latest agreement.']
            ]));
            $ua = new UserAgreement();
            $ua->user_id = $user->id;
            $ua->sha = $privacy_sha;
            $ua->ip = request()->ip();
            $ua->save();

            $as->sendVerificationEmail($user);
            return $user;
        });

        return (new CurrentUserResource($user))
            ->response()
            ->setStatusCode(201);
    }
}
