<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAllNotificationsAsRead()
    {
        $user = User::find(auth()->user()->id);
        $user->notifications->markAsRead();

        return ResponseHelper::finalResponse(
            'All Notifications Marked As Read',
            null,
            true,
            Response::HTTP_OK
        );
    }

    public function markNotificationAsRead($id)
    {
        $notification = DatabaseNotification::find($id);
        if ($notification && $notification->notifiable_id === auth()->user()->id) {
            $notification->markAsRead();

            return ResponseHelper::finalResponse(
                'Notification Marked As Read',
                null,
                true,
                Response::HTTP_OK
            );
        }

        return ResponseHelper::finalResponse(
            'Notification Not Found or Unauthorized',
            null,
            false,
            Response::HTTP_NOT_FOUND
        );
    }

    public function clearAllNotifications()
    {
        $user = User::find(auth()->user()->id);
        $user->notifications()->delete();

        return ResponseHelper::finalResponse(
            'All Notifications Cleared',
            null,
            true,
            Response::HTTP_OK
        );
    }

    public function clearNotification($id)
    {
        $notification = DatabaseNotification::find($id);
        if ($notification && $notification->notifiable_id === auth()->user()->id) {
            $notification->delete();

            return ResponseHelper::finalResponse(
                'Notification Cleared',
                null,
                true,
                Response::HTTP_OK
            );
        }

        return ResponseHelper::finalResponse(
            'Notification Not Found or Unauthorized',
            null,
            false,
            Response::HTTP_NOT_FOUND
        );
    }
}
