<?php

namespace App\Listeners;

use App\Models\User;
use Notification;
use Log;

use App\Events\ImagenesProcesadasEvent;
use App\Notifications\ImagenesProcesadasAdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ImagenesProcesadasAdminlistener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ImagenesProcesadasEvent  $event
     * @return void
     */
    public function handle(ImagenesProcesadasEvent $event)
    {
        $administradores = User::query()
            ->whereHas('roles', function($q) { 
                $q->whereName('Administrador'); 
            })
            ->get();

        Notification::send($administradores, new ImagenesProcesadasAdminNotification($event->post));
    }
}
