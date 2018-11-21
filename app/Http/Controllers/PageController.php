<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->fullUrl() != config('app.url')) {
            return redirect(config('app.url'));
        }

        if (auth()->check('user')) {
            return redirect()->route('personal-office.dashboard');
        }

        return redirect()->route('personal-office.login');
    }

    public function page(Request $request)
    {
        return view('pages.'.$request->route()->getName());
    }
}
