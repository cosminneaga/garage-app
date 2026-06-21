@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'countries',
])

@php
    $columns = collect(SupplierColumns::cases())->map(fn($col) => $col->value);

    if ($edit || $delete) {
        $columns->push('Actions');
    }
@endphp

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
                <td class="px-6 py-4">{{ $row->name }}</td>
                <td class="px-6 py-4">{{ $row->code }}</td>
                <td class="px-6 py-4">
                    {{ SupplierType::getLabel($row->type) }}
                </td>
                <td class="px-6 py-4">{{ $row->tax_id }}</td>
                <td class="px-6 py-4">{{ $row->registration_number }}</td>
                @if ($edit || $delete)
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            @if ($edit)
                                <a
                                    class="text-brand"
                                    href="{{ route('suppliers.edit', $row) }}"
                                >Edit</a>
                            @endif
                            @if ($delete)
                                <x-modal.confirm
                                    id="supplier-delete-{{ $row->id }}"
                                    type="delete"
                                    action="{{ route('suppliers.destroy', $row->id) }}"
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
                        </div>
                    </td>
                @endif
            </tr>
        @empty
            No available data
        @endforelse
    </x-slot>
</x-table.wrapper>
