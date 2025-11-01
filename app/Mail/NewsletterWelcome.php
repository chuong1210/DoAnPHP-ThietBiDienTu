<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterWelcome extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this->from('chuongbd1012@gmail.com', 'Tech Shop')
            ->subject('Chào mừng bạn đến với Tech Shop!')
            ->view('emails.newsletter.welcome')
            ->with(['email' => $this->email]);
    }
}
