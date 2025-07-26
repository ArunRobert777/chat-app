<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\PrivateMessageRequest;
use App\Models\Message;
use App\Models\RoomMember;
use App\Services\MessageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    protected $messageService;

    public function __construct(MessageService $messageService) {
        $this->messageService = $messageService;
    }

    public function store(CreateMessageRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $validatedData['sender_id'] = Auth::user()->id;

        $message = Message::create($validatedData);

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => $message
        ], 201);
    }


    public function getPrivateRoomMessages(PrivateMessageRequest $request): JsonResponse
    {
        $userA = Auth::id();
        $userB = $request->input('receiver_id');
        $roomId = $request->input('room_id');

        $messages = $this->messageService->getPrivateRoomMessages($userA, $userB, $roomId);

        $data['messages'] = $messages;
        $data['selectedChat'] = RoomMember::where('user_id', $userB)
            ->where('room_id', $roomId)
            ->with('user')
            ->first();

        return response()->json($data);
    }
}
