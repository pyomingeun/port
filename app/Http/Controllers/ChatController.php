<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $rooms = ChatRoom::with(['getLastMessage', 'getUser', 'getFriend'])
        ->where('user_id', auth()->user()->id)
        ->orWhere('friend_id', auth()->user()->id)
        ->orderBy('updated_at', 'desc')
        ->get();
      $chatMessages = count($rooms) > 0 ?
				ChatMessage::where('chat_room_id', $rooms[0]->id)->get(): [];
      if (count($rooms) > 0) {
        ChatMessage::where([
          'chat_room_id' => $rooms[0]->id,
          'receiver_id' => auth()->user()->id
        ])->update(['is_read' => 1]);
      }
      return view('chat.index', compact('rooms', 'chatMessages'));
    }

    public function getMessages(Request $request)
    {
      $chatMessages = ChatMessage::where('chat_room_id', $request->roomId)->get();
      ChatMessage::where([
        'chat_room_id' => $request->roomId,
        'receiver_id' => auth()->user()->id
      ])->update(['is_read' => 1]);
      return response()->json([
        'status' => 'success',
        'message' => 'Chat messages fetched successfully',
        'data' => $chatMessages,
        'chatCount' => getUnreadMessage()
      ]);
    }

    public function search(Request $request)
    {
      $rooms = ChatRoom::with(['getLastMessage', 'getUser', 'getFriend'])
        ->withCount(['getUser' => function ($query) use ($request) {
          $query->where('full_name', 'like', '%' . $request->search . '%');
        }, 'getFriend' => function ($query) use ($request) {
          $query->where('full_name', 'like', '%' . $request->search . '%');
        }])
        ->where('user_id', auth()->user()->id)
        ->orWhere('friend_id', auth()->user()->id)
        ->having('get_user_count', '>', 0)
        ->orHaving('get_friend_count', '>', 0)
        ->orderBy('updated_at', 'desc')
        ->get();
      $roomHtml = view('chat.roomlist', compact('rooms'))->render();
      return response()->json([
        'status' => 'success',
        'message' => 'Chat rooms fetched successfully',
        'data' => $roomHtml,
        'roomid' => count($rooms) > 0 ? $rooms[0]->id : 0
      ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $chat = ChatMessage::create([
        'chat_room_id' => $request->roomId,
        'sender_id' => $request->senderId,
        'receiver_id' => $request->receiverId,
        'message' => $request->message
      ]);
      if ($chat) {
        ChatRoom::where('id', $request->roomId)->update([
          'updated_at' => date('Y-m-d H:i:s')
        ]);
        return response()->json([
          'status' => 'success',
          'message' => 'Message sent successfully',
          'data' => $chat
        ]);
      } else {
        return response()->json([
          'status' => 'error',
          'message' => 'Message sent failed',
          'data' => []
        ]);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
