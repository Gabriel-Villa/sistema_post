<?php

namespace App\Jobs;

use App\Models\PermisosEdicionPost;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class PermitirEdicionPostLectorJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $permisosEdicionPost;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PermisosEdicionPost $permisosEdicionPost)
    {
        $this->permisosEdicionPost = $permisosEdicionPost;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::error("Se acabo el tiempo");
        
        $this->permisosEdicionPost->update(['estado' => PermisosEdicionPost::ESTADO_FINALIZADO]);
    }
}
