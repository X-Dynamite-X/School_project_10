<?php

namespace App\Http\Controllers\Message;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function searchUser(Request $request)
    {
        $searchTerm = $request->input('search');
        $user1_id = auth()->user()->id;

        $conversationExists = Conversation::where(function ($query) use ($user1_id) {
            $query->where('user1_id', $user1_id);
        })->orWhere(function ($query) use ($user1_id) {
            $query->where('user2_id', $user1_id);
        })->get()->toArray();
        $conversationUsers[] = $user1_id; // إضافة معرف المستخدم الحالي إلى القائمة
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



    public function index()
    {
        $conversations = Conversation::all();
        $users = User::all();
        return view("chat.chat_room", ['conversations' => $conversations, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */


    public function create(Request $request, $user1_id, $user2_id)
    {
        $conversation = Conversation::where(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user1_id)
                ->where('user2_id', $user2_id);
        })->orWhere(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user2_id)
                ->where('user2_id', $user1_id);
        })->first();

        // إذا كانت المحادثة موجودة بالفعل، قم بإعادة المحادثة والرسائل الخاصة بها
        if ($conversation) {
            $messages = Message::where("conversation_id", $conversation->id)
                ->orderBy('created_at', 'asc')
                ->get();
            return response()->json([
                'conversation' => $conversation,
                'messages' => $messages
            ], 200);
        }

        // إنشاء محادثة جديدة
        $conversation = new Conversation();
        $conversation->user1_id = min($user1_id, $user2_id); // اختيار أصغر قيمة
        $conversation->user2_id = max($user1_id, $user2_id); // اختيار أكبر قيمة
        $conversation->save();

        $messages = Message::where("conversation_id", $conversation->id)
            ->orderBy('created_at', 'asc')
            ->get();
        $me = auth()->user()->id;
        $receiver = $conversation->user1_id == $me ? $conversation->user2_id : $conversation->user1_id;
        $user = User::find($receiver);
        // dd($user);
        return response()->json([
            'conversation' => $conversation,
            "user" => $user,
            'messages' => $messages
        ], 201);
    }


    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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
