<x-app-layout>

    @if (Session::has('success'))
        <x-alerta>
            {{ Session::get('success') }}
        </x-alerta>
    @endif

    <x-post-form />

</x-app-layout>