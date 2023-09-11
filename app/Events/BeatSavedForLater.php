<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BeatSavedForLater implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $beat;
    public $username;

    /**
     * Create a new event instance.
     */
    public function __construct(Beat $beat, $username)
    {
        $this->beat = $beat;
        $this->username = $username;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
       return new Channel('beat-notifications.' . $this->beat->user->id);
    }

    public function broadcastAs()
    {
        return 'beat-saved-for-later';
    }
}
