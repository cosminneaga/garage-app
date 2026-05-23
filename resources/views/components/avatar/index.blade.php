@props(['src', 'alt', 'title', 'size' => null])

@php
    switch ($size) {
        case 'small':
            $size = 'h-12 w-12';
            break;
        case 'medium':
            $size = 'h-16 w-16';
            break;
        case 'big':
            $size = 'h-24 w-24';
            break;

        default:
            $size = 'h-16 w-16';
            break;
    }
@endphp

<img
    class="{{ $size }} border-3 rounded-full border-white object-cover object-center"
    src="{{ $src }}"
    title="{{ $title }}"
    alt="{{ $alt }}"
    {{ $attributes }}
/>
