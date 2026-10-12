@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'resource',
])

@php
    $columns = InvoiceColumns::tableColumns();
    $parentname = $resource->getTable();
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
                    identifier="name"
                    name="invoices"
                    :data="$row"
                    show_route="{{ route('invoices.' . $parentname . '.edit', [$row, $resource]) }}"
                />
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
