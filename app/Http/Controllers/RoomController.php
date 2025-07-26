<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoomRequest;
use App\Models\Message;
use App\Models\Room;
use App\Models\RoomMember;
use App\Services\MessageService;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class RoomController extends Controller
{
  public function index(): Response
  {
    return Inertia::render('Room/Index', [
      'rooms' =>  Room::myRooms()->paginate(10),
    ]);
  }

  public function store(CreateRoomRequest $request): RedirectResponse
  {
    $validatedData = $request->validated();

    $validatedData['user_id'] = Auth::user()->id;

    $room = Room::create($validatedData);

    RoomMember::create([
      'user_id' => Auth::user()->id,
      'room_id' => $room->id,
      'role' => 'admin',
    ]);

    return to_route('room.index');
  }

  public function join(Room $room, MessageService $messageService): Response
  {
    // Check if the user is already a member of the room
    $exists = RoomMember::where('user_id', Auth::id())
      ->where('room_id', $room->id)
      ->exists();

    if (!$exists) {
      RoomMember::create([
        'user_id' => Auth::user()->id,
        'room_id' => $room->id,
        'role' => 'member',
      ]);
    }

    $members = RoomMember::where('room_id', $room->id)
      ->with('user')
      ->where('user_id', '!=', Auth::user()->id)
      ->get();

    // $selectedUser = $members[0] ?? null;

    $messages = $messageService->getRoomMessages(
      $room->id
    );

    return Inertia::render('Room/Chat/Index', [
      'users' => $members,
      // 'selectedChat' => $selectedUser,
      'messages' => $messages,
      'room' => [
        'name' => $room->name,
        'id' => $room->id,
      ],
    ]);
  }

  public function destroy(Room $room): RedirectResponse
  {
    $room->delete();

    return Redirect::back();
  }
}
