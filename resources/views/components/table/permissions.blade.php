@props([
    'data' => [],
    'edit' => false,
])

@php
    $columns = collect(PermissionColumns::cases())->map(fn($col) => $col->value);
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
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">
                <th class="text-heading whitespace-nowrap px-6 py-4 font-medium">
                    {{ $row->id }}
                </th>
                <td class="px-6 py-4">{{ $row->name }}</td>
                <td class="px-6 py-4">{{ $row->guard_name }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-3">
                        @if ($edit)
                            @if (isset($row->pivot->model_id))
                                <button
                                    class="text-red-500 hover:cursor-pointer"
                                    data-modal-target="user-send-message-modal"
                                    data-modal-toggle="user-send-message-modal"
                                    type="button"
                                >
                                    Revoke
                                </button>
                            @elseif (isset($row->available))
                                <button
                                    class="text-red-500 hover:cursor-pointer"
                                    data-modal-target="user-send-message-modal"
                                    data-modal-toggle="user-send-message-modal"
                                    type="button"
                                >
                                    Revoke
                                </button>
                            @endif
                        @endif
                    </div>
                </td>

            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
