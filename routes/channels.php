<?php

use App\Broadcasting\ChatChannel;
use App\Broadcasting\AppNotifications;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('app-notifications', AppNotifications::class);
Broadcast::channel('chat', ChatChannel::class);