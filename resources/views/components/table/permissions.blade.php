@props([
    'data' => [],
    'user' => null,
    'edit' => false,
])

@php
    $columns = PermissionColumns::tableColumns();
@endphp

<x-table.wrapper :data="$data">
    <x-table.extension.thead
        :columns="$columns"
        action_column_enabled="{{ $edit }}"
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
                <td class="px-6 py-4">
                    <div class="flex gap-3">
                        @if ($edit)
                            @if (isset($row->pivot->model_id))
                                <form
                                    action="{{ route('users.permission.revoke', [$user, $row->name]) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="text-red-500 hover:cursor-pointer"
                                        data-modal-target="user-send-message-modal"
                                        data-modal-toggle="user-send-message-modal"
                                        data-test="{{ $row->name }}-revoke"
                                        type="submit"
                                    >
                                        Revoke
                                    </button>
                                </form>
                            @elseif (isset($row->available))
                                <form
                                    action="{{ route('users.permission.revoke', [$user, $row->name]) }}"
                                    method="POST"
                                >
                                    @csrf
                                    @method('PUT')

                                    <button
                                        class="text-green-500 hover:cursor-pointer"
                                        data-modal-target="user-send-message-modal"
                                        data-modal-toggle="user-send-message-modal"
                                        data-test="{{ $row->name }}-assign"
                                        type="submit"
                                    >
                                        Assign
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </td>

            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
