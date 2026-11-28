@php
    Session::flashInput([
        'contact' => $contact->toArray(),
    ]);
@endphp

<x-layout::index title="{{ $supplier->name }} | Contacts">
    <x-tabs :tabs="SupplierTabs::tabs()">
        <x-card description="Visualise & Edit {{ $supplier->name }}'s contact details">
            <form
                method="post"
                action="{{ route('contact.supplier.update', [$contact, $supplier]) }}"
            >
                @csrf
                @method('PUT')

                <x-form.content.contact identifier="supplier_edit" />

                <section class="mt-2">
                    <x-button type="submit">Update contact</x-button>
                </section>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
