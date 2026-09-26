@props([
    'data' => null,
    'limit' => 10,
    'resource',
])

@php
    $columns = WorkorderOperationTimeColumns::tableColumns();
@endphp

<x-table.wrapper :data="$data">
    <x-table.extension.thead
        :columns="$columns"
        action_column_enabled
    />

    <x-slot name="tbody">
        @foreach ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">

                <!-- GENERIC DATABASE COLUMNS -->
                @foreach ($columns as $column)
                    <td class="px-6 py-4">{{ $row[$column->value] }}</td>
                @endforeach

                <!-- ACTION COLUMNS -->
                @if ($row->end)
                    <td class="px-6 py-4">
                        Worked Time: {{ Carbon\CarbonInterval::minutes($row->minutes)->cascade()->forHumans() }}
                    </td>
                @else
                    <td class="px-6 py-4">
                        <form
                            action="{{ route('times.operations.update', [$row, $resource]) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PUT')

                            <x-button
                                type="submit"
                                variant="success"
                                :disabled="$row->end"
                            >End</x-button>
                        </form>
                    </td>
                @endif
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
