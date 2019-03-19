<?php

namespace App\Services;

use App\Mail\Auth\EmailChangeVerification;
use App\Mail\PasswordChange;
use App\Mail\PasswordReset;
use App\Mail\EmailVerification;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Mail;
use Password;
use URL;
use Hash;

class AuthService
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
     * @param string $email_new
     * @param string $password
     * @return User
     * @throws \Throwable
     */
    public function emailChangeRequest($email_new, $password): User {
        $user = $this->validateAuthenticatedUsersPassword($password);

        // Note: we check whether the email already belongs to a user on verification.
        // this ensures that no information about who has a user account is leaked.

        $user->email_pending = $email_new;
        $user->save();

        $this->sendEmailChangeVerification($user);

        return $user;
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
     * @param User $user
     */
    public function sendEmailChangeVerification(User $user){
        $route = URL::signedRoute('auth.email.change.update', [
            'id' => $user->id,
            'email_pending' => $user->email_pending
        ]);
        Mail::to($user)->queue(new EmailChangeVerification($user, $route));
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
     * @param string $password
     * @return User
     * @throws \Throwable
     */
    public function validateAuthenticatedUsersPassword($password): User {
        $user = auth()->user();
        throw_unless(Hash::check($password, $user->password), ValidationException::withMessages([
            'password'    => ['The given credentials are incorrect']
        ]));

        return $user;
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