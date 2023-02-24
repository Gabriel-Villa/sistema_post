<?php

namespace App\Service;

class FileService {

    function guardar_archivo($directory, $file)
    {
        $filename = $file->getClientOriginalName();
        
        $path = $file->storeAs($directory, $filename);

        return [
            'path' => $path,
            'nombre' => $filename
        ];
    }

}