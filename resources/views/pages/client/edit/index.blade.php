@php
    Session::flashInput($resource->toArray());
@endphp

<x-layout::index title="Client">
    <x-tabs :tabs="ClientTabs::tabs()">
        <x-card description="Visualise & Edit {{ $resource->name }} details">
            <form
                method="POST"
                action="{{ route('clients.companies.update', [$resource, $parent]) }}"
                id="client-update-form"
            >
                @csrf
                @method('PUT')

                <x-form.content.client identifier="company" />

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
                action="{{ route('clients.companies.destroy', [$resource, $parent]) }}"
                message="Are you sure you want to remove {{ $resource->name }} from your list of clients?"
            />
        </x-card>
    </x-tabs>
</x-layout::index>
