<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\RoomMember;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService) {
        $this->messageService = $messageService;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'receiver_id' => 'nullable|exists:users,id',
            'message' => 'required|string|max:255',
        ]);

        $validatedData['sender_id'] = $request->user()->id;

        $message = Message::create($validatedData);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => $message
        ], 201);
    }


    public function getPrivateRoomMessages(Request $request)
    {
        $userA = Auth::id();
        $userB = $request->post('receiver_id');
        $roomId = $request->post('room_id');

        $messages = $this->messageService->getPrivateRoomMessages($userA, $userB, $roomId);

        $data['messages'] = $messages;
        $data['selectedChat'] = RoomMember::where('user_id', $userB)
            ->where('room_id', $roomId)
            ->with('user')
            ->first();

        return response()->json($data);
    }
}
