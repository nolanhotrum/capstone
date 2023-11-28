<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $verificationUrl;

    public function __construct(User $user, $verificationUrl)
    {
        $this->user = $user;
        $this->verificationUrl = $verificationUrl;
    }

    public function build()
    {
        $name = $this->user->name;

        return $this->html("Hello $name,<br><br>Thank you for registering. Please click the following link to verify your email: <a href=\"$this->verificationUrl\">Verify Email</a><br><br>If you did not create an account, no further action is required.")
            ->subject('Verify Your Email');
    }
}
