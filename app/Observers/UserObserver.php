<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\NewUserNotification;
use Filament\Notifications\Events\DatabaseNotificationsSent;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        /* send OTP mail notification to user */
        \Illuminate\Support\Facades\Notification::send($user, new NewUserNotification($user));
        /* send notification to admin that new user come */
        $admin = User::where("is_admin", true)->first();
        \Filament\Notifications\Notification::make()
            ->icon('fas-user-plus')
            ->iconColor('primary')
            ->title('New User In Your Pharmacy')
            ->body('Name : ' . $user->name . ' & Email : ' . $user->email)
            ->sendToDatabase($admin);
        event(new DatabaseNotificationsSent($admin));
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        /* send notification to admin that user leave */
        $admin = User::where("is_admin", true)->first();
        \Filament\Notifications\Notification::make()
            ->icon('fas-user-minus')
            ->iconColor('danger')
            ->title('User Leaved Your Pharmacy')
            ->body('Name : ' . $user->name . ' & Email : ' . $user->email . ' & Phone : ' . $user->phone)
            ->sendToDatabase($admin);
        event(new DatabaseNotificationsSent($admin));
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
