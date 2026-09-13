@php
    Session::flashInput($resource->toArray());
@endphp

<x-layout::index title="Client">
    <x-tabs :tabs="ClientTabs::tabs()">
        <x-card description="Visualise % Edit {{ $resource->name }} details">
            <form method="POST" action="{{ route('clients.update', $resource) }}" id="client-update-form">
                @csrf
                @method('PUT')

                <x-form.field.text
                    identifier="client"
                    name="name"
                    label="Name"
                />
                <x-form.field.text
                    identifier="client"
                    name="email"
                    label="Email"
                    type="email"
                />
                <x-form.field.switch
                    identifier="client"
                    name="active"
                    label="Active"
                    checked="{{ old('active') }}"
                >
                    <x-slot name="before">Inactive</x-slot>
                    <x-slot name="after">Active</x-slot>
                </x-form.field.switch>

                <div class="mt-5 flex gap-1">
                    @permitted(UserPermission::CLIENT, 'update')
                        <x-button
                            class="w-fit"
                            id="client-update-submit"
                            form="client-update-form"
                            type="submit"
                        >Update Details</x-button>
                    @endpermitted

                    @permitted(UserPermission::CLIENT, 'delete')
                        <x-button
                            class="w-fit"
                            id="client-update-delete-button"
                            data-modal-target="client-delete-modal"
                            data-modal-toggle="client-delete-modal"
                            type="button"
                            variant="danger"
                        >Delete Details</x-button>
                    @endpermitted
                </div>
            </form>

            <x-modal.confirm
                id="client-delete"
                type="delete"
                action="{{ route('clients.destroy', $resource->id) }}"
                message="Are you sure you want to remove {{ $resource->name }} from your list of clients?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
