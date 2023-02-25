<?php

namespace App\Observers;

use App\Events\NotificacionEstadoSolicitudEdicionPostEvent;
use App\Events\NotificacionNuevoPermisoEdicionPostEvent;
use App\Jobs\PermitirEdicionPostLectorJob;
use App\Models\PermisosEdicionPost;
use App\Notifications\PermisosEditarPostNotification;

class PermisosEdicionPostObserver
{
    
    /**
     * Handle the PermisosEdicionPost "created" event.
     *
     * @param  \App\Models\PermisosEdicionPost  $permisosEdicionPost
     * @return void
     */
    
    public function created(PermisosEdicionPost $permisosEdicionPost)
    {
        event(new NotificacionNuevoPermisoEdicionPostEvent($permisosEdicionPost));
    }

    /**
     * Handle the PermisosEdicionPost "updated" event.
     *
     * @param  \App\Models\PermisosEdicionPost  $permisosEdicionPost
     * @return void
     */
    public function updated(PermisosEdicionPost $permisosEdicionPost)
    {
        if($permisosEdicionPost->esta_aprobado())
        {
            $permisosEdicionPost->solicitadopor->notify(new PermisosEditarPostNotification($permisosEdicionPost));

            event(new NotificacionEstadoSolicitudEdicionPostEvent($permisosEdicionPost, 'Tu solicitud para editar el post fue aprobada'));

        }

        if($permisosEdicionPost->esta_rechazada())
        {
            event(new NotificacionEstadoSolicitudEdicionPostEvent($permisosEdicionPost, 'Tu solicitud para editar el post fue rechazada'));
        }

        if($permisosEdicionPost->esta_en_curso())
        {
            PermitirEdicionPostLectorJob::dispatch($permisosEdicionPost)->delay(now()->addMinutes(config('helpers.tiempo_edicion_minutos')));;
        }
    }

   
}
