@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'restore' => false,
    'searchRoute' => route('companies.index'),
])

@php
    use App\Enums\Columns\CompanyColumns;
    $columns = collect(CompanyColumns::cases())
        ->map(fn ($col) => $col->value);

    if ($edit || $delete || $restore) {
        $columns->push('actions');
    }
@endphp

<x-table.wrapper :data="$data">
    <x-slot name="header">
        <form
            class="flex items-center gap-2"
            method="GET"
            action="{{ $searchRoute }}"
        >
            <x-form.field
                name="search"
                type="text"
                value="{{ request('search') }}"
                label="Search companies..."
            />

            <x-button type="submit">
                Search
            </x-button>
        </form>
    </x-slot>

    <x-slot name="thead">
        @foreach ($columns as $column)
            <th
                class="px-6 py-3"
                scope="col"
            >
                {{ $column }}
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
                    @if ($restore && $row->trashed())
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
