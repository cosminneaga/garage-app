@props([
    'identifier' => 'part',
    'nested_parent_name' => false,
    'available_vehicle_makes' => [],
    'available_suppliers' => [],
])

<section>
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('name', $nested_parent_name) }}"
        label="Name"
        placeholder="Oil Filter"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('manufacturer', $nested_parent_name) }}"
        label="Manufacturer"
        placeholder="MANN"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('part_number', $nested_parent_name) }}"
        label="Part Number"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('serial_number', $nested_parent_name) }}"
        label="Serial Number"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('item_price', $nested_parent_name) }}"
        label="Price"
        type="number"
        step="0.01"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('commercial_markup', $nested_parent_name) }}"
        label="Commercial Markup"
        type="number"
        step="0.01"
    />
</section>

<section>
    <x-form.field.textarea
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('notes', $nested_parent_name) }}"
        label="General Notes"
    />
    <x-form.field.select
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('supplier_id', $nested_parent_name) }}"
        label="Supplier"
        :options="$available_suppliers"
        select_map_value="id"
        select_map_label="name"
    />
    <x-form.field.select
        identifier="{{ $identifier }}"
        name="{{ Str::generateFormFieldName('brand', $nested_parent_name) }}"
        label="Vehicle Brand"
        :options="$available_vehicle_makes"
        select_map_value="id"
        select_map_label="name"
    />
</section>
