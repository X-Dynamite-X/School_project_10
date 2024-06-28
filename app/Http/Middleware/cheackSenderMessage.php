<?php

namespace App\Http\Middleware;

use App\Models\Message;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class cheackSenderMessage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd($request->messages_id);
        $authId = auth()->user()->id;
        $message = Message::where('id', $request->messages_id)
            ->where(function ($query) use ($authId) {
                $query->where('sender_user_id', $authId);
            })
            ->first();

        if ($message) {
            return $next($request);
        }

        return response()->json([
            'User does not have the right permissions.'
        ], 403);
    }
}
