<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendUserPasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    private $emailTemplate;

    public function __construct($content,$emailTemplate)
    {
        $this->content = $content;
        $this->emailTemplate =$emailTemplate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.email')
            ->subject($this->emailTemplate->subject)
            ->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
    }
}
