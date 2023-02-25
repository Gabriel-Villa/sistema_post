<?php

namespace App\Events;

use App\Models\PermisosEdicionPost;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificacionEstadoSolicitudEdicionPostEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $permisosEdicionPost, $mensaje; 
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PermisosEdicionPost $permisosEdicionPost, $mensaje)
    {
        $this->permisosEdicionPost = $permisosEdicionPost;
        $this->mensaje = $mensaje;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('notificacion.'.$this->permisosEdicionPost->solicitado_por);
    }

    public function broadcastWith()
    {
        return [
            'body' => $this->mensaje,
        ];
    }

}
