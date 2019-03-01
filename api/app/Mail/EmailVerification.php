<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerification extends Mailable
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
        $url = url(config('app.client_url') . '/auth/verify/?signature=' . $this->signature);
        return $this->subject('Verify Email Address')
            ->markdown('emails.auth.verify')
            ->with([
                'url' => $url
            ]);
    }
}
