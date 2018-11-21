<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewSupportMessage extends Notification
{
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
            'link'   => route('personal-office.issues.show', ['id' => $this->issue_id], false),
        ];
    }
}
