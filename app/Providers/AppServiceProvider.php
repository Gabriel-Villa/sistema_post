<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Auth;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::after(function ($user, $ability) {
            if($user->hasRole('Administrador'))
            {
                return true;
            }
        });
        
        view()->composer('layouts.app', function ($view) 
        {
            $notificaciones = auth()->user()->unreadNotifications;
            
            $view->with('notificaciones', $notificaciones);    
        });
    }
}
