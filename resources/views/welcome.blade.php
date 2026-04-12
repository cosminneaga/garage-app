<?php
$labels = [\Carbon\Carbon::now()->subDays(10)->format('d-m-Y'), \Carbon\Carbon::now()->format('d-m-Y')];
$data = [];

$options = [
    'responsive' => true,
    'scales' => [
        'x' => ['title' => ['display' => true, 'text' => 'Date']],
        'y' => [
            'beginAtZero' => true,
            'title' => ['display' => true, 'text' => 'Count'],
        ],
    ],
];
?>

<x-layout>
    Hello, {{ Auth::user() ? Auth::user()->name : 'Guest' }}!

    @auth
        <div class="grid grid-cols-1 md:grid-cols-3">
            <x-bladewind.card title="users" class="p-3! col-span-2">
                <x-bladewind.chart
                    type="line"
                    :labels="$users['date']"
                    :data="$users['count']"
                    :options="$options"
                    show_legends="true"
                />
            </x-bladewind.card>
        </div>
    @endauth
</x-layout>
