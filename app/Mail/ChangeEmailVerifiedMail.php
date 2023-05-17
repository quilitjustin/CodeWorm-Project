<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChangeEmailVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $l_name;
    public $date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($l_name)
    {
        $this->l_name = $l_name;
        $date = now(); 
        $this->date = $date->format('F j, Y g:i A'); 
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(subject: 'Change Email Verified Mail');
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(markdown: 'mail.change_email_verified');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
