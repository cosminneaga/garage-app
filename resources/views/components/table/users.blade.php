@props([
    'data' => null,
    'limit' => 10,
    'edit' => false,
    'delete' => false,
    'chat' => false,
    'restore' => false,
    'attach' => false,
    'routes_prefix' => 'users',
    'search_route' => null,
    'parent_resource' => null,
])

@php
    $columns = collect(UserColumns::cases())->map(fn($col) => $col->value);

    if (
        $edit ||
        $delete ||
        $chat ||
        $restore ||
        ($attach && $parent_resource)
    ) {
        $columns->push('Actions');
    }
@endphp

<x-table.wrapper :data="$data">
    @if ($search_route)
        <x-slot name="header">
            <form
                method="GET"
                action="{{ $search_route }}"
            >
                <x-form.field
                    name="search"
                    type="search"
                    value="{{ request('search') }}"
                    label="Search users..."
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
            <tr
                class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
                <th
                    class="text-heading whitespace-nowrap px-6 py-4 font-medium">
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
                        @if ($attach && $parent_resource)
                            <form
                                action="{{ route('users.' . $routes_prefix . '.attach', [$row, $parent_resource]) }}"
                                method="POST"
                                id="user-attach-submit"
                            >
                                @csrf
                                @method('PUT')

                                <button
                                    class="text-success hover:cursor-pointer"
                                    data-test="user-attach-{{ $row->id }}-button"
                                    type="submit"
                                    form="user-attach-submit"
                                >
                                    Attach
                                </button>
                            </form>
                        @endif
                        @if ($edit)
                            @isCurrentUser($row->id)
                                <a
                                    class="text-brand"
                                    href="{{ route($routes_prefix . '.profile.edit') }}"
                                >Profile</a>
                            @else
                                <a
                                    class="text-brand"
                                    href="{{ route($routes_prefix . '.edit', $row) }}"
                                >Edit</a>
                            @endisCurrentUser
                        @endif
                        @if ($delete)
                            @isNotCurrentUser($row->id)
                                <x-modal.confirm
                                    id="user-delete-{{ $row->id }}"
                                    type="delete"
                                    action="{{ route($routes_prefix . '.destroy', $row->id) }}"
                                    message="Are you sure you want to remove {{ $row->name }} from your team?"
                                />
                                <button
                                    class="text-danger hover:cursor-pointer"
                                    data-modal-target="user-delete-{{ $row->id }}-modal"
                                    data-modal-toggle="user-delete-{{ $row->id }}-modal"
                                    data-test="user-delete-{{ $row->id }}-modal-trigger"
                                    type="button"
                                >
                                    Delete
                                </button>
                            @endisNotCurrentUser
                        @endif
                        @if ($restore && $row->trashed())
                            <x-modal.confirm
                                id="user-restore-{{ $row->id }}"
                                type="restore"
                                action="{{ route($routes_prefix . '.restore', $row->id) }}"
                                message="Are you sure you want to restore {{ $row->name }}?"
                            />
                            <button
                                class="text-success hover:cursor-pointer"
                                data-modal-target="user-restore-{{ $row->id }}-modal"
                                data-modal-toggle="user-restore-{{ $row->id }}-modal"
                                data-test="user-restore-{{ $row->id }}-modal-trigger"
                                type="button"
                            >
                                Restore
                            </button>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
