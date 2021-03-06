<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct( $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        // get the activation token
        $token = $this->user->verificationToken()
            ->where('type', 'activate')
            ->first();

        return $this->subject('Activate Your Account')
            ->view('activation_mail')
            ->with(['token' => $token]);
    }
}
