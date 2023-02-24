<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\PermisosEdicionPostController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostImagenesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('login'); });

Route::group(['middleware' => ['auth']], function () 
{
    Route::view('dashboard', 'dashboard')->name('dashboard');
    
    Route::post('/marcar/notificacion', NotificacionController::class)->name('marcar.notificacion');
   
    Route::resource('post', PostController::class);

    Route::resource('postImagenes', PostImagenesController::class);

    Route::resource('permisos_post', PermisosEdicionPostController::class);

    Route::group(['prefix' => 'exportacion', 'as' => 'exportacion.'], function(){
        Route::get('posts', [PostController::class, 'exportar_posts'])->name('posts');
    });

    Route::get('permisos/tokens/{token}', [PermisosEdicionPostController::class, 'verificar_token'])->name('verificar.token');
    Route::post('comparar/token', [PermisosEdicionPostController::class, 'comparar_token'])->name('comparar.token');

    Route::resource('solicitudes', PermisosEdicionPostController::class);

    Route::fallback(function () {
        return \Response::view('errors.404');
    });
});

require __DIR__.'/auth.php';
