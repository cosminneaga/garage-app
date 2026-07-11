@props([
    'resource',
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'chat' => false,
])

@php
    $parentname = $resource->getTable();
    $columns = collect(UserColumns::cases())->map(fn($col) => $col->value);

    if ($edit || $delete || $chat || $restore) {
        $columns->push('Actions');
    }
@endphp

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
        @foreach ($data as $row)
            <tr
                class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
                <th class="text-heading whitespace-nowrap px-6 py-4 font-medium">
                    {{ $row->id }}
                </th>
                <td class="px-6 py-4">
                    <div class="flex items-end gap-1">
                        <x-avatar
                            alt="{{ $row->id }}-user-pic"
                            :src="$row->image_path &&
                            !Str::isUrl($row->image_path)
                                ? asset('storage/' . $row->image_path)
                                : $row->image_path"
                            :title="$row->name"
                            size="small"
                        />
                        {{ $row->name }}
                    </div>
                </td>
                <td class="px-6 py-4">{{ $row->email }}</td>
                <td class="px-6 py-4">
                    <x-tab.active :status="$row->active" />
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-3">
                        @if ($chat)
                            @isNotCurrentUser($row->id)
                                <button
                                    class="text-green-500 hover:cursor-pointer"
                                    data-modal-target="user-send-message-modal"
                                    data-modal-toggle="user-send-message-modal"
                                    type="button"
                                >
                                    Message
                                </button>
                                <x-modal.message.send
                                    id="user-send-message-modal"
                                    :resource="$row"
                                />
                            @endisNotCurrentUser
                        @endif
                        @if ($edit)
                            @isCurrentUser($row->id)
                                <a
                                    class="text-brand"
                                    href="{{ route('profile.users.edit') }}"
                                >Profile</a>
                            @else
                                <a
                                    class="text-brand"
                                    href="{{ route('users.edit', $row) }}"
                                >Edit</a>
                            @endisCurrentUser
                        @endif
                        @if ($delete)
                            @isNotCurrentUser($row->id)
                                <x-modal.confirm
                                    id="user-company-delete-{{ $row->id }}"
                                    type="delete"
                                    action="{{ route('users.' . $parentname . '.destroy', [$resource, $row]) }}"
                                    {{-- users.companies.destroy --}}
                                    message="Are you sure you want to remove {{ $row->name }} from {{ $resource->name }}?"
                                />
                                <button
                                    class="text-danger hover:cursor-pointer"
                                    data-modal-target="user-company-delete-{{ $row->id }}-modal"
                                    data-modal-toggle="user-company-delete-{{ $row->id }}-modal"
                                    data-test="user-company-delete-{{ $row->id }}-modal-trigger"
                                    type="button"
                                >
                                    Delete
                                </button>
                            @endisNotCurrentUser
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
