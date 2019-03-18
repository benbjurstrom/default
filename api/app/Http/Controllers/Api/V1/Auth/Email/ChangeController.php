<?php

namespace App\Http\Controllers\Api\V1\Auth\Email;

use App\Http\Resources\CurrentUserResource;
use App\Mail\Auth\EmailChangeVerification;
use App\Services\PasswordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Hash;
use URL;
use Mail;

class ChangeController extends Controller
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     * @throws
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        throw_unless($user->email_pending, ValidationException::withMessages([
            'email_pending'    => ['There is no pending email change request.']
        ]));

        $url = URL::signedRoute('emailChangeVerification', [
            'id' => $user->id,
            'email_pending' => $user->email_pending
        ]);

        Mail::to($user)->queue(new EmailChangeVerification($user, $url));

        return (new CurrentUserResource($user))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     * @throws
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:3',
        ]);

        $user = auth()->user();
        throw_unless(Hash::check($data['password'], $user->password), ValidationException::withMessages([
            'password'    => ['The given credentials are incorrect']
        ]));

        $user->email_pending = $data['email'];
        $user->save();

        return (new CurrentUserResource($user))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     * @throws
     */
    public function update(Request $request, PasswordService $as)
    {
        $data = $this->validate($request, [
            'signature'      => 'required|string|size:64',
            'email_pending'  => 'required|email'
        ]);

        $user = $user = auth()->user();
        throw_unless($user->email_pending === $data['email_pending'], ValidationException::withMessages([
            'email_pending'    => ['The given email_pending does not match the user record']
        ]));

        $user->email = $user->email_pending;
        $user->email_pending = null;
        $user->save();

        return (new CurrentUserResource($user))
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = $user = auth()->user();
        $user->email_pending = null;
        $user->save();

        return response()->json(null, 204);
    }
}
