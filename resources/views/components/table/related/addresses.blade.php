@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'resource',
    'countries',
    'trigger' => true,
])

@php
    $parentname = $resource->getTable();
    $columns = AddressColumns::tableColumns();
@endphp

@if ($trigger)
    <x-modal.address.create
        id="address_create"
        :countries="$countries"
        action="{{ route('addresses.' . $parentname . '.store', $resource) }}"
        trigger
    />
@endif

<x-table.wrapper :data="$data">
    <x-table.extension.thead
        :columns="$columns"
        action_column_enabled="{{ $edit || $delete }}"
    />

    <x-slot name="tbody">
        @forelse ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">

                <!-- GENERIC DATABASE COLUMNS -->
                @foreach ($columns as $column)
                    <td class="px-6 py-4">{{ $row[$column->value] }}</td>
                @endforeach

                <!-- ACTION COLUMNS -->
                @if ($edit || $delete)
                    <x-table.extension.action
                        identifier="street"
                        name="address"
                        :data="$row"
                        :edit="$edit"
                        :delete="$delete"
                        edit_route="{{ route('addresses.' . $parentname . '.edit', [$row, $resource]) }}"
                        delete_route="{{ route('addresses.' . $parentname . '.destroy', [$row, $resource]) }}"
                    />
                @endif
            </tr>
        @empty
            No data available
        @endforelse
    </x-slot>
</x-table.wrapper>
