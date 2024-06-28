<?php

namespace App\Http\Controllers\Message;

use App\Events\deleteMessageEvent;
use App\Events\updateMessageEvent;
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
use Illuminate\Validation\ValidationException;

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
        try {
            $conversation = Conversation::findOrFail($conversation_id);

            if ($conversation->user1_id != auth()->user()->id && $conversation->user2_id != auth()->user()->id) {
                Log::error('Unauthorized access attempt', ['user_id' => auth()->user()->id, 'conversation_id' => $conversation_id]);
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $request->validate([
                'message_text' => 'required|string|max:1000',
            ]);

            $sender = auth()->user()->id;
            $receiverId = $conversation->user1_id == $sender ? $conversation->user2_id : $conversation->user1_id;

            $message = Message::create([
                "conversation_id" => $conversation_id,
                "sender_user_id" => $sender,
                "receiver_user_id" => $receiverId,
                "message_text" => $request->input("message_text"),
            ]);

            broadcast(new MessageUserEvent($message))->toOthers();

            $receiver = User::find($receiverId);
            if ($receiver->status == false) {
                Notification::send($receiver, new NotificationMessage($receiver, $message->message_text));
            }

            return response()->json(["message" => $message]);

        }catch (ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json(['error' => 'Validation failed', 'messages' => $e->errors()], 422);

        } catch (\Exception $e) {
            Log::error('An unexpected error occurred', ['exception' => $e->getMessage()]);
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }



    public function receiveMessages(Request $request, $conversation_id)
    {
        $messageId = $request->input('messageId');
        $message = Message::where("conversation_id", $conversation_id)
                    ->where("id", $messageId)
                    ->first(['id', 'conversation_id', 'sender_user_id', 'receiver_user_id', 'message_text', 'created_at']);

        if ($message) {
            $date = Helpers::formatMessageDate($message->created_at);
            return response()->json([
                "message" => $message,
                "sender" => $message->sender()->select('id', 'name', 'image')->first(),
                "date" => $date
            ], 200);
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


    public function update(Request $request, $conversation_id, $message_id)
    {
        $validatedData = $request->validate([
            'editMessageText' => 'required|string|max:255',
        ]);

        $message = Message::find($message_id);
        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        $message->message_text = $validatedData['editMessageText'];
        $message->save();

        broadcast(new UpdateMessageEvent($message));

        return response()->json(['success' => true, 'message_text' => $message->message_text, 'id' => $message->id]);
    }


    public function destroy($conversation_id,$messages_id)
    {
        $message = Message::find($messages_id);

        if (!$message) {
            return response()->json(['error' => 'Message not found'], 404);
        }

        broadcast(new deleteMessageEvent($message));
        $message->delete();


        return response()->json(['message' => 'Message deleted successfully',"data" =>$message]);
    }


}
