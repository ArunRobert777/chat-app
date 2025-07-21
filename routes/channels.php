<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.room.{roomId}', function ($user, $roomId) {
    return $user->rooms()->where('room_id', $roomId)->exists();
});
