@props(['vehicle', 'company'])

<x-card
    class="min-w-62 hover:cursor-pointer hover:bg-gray-950"
    onclick="window.open('{{ route('vehicles.companies.search', ['company' => $company]) }}', '_blank')"
>
    <h3 class="mb-2 text-lg font-bold">{{ $vehicle->registration }}</h3>
    <hr class="bg-neutral-quaternary mb-3 mt-2 h-px border-0">

    <p class="text-sm"><b>VIN:</b> {{$vehicle->vin}} </p>
    <p class="text-sm"><b>Make:</b> {{ $vehicle->make?->name }} </p>
    <p class="text-sm"><b>Model:</b> {{ $vehicle->model?->name }} </p>
    <p class="text-sm"><b>Data:</b></p>
    <ul class="text-sm pl-2">
        <li><b>Name:</b> {{ $vehicle->data?->name }} </li>
        <li><b>Cylinders:</b> {{ $vehicle->data?->cylinders }} </li>
        <li><b>Displacement:</b> {{ $vehicle->data?->displacement }} </li>
        <li><b>Drive:</b> {{ $vehicle->data?->drive }} </li>
        <li><b>Transmission:</b> {{ $vehicle->data?->transmission }} </li>
    </ul>
</x-card>
