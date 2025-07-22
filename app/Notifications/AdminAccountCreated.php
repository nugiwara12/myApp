<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminAccountCreated extends Notification
{
    use Queueable;

    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Admin Account')
            ->greeting('Hello ' . $notifiable->name)
            ->line('You have been added as an Admin.')
            ->line('Your temporary password is: **' . $this->password . '**')
            ->action('Login Now', route('login'))
            ->line('You are required to change your password on first login.');
    }

}
