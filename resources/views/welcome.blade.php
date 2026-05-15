<?php
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

<x-layout::index>
    <h2 class="text-2xl font-bold">Hello, {{ Auth::user() ? Auth::user()->name : 'Guest' }}!</h2>
    <br><br>
    @auth
        <div class="grid grid-cols-1 md:grid-cols-3">
            <x-bladewind.card title="registered users" class="p-3! col-span-2">
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
</x-layout::index>
