@props(['id', 'resource', 'countries' => [], 'trigger' => false])

@php
    use App\Enums\SupplierType;
    $parentname = $resource->getTable();
    $ids = [
        'modal' => $parentname . '-' . $id . '-modal',
        'trigger' => $parentname . '-' . $id . '-modal-trigger',
        'submit' => $parentname . '-' . $id . '-modal-submit',
    ];
@endphp

@if ($trigger)
    <x-button
        class="w-fit"
        id="{{ $ids['trigger'] }}"
        data-modal-target="{{ $ids['modal'] }}"
        data-modal-toggle="{{ $ids['modal'] }}"
        type="button"
        variant="default"
    >Add Supplier</x-button>
@endif

<x-modal.wrapper id="{{ $ids['modal'] }}" size="6xl">
    <form
        action="{{ route($parentname . '.supplier.store', $resource) }}"
        method="POST"
    >
        @csrf

        <div class="grid grid-rows-1 gap-4 md:grid-cols-3">
            <div>
                <x-form.field
                    name="name"
                    type="text"
                    label="Name"
                    identifier="supplier"
                />
                <x-form.field
                    name="code"
                    type="text"
                    label="Code"
                    identifier="supplier"
                />
                <x-form.field
                    name="type"
                    type="select"
                    label="Type"
                    select_map_label="label"
                    select_map_value="value"
                    :options="SupplierType::ui()"
                    :selected_value="SupplierType::DISTRIBUTOR->value"
                    identifier="supplier"
                />
                <x-form.field
                    name="tax_id"
                    type="text"
                    label="Tax ID"
                    identifier="supplier"
                />
                <x-form.field
                    name="registration_number"
                    type="text"
                    label="Registration Number"
                    identifier="supplier"
                />
            </div>

            <div>
                <x-form.field
                    name="address[number]"
                    type="number"
                    label="Number"
                    identifier="supplier"
                />
                <x-form.field
                    name="address[street]"
                    type="text"
                    label="Number"
                    identifier="supplier"
                />
                <x-form.field
                    name="address[postcode]"
                    type="text"
                    label="Postcode"
                    identifier="supplier"
                />
                <x-form.field
                    name="address[country_id]"
                    type="select"
                    label="Select a country"
                    select_map_label="name"
                    select_map_value="id"
                    :options="$countries"
                    selected_value="1"
                    identifier="supplier"
                />
                <h3>Location</h3>
                <br>
                <x-form.field
                    name="coordinates[latitude]"
                    type="text"
                    label="Latitude"
                    identifier="supplier"
                />
                <x-form.field
                    name="coordinates[longitude]"
                    type="text"
                    label="Longitude"
                    identifier="supplier"
                />
            </div>

            <div>
                <x-form.field
                    name="contact[mobile]"
                    type="text"
                    label="Mobile Phone"
                    identifier="supplier"
                />
                <x-form.field
                    name="contact[landline]"
                    type="text"
                    label="Landline Phone"
                    identifier="supplier"
                />
                <x-form.field
                    name="contact[email]"
                    type="email"
                    label="Email"
                    identifier="supplier"
                />
                <x-form.field
                    name="contact[url]"
                    type="text"
                    label="URL"
                    identifier="supplier"
                />
                <x-form.field
                    name="contact[info]"
                    type="textarea"
                    label="More Information"
                    identifier="supplier"
                />
            </div>
        </div>

        <x-button
            type="submit"
            id="{{ $ids['submit'] }}"
        >Submit</x-button>
    </form>
</x-modal.wrapper>
