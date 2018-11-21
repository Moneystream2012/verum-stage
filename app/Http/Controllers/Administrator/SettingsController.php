<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Artisan;

class SettingsController extends Controller
{
    public function index()
    {
        $checkDown = \App::isDownForMaintenance();

        return view('administrator.settings', ['checkDown' => $checkDown]);
    }

    public function up()
    {
        Artisan::call('up');
        flash()->success('Site: Enable!')->important();

        return redirect()->back();
    }

    public function down()
    {
        Artisan::call('down');
        flash()->success('Site: Disable!')->important();

        return redirect()->back();
    }
}
