{{-- @json(Str::classLower($resource)) --}}

<x-layout::index title="Invoice Create">
    {{-- @json($resource) --}}

    <x-card title="Create invoice for {{ Str::classLower($resource) }}: {{ $resource->number ? $resource->number : $resource->id }}">

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

        <div class="grid grid-flow-row gap-2 lg:grid-flow-col">
            <x-card.booking :booking="$resource" />
            <x-card.company :company="$company" />
            <x-card.client
                :client="$client"
                :company="$company"
            />
            <x-card.vehicle
                :vehicle="$vehicle"
                :company="$company"
            />
        </div>

        @if($resource::class === \App\Models\Booking::class)
            <x-alert.inline>
                <p>Workorders: {{ count($resource->workorders) }}</p>
                <p>Operations: {{ count($resource->operations) }}</p>
            </x-alert.inline>
        @elseif ($resource::class === \App\Models\Workorder::class)
            <x-alert.inline>
                <p>Operations: {{ count($resource->operations) }}</p>
            </x-alert.inline>
        @endif

        <form
            action="{{ route('invoices.' . $resource->getTable() . '.store', [$resource, $client, $vehicle]) }}"
            method="POST"
        >
            @csrf

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

            <x-button type="submit">Create</x-button>
        </form>

    </x-card>
</x-layout::index>
