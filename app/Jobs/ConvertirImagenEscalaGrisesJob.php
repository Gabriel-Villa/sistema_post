<?php

namespace App\Jobs;

use App\Models\PostImagenes;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;
use Log;
use Image;
use Storage;

class ConvertirImagenEscalaGrisesJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $post_imagen;

    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PostImagenes $post_imagen)
    {
        $this->post_imagen = $post_imagen;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $imagePath = Storage::disk('posts')->path('') . $this->post_imagen->nombre;

        Image::make($imagePath)->greyscale()->save();
    }

    /**
     * Get the tags that should be assigned to the job.
     *
     * @return array
     */
    public function tags()
    {
        return ['conversion_escala_grises'];
    }

}



