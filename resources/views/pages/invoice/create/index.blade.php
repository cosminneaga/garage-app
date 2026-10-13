@json(Str::classLower($resource))

<x-layout::index title="Invoice Create">
    {{-- @json($resource) --}}

    <x-card title="Create invoice for {{ Str::classLower($resource) }}: {{ $resource->number ? $resource->number : $resource->id }}">

        <x-card.booking :booking="$resource" />
        <form
            action="{{ route('invoices.' . $resource->getTable() . '.store', [$resource, $client, $vehicle]) }}"
            method="POST"
        >
            @csrf

            <x-alert.inline>
                <a
                    href="{{ route('companies.edit', $company) }}"
                    target="_blank"
                >Company: {{ $company->name }},</a>
                <a
                    href="{{ route('companies.edit', ['company' => $company, 'tab' => 'vehicles']) }}"
                    target="_blank"
                >Vehicle: {{ $vehicle->registration }},</a>
                <a
                    href="{{ route('companies.edit', ['company' => $company, 'tab' => 'clients']) }}"
                    target="_blank"
                >Client: {{ $client->name }}</a>
            </x-alert.inline>

            <x-form.field.datetime
                identifier="invoice"
                name="due_date"
                label="Due Date"
            />

            <x-form.field.textarea
                identifier="invoice"
                name="notes"
                label="Notes"
            />

            <x-button
                type="submit"
            >Create</x-button>
        </form>

    </x-card>
</x-layout::index>
