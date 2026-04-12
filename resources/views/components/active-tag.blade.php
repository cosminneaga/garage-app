@props([
    'active' => 1,
])

<x-bladewind.tag
    :label="$active ? 'active' : 'deactivated'"
    :color="$active ? 'primary' : 'red'"
/>
