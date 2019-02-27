<?php

namespace App\Services;

use App\Mail\PasswordChange;
use App\Mail\PasswordReset;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Mail;
use Password;

class PasswordService
{
    /**
     * @param array $credentials
     * @return User
     */
    public function updatePasswordFromToken($credentials): User {

        return \DB::transaction(function() use ($credentials) {
            $user = $this->getTokenUser($credentials['email'], $credentials['token']);
            $user->password = bcrypt($credentials['password']);
            $user->save();

            Password::deleteToken($user);
            Mail::to($user)->queue(new PasswordChange($user));

            return $user;
        });

    }

    /**
     * @param string $email
     * @throws \Throwable
     */
    public function sendForgotPasswordEmail($email){
        $user = (new User)->where('email', $email)->first();

        // silently fail if the user is not found for privacy reasons
        if(!$user) return;

        Password::deleteToken($user);
        $token = Password::createToken($user);

        Mail::to($user)->queue(new PasswordReset($user, $token));
    }

    /**
     * @param string $email
     * @param string $token
     * @return User
     * @throws \Throwable
     */
    public function getTokenUser($email, $token): User {
        $user = (new User)
            ->where('email', $email)
            ->first();

        $this->validate($user);
        $this->validate(Password::tokenExists($user, $token));
        return $user;
    }

    /**
     * @param bool $subject
     * @throws \Throwable
     */
    public function validate($subject){
        throw_unless($subject, ValidationException::withMessages([
            'token'    => ['The given credentials are incorrect']
        ]));
    }
}