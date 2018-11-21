<?php

namespace App\Notifications\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRank extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var
     */
    private $reward;

    public function __construct($reward)
    {
        $this->reward = $reward;
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
