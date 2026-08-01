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
    $columns = collect(CompanyColumns::cases())->map(fn($col) => $col->value);

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
            <th
                class="px-6 py-3"
                scope="col"
            >{{ $column }}</th>
        @endforeach
    </x-slot>
    <x-slot name="tbody">
        @foreach ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
                <th class="text-heading whitespace-nowrap px-6 py-4 font-medium">
                    {{ $row->id }}
                </th>
                <td class="px-6 py-4">
                    <div class="flex items-end gap-1">
                        <x-avatar
                            alt="{{ $row->id }}-company-pic"
                            :src="$row->image_path && !Str::isUrl($row->image_path)
                                ? asset('storage/' . $row->image_path)
                                : $row->image_path"
                            :title="$row->name"
                            size="small"
                        />
                        {{ $row->name }}
                    </div>
                </td>
                <td class="px-6 py-4">{{ $row->tax_id }}</td>
                <td class="px-6 py-4">{{ $row->registration_number }}</td>
                <td class="px-6 py-4">{{ $row->tax_value }}</td>
                <td class="px-6 py-4">{{ $row->invoice_prefix }}</td>
                <td class="px-6 py-4">
                    @if ($edit)
                        <a
                            class="text-brand"
                            data-test="company-{{ $row->id }}-edit-button"
                            href="{{ route($edit_route ? $edit_route : 'companies.edit', $row) }}"
                        >Edit</a>
                    @endif
                    @if ($delete)
                        <x-modal.confirm
                            id="company-delete-{{ $row->id }}"
                            type="delete"
                            action="{{ route($delete_route ? $delete_route : 'companies.destroy', $row->id) }}"
                            message="Are you sure you want to remove {{ $row->name }} from your list of companies?"
                        />
                        <button
                            class="text-danger hover:cursor-pointer"
                            data-modal-target="company-delete-{{ $row->id }}-modal"
                            data-modal-toggle="company-delete-{{ $row->id }}-modal"
                            data-test="company-delete-{{ $row->id }}-modal-trigger"
                            type="button"
                        >
                            Delete
                        </button>
                    @endif
                    @if ($restore && $row->trashed())
                        <x-modal.confirm
                            id="company-restore-{{ $row->id }}"
                            type="restore"
                            action="{{ route($restore_route ? $restore_route : 'companies.restore', $row->id) }}"
                            message="Are you sure you want to restore {{ $row->name }}?"
                        />
                        <button
                            class="text-success hover:cursor-pointer"
                            data-modal-target="company-restore-{{ $row->id }}-modal"
                            data-modal-toggle="company-restore-{{ $row->id }}-modal"
                            data-test="company-restore-{{ $row->id }}-modal-trigger"
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
