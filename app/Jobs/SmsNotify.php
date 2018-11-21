<?php

namespace App\Jobs;

use App\Extensions\SmsRu;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SmsNotify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var User
     */
    private $user;
    /**
     * @var string
     */
    private $type;
    private $msg;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param string $type
     * @param array $data
     */
    public function __construct(User $user, string $type, array $data)
    {
        $this->user = $user;
        $this->type = $type;
        $this->msg = trans('sms_notify.'.$type, [
            'username' => $user->first_name
        ] + $data);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $smsru = new SmsRu('A5425202-B2A1-2950-763E-1F41A81B612F');
        $data = (object) [
            'from' => 'verumtrade',
            'to' => $this->user->mobile_number,
            'text' => $this->msg,
        ];

        $sms = $smsru->send_one($data);

        if ($sms->status == "OK") {
            echo "Сообщение отправлено успешно. ";
            echo "ID сообщения: $sms->sms_id. ";
            echo "Ваш новый баланс: $sms->balance";
        } else {
            echo "Сообщение не отправлено. ";
            echo "Код ошибки: $sms->status_code. ";
            echo "Текст ошибки: $sms->status_text.";
        }
    }
}
