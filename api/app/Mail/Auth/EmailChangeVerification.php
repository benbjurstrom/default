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
    protected $signature;

    /**
     * Create a new message instance.
     * @param User $user
     * @param string $signature
     * @return void
     */
    public function __construct(User $user, $signature)
    {
        $this->user  = $user;
        $this->signature = $signature;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Email Change Verification')
            ->markdown('emails.auth.email.change-verification')
            ->with([
                'url' => $this->signature
            ]);
    }
}
