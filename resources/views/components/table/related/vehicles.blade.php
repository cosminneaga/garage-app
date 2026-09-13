@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'restore' => false,
    'resource',
])

@php
    $parentname = $resource->getTable();
    $columns = VehicleColumns::tableColumns();
@endphp

<x-modal.vehicle.create
    id="vehicle_create"
    :resource="$resource"
    trigger
    action="{{ route('vehicles.companies.store', $resource) }}"
/>

<x-table.wrapper :data="$data">
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
                        name="vehicles"
                        identifier="registration"
                        :data="$row"
                        :edit="$edit"
                        :delete="$delete"
                        :restore="$restore"
                        edit_route="{{ route('companies.edit', $row->id) }}"
                        delete_route="{{ route('companies.destroy', $row->id) }}"
                        restore_route="{{ route('companies.restore', $row->id) }}"
                    />
                @endif

            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
