@props(['client', 'company'])

<x-card
    class="min-w-62 hover:cursor-pointer hover:bg-gray-950"
    onclick="window.open('{{ route('clients.companies.edit', [$client, $company]) }}', '_blank')"
>
    <h3 class="mb-2 text-lg font-bold">{{ $client->name }}</h3>
    <hr class="bg-neutral-quaternary mb-3 mt-2 h-px border-0">

    <p class="text-sm"><b>Name:</b> {{ $client->name }} </p>
    <p class="text-sm"><b>Email:</b> {{ $client->email }} </p>

    <h4 class="font-bold">Address:</h4>
    <p class="text-sm">{{ ResourceStringHelper::address($client->addresses[0]) }}</p>

    <h4 class="font-bold">Contacts: </h4>
    @foreach ($client->contacts as $contact)
        <p class="text-sm">{{ ResourceStringHelper::contact($contact) }}</p>
    @endforeach
</x-card>
