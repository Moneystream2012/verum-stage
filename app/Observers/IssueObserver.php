<?php

namespace App\Observers;

class IssueObserver
{
    public function created($model)
    {
        $model::flushCache('issues_count_'.$model->user_id);
    }

    public function updated($model)
    {
        $model::flushCache('issues_count_'.$model->user_id);
    }
}
