<?php

namespace App\Observers;

use App\Models\Post;
use Log;
use App\Service\PostImagenService;

class PostObserver
{
    
    private $postImagenService;

    public function __construct(PostImagenService $postImagenService)
    {
        $this->postImagenService = $postImagenService;
    }
    
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    
    public function created(Post $post)
    {
        activity()->log('Se creo un post');
       
        $jobs = $this->postImagenService->retornarJobs($post);

        $this->postImagenService->despacharJobs($jobs, $post);
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        activity()->log('Actualizo un post');

        if(request()->hasFile('post_file'))
        {
            $jobs = $this->postImagenService->retornarJobs($post);
    
            $this->postImagenService->despacharJobs($jobs, $post);

        }

    }

    /**
     * Handle the Post "deleted" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function deleted(Post $post)
    {
        activity()->log('Elimino un post : '. $post->nombre);
    }

}
