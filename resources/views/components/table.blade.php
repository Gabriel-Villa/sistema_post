<table id="tabla-{{ $id }}" class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
    <thead class="text-xs uppercase bg-blue-700 text-white">
        <tr>
            @foreach ($headers as $header)
                <th class="px-4 py-2">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr class="border-b dark:border-gray-700">
            @if ($slot->isNotEmpty())
                {{ $slot }}
            @endif
        </tr>
    </tbody>
</table>