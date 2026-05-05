@props([
    'deleted_at' => null
])

<x-bladewind.tag
    :label="$deleted_at ? 'deleted' : 'enabled'"
    :color="$deleted_at ? 'red' : 'green'"
/>
