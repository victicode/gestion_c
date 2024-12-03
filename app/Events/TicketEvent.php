<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel; 
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class TicketEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $departament;

    public function __construct($departament)
    {
        //
        $this->departament = $departament;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(){
    
        return[
            new Channel('updateTicket'. $this->departament),
            new Channel('recall'. $this->departament),
            new Channel('updateDepataments'),
        ] ;
    }
}
