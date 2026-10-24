@props(['company'])

<x-card
    class="min-w-62 hover:cursor-pointer hover:bg-gray-950"
    onclick="window.open('{{ route('companies.edit', $company) }}', '_blank')"
>
    <h3 class="mb-2 text-lg font-bold">{{ $company->name }}</h3>
    <hr class="bg-neutral-quaternary mb-3 mt-2 h-px border-0">

    <p class="text-sm"><b>Number:</b> {{ $company->registration_number }}</p>
    <p class="text-sm"><b>Tax ID:</b> {{ $company->tax_id }}</p>

    <h4 class="font-bold">Address:</h4>
    <p class="text-sm">{{ ResourceStringHelper::address($company->addresses[0]) }}</p>

    <h4 class="font-bold">Contacts: </h4>
    @foreach ($company->contacts as $contact)
        <p class="text-sm">{{ ResourceStringHelper::contact($contact) }}</p>
    @endforeach
</x-card>
