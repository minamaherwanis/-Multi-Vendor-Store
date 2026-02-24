<?php

namespace App\Events;

use App\Models\Delivery;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeliveryLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $latitude;

    public $longitude;

    protected $delivery;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Delivery $delivery, $latitude, $longitude)
    {
        $this->delivery = $delivery;
        $this->latitude = (float) $latitude;
        $this->longitude = (float) $longitude;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('deliveries.' . $this->delivery->order_id);
    }

    public function broadcastWith()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    public function broadcastAs()
    {
        return 'location-updated';
    }
}
