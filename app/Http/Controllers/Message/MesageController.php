<?php

namespace App\Http\Controllers\Message;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Events\MessageUserEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class MesageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $users = User::all();
        // $conversations = auth()->user()->conversations;

        $conversations = Conversation::where("user1_id", auth()->user()->id)->orWhere("user2_id", auth()->user()->id)->get();;
        // $conversations = Conversation::find(1);
        // dd($conversations);

        return view("user.message.index", ["conversations" => $conversations]);
    }


    public function store(Request $request, $conversation_id)
    {
        Log::info('Starting to store message');

        $conversation = Conversation::find($conversation_id);

        if (!$conversation) {
            Log::error('Conversation not found', ['conversation_id' => $conversation_id]);
            return response()->json(['error' => 'Conversation not found'], 404);
        }

        if ($conversation->user1_id != auth()->user()->id && $conversation->user2_id != auth()->user()->id) {
            Log::error('Unauthorized access', ['user_id' => auth()->user()->id]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message_text' => 'required',
        ]);

        $sender = auth()->user()->id;
        $receiver = $conversation->user1_id == $sender ? $conversation->user2_id : $conversation->user1_id;

        $message = Message::create([
            "conversation_id" => $conversation_id,
            "sender_user_id" => $sender,
            "receiver_user_id" => $receiver,
            "message_text" => $request->input("message_text"),
        ]);

        Log::info('Message created', ['message' => $message]);

        broadcast(new MessageUserEvent($message->conversation_id, $message->sender_user_id, $message->receiver_user_id, $message->message_text))->toOthers();

        Log::info('Event broadcasted');

        return view("user.message.action.sender", ['message' => $message]);
    }


    public function receiveMessages(Request $request,$conversation_id)
    {
        $conversation = Conversation::find($conversation_id);

        $message = Message::where("conversation_id", $conversation_id)->get()->last();
        // dd($message->text);
        return view('user.message.action.reseve', ['message' => $message]);
    }

    // public function store(Request $request, $conversation_id)
    // {
    //     $conversation = Conversation::findOrFail($conversation_id);

    //     $request->validate([
    //         'message_text' => 'required',
    //     ]);

    //     if ($conversation->user1_id == auth()->user()->id || $conversation->user2_id == auth()->user()->id) {
    //         $sender = auth()->user()->id;
    //         $receiver = $conversation->user1_id == auth()->user()->id ? $conversation->user2_id : $conversation->user1_id;

    //         $message = Message::create([
    //             'conversation_id' => $conversation_id,
    //             'sender_user_id' => $sender,
    //             'receiver_user_id' => $receiver,
    //             'message_text' => $request->input('message_text'),
    //         ]);

    //         broadcast(new MessageUserEvent($message->conversation_id, $message->sender_user_id, $message->receiver_user_id, $message->message_text))->toOthers();

    //         return view('user.message.action.sender', ['message' => $message]);
    //     } else {
    //         return response()->json(['error' => 'Unauthorized'], 403);
    //     }
    // }


    // public function receiveMessages(Request $request, $conversation_id)
    // {
    //     $conversation = Conversation::findOrFail($conversation_id);

    //     if ($conversation->user1_id == auth()->user()->id || $conversation->user2_id == auth()->user()->id) {
    //         $receive_user = $conversation->user1_id == auth()->user()->id ? $conversation->user2 : $conversation->user1;
    //         $message = Message::where('conversation_id', $conversation_id)->latest()->first();

    //         return view('user.message.action.receive', ['message' => $message, 'receive_user' => $receive_user]);
    //     } else {
    //         return response()->json(['error' => 'Unauthorized'], 403);
    //     }
    // }


    /**
     * Display the specified resource.
     */
    public function show(string $conversation_id)
    {
        //
        // $conversation =Conversation::where("id",$conversation_id);

        $conversations = Conversation::all();
        $conversation = Conversation::find($conversation_id);
        $messages = Message::where("conversation_id", $conversation_id)
            ->orderBy('created_at', 'asc')
            ->get();
        $users = User::all();

        return view("user.message.index", ['conversations' => $conversations, 'users' => $users, 'conversation' => $conversation, "messages" => $messages]);
        // return view("chat.chat_room");

    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
