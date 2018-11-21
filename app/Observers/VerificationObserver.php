<?php

namespace App\Observers;

use App\Verification;
use Storage;

class VerificationObserver
{
    public function deleting(Verification $model)
    {
        Storage::disk('verifications')->delete([
            $model->avatar,
            $model->doc_img
        ]);

        if ($model->user->hasSetting('verified')){
            $model->user->forgetSetting('verified');
        }
    }

    public function updated(Verification $model)
    {
        if ($model->status == Verification::VERIFIED){
            $model->user->setSetting(['verified' => true]);
        }
    }

}
