<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ForgotPWD extends Mailable
{
    use Queueable, SerializesModels;

    public $url, $account;

    public $subject = 'NCSLab重置密码';
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($forgotpwd_token, $account)
    {
        $this->url = env('APP_URL').'/resetpwd?token='.$forgotpwd_token;
        $this->account = $account;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forgotPWD');
    }
}
