<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return Auth::user()->notifications;
    }

    public function markAsRead($notificationId)
    {
        Auth::user()->notifications->find($notificationId)->markAsRead();
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications->markAsRead();
    }
}
