@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'resource',
])

@php
    $parentname = $resource->getTable();
    $columns = collect(ContactColumns::cases())->map(fn($col) => $col->value);

    if ($edit || $delete) {
        $columns->push('Actions');
    }
@endphp

<x-modal.contact.create
    id="contact-create"
    :resource="$resource"
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
                <td class="px-6 py-4">{{ $row->mobile }}</td>
                <td class="px-6 py-4">{{ $row->landline }}</td>
                <td class="px-6 py-4">{{ $row->email }}</td>
                <td class="px-6 py-4">
                    <a
                        class="text-fg-brand font-medium hover:underline"
                        href="{{ $row->url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >{{ $row->url }}</a>
                </td>
                <td class="px-6 py-4">{{ $row->info }}</td>
                @if ($edit || $delete)
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            @if ($edit)
                                <a
                                    class="text-brand"
                                    href="{{ route('contacts.' . $parentname . '.edit', [$row, $resource]) }}"
                                >Edit</a>
                            @endif
                            @if ($delete)
                                <x-modal.confirm
                                    id="{{ $parentname }}-contact-delete-{{ $row->id }}"
                                    type="delete"
                                    action="{{ route('contacts.' . $parentname . '.destroy', [$row, $resource]) }}"
                                    message="Are you sure you want to remove this contact?"
                                />
                                <button
                                    class="text-danger hover:cursor-pointer"
                                    data-modal-target="{{ $parentname }}-contact-delete-{{ $row->id }}-modal"
                                    data-modal-toggle="{{ $parentname }}-contact-delete-{{ $row->id }}-modal"
                                    data-test="{{ $parentname }}-contact-delete-{{ $row->id }}-modal-trigger"
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
