<?php

namespace App\Http\Controllers\Message;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ConversationController extends Controller
{

    public function searchUser(Request $request)
    {
        $searchTerm = $request->input('search');
        $user1_id = auth()->user()->id;

        $conversationExists = Conversation::where(function ($query) use ($user1_id) {
            $query->where('user1_id', $user1_id);
        })->orWhere(function ($query) use ($user1_id) {
            $query->where('user2_id', $user1_id);
        })->get()->toArray();
        $conversationUsers[] = $user1_id;
        foreach ($conversationExists as $conversationExist) {
            if ($conversationExist["user1_id"] == auth()->user()->id) {
                $conversationUsers[$conversationExist["user2_id"]] = $conversationExist["user2_id"]; // تصحيح الإضافة هنا
            } else {
                $conversationUsers[$conversationExist["user1_id"]] = $conversationExist["user1_id"]; // وهنا أيضًا
            }
        };
        $data = User::whereNotIn('id', $conversationUsers)
            ->where(function ($query) use ($searchTerm) {
                $query->where('id', 'LIKE', "%" . $searchTerm . "%")
                    ->orWhere('email', 'LIKE', "%" . $searchTerm . "%")
                    ->orWhere('name', 'LIKE', "%" . $searchTerm . "%");
            })->get();

        return response()->json($data);
    }



    // public function getConversations()
    // {
    //     $conversations = Conversation::where(function ($query) {
    //         $query->where('user1_id', auth()->user()->id)
    //             ->orWhere('user2_id', auth()->user()->id);
    //     })
    //         ->with(['user1.sessions', 'user2.sessions', 'messages' => function ($query) {
    //             $query->latest(); // ترتيب الرسائل داخل كل محادثة بناءً على الأحدث
    //         }])
    //         ->get()
    //         ->sortByDesc(function ($conversation) {
    //             return $conversation->messages->first()->created_at ?? $conversation->created_at;
    //         })->values();

    //     return response()->json(['conversations' => $conversations]);
    // }

    public function getConversations()
    {
        try {
            // جلب المحادثات
            $conversations = Conversation::where(function ($query) {
                $query->where('user1_id', auth()->user()->id)
                      ->orWhere('user2_id', auth()->user()->id);
            })
            ->with(['user1', 'user2', 'messages' => function ($query) {
                $query->latest(); // ترتيب الرسائل داخل كل محادثة بناءً على الأحدث
            }])
            ->get()
            ->sortByDesc(function ($conversation) {
                return $conversation->messages->first()->created_at ?? $conversation->created_at;
            })->values();

            // طباعة البيانات للتحقق
            Log::info('Conversations: ', $conversations->toArray());

            // التحقق من وجود الحقول المطلوبة
            $conversations = $conversations->map(function ($conversation) {
                $conversation->user1->is_online = $conversation->user1->is_online ?? false;
                $conversation->user1->last_seen_at = $conversation->user1->last_seen_at ?? 'No data available';

                $conversation->user2->is_online = $conversation->user2->is_online ?? false;
                $conversation->user2->last_seen_at = $conversation->user2->last_seen_at ?? 'No data available';

                return $conversation;
            });

            return response()->json(['conversations' => $conversations]);

        } catch (\Exception $e) {
            // تسجيل الخطأ وإرجاع رسالة خطأ
            Log::error('Error fetching conversations: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to fetch conversations'], 500);
        }
    }

    public function create(Request $request, $user1_id, $user2_id)
    {
        $conversation = Conversation::where(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user1_id)
                ->where('user2_id', $user2_id);
        })->orWhere(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user2_id)
                ->where('user2_id', $user1_id);
        })->first();
        $conversation = new Conversation();
        $conversation->user1_id = min($user1_id, $user2_id); //  Choose the smallest value
        $conversation->user2_id = max($user1_id, $user2_id); //  Choose the largest value
        $conversation->save();

        $messages = Message::where("conversation_id", $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();
        $authUser = auth()->user()->id;
        $receiver = $conversation->user1_id == $authUser ? $conversation->user2_id : $conversation->user1_id;
        $user = User::find($receiver);
        $authUser = User::find($authUser);

        return response()->json([
            'conversation' => $conversation,
            "user" => $user,
            'messages' => $messages,
            "authUser"=>$authUser,
        ], 201);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
