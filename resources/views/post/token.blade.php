<x-app-layout>

    @if (Session::has('success'))
        <x-alerta>
            {{ Session::get('success') }}
        </x-alerta>
    @endif

    <form method="POST" action="{{ route('comparar.token') }}">
        <div class="flex items-center justify-center h-screen">
            @csrf
            <div class="p-6 bg-white rounded-md shadow-md">
                <label for="token" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Confirma el token para poder ingresar</label>
                <div class="flex">
                    <input type="text" id="token"
                        name="token"
                        class="rounded-none rounded-r-lg bg-gray-50 border border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500 block flex-1 min-w-0 w-full text-sm p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Ingresa el token" required>
                </div>
                <button type="submit" class="mt-3 focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                    Salvar
                </button>
            </div>
        </div>
    </form>

</x-app-layout>
