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
    $columns = BookingColumns::tableColumns();

    if ($edit || $delete || $restore) {
        $columns->push(...ActionColumn::tableColumns());
    }
@endphp

<x-table.wrapper :data="$data">
    @if ($search_route)
        <x-slot name="header">
            <form
                class="flex items-center gap-2"
                method="GET"
                action="{{ $search_route }}"
            >
                <x-form.field.search
                    identifier="company"
                    name="search"
                    value="{{ request('search') }}"
                    label="Search companies..."
                />
            </form>
        </x-slot>
    @endif

    <x-slot name="thead">
        @foreach ($columns as $column)
            <th
                class="px-6 py-3"
                scope="col"
            >{{ $column->label }}</th>
        @endforeach
    </x-slot>

    <x-slot name="tbody">
        @foreach ($data as $row)
            <tr
                class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
                @foreach (BookingTableMap::values() as $column_value)
                    <td class="px-6 py-4">{{ $row[$column_value] }}</td>
                @endforeach
                <td class="px-6 py-4">
                    @if ($edit)
                        <a
                            class="text-brand"
                            data-test="booking-{{ $row->id }}-edit-button"
                            href="{{ route($edit_route ? $edit_route : 'bookings.edit', $row) }}"
                        >Show</a>
                    @endif
                    @if ($delete)
                        <x-modal.confirm
                            id="booking-delete-{{ $row->id }}"
                            type="delete"
                            action="{{ route($delete_route ? $delete_route : 'bookings.destroy', $row->id) }}"
                            message="Are you sure you want to remove booking with number {{ $row->number }}?"
                        />
                        <button
                            class="text-danger hover:cursor-pointer"
                            data-modal-target="booking-delete-{{ $row->id }}-modal"
                            data-modal-toggle="booking-delete-{{ $row->id }}-modal"
                            data-test="booking-delete-{{ $row->id }}-modal-trigger"
                            type="button"
                        >
                            Delete
                        </button>
                    @endif
                    @if ($restore && $row->trashed())
                        <x-modal.confirm
                            id="booking-restore-{{ $row->id }}"
                            type="restore"
                            action="{{ route($restore_route ? $restore_route : 'bookings.restore', $row->id) }}"
                            message="Are you sure you want to restore booking with number {{ $row->number }}?"
                        />
                        <button
                            class="text-success hover:cursor-pointer"
                            data-modal-target="booking-restore-{{ $row->id }}-modal"
                            data-modal-toggle="booking-restore-{{ $row->id }}-modal"
                            data-test="booking-restore-{{ $row->id }}-modal-trigger"
                            type="button"
                        >
                            Restore
                        </button>
                    @endif
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
