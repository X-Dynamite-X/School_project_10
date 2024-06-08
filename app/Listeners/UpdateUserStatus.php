<?php

namespace App\Listeners;

use Pusher\Pusher;
use App\Events\UserOnline;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUserStatus
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

    public function handle(UserOnline $event)
    {
        $this->pusher->trigger('user-status-channel', 'user-status-changed', [
            'userId' => $event->userId,
            'status' => $event->status
        ]);
    }
}
