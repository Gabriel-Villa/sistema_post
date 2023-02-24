@props(['notification'])


<div id="alert-additional-content-{{ $notification->id }}"
    class="p-4 mb-4 text-blue-800 border border-blue-300 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 dark:border-blue-800 notificacion-{{ $notification->id }}"
    role="alert">
    <div class="flex items-center">
        <svg aria-hidden="true" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Info</span>
        <h3 class="text-lg font-medium"> {{ $notification->data['nombre'] }}</h3>
    </div>
    <div class="mt-2 mb-4 text-sm">
        [{{ $notification->created_at->format('d/m/Y H:i:s') }}] {{ $notification->data['contenido'] }}
    </div>
    <div class="flex">
        <button type="button" class="marcar-como-leido" data-id="{{ $notification->id }}"
            class="text-blue-800 bg-transparent border border-blue-800 hover:bg-blue-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-blue-600 dark:border-blue-600 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800"
            data-dismiss-target="#alert-additional-content-{{ $notification->id }}" aria-label="Close">
            <i class="fas fa-check mx-2"></i> Marcar como leido
        </button>
    </div>
</div>
