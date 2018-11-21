<?php

namespace App\Notifications\Administrator;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewUserOfSupportMessage extends Notification
{
    use Queueable;

    use Queueable;

    /**
     * @var
     */
    private $issue_id;

    /**
     * NewSupportMessage constructor.
     *
     * @param $issue_id
     */
    public function __construct($issue_id)
    {
        $this->issue_id = $issue_id;
    }

    /**
     * Get the notification's delivery channels.
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
            'icon'   => 'fa-comment',
            'status' => 'default',
            'text'   => 'Новое сообщения от пользователя',
            'link'   => route('administrator.issues.dialog', ['id' => $this->issue_id], false),
        ];
    }
}
