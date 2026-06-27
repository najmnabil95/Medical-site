<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Appointment;

class AppointmentStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $appointment;
    public $oldStatus;

    /**
     * Create a new event instance.
     */
    public function __construct(Appointment $appointment, $oldStatus = null)
    {
        $this->appointment = $appointment;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
