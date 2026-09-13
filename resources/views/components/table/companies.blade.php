@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'restore' => false,
    'search_route' => null,
    'edit_route' => null,
    'delete_route' => null,
    'restore_route' => null,
])

@php
    $columns = CompanyColumns::tableColumns();
@endphp

<x-table.wrapper :data="$data">
    <x-table.extension.search
        :route="$search_route"
        label="Search bookings..."
    />

    <x-table.extension.thead
        :columns="$columns"
        action_column_enabled="{{ $edit || $delete || $restore }}"
    />

    <x-slot name="tbody">
        @foreach ($data as $row)
            <tr
                class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">

                <!-- GENERIC DATABASE COLUMNS -->
                @foreach ($columns as $column)
                    <td class="px-6 py-4">{{ $row[$column->value] }}</td>
                @endforeach

                <!-- ACTION COLUMNS -->
                @if ($edit || $delete || $restore)
                    <x-table.extension.action
                        name="company"
                        identifier="name"
                        :data="$row"
                        :edit="$edit"
                        :delete="$delete"
                        edit_route="{{ route($edit_route ? $edit_route : 'companies.edit', $row) }}"
                        delete_route="{{ route($delete_route ? $delete_route : 'companies.destroy', $row->id) }}"
                    />
                @endif

            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
