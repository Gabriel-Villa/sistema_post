<x-app-layout>

    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent"
            role="tablist">
            <li class="mr-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="profile-tab" data-tabs-target="#profile"
                    type="button" role="tab" aria-controls="profile" aria-selected="false">Solicitudes Nuevas</button>
            </li>
        </ul>
    </div>
    <div id="myTabContent">
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel"
            aria-labelledby="profile-tab">
            @forelse ($solicitudes as $solicitud)
                <div id="alert-additional-content-{{ $solicitud->id }}"
                    class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800"
                    role="alert">
                    <div class="flex items-center">
                        <svg aria-hidden="true" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <h3 class="text-lg font-medium">Nueva solicitud</h3>
                    </div>
                    <div class="mt-2 mb-4 text-sm">
                        Nueva solicitud para editar el post: {{ $solicitud->post->nombre ?? '' }}, 
                        solicitado por el usuario: {{ $solicitud->solicitadopor->name ?? '' }}
                    </div>
                    <div class="flex">
                        <button type="button" onclick="actualizar_solicitud_permiso_edicion({{ $solicitud->id }}, {{ $solicitud->estado_aprobado }})"
                            data-dismiss-target="#alert-additional-content-{{ $solicitud->id }}" aria-label="Close"
                            class="text-white bg-blue-800 hover:bg-blue-900 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-lg text-xs px-3 py-1.5 mr-2 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg aria-hidden="true" class="-ml-0.5 mr-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                <path fill-rule="evenodd"
                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Aceptar
                        </button>
                        <button type="button" onclick="actualizar_solicitud_permiso_edicion({{ $solicitud->id }}, {{ $solicitud->estado_rechazado }})"
                            class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-200 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-400 dark:hover:text-white dark:focus:ring-red-800"
                            data-dismiss-target="#alert-additional-content-{{ $solicitud->id }}" aria-label="Close">
                            Rechazar
                        </button>
                    </div>
                </div>

            @empty
                <p>Sin nuevas solicitudes !</p>
            @endforelse
        </div>
    </div>

    <script>
        async function actualizar_solicitud_permiso_edicion(id, estado)
        {
            let url = '{{ route('permisos_post.update', ':id') }}'.replace(':id', id);
            
            let options = {
                body: {id, estado},
                headers: {"content-type": "application/json"}
            };

            let res = await api.put(url, options);

            if (!res.err) 
            {
                notificacion("Solicitud procesada con exito");
                
                await hablar(res.mensaje);
            }

        }
    </script>

</x-app-layout>
