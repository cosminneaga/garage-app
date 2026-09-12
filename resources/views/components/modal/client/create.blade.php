@props([
    'countries' => [],
])

<div>
    <x-button
        id="create-company-client-button"
        data-modal-target="create-company-client-modal"
        data-modal-toggle="create-company-client-modal"
        type="button"
        @click="$refs.client_store_form.action = `/clients/companies/${$store.form_data.company.id}`"
    >
        Create
    </x-button>

    <x-modal.wrapper
        id="create-company-client-modal"
        title="Create new client"
        size="7xl"
    >
        <form
            action="#"
            method="POST"
            x-ref="client_store_form"
        >
            @csrf

            <x-form.content.client
                identifier="client"
                :countries="$countries"
            />

            <x-button
                id="client-create-submit"
                type="submit"
            >Submit</x-button>
        </form>
    </x-modal.wrapper>
</div>
