<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomMember extends Model
{
    protected $fillable = [
        'user_id',
        'room_id',
        'role',
    ];
    /**
     * Get the user that owns the RoomMember.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the room that owns the RoomMember.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
