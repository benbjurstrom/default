<?php

namespace App\Services;

use App\Mail\PasswordChange;
use App\Mail\PasswordReset;
use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Mail;
use Password;
use URL;

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
     * @param User $user
     * @throws \Throwable
     */
    public function sendForgotPasswordEmail(User $user){
        Password::deleteToken($user);
        $token = Password::createToken($user);

        Mail::to($user)->queue(new PasswordReset($user, $token));
    }

    /**
     * @param User $user
     * @throws \Throwable
     */
    public function sendVerificationEmail(User $user) {
        $this->validateUserNotVerified($user);
        $sig = $this->getEmailVerificationSignature($user);

        Mail::to($user)->queue(new EmailVerification($user, $sig));
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
     * @param User $user
     * @return string
     */
    public function getEmailVerificationSignature(User $user) {
        $route = URL::signedRoute('auth.email.verify.update', ['id' => $user->id]);
        return substr($route, strrpos($route, '=') + 1);
    }

    /**
     * @param bool $subject
     * @throws \Throwable
     */
    protected function validate($subject) {
        throw_unless($subject, ValidationException::withMessages([
            'token'    => ['The given credentials are incorrect']
        ]));
    }

    /**
     * @param User $user
     * @throws \Throwable
     */
    protected function validateUserNotVerified(User $user){
        throw_if($user->hasVerifiedEmail(), ValidationException::withMessages([
            'id'    => ['The current user email address is already verified.']
        ]));
    }
}