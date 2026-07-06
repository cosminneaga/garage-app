@props([
    'data' => [],
    'remove' => false,
    'user' => null,
])

@php
    $columns = collect(PermissionColumns::cases())->map(
        fn($col) => $col->value,
    );
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
                    {{ $row->name }}
                </td>
                <td class="px-6 py-4">
                    {{ $row->guard_name }}
                </td>
                @if ($remove && $user)
                    <td class="px-6 py-4">
                        <form
                            action="{{ route('permission.destroy', [$row->id, $user]) }}"
                            method="POST"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit">Remove</button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
