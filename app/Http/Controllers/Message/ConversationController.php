<?php

namespace App\Http\Controllers\Message;

use App\Models\User;
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
            if ($conversationExist["user1_id"] ==auth()->user()->id) {
                // print_r($conversationExist["user2_id"]);
                // print_r("\n############\n");
                $conversationUsers[$conversationExist["user2_id"]] = $conversationExist["user2_id"]; // تصحيح الإضافة هنا
            } else {
                // print_r($conversationExist["user1_id"]);
                // print_r("\n############\n");
                $conversationUsers[$conversationExist["user1_id"]] = $conversationExist["user1_id"]; // وهنا أيضًا
            }
        };

        // print_r("\n############\n");
        // print_r($conversationUsers);

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
        //
        $conversations = Conversation::all();
        $users = User::all();
        return view("chat.chat_room", ['conversations' => $conversations, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */


    public function create(Request $request, $user1_id, $user2_id)
    {
        // Validate the incoming request data
        $request->validate([
            'user1_id' => 'required|exists:users,id',
            'user2_id' => 'required|exists:users,id',
        ]);

        // Check if conversation already exists
        $conversationExists = Conversation::where(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user1_id)
                ->where('user2_id', $user2_id);
        })->orWhere(function ($query) use ($user1_id, $user2_id) {
            $query->where('user1_id', $user2_id)
                ->where('user2_id', $user1_id);
        })->exists();

        // If conversation already exists, return error response
        if ($conversationExists) {
            // return response()->json(['message' => 'Conversation already exists'], 400);
            $conversation=Conversation::where('user1_id', $user1_id)->where('user2_id', $user2_id);
            $conversation_id=$conversation->id;
            return redirect()->route('show_ConversationController',['conversation_id'=>$conversation_id]);
        }

        // Create the conversation
        $conversation = new Conversation();
        $conversation->user1_id = min($user1_id, $user2_id); // أختيار أصغر قيمة
        $conversation->user2_id = max($user1_id, $user2_id); // أختيار أكبر قيمة
        $conversation->save();

        // Return a response indicating success
        // return response()->json(['message' => 'Conversation created successfully'], 201);
        return redirect()->route('show_ConversationController',['conversation_id'=>$conversation->id]);

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
