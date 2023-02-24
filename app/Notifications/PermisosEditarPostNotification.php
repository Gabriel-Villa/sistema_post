<?php

namespace App\Notifications;

use App\Models\PermisosEdicionPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PermisosEditarPostNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $permisosEdicionPost;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(PermisosEdicionPost  $permisosEdicionPost)
    {
        $this->permisosEdicionPost = $permisosEdicionPost;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Solicitud para editar el post: '. $this->permisosEdicionPost->post->nombre ?? '' . 'fue aceptada') 
            ->line('Ingresa este token: ')
            ->line($this->permisosEdicionPost->token)
            ->action('En este link: ' , route('verificar.token', $this->permisosEdicionPost->token));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
