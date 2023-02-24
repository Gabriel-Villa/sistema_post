@props(['requerido' => false])

<label for="floating_email"
    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white {{ $requerido ? 'text-red-800' : '' }}"
>
    {{ $slot }}
    @if ($requerido)
        <span class="text-red-900">*</span>
    @endif
</label>
