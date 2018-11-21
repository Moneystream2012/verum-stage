<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewNoticeMessage extends Notification
{
    use Queueable;

    /**
     * @var
     */
    private $text;

    /**
     * Create a new notification instance.
     *
     * @param $text
     */
    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'icon'   => 'fa-envelope',
            'status' => 'default',
            'text'   => $this->text,
        ];
    }
}
