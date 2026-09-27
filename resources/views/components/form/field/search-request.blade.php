@props([
    'name',
    'route',
    'nested_parent_name' => false,
    'identifier' => '',
    'label' => false,
    'map_value' => 'id',
    'map_label' => 'label',
])

@php
    $ids = BladeModalHelper::ids($name);
    $name = Str::generateFormFieldName($name, $nested_parent_name);
@endphp

<div x-data="{
    options: [],
    selected: null,
    dropdownInstance: null,

    async search(event) {
        const data = await ServerRequest.query(@js($route), { search: event.target.value });
        this.options = data;

        const target = document.getElementById(@js($ids->get('modal')));
        const trigger = document.getElementById(@js($name . '_search'));
        const dropdown = new Dropdown(target, trigger);
        dropdown.show();
        this.dropdownInstance = dropdown;
    }
}" class="relative">
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ $name }}"
        x-model="selected"
        :visible="false"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ $name . '_search' }}"
        data-dropdown-toggle="{{ $ids->get('modal') }}"
        data-dropdown-trigger="click"
        label="{{ $label }}"
        x-ref="make_search"
        @keyup.debounce.500ms="search"
        @click="search"
    />

    <div
        class="bg-neutral-primary-medium border-default-medium rounded-base w-full z-10 hidden border shadow-lg"
        id="{{ $ids->get('modal') }}"
    >
        <ul class="text-body h-auto max-h-80 overflow-y-auto p-2 text-sm font-medium">
            <template
                x-for="option in options"
                :key="option[@js($map_value)]"
            >
                <li
                    class="border p-3 hover:cursor-pointer hover:border-white"
                    x-text="option[@js($map_label)]"
                    @click="selected = option[@js($map_value)]; $refs.make_search.value = option.name; dropdownInstance.hide();"
                ></li>
            </template>
        </ul>
    </div>
</div>
