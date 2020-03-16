<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCaptcha extends Mailable
{
    use Queueable, SerializesModels;

    public $captcha;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($captcha)
    {
        $this->captcha = $captcha;
    }

    public $subject = 'NCSLab注册验证码';
  /** NCSLab注册验证码  */
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.sendCaptcha');
    }
}
