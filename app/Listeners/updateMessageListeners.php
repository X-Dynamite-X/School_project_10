<?php

namespace App\Listeners;

use Pusher\Pusher;
use App\Events\updateMessageEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class updateMessageListeners
{
    /**
     * Create the event listener.
     */
    protected $pusher;

    public function __construct()
    {
        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true
            ]
        );
    }
    /**
     * Handle the event.
     */
    public function handle(updateMessageEvent $event): void
    {
        $this->pusher->trigger('updateMessageConversation'.$event->message->id , 'updateMessageConversation', [
            'message' => $event->message,
        ]);
    }
}
