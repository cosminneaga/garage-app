@props([
    'data' => [],
    'limit' => 10,
    'resource',
])

@php
    $columns = TransactionColumns::tableColumns();
@endphp

<h2 class="text-lg font-bold">Transactions History</h2>
<x-table.wrapper :data="$data">
    <x-table.extension.thead :columns="$columns" />

    <x-slot name="tbody">
        @foreach ($data as $row)
            <tr class="bg-neutral-primary-soft border-default hover:bg-neutral-secondary-medium border-b">

                <!-- GENERIC DATABASE COLUMNS -->
                @foreach ($columns as $column)
                    <td class="px-6 py-4">{{ $row[$column->value] }}</td>
                @endforeach
            </tr>
        @endforeach
    </x-slot>
</x-table.wrapper>
