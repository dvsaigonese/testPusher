<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class GreetingSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $user;
    //dùng protected vì đây là người nhận
    public $message;
    public function __construct(User $user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }
    public function broadcastOn(): array
    {
        //set channel lại như thế này
        \Log::debug($this->message);
        return [new Channel("chat.greet.{$this->user->id}")];
    }
}