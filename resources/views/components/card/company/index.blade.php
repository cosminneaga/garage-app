@props(['company'])

<x-card
    :description="'Company: ' . $company->name . ', ID: ' . $company->id"
    onclick="location.href = '{{ route('companies.edit', $company) }}'"
    class="hover:cursor-pointer hover:bg-gray-950 min-w-62"
>
    <p class="text-sm"><b>Registration NUmber:</b> {{ $company->registration_number }}</p>
    <p class="text-sm"><b>Labour Rate (hourly):</b> {{ $company->labour_rate_hourly }}</p>
</x-card>
