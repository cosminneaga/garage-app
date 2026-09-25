@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'resource',
])

@php
    $columns = WorkorderOperationTimeColumns::tableColumns();
@endphp

<x-table.wrapper :data="$data">
    <x-table.extension.thead
        :columns="$columns"
        action_column_enabled="{{ $edit }}"
    />

    <x-slot name="tbody">
        @foreach ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">

                <!-- GENERIC DATABASE COLUMNS -->
                @foreach ($columns as $column)
                    <td class="px-6 py-4">{{ $row[$column->value] }}</td>
                @endforeach

                <!-- ACTION COLUMNS -->
                @if ($edit)
                    <x-table.extension.action
                        identifier="id"
                        name="workorder_operation_times"
                        :data="$row"
                        :edit="$edit"
                        edit_route="#"
                    />
                @endif
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
