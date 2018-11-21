<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function boot()
    {
        parent::boot();
        fastcgi_finish_request();
    }

    public function trans_view($path = ''){
        return trans('unify/'.app('request')->path().'.'.$path);
    }
}
