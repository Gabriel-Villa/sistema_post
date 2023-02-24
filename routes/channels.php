<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('notificacion.administradores', function ($user) {
    return $user->hasRole('Administrador') ? true : false;
});

Broadcast::channel('notificacion.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
