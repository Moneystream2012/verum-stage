<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Changelog;
use Carbon\Carbon;

class ChangelogController extends Controller
{
    public function index()
    {
        $data = Changelog::latest()->get();
        return view('personal-office.changelog', [
            'data' => $data,
        ]);
    }
}
