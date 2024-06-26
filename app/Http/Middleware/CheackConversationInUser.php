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
        // dd($request->conversation_id);
        $authId = auth()->user()->id;
        $conversation = Conversation::where('id', $request->conversation_id)
            ->where(function ($query) use ($authId) {
                $query->where('user1_id', $authId)
                    ->orWhere('user2_id', $authId);
            })
            ->first();

        if ($conversation) {
            return $next($request);
        }

        return response()->json([
            'User does not have the right permissions.'
        ], 403);
    }
}
