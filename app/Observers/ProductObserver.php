<?php

namespace App\Observers;

use App\Events\NewProductAddEvent;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewProductAddNotification;
use Illuminate\Support\Facades\Notification;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $users = User::where('is_admin', false)->get();
        foreach ($users as $user) {
            Notification::send($user, new NewProductAddNotification($product));
            event(new NewProductAddEvent($product));
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
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
