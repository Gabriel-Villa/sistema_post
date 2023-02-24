<?php

namespace App\Service;

use App\Jobs\ConvertirImagenEscalaGrisesJob;
use App\Models\Post;
use App\Models\PostImagenes;
use App\Events\ImagenesProcesadasEvent;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch;


class PostImagenService {

    function retornarJobs(Post $post) 
    {
        $jobs = collect();

        foreach (request()->post_file as $imagen)
        {
            $file = (new FileService())->guardar_archivo("/posts", $imagen);

            $post_imagen = PostImagenes::create(['nombre' => $file['nombre'], 'post_id' => $post->id]);

            $jobs->push(new ConvertirImagenEscalaGrisesJob($post_imagen));
        }

        return $jobs;
    }

    function despacharJobs($jobs, Post $post)
    {
        $usuario = auth()->user();
        
        Bus::batch($jobs)
            ->finally(function (Batch $batch) use($usuario, $post)
            {
                event(new ImagenesProcesadasEvent($usuario, $post));
            })
            ->name('Convertir imagenes en blanco y negro')
            ->allowFailures()
            ->onConnection('redis-long-processes')
            ->dispatch();
    }


}