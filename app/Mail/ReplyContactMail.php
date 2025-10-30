<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact; // dữ liệu contact
    public $replyMessage; // nội dung trả lời

    /**
     * Create a new message instance.
     */
    public function __construct($contact, $replyMessage)
    {
        $this->contact = $contact;
        $this->replyMessage = $replyMessage;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Phản hồi từ chúng tôi')
                    ->view('emails.reply_contact'); // view email
    }
}
