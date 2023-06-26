<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HotelEnquiry;
use App\Models\ChatRoom;
use App\Models\ChatMessage;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chatRoom = ChatRoom::firstOrCreate([
            'user_id' => auth()->user()->id,
            'friend_id' => $request->id
        ], [
            'user_id' => auth()->user()->id,
            'friend_id' => $request->id
        ]);
        if ($chatRoom) {
            $chatMessage = ChatMessage::create([
                'chat_room_id' => $chatRoom->id,
                'sender_id' => auth()->user()->id,
                'receiver_id' => $request->id,
                'message' => $request->message,
                'is_read' => 0
            ]);
            if ($chatMessage) {
                return ['status' => 1, 'message' => 'Enquiry sent successfully'];
            } else {
                return ['status' => 0, 'message' => 'Enquiry not sent'];
            }
        } else {
            return ['status' => 0, 'message' => 'Enquiry not sent'];
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
