@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'resource',
    'countries',
])

@php
    $parentname = $resource->getTable();
    $columns = AddressColumns::tableColumns();
@endphp

<x-modal.address.create
    id="address-create"
    :resource="$resource"
    :countries="$countries"
    trigger
/>

<x-table.wrapper :data="$data">
    <x-table.extension.thead
        :columns="$columns"
        action_column_enabled="{{ $edit || $delete }}"
    />

    <x-slot name="tbody">
        @forelse ($data as $row)
            <tr
                class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">

                <!-- GENERIC DATABASE COLUMNS -->
                @foreach ($columns as $column)
                    <td class="px-6 py-4">{{ $row[$column->value] }}</td>
                @endforeach

                <!-- ACTION COLUMNS -->
                @if ($edit || $delete || $restore)
                    <x-table.extension.action
                        name="address"
                        identifier="street"
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
