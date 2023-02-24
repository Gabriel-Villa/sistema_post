<form method="{{ $method ?? 'POST' }}" id="{{ $id }}" {{ $attributes->merge(['class' => 'm-0']) }}>
    @csrf

    <input type="hidden" name="creado_por" value="{{ auth()->id() }}">
    <input type="hidden" name="fecha_creacion" value="{{ now()->format("Y-m-d") }}">

    {{ $slot }}

</form>

