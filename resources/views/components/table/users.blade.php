@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'chat' => false,
    'restore' => false,
])

@php
    $columns = collect(Schema::getColumnListing('users'))
        ->diff(['pivot', 'image_path', 'password', 'remember_token', 'deleted_at', 'updated_at', 'created_at', 'email_verified_at'])
        ->values();

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
                            <x-modal.confirm
                                type="delete"
                                id="user-delete-{{ $row->id }}"
                                action="{{ route('users.destroy', $row->id) }}"
                                message="Are you sure you want to remove {{ $row->name }} from your team?"
                            />

                            <button
                                class="text-danger hover:cursor-pointer"
                                data-modal-target="user-delete-{{ $row->id }}"
                                data-modal-toggle="user-delete-{{ $row->id }}"
                                type="button"
                            >Delete</button>
                        @endif
                        @if($restore)
                            <x-modal.confirm
                                type="restore"
                                id="user-restore-{{ $row->id }}"
                                action="{{ route('users.restore', $row->id) }}"
                                message="Are you sure you want to restore {{ $row->name }}?"
                            />

                            <button
                                class="text-success hover:cursor-pointer"
                                data-modal-target="user-restore-{{ $row->id }}"
                                data-modal-toggle="user-restore-{{ $row->id }}"
                                type="button"
                            >Restore</button>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
