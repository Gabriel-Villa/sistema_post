<?php

    if (! function_exists('limpiar_directorio'))
    {
        function limpiar_directorio($ruta, $funcion_path)
        {
            try {
                
                $directory = $funcion_path($ruta);
                $files = \File::allFiles($directory);
                foreach ($files as $file) {
                    \File::delete($file);
                }
    
                \Log::info("Directorio limpiado: " . $directory);
                //code...
            } catch (\Exception $th) {
               
                \Log::info("El directorio no existe: " . $directory);

            }
            
        }
    }