@php
    Session::flashInput([
        'contact' => $contact->toArray()
    ]);
@endphp

<x-layout::index>
    <x-tabs :tabs="CompanyTabs::tabs()">
        <x-card
            description="Visualise & Edit {{ $company->name }}'s contact details"
        >
            <form
                method="post"
                action="{{ route('contact.company.update', [$contact, $company]) }}"
            >
                @csrf
                @method('PUT')

                <x-form.content.contact
                    identifier="company_edit"
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
