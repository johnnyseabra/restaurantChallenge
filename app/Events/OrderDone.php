<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PhpParser\Node\Expr\BinaryOp\Identical;

class OrderDone implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

       public $message;

    /**
     * Create a new event instance.
     *
     * @param $id Order's id
     * @param $name Client's name
     * @return void
     */
    public function __construct($id, $name)
    {
        $this->message  = $id . "|" . $name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['restaurant-app'];
    }
    
    
    /**
     * Set the channels the event class name should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastAs()
    {
        return 'order-done';
    }
    
    /**
     * Set the parameters for broadcast.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastWith()
    {
        return ["message" => $this->message];
    }
}
