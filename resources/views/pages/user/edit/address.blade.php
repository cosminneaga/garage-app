@php
    Session::flashInput([
        'address' => $address->toArray()
    ]);
@endphp

<x-layout::index title="Address">
    <x-tabs :tabs="UserTabs::tabs()">
        <x-card
            title="Visualise & Edit {{ $user->name }} location's details"
        >
            <form action="{{ route('address.user.edit', [$address, $user]) }}" method="post">
                @csrf
                @method('PUT')

                <x-form.content.address
                    identifier="user_edit"
                />

                <section class="mt-2">
                    <x-button type="submit">Update address</x-button>
                </section>
            </form>
        </x-card>
    </x-tabs>
</x-layout::index>
