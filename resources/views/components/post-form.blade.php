@props(['post' => null])


<x-form :action="$post ? route('post.update', $post) : route('post.store')" id="post-form" enctype="multipart/form-data" method="POST">

    @csrf

    @if (!$post)
        <input type="hidden" name="creado_por" value="{{ auth()->id() }}">
        <input type="hidden" name="fecha_creacion" value="{{ now()->format("Y-m-d H:i:s") }}">
    @else
        @method("PUT")
    @endif

    <div class="grid:nd-grid-cols md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <x-label for="nombre" requerido>Nombre</x-label>
            <input type="text" name="nombre" id="nombre"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                placeholder="Ingresa un nombre"
                value="{{ $post ? $post->nombre : old('nombre') }}"
            />

            @if (isset($errors) && $errors->has('nombre'))
                <x-error-form>{{ $errors->first('nombre') }}</x-error-form>
            @endif

        </div>
    </div>
    <div class="grid:nd-grid-cols md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <x-label for="descripcion">Descripcion</x-label>
            
            <x-textarea id="descripcion" name="descripcion" placeholder="Ingresa una descripcion">{{ $post ? $post->descripcion : old('descripcion') }}</x-textarea>

            @if (isset($errors) && $errors->has('descripcion'))
                <x-error-form>{{ $errors->first('descripcion') }}</x-error-form>
            @endif
        </div>
    </div>
    <div class="grid:nd-grid-cols md:gap-6">
        <x-label for="post_file">Subir imagen(s)</x-label>
        <input
            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
            aria-describedby="post_file_help" id="post_file" name="post_file[]" type="file" multiple>

        @if (isset($errors) && $errors->has('post_file'))
            <x-error-form>{{ $errors->first('post_file') }}</x-error-form>
        @endif

    </div>
    <button type="submit"
        class="mt-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        Submit
    </button>

</x-form>