<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, $id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json([
            'message' => 'Notification marked as read',
            'success' => true
        ]);
    }

    public function markAllAsRead(Request $request)
    {
        $notifications = auth()->user()->unreadNotifications;
        foreach ($notifications as $notification) {
            $notification->markAsRead();
        }

        return response()->json([
            'message' => 'All notifications marked as read',
            'success' => true,
            'count' => $notifications->count()
        ]);
    }
}
