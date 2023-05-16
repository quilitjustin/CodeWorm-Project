<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class ChangeEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $id;
    public $email;
    public $verification_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id, $email)
    {
        $this->id = $id;
        $this->email = $email;
        $this->verification_url = $this->get_verification_url();
    }

    protected function get_verification_url()
    {
        $token = hash_hmac('sha256', $this->id . $this->email, env('APP_KEY'));

        $url = URL::temporarySignedRoute('verification.update.verify', now()->addHours(24), ['id' => $this->id, 'email' => $this->email, 'token' => $token]);

        return $url;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(subject: 'Change Email Mail');
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(markdown: 'mail.change_email');
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
