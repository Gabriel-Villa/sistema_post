<div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-end px-4 pt-4">
    </div>
    <div class="flex flex-col items-center pb-10">
        <img class="w-24 h-24 mb-3 rounded-full shadow-lg"
            src="{{ asset('storage/posts/'.$postImagen->nombre) }}" alt="Bonnie image" />
        @can('eliminar_post')
            <div class="flex mt-4 space-x-3 md:mt-6">
                <a href="#" onclick="eliminar_post_imagen({{ $postImagen->id }})"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    Eliminar
                </a>
            </div>
        @endcan
    </div>
</div>
