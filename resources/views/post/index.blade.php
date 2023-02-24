<x-app-layout>

    <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 py-4">
        <div
            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
            @can('crear_post')
                <a href="{{ route('post.create') }}"
                    class="flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    Crear nuevo Post
                    <svg class="h-3.5 w-3.5 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z">
                        </path>
                    </svg>
                </a>
            @endcan
            @can('descargar_post')
                <a href="{{ route('exportacion.posts') }}"
                    class="flex items-center justify-center text-white bg-green-500 hover:bg-green-600 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                    Descargar posts
                    <svg class="h-3.5 w-3.5 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z">
                        </path>
                    </svg>
                </a>
            @endcan
        </div>
    </div>

    <div class="overflow-x-auto">
        <x-table id="tabla-post" :headers="['nombre', 'slug', 'creado_por', 'publicado', 'descripcion', 'Acciones']">
            @forelse ($posts as $post)
                <tr id="post-id-{{ $post->id }}" class="border-b">
                    <td class="text-start">{{ $post->nombre }}</td>
                    <td class="text-start">
                        <x-badge>{{ $post->slug }}</x-badge>
                    </td>
                    <td>{{ $post->creadopor->name ?? '' }}</td>
                    <td>
                        <x-badge>{{ $post->estado_post }}</x-badge>
                    </td>
                    <td class="text-start">{{ $post->descripcion }}</td>
                    <td class="py-1">
                        <a href="{{ route('post.show', $post) }}">
                            <x-badge color="blue">
                                <i class="fas fa-eye mx-2"></i> Ver
                            </x-badge>
                        </a>
                        @can('update', $post)
                            <a href="{{ route('post.edit', $post) }}">
                                <x-badge color="blue">
                                    <i class="fas fa-pencil mx-2"></i> Editar Post
                                </x-badge>
                            </a>
                        @else
                            <x-badge color="red">
                                <i class="fas fa-lock mx-2"></i> Sin permisos
                            </x-badge>
                        @endcan

                        @can('eliminar_post', $post)
                            <button class="btn-eliminar-post" data-id="{{ $post->id }}">
                                <x-badge color="red">
                                    <i class="fas fa-trash mx-2"></i> Eliminar Post
                                </x-badge>
                            </button>
                        @else
                            <x-badge color="red">
                                <i class="fas fa-lock mx-2"></i> Sin permisos
                            </x-badge>
                        @endcan

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Sin registros</td>
                </tr>
            @endforelse
        </x-table>

        {{ $posts->links() }}

    </div>

    <script>
        const $btnEliminarPost = document.querySelectorAll('.btn-eliminar-post');

        $btnEliminarPost.forEach(el => {
            el.addEventListener('click', async () => {

                const id = el.getAttribute('data-id');

                eliminar_post(id, el);

            });
        });

        async function eliminar_post(id) {
            var url = '{{ route('post.destroy', ':id') }}'.replace(':id', id);

            let res = await api.del(url);

            if (!res.err) {

                d.getElementById(`post-id-${id}`).remove();

                notificacion("Post eliminado");

                await hablar("Post eliminado");

            } else {
                notificacion("Ocurrio un error");

                await hablar("Ocurrio un error");
            }
        }
    </script>

</x-app-layout>
