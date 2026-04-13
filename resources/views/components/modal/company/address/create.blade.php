@props(['name', 'company'])

<x-bladewind.modal
    title="Create new address for {{ $company->name }}"
    :name="$name"
    showActionButtons="false"
>
    <form
        id="{{ $name }}"
        action="{{ route('companies.address.store', $company) }}"
        method="POST"
    >
        @csrf

        <x-bladewind.input
            name="number"
            type="text"
            value="777"
            label="Number"
        />
        <x-bladewind.input
            name="street"
            type="text"
            value="God's Street"
            label="Street"
        />
        <x-bladewind.input
            name="postcode"
            type="text"
            value="777777"
            label="Postcode"
        />
        <x-bladewind.textarea
            name="extra"
            selected_value="Suite 75488, to the left of the building"
            label="Extra information"
        />
        <x-bladewind.select
            name="country_id"
            value_key="id"
            label="Select a country"
            label_key="name"
            flag_key="code"
            :data="\App\Models\Country::all()"
            selected_value="1"
        />
        <h3>Location</h3>
        <br>
        <x-bladewind.input
            name="coordinates[latitude]"
            type="text"
            value="8.327832"
            label="Latitude"
        />
        <x-bladewind.input
            name="coordinates[longitude]"
            type="text"
            value="94.676743"
            label="Longitude"
        />

        <x-bladewind.button
            can_submit
        >create</x-bladewind.button>
    </form>
</x-bladewind.modal>
