<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Order;
use App\Events\OrderDoneEvent;
use App\Notifications\OrderDoneNotification;
use Illuminate\Support\Facades\Notification;
use Filament\Notifications\Events\DatabaseNotificationsSent;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if ($order->payment_status) {
            /* send notification to admin that order done */
            $admin = User::where("is_admin", true)->first();
            \Filament\Notifications\Notification::make()
                ->icon('fas-cart-shopping')
                ->iconColor('success')
                ->title('New Order Done')
                ->body('ID of order : ' . $order->payment_id)
                ->sendToDatabase($admin);
            event(new DatabaseNotificationsSent($admin));
            /* send notification to user that order done */
            $users = User::where('is_admin', false)->get();
            foreach ($users as $user) {
                Notification::send($user, new OrderDoneNotification($order));
                event(new OrderDoneEvent($order));
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
