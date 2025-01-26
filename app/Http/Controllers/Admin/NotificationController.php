<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.notifications');
    }

    public function fetchNotifications()
    {
        $notifications = Notification::with(['order.user', 'product'])->where('is_read', false)->get();
        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        return response()->json(['success' => true]);
    }

    public function countUnread()
    {
        $count = Notification::where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }
}
