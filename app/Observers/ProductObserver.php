<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Product;
use App\Events\NewProductAddEvent;
use App\Events\StockProductEditEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewProductAddNotification;
use App\Notifications\ProducStockEditAddNotification;
use Filament\Notifications\Events\DatabaseNotificationsSent;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        /* send notification to all user that new product added */
        $users = User::where('is_admin', false)->get();
        foreach ($users as $user) {
            Notification::send($user, new NewProductAddNotification($product));
        }
        event(new NewProductAddEvent($product));
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        /* send notification to admin that stock decrease */
        $admin = User::where("is_admin", true)->first();
        if ($product->stock <= $product->alert) {
            \Filament\Notifications\Notification::make()
                ->icon('fas-clock')
                ->iconColor('warning')
                ->title('Product is near to finish.')
                ->body('Name : ' . $product->name)
                ->sendToDatabase($admin);
            event(new DatabaseNotificationsSent($admin));
        }
        /* send notification to all user that stock product edited */
        if ($product->stock > $product->alert) {
            $users = User::where('is_admin', false)->get();
            foreach ($users as $user) {
                Notification::send($user, new ProducStockEditAddNotification($product));
            }
            event(new StockProductEditEvent($product));
        }
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
