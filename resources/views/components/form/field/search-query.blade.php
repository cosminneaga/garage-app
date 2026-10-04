@props([
    'name',
    'route',
    'identifier' => '',
    'value' => null,
    'nested_parent_name' => false,
    'label' => false,
    'map_value' => 'id',
    'map_label' => 'label',
    'map_labels' => null,
])

{{--
    EXAMPLE

    <x-form.field.search-query
        name="part_id"
        label="Part"
        route="{{ route('parts.search') }}"
        map_value="id"
        // map_label="name"
        :map_labels="['name', 'code']"
        :value="\App\Models\Part::find(old('part_id'))"
    />

--}}

@php
    $ids = BladeModalHelper::ids($name);
    $name = Str::generateFormFieldName($name, $nested_parent_name);
    $helper = BladeFormHelper::names($identifier, $name);
@endphp

<div
    class="relative"
    x-data="{
        options: [],
        selected: null,
        dropdownInstance: null,

        async search(event) {
            this.options = await ServerRequest.query(@js($route), { search: event.target.value });
        },
        actionSelect(value, label) {
            this.selected = value;
            $refs.make_search.value = label;
            this.dropdownInstance.hide();
        },
    }"
    x-init="function() {
        const target = document.getElementById(@js($ids->get('modal')));
        const trigger = document.getElementById(@js($name . '_search'));
        const dropdown = new Dropdown(target, trigger);
        dropdownInstance = dropdown;

        const value = @js($value);
        if (value) {
            selected = value[@js($map_value)];
            const label = @js($map_label);
            const labels = @js($map_labels);

            if (labels) {
                $refs.make_search.value = labels.map(a => value[a]).join(', ');
            } else {
                $refs.make_search.value = value[label];
            }
        }
    }"
>
    <input
        type="text"
        name="{{ $name }}"
        id="{{ $name }}"
        data-test="{{ $helper->get('testName') }}"
        x-model="selected"
        class="hidden"
    />
    <x-form.field.text
        identifier="{{ $identifier }}"
        name="{{ $name . '_search' }}"
        label="{{ $label }}"
        x-ref="make_search"
        @keyup.debounce.500ms="search"
        @click="dropdownInstance.show(); search($event);"
    />

    <div
        class="bg-neutral-primary-medium border-default-medium rounded-base z-10 hidden w-full border shadow-lg"
        id="{{ $ids->get('modal') }}"
    >
        <ul class="text-body h-auto max-h-80 overflow-y-auto p-2 text-sm font-medium">
            <template
                x-for="option in options"
                :key="option[@js($map_value)]"
            >
                <li
                    class="my-1 border p-3 hover:cursor-pointer hover:border-white"
                    @if ($map_labels)
                        x-text="@js($map_labels).map(property => option[property]).join(', ')"
                        @click="actionSelect(option[@js($map_value)], @js($map_labels).map(property => option[property]).join(', '));"
                    @elseif ($map_label)
                        x-text="option[@js($map_label)]"
                        @click="actionSelect(option[@js($map_value)], option[@js($map_label)]);"
                    @endif
                ></li>
            </template>
        </ul>
    </div>
</div>
