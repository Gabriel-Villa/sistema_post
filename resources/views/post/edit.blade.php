<x-app-layout>

    @if (Session::has('success'))
        <x-alerta>
            {{ Session::get('success') }}
        </x-alerta>
    @endif

    <x-post-form :post=$post />

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
        async function eliminar_post_imagen(id)
        {
            var url = '{{ route('postImagenes.destroy', ':id') }}'.replace(':id', id);

            let res = await api.del(url);

            console.log(res);

            if (!res.err) {
                
                d.getElementById(`post-imagen-id-${id}`).remove();

                notificacion("Procesado con exito");

                await hablar("Imagen eliminada");

            } else {
                notificacion("Ocurrio un error", "error");
            }
        }
    </script>

</x-app-layout>
