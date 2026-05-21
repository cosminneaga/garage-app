@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'resource',
])

@php
    use App\Enums\UserPermission;

    $parentname = $resource->getTable();
    $columns = Schema::getColumnListing('addresses');
    $columns = collect($columns)
        ->diff(['created_at', 'updated_at', 'deleted_at', 'country_id', 'coordinates'])
        ->values();

    if ($edit || $delete) {
        $columns->push('actions');
    }
@endphp

<x-modal.address.create
    id="user-address-create-modal"
    triggerId="user-contact-create-modal-trigger"
    :resource="$resource"
    trigger
/>

<x-table.wrapper :data="$data">
    <x-slot name="thead">
        @foreach ($columns as $column)
            <th
                class="px-6 py-3"
                scope="col"
            >
                {{ Str::ucwords(Str::replace(['_'], [' '], $column)) }}
            </th>
        @endforeach
    </x-slot>

    <x-slot name="tbody">
        @forelse ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
                <th class="text-heading whitespace-nowrap px-6 py-4 font-medium">
                    {{ $row->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $row->number }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->street }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->postcode }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->extra }}
                </td>
                @if ($edit || $delete)
                    <td class="px-6 py-4">
                        <div class="flex gap-3">
                            @if ($edit)
                                <a
                                    class="text-brand"
                                    href="{{ route($parentname . '.address.edit', [$resource, $row]) }}"
                                >Edit</a>
                            @endif
                            @if ($delete && Auth::user()->id !== $row->id)
                                <x-modal.confirm
                                    id="user-address-delete-{{ $row->id }}"
                                    type="delete"
                                    action="{{ route($parentname . '.address.destroy', [$resource, $row]) }}"
                                    message="Are you sure you want to remove this address?"
                                />

                                <button
                                    class="text-danger hover:cursor-pointer"
                                    data-modal-target="user-address-delete-{{ $row->id }}"
                                    data-modal-toggle="user-address-delete-{{ $row->id }}"
                                    type="button"
                                >Delete</button>
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
