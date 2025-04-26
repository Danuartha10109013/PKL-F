<?php

namespace App\Events;

use App\Models\NotifM;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NotifikasiBaru implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $notif;

    /**
     * Create a new event instance.
     */
    public function __construct(NotifM $notif)
    {
        $this->notif = $notif;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn()
{
    \Log::info('Broadcast ke channel:', ['notification-channel.' . $this->notif->user_id]);
    return new PrivateChannel('notification-channel.' . $this->notif->user_id);
}


    /**
     * Nama event yang dikirim ke frontend
     */

     public function broadcastAs()
     {
         return 'NotifikasiBaru'; // Pastikan nama event sesuai
     }

     public function broadcastWith()
{
    return [
        'notif' => $this->notif->toArray()
    ];
}

}
