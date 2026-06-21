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
    $columns = collect(AddressColumns::cases())->map(fn($col) => $col->value);

    if ($edit || $delete) {
        $columns->push('Actions');
    }
@endphp

<x-modal.address.create
    id="address-create"
    :resource="$resource"
    :countries="$countries"
    trigger
/>

<x-table.wrapper :data="$data">
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
                <th class="text-heading whitespace-nowrap px-6 py-4 font-medium">
                    {{ $row->id }}
                </th>
                <td class="px-6 py-4">{{ $row->street_number }}</td>
                <td class="px-6 py-4">{{ $row->street }}</td>
                <td class="px-6 py-4">{{ $row->postcode }}</td>
                <td class="px-6 py-4">{{ $row->building }}</td>
                <td class="px-6 py-4">{{ $row->floor }}</td>
                <td class="px-6 py-4">{{ $row->unit }}</td>
                @if ($edit || $delete)
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            @if ($edit)
                                <a
                                    class="text-brand"
                                    href="{{ route($parentname . '.address.edit', [$resource, $row]) }}"
                                >Edit</a>
                            @endif
                            @if ($delete)
                                <x-modal.confirm
                                    id="{{ $parentname }}-address-delete-{{ $row->id }}"
                                    type="delete"
                                    action="{{ route($parentname . '.address.destroy', [$resource, $row]) }}"
                                    message="Are you sure you want to remove this address?"
                                />
                                <button
                                    class="text-danger hover:cursor-pointer"
                                    data-modal-target="{{ $parentname }}-address-delete-{{ $row->id }}-modal"
                                    data-modal-toggle="{{ $parentname }}-address-delete-{{ $row->id }}-modal"
                                    data-test="{{ $parentname }}-address-delete-{{ $row->id }}-modal-trigger"
                                    type="button"
                                >
                                    Delete
                                </button>
                            @endif
                        </div>
                    </td>
                @endif
            </tr>
        @empty
            No data available
        @endforelse
    </x-slot>
</x-table.wrapper>
