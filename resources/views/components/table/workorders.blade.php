@props([
    'data' => null,
    'limit' => 10,
    'resource' => null,
])

@php
    $class = $resource ? $resource::class : '';
    $route = match($class) {
        \App\Models\Booking::class => [
            'name' => 'workorders.bookings.edit',
            'relation' => 'booking',
        ],
        \App\Models\Company::class => [
            'name' => 'workorders.companies.edit',
            'relation' => 'company',
        ],
        default => [
            'name' => 'workorders.bookings.edit',
            'relation' => 'booking',
        ],
    };
    $columns = WorkorderColumns::tableColumns();
@endphp

<x-table.wrapper :data="$data">
    <x-table.extension.thead
        :columns="$columns"
        action_column_enabled
    />

    <x-slot name="tbody">
        @foreach ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">

                <!-- GENERIC DATABASE COLUMNS -->
                @foreach ($columns as $column)
                    <td class="px-6 py-4">{{ $row[$column->value] }}</td>
                @endforeach

                <!-- ACTION COLUMNS -->
                <x-table.extension.action
                    identifier="number"
                    name="workorders"
                    :data="$row"
                    show_route="{{ route($route['name'], [$row, $row[$route['relation']]]) }}"
                />
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
