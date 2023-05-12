<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ChangeEmailNotification extends Notification
{
    use Queueable;

    protected $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->getVerificationUrl($notifiable);

        return (new MailMessage())
            ->subject('Verify your new email address')
            ->line('Please click the button below to verify your new email address.')
            ->action('Verify Email Address', $verificationUrl)
            ->line('If you did not made this change, no further action is required on your part.')
            ->line('Thank you for using our services.')
            ->salutation('Sincerely,')
            ->greeting('Codeworm');
    }

    protected function getVerificationUrl($notifiable)
    {
        $token = hash_hmac('sha256', $notifiable->getKey() . $this->email, env('APP_KEY'));

        $url = URL::temporarySignedRoute('verification.update.verify', now()->addHours(24), ['id' => $notifiable->getKey(), 'email' => $this->email, 'token' => $token]);

        return $url;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                //
            ];
    }
}
