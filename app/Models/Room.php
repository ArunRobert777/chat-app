<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Room extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function scopeMyRooms($query)
    {
        return $query->where('user_id', Auth::id())->orderBy('created_at', 'desc');
    }
}
