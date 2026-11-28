@php
    Session::flashInput([
        'address' => json_decode(json_encode($address), true)
    ]);
@endphp

<x-layout::index title="{{ $user->name }} | Addresses">
    <x-tabs :tabs="UserTabs::tabs()">
        <x-card
            description="Visualise & Edit {{ $user->name }}'s location details"
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
