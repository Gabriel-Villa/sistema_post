<?php

namespace App\Listeners;

use App\Models\User;
use Notification;
use Log;

use App\Events\ImagenesProcesadasEvent;
use App\Notifications\ImagenesProcesadasEditorNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ImagenesProcesadasEditorlistener
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
        $editor = User::where('id', $event->user->id)->get();

        Notification::send($editor, new ImagenesProcesadasEditorNotification($event->post));
    }
}
