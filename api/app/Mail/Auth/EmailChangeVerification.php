<?php

namespace App\Mail\Auth;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailChangeVerification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var string
     */
    protected $route;

    /**
     * Create a new message instance.
     * @param User $user
     * @param string $route
     * @return void
     */
    public function __construct(User $user, $route)
    {
        $this->user  = $user;
        $this->route = $route;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url(config('app.client_url') . '/auth/email/change?route=' . base64_encode($this->route));
        return $this->subject('Email Change Verification')
            ->markdown('emails.auth.email.change-verification')
            ->with([
                'url' => $url
            ]);
    }
}
