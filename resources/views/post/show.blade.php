<x-app-layout>

    @if (Session::has('success'))
        <x-alerta>
            {{ Session::get('success') }}
        </x-alerta>
    @endif

    @hasrole('Lector')
        <button type="button" onclick="solicitar_accesos_post({{ $post->id }})" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Solicitar accesos
        </button>
    @endhasrole

        
    <div class="grid mb-8 border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 md:mb-12">
        <figure class="flex flex-col items-center justify-center p-8 text-center bg-white border-b border-gray-200 rounded-t-lg md:rounded-t-none md:rounded-tl-lg md:border-r dark:bg-gray-800 dark:border-gray-700">
            <blockquote class="max-w-2xl mx-auto mb-4 text-gray-500 lg:mb-8 dark:text-gray-400">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nombre post: {{ $post->nombre }}</h3>
                <p class="my-4 font-light">Descripcion: {{ $post->descripcion }}</p>
            </blockquote>
            <figcaption class="flex items-center justify-center space-x-3">
                <div class="space-y-0.5 font-medium dark:text-white text-left">
                    <div>
                        Creador: <i class="fas fa-user mx-2"></i>{{ $post->creadopor->name ?? 'Sin creador' }}
                    </div>
                    <div class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Contacto: <i class="fas fa-envelope mx-2"> </i>{{ $post->creadopor->email ?? 'Sin creador' }}
                    </div>
                </div>
            </figcaption>    
        </figure>
    </div>


    <div class="grid grid-cols-3 gap-4">
        @forelse ($post->detalle as $postImagen)
            <div class="col-span-1 bg-gray-100 p-4" id="post-imagen-id-{{ $postImagen->id }}">
                <x-post-card :postImagen=$postImagen />
            </div>
        @empty
            <p>Sin contenido !</p>
        @endforelse
    </div>

    <script>
        async function solicitar_accesos_post(post_id) 
        {
            let options = {
                body: {post_id},
                headers: {"content-type": "application/json"}
            };

            let url = "{{ route('permisos_post.store') }}";

            let res = await api.post(url, options);

            if (!res.err) 
            {
                notificacion("Solicitud procesada con exito");
                
                await hablar(res.mensaje);
            }
        }

    </script>

</x-app-layout>
