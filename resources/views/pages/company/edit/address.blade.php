@php
    Session::flashInput([
        'address' => json_decode(json_encode($address), true)
    ]);
@endphp

<x-layout::index>
    <x-tabs :tabs="CompanyTabs::tabs()">
        <x-card
            description="Visualise & Edit {{ $company->name }}'s location details"
        >
            <form action="{{ route('address.company.edit', [$address, $company]) }}" method="post">
                @csrf
                @method('PUT')

                <x-form.content.address
                    identifier="company_edit"
                />

                <section class="mt-2">
                    <x-button type="submit">Update address</x-button>
                </section>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
