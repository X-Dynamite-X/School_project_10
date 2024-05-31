<?php

namespace App\Http\Controllers\Message;

use App\Models\User;
use App\Models\Message;
use App\Models\Session;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Events\MessageUserEvent;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Events\MessageSentNotification;
use App\Notifications\NotificationMessage;
use Illuminate\Support\Facades\Notification;

class MesageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $conversations = Conversation::where(function ($query) {
            $query->where('user1_id', Auth::id())
                ->orWhere('user2_id', Auth::id());
        })
        ->with(['user1.sessions', 'user2.sessions', 'messages' => function ($query) {
            $query->latest()->first();
        }])
        ->get()
        ->sortByDesc(function ($conversation) {
            return optional($conversation->messages->first())->created_at ?? $conversation->created_at;
        });

        return view("user.message.index", ["conversations" => $conversations]);
    }

    // private function isUserOnline($userId)
    // {
    //     // تحقق من وجود جلسة نشطة لهذا المستخدم
    //     return Session::where('user_id', $userId)
    //         ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
    //         ->exists();
    // }


    public function store(Request $request, $conversation_id)
    {

        Log::info('Starting to store message');

        $conversation = Conversation::findOrFail($conversation_id);

        if ($conversation->user1_id != auth()->user()->id && $conversation->user2_id != auth()->user()->id) {
            Log::error('Unauthorized access', ['user_id' => auth()->user()->id]);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message_text' => 'required',
        ]);

        $sender = auth()->user()->id;
        $receiverId = $conversation->user1_id == $sender ? $conversation->user2_id : $conversation->user1_id;

        $message = Message::create([
            "conversation_id" => $conversation_id,
            "sender_user_id" => $sender,
            "receiver_user_id" => $receiverId,
            "message_text" => $request->input("message_text"),
        ]);

        Log::info('Message created', ['message' => $message]);

        broadcast(new MessageUserEvent($message->conversation_id, $message->sender_user_id, $message->receiver_user_id, $message->message_text))->toOthers();
        // $receiver = User::find($receiver);
        // Notification::send( $receiver,new NotificationMessage( $receiver , $message->message_text));

        Log::info('Event broadcasted');

        return view("user.message.action.sender", ['message' => $message]);
    }


    public function receiveMessages(Request $request, $conversation_id)
{
    $message = Message::where("conversation_id", $conversation_id)->latest()->first();
    return view('user.message.action.reseve', ['message' => $message]);
}


public function show(string $conversation_id)
{
    $conversation = Conversation::with(['messages' => function ($query) {
        $query->orderBy('created_at', 'asc');
    }, 'user1', 'user2'])->findOrFail($conversation_id);

    return view("user.message.chatSbace", [
        'conversations' => Conversation::where('user1_id', auth()->user()->id)
            ->orWhere('user2_id', auth()->user()->id)
            ->with(['user1', 'user2', 'messages' => function ($query) {
                $query->latest()->first();
            }])
            ->get()
            ->sortByDesc(function ($conversation) {
                return $conversation->messages->first()->created_at ?? $conversation->created_at;
            }),
        'users' => User::all(),
        'conversation' => $conversation,
        'messages' => $conversation->messages
    ]);
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
     *
     *
     *
     * +
     *
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
