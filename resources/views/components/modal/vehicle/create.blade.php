@props([
    'makes' => [],
    'models' => [],
    'data' => [],
    'years' => [],
])

<div>
    <x-button
        id="create-company-vehicle-button"
        data-modal-target="create-company-vehicle-modal"
        data-modal-toggle="create-company-vehicle-modal"
        type="button"
        @click="$refs.vehicle_store_form.action = `/vehicles/companies/${$store.form_data.company.id}`"
    >
        Create
    </x-button>

    <x-modal.wrapper
        id="create-company-vehicle-modal"
        title="Create new vehicle"
        size="7xl"
    >
        <form
            action="#"
            method="POST"
            x-ref="vehicle_store_form"
        >
            @csrf

            <x-form.content.vehicle
                identifier="vehicle"
                :makes="$makes"
                :models="$models"
                :data="$data"
                :years="$years"
            />

            <x-button
                id="vehicle-create-submit"
                type="submit"
            >Submit</x-button>
        </form>
    </x-modal.wrapper>
</div>
