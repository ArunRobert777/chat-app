<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'receiver_id' => 'nullable|exists:users,id',
            'message' => 'required|string|max:255',
        ]);

        $validatedData['sender_id'] = $request->user()->id;

        $message = Message::create($validatedData);

        return redirect()->back();

    }
}
