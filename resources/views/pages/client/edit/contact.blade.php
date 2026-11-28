@php
    Session::flashInput([
        'contact' => $contact->toArray()
    ]);
@endphp

<x-layout::index title="Client's contacts">
    <x-tabs :tabs="ClientTabs::tabs()">
        <x-card description="Visualise & Edit {{ $client->name }} contacts">
            <form
                method="post"
                action="{{ route('contact.client.update', [$contact, $client]) }}"
            >
                @csrf
                @method('PUT')

                <x-form.content.contact
                    identifier="client_edit"
                />

                <section class="mt-2">
                    <x-button
                        type="submit"
                    >Update contact</x-button>
                </section>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
