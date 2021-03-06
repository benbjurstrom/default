<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $token;

    /**
     * Create a new message instance.
     * @param User $user
     * @param string $token
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url(config('app.client_url') . '/auth/reset/' . $this->token . '?email=' . $this->user->email);
        return $this->subject('Password Reset')
            ->markdown('emails.auth.reset')
            ->with([
                'url' => $url
            ]);
    }
}
