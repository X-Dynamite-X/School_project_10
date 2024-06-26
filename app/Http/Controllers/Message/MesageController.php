<?php

namespace App\Http\Controllers\Message;

use Carbon\Carbon;
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
use Helpers;
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

        return view("user.message.index", ["conversations" => $conversations,]);
    }


    public function store(Request $request, $conversation_id)
    {


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


        broadcast(new MessageUserEvent($message->conversation_id, $message->sender_user_id, $message->receiver_user_id, $message->message_text,$message->id))->toOthers();
        $receiver = User::find($receiverId);
        if($receiver->status == false){

            Notification::send($receiver, new NotificationMessage($receiver, $message->message_text));
        }
        return response()->json(["message"=>$message]);
    }


    public function receiveMessages(Request $request, $conversation_id)
    {
        $messageId = $request->input('messageId');
        $message = Message::where("conversation_id", $conversation_id)
                    ->where("id", $messageId)
                    ->first();

        if ($message) {
            $date = Helpers::formatMessageDate($message->created_at);
            return response()->json(["message" => $message, "sender" => $message->sender, "date" => $date], 200);
        } else {
            return response()->json(["error" => "Message not found"], 404);
        }
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

    public function getMessage($getMessage)
    {
        //
        $message = Message::find($getMessage);

        if ($message) {
            return response()->json($message);
        } else {
            return response()->json(['error' => 'message not found'], 404);
        }
    }

    public function edit(string $id)
    {

    }

    // public function update($request, $messages_id)
    // {
    //     // dd($request);
    //     $messages = Message::find($messages_id)->first();
    //     $messages->message_text = $request->input('editMessageText');
    //     $messages->save();
    //     return response("done");
    // }
    public function update(Request $request, $conversation_id, $messages_id)
    {
        // تحقق من صحة البيانات المستلمة
        $validatedData = $request->validate([
            'editMessageText' => 'required|string|max:255',
        ]);

        // ابحث عن الرسالة المطلوبة
        $messages = Message::find($messages_id);
        if (!$messages) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        // حدث نص الرسالة واحفظ التغييرات
        $messages->message_text = $validatedData['editMessageText'];
        $messages->save();

        return response()->json(['success' => true, 'message_text' => $messages->message_text, 'id' => $messages->id]);
    }
    public function destroy($messages_id)
    {
        $messages = Message::find($messages_id)->first();
        $messages->delete();
        return response()->json($messages);
    }

}
