@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'chat' => false,
])

@php
    $columns = collect($data[0])
        ->except(['pivot', 'image_path'])
        ->keys();

    if ($edit || $delete || $chat) {
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
                    {{ $row->email }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->active }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-3">
                        @if ($chat && Auth::user()->id !== $row->id)
                            <button
                                class="text-green-500"
                                onclick="alert('openMessageModal')"
                            >Message</button>
                        @endif
                        @if ($edit)
                            <a
                                class="text-brand"
                                href="{{ route('users.edit', $row) }}"
                            >Edit</a>
                        @endif
                        @if ($delete && Auth::user()->id !== $row->id)
                            <x-modal.confirm.delete
                                id="user-delete-{{ $row->id }}"
                                routeName="users.destroy"
                                resourceId="{{ $row->id }}"
                                message="Are you sure you want to remove {{ $row->name }} from your team?"
                            />

                            <button
                                class="text-danger hover:cursor-pointer"
                                data-modal-target="user-delete-{{ $row->id }}"
                                data-modal-toggle="user-delete-{{ $row->id }}"
                                type="button"
                            >Delete</button>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
