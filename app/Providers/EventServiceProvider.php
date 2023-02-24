<?php

namespace App\Providers;

use App\Events\ImagenesProcesadasEvent;
use App\Listeners\ImagenesProcesadasAdminlistener;
use App\Listeners\ImagenesProcesadasEditorlistener;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Models\Post;
use App\Observers\PostObserver;
use App\Models\PermisosEdicionPost;
use App\Observers\PermisosEdicionPostObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ImagenesProcesadasEvent::class => [
            ImagenesProcesadasAdminlistener::class,
            ImagenesProcesadasEditorlistener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Post::observe(PostObserver::class);
        PermisosEdicionPost::observe(PermisosEdicionPostObserver::class);
    }
}
