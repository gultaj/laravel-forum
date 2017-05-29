<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use \Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $user)
    {
        return $user->unreadNotifications;
    }

    public function destroy(User $user, $notification_id)
    {
        $user->notifications()->findOrFail($notification_id)->markAsRead();
    }
}
