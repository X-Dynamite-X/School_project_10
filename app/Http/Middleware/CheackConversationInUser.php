<?php

namespace App\Http\Middleware;

use App\Models\Conversation;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheackConversationInUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authId = auth()->user()->id;
        $conversation =Conversation::find($request->conversation_id);
        // ->where("user1_id",$authId)
        // ->orWhere("user2_id",$authId)->get();
        if($conversation->user1_id ==$authId || $conversation->user2_id ==$authId ){

            return $next($request);
        };
        return response()->json([
            'User does not have the right permissions.'
            ],403);
    }
}
