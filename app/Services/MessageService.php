<?php

namespace App\Services;

use App\Models\Message;
use Illuminate\Database\Eloquent\Collection;

class MessageService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getRoomMessages($roomId): Collection
    {
        return Message::where('room_id', $roomId)->whereNull('receiver_id')->get();
    }

    public function getPrivateRoomMessages($userA, $userB, $roomId): Collection
    {
        return Message::where(function ($query) use ($userA, $userB, $roomId) {
            $query->where('sender_id', $userA)
                ->where('receiver_id', $userB)
                ->where('room_id', $roomId);
        })->orWhere(function ($query) use ($userA, $userB, $roomId) {
            $query->where('sender_id', $userB)
                ->where('receiver_id', $userA)
                ->where('room_id', $roomId);
        })->oldest()->get();
    }
}
