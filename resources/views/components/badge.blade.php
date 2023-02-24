@props(['color' => 'gray'])

@php
    $bgColor = "bg-$color-100";
    $textColor = "text-$color-800";
    $darkBgColor = "dark:bg-$color-700";
    $darkTextColor = "dark:text-$color-300";
@endphp

<span class="{{ $bgColor }} {{ $textColor }} text-xs font-medium mr-2 px-2.5 py-0.5 rounded {{ $darkBgColor }} {{ $darkTextColor }}">
    {{ $slot }}
</span>