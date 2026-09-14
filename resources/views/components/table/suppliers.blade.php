@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'restore' => false,
    'search_route' => null,
    'prefix_route' => null,
])

@php
    $columns = SupplierColumns::tableColumns();

    $routes = [
        [
            'type' => 'edit',
            'name' => $prefix_route
                ? $prefix_route . '.suppliers.edit'
                : 'super.suppliers.edit',
        ],
        [
            'type' => 'delete',
            'name' => $prefix_route
                ? $prefix_route . '.suppliers.destroy'
                : 'super.suppliers.destroy',
        ],
        [
            'type' => 'restore',
            'name' => $prefix_route
                ? $prefix_route . '.suppliers.restore'
                : 'super.suppliers.restore',
        ],
    ];
@endphp

<x-table.wrapper :data="$data">
    <x-table.extension.search
        :route="$search_route"
        label="Search suppliers..."
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
                <th
                    class="text-heading whitespace-nowrap px-6 py-4 font-medium">
                    {{ $row->id }}
                </th>
                <td class="px-6 py-4">{{ $row->name }}</td>
                <td class="px-6 py-4">{{ $row->code }}</td>
                <td class="px-6 py-4">
                    {{ SupplierType::getLabel($row->type) }}
                </td>
                <td class="px-6 py-4">{{ $row->tax_id }}</td>
                <td class="px-6 py-4">{{ $row->registration_number }}</td>

                <!-- ACTION COLUMNS -->
                @if ($edit || $delete || $restore)
                    <x-table.extension.action
                        name="supplier"
                        identifier="name"
                        :data="$row"
                        :edit="$edit"
                        :delete="$delete"
                        :restore="$restore"
                        edit_route="{{ route($routes[0]['name'], $row) }}"
                        delete_route="{{ route($routes[1]['name'], $row->id) }}"
                        restore_route="{{ route($routes[2]['name'], $row->id) }}"
                    />
                @endif
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
