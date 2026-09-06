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
    $columns = BookingTableMap::labels();

    if ($edit || $delete || $restore) {
        $columns->push('Actions');
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
                <x-form.field
                    identifier="company"
                    name="search"
                    type="search"
                    value="{{ request('search') }}"
                    label="Search companies..."
                />
            </form>
        </x-slot>
    @endif

    <x-slot name="thead">
        @foreach ($columns as $column)
            <th class="px-6 py-3" scope="col">{{ $column }}</th>
        @endforeach
    </x-slot>

    <x-slot name="tbody">
        @foreach ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
                @foreach (BookingTableMap::values() as $column_value)
                    <th class="px-6 py-4">{{ $row[$column_value] }}</th>
                @endforeach
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
