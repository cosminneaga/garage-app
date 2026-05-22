@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'restore' => false,
])

@php
    $columns = collect(Schema::getColumnListing('companies'))
        ->diff(['deleted_at', 'updated_at', 'created_at', 'image_path'])
        ->values();

    if ($edit || $delete || $restore) {
        $columns->push('actions');
    }
@endphp

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
        @foreach ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
                <th class="text-heading whitespace-nowrap px-6 py-4 font-medium">
                    {{ $row->id }}
                </th>
                <td class="px-6 py-4">
                    {{ $row->name }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->tax_id }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->registration_number }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->tax_value }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->invoice_prefix }}
                </td>
                <td class="px-6 py-4">
                    @if ($edit)
                        <a
                            class="text-brand"
                            href="{{ route('companies.edit', $row) }}"
                        >Edit</a>
                    @endif
                    @if ($delete)
                        <x-modal.confirm
                            id="company-delete-{{ $row->id }}"
                            type="delete"
                            action="{{ route('companies.destroy', $row->id) }}"
                            message="Are you sure you want to remove {{ $row->name }} from your list of companies?"
                        />

                        <button
                            class="text-danger hover:cursor-pointer"
                            data-modal-target="company-delete-{{ $row->id }}"
                            data-modal-toggle="company-delete-{{ $row->id }}"
                            type="button"
                        >Delete</button>
                    @endif
                    @if ($restore)
                        <x-modal.confirm
                            id="company-restore-{{ $row->id }}"
                            type="restore"
                            action="{{ route('companies.restore', $row->id) }}"
                            message="Are you sure you want to restore {{ $row->name }}?"
                        />

                        <button
                            class="text-success hover:cursor-pointer"
                            data-modal-target="company-restore-{{ $row->id }}"
                            data-modal-toggle="company-restore-{{ $row->id }}"
                            type="button"
                        >Restore</button>
                    @endif
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
