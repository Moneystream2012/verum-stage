<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function show()
    {
        $notifications = auth()->user()->notifications;
        auth()->user()->unreadNotifications->markAsRead();

        return view('administrator.notification', ['notifications' => $notifications]);
    }
}
