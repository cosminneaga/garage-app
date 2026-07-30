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
    $columns = collect(SupplierColumns::cases())->map(fn($col) => $col->value);

    if ($edit || $delete || $restore) {
        $columns->push('Actions');
    }

    $routes = [
        [
            'type' => 'edit',
            'name' => $prefix_route ? $prefix_route . '.suppliers.edit' : 'suppliers.edit',
        ],
        [
            'type' => 'delete',
            'name' => $prefix_route ? $prefix_route . '.suppliers.destroy' : 'suppliers.destroy',
        ],
        [
            'type' => 'restore',
            'name' => $prefix_route ? $prefix_route . '.suppliers.restore' : 'suppliers.restore',
        ],
    ];
@endphp

<x-table.wrapper :data="$data">
    <x-slot name="header">
        <form
            class="flex items-center gap-2"
            method="GET"
            action="{{ $search_route }}"
        >
            <x-form.field
                name="search"
                type="search"
                value="{{ request('search') }}"
                label="Search suppliers..."
            />
        </form>
    </x-slot>

    <x-slot name="thead">
        @foreach ($columns as $column)
            <th
                class="px-6 py-3"
                scope="col"
            >{{ $column }}</th>
        @endforeach
    </x-slot>

    <x-slot name="tbody">
        @forelse ($data as $row)
            <tr
                class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
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
                <td class="not-last:py-4 px-6">
                    @if ($edit)
                        <a
                            class="text-brand"
                            href="{{ route($routes[0]['name'], $row) }}"
                        >Edit</a>
                    @endif
                    @if ($delete)
                        <x-modal.confirm
                            id="supplier-delete-{{ $row->id }}"
                            type="delete"
                            action="{{ route($routes[1]['name'], $row->id) }}"
                            message="Are you sure you want to remove this {{ $row->name }}?"
                        />
                        <button
                            class="text-danger hover:cursor-pointer"
                            data-modal-target="supplier-delete-{{ $row->id }}-modal"
                            data-modal-toggle="supplier-delete-{{ $row->id }}-modal"
                            data-test="supplier-delete-{{ $row->id }}-modal-trigger"
                        >
                            Delete
                        </button>
                    @endif
                    @if ($restore && $row->trashed())
                        <x-modal.confirm
                            id="supplier-restore-{{ $row->id }}"
                            type="restore"
                            action="{{ route($routes[2]['name'], $row->id) }}"
                            message="Are you sure you want to restore {{ $row->name }}?"
                        />
                        <button
                            class="text-success hover:cursor-pointer"
                            data-modal-target="supplier-restore-{{ $row->id }}-modal"
                            data-modal-toggle="supplier-restore-{{ $row->id }}-modal"
                            data-test="supplier-restore-{{ $row->id }}-modal-trigger"
                            type="button"
                        >
                            Restore
                        </button>
                    @endif
                </td>
            </tr>
        @empty
            No available data
        @endforelse
    </x-slot>
</x-table.wrapper>
