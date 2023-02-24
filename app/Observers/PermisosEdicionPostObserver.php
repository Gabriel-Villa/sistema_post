<?php

namespace App\Observers;

use App\Jobs\PermitirEdicionPostLectorJob;
use App\Models\PermisosEdicionPost;
use App\Notifications\PermisosEditarPostNotification;
use Log;

class PermisosEdicionPostObserver
{
    
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
        }

        if($permisosEdicionPost->esta_en_curso())
        {
            PermitirEdicionPostLectorJob::dispatch($permisosEdicionPost)->delay(now()->addMinutes(config('helpers.tiempo_edicion_minutos')));;
        }
    }

   
}
