<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification implements ShouldQueue
{
    use  Queueable;

    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Your Reset Password')
            ->subject('Your Reset Password')
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', route('personal-office.password-reset-token', ['token' => $this->token]))
            ->line('If you did not request a password reset, no further action is required.');
    }
}
