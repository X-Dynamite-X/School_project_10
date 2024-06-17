<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Conversation;

class NewConversation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversation;
    public $receiver;
    public $authUser;

    public function __construct(Conversation $conversation,$receiver,$authUser)
    {
        $this->conversation = $conversation;
        $this->receiver = $receiver;
        $this->authUser = $authUser;


    }

    public function broadcastOn()
    {
        return new Channel('user_' . $this->receiver->id);
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->conversation->id,
            'user' =>$this->authUser ,
        ];
    }

    public function broadcastAs()
    {
        return 'new_conversation';
    }

}
