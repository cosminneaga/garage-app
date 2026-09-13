@props([
    'columns' => [],
    'action_column_enabled' => false,
])

<x-slot name="thead">
    @foreach ($columns as $column)
        <th
            class="px-6 py-3"
            scope="col"
        >{{ $column->label }}</th>
    @endforeach

    @if ($action_column_enabled)
        <th
            class="px-6 py-3"
            scope="col"
        >ACTIONS</th>
    @endif
</x-slot>
