<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('limpiar:directorio_public {ruta}', function () {
    $ruta = $this->argument('ruta');
    limpiar_directorio($ruta, 'public_path');
});

Artisan::command('limpiar:directorio_storage {ruta}', function () {
    $ruta = $this->argument('ruta');
    limpiar_directorio($ruta, 'storage_path');
});
