@props([
    'identifier' => 'address',
])

<section class="mt-4">
    <h3 class="text-lg font-bold">Address Basic Information *</h3>
    <hr class="bg-neutral-quaternary mb-3 mt-2 h-px border-0">

    <x-form.field.text
        identifier="{{ $identifier }}"
        name="address[number]"
        value="{{ old('address.number' , '') }}"
        label="Number"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="address[name]"
        value="{{ old('address.name', '') }}"
        label="Street Name"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="address[postcode]"
        value="{{ old('address.postcode', '') }}"
        label="Postcode"
    />
    <x-form.content.world
        identifier="{{ $identifier }}"
    />
</section>

<section class="mt-4">
    <h3 class="text-lg font-bold">Address Extra Information</h3>
    <hr class="bg-neutral-quaternary mb-3 mt-2 h-px border-0">

    <div class="grid grid-cols-2 gap-2">
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="address[coordinates][latitude]"
            value="{{ old('address.coordinates.latitude', '') }}"
            label="Latitude"
        />
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="address[coordinates][longitude]"
            value="{{ old('address.coordinates.longitude', '') }}"
            label="Longitude"
        />
    </div>

    <x-form.field.text
        identifier="{{ $identifier }}"
        name="address[building]"
        value="{{ old('address.building', '') }}"
        label="Building"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="address[floor]"
        value="{{ old('address.floor', '') }}"
        label="Floor"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="address[unit]"
        value="{{ old('address.unit', '') }}"
        label="Unit"
    />
</section>
