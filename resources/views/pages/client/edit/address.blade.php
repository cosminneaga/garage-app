@php
    Session::flashInput([
        'address' => json_decode(json_encode($address), true)
    ]);
@endphp

<x-layout::index title="Client's addresses">
    <x-tabs :tabs="ClientTabs::tabs()">
        <x-card description="Visualise & Edit {{ $client->name }} addresses">
            <form action="{{ route('address.client.edit', [$address, $client]) }}" method="post">
                @csrf
                @method('PUT')

                <x-form.content.address
                    identifier="client_edit"
                />

                <section class="mt-2">
                    <x-button type="submit">Update address</x-button>
                </section>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
