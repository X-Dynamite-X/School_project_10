<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageUserEvent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $conversation_id;
    public $sender_user_id;
    public $receiver_user_id;
    public $message_text;
    public $message_id;


    public function __construct($conversation_id, $sender_user_id, $receiver_user_id, $message_text,$message_id)
    {
        $this->conversation_id = $conversation_id;
        $this->sender_user_id = $sender_user_id;
        $this->receiver_user_id = $receiver_user_id;
        $this->message_text = $message_text;
        $this->message_id = $message_id;

    }
    public function broadcastOn()
    {
        return new Channel('conversation' . $this->conversation_id);
    }

    public function broadcastAs()
    {
        return 'conversation';
    }
}
