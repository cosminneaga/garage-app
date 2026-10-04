@props(['workorder', 'resource' => null])

@php
    $class = $resource ? $resource::class : '';
    $route = match($class) {
        \App\Models\Booking::class => [
            'name' => 'workorders.bookings.edit',
            'relation' => 'booking',
        ],
        \App\Models\Company::class => [
            'name' => 'workorders.companies.edit',
            'relation' => 'company',
        ],
        default => [
            'name' => 'workorders.companies.edit',
            'relation' => 'company',
        ],
    };
@endphp

<x-card
    :description="'Workorder number: ' . $workorder->number . ', ID: ' . $workorder->id"
    onclick="location.href = '{{ route($route['name'], [$workorder, $workorder[$route['relation']]]) }}'"
    class="hover:cursor-pointer hover:bg-gray-950"
>
    <p class="text-sm font-bold"><b>Title:</b> {{ $workorder->title->label() }}</p>
    <p class="text-sm"><b>Status:</b> {{ $workorder->status->label() }}</p>
    @if($workorder->client)
        <p class="text-sm font-bold">Client:</p>
        <ul class="pl-2">
            <li class="text-sm">Name: {{ $workorder->client->name }}</li>
            <li class="text-sm">Email: {{ $workorder->client->email }}</li>
        </ul>
    @endif
    @if($workorder->vehicle)
        <p class="text-sm font-bold">Vehicle:</p>
        <ul class="pl-2">
            <li class="text-sm">Registration: {{ $workorder->vehicle->registration }}</li>
            <li class="text-sm">VIN: {{ $workorder->vehicle->vin }}</li>
        </ul>
    @endif
    <p class="text-sm"><b>Completed At:</b> {{ $workorder->completed_at }}</p>
    <p class="text-sm"><b>In Progress At:</b> {{ $workorder->in_progress_at }}</p>
    <p class="text-sm"><b>In Pause At:</b> {{ $workorder->in_pause_at }}</p>
    <p class="text-sm"><b>Cancelled At:</b> {{ $workorder->cancelled_at }}</p>
    <p class="text-sm"><b>Created By:</b> {{ $workorder->creator?->name }}</p>
    <p class="text-sm"><b>Updated By:</b> {{ $workorder->updater?->name }}</p>
    <p class="text-sm"><b>Deleted By:</b> {{ $workorder->deletor?->name }}</p>
</x-card>
