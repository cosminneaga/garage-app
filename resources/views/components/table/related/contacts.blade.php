@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'resource',
])

@php
    $parentname = $resource->getTable();
    $columns = ContactColumns::tableColumns();
@endphp

<x-modal.contact.create
    id="contact-create"
    :resource="$resource"
    trigger
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
                @if ($edit || $delete)
                    <x-table.extension.action
                        identifier="email"
                        name="contact"
                        :data="$row"
                        :edit="$edit"
                        :delete="$delete"
                        edit_route="{{ route('contacts.' . $parentname . '.edit', [$row, $resource]) }}"
                        delete_route="{{ route('contacts.' . $parentname . '.destroy', [$row, $resource]) }}"
                    />
                @endif
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
