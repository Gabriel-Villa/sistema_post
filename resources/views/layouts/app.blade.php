<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <!-- Toastify css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/helpHttp.js') }}" type="module"></script>
    <script src="{{ asset('js/helpers.js') }}"></script>
</head>

<script>
    const d = document;
    let api = helpHttp();
</script>

<body>
    <x-nav-bar />
    <x-aside-bar />

    <div class="p-4 sm:ml-64 mt-9" style="margin-top: 50px;">

        <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

            @forelse($notificaciones as $notification)
                <x-notificaciones :notification="$notification" />
            @empty
            @endforelse

            {{ $slot }}
        </div>
    </div>
</body>


<!-- Toastify js -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.3/flowbite.min.js"></script>

<script>

    @can(Auth::user()->hasRole('Administrador'))

        Echo.channel('nueva-solicitud-edicion-post')
            .listen('NotificacionNuevoPermisoEdicionPostEvent', async ({body}) => {
                console.log("NotificacionNuevoPermisoEdicionPostEvent ", body);
                if (body) {
                    notificacion(body);
                    await hablar(body);
                }
            });
            
    @endcan

    Echo.private('notificacion.{{ auth()->id() }}')
        .listen('ImagenesProcesadasEvent', async ({body}) => {
            console.log("ImagenesProcesadasEvent ", body);
            if(body){
                notificacion(body);
                await hablar(body);
            }
        });

    const notificaciones = document.querySelectorAll('.marcar-como-leido');

    notificaciones.forEach(el => {
        el.addEventListener('click', () => 
        {
            const id = el.getAttribute('data-id');

            marcar_notificacion(id, el);
        });
    });

    async function marcar_notificacion(id, el) 
    {
        let options = {
            body: { id},
            headers: { "content-type": "application/json"}
        };

        let url = "{{ route('marcar.notificacion') }}";

        let res = await api.post(url, options);

        if (!res.err) 
        {
            await hablar(res.mensaje);
        }
    }
</script>


</html>
