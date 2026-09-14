@props(['identifier', 'parent_name' => ''])

@php
    $helper_make = BladeFormHelper::names($identifier, 'make_id');
    $helper_model = BladeFormHelper::names($identifier, 'model_id');
    $helper_data = BladeFormHelper::names($identifier, 'data_id');

    $name_make = Str::generateFormFieldName('make_id', $parent_name);
    $name_model = Str::generateFormFieldName('model_id', $parent_name);
    $name_data = Str::generateFormFieldName('data_id', $parent_name);

    $class_select =
        'bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm';
    $class_label = 'text-heading mb-1.25 text-md block font-medium';
@endphp

<section>
    <label class="{{ $class_label }}">Car make</label>
    <select
        class="{{ $class_select }}"
        id="{{ $name_make }}"
        name="{{ $name_make }}"
        data-test="{{ $helper_make->get('testName') }}"
        x-data="{
            options: [],
            async setOptions() {
                const response = await fetch('/car/makes');
                this.options = await response.json();
            }
        }"
        x-init="setOptions()"
        x-model="$store.form_data.car.make_id"
        @change="console.log($store.form_data.car.make_id)"
    >
        <template
            x-for="option in options"
            :key="option.id"
        >
            <option
                :value="option.id"
                x-text="option.name"
            ></option>
        </template>
    </select>
</section>

<section x-data="{
    options: [],
    async setOptions() {
        const response = await fetch('/car/makes/' + $store.form_data.car.make_id + '/models');
        this.options = await response.json();
    }
}">
    <label class="{{ $class_label }}">Car model</label>

    <div class="grid grid-cols-[auto_1fr] gap-2">
        <x-button
            type="button"
            @click="setOptions()"
            ::disabled="$store.form_data.car.make_id === null"
        >
            fetch
        </x-button>

        <select
            class="{{ $class_select }}"
            id="{{ $name_model }}"
            name="{{ $name_model }}"
            data-test="{{ $helper_model->get('testName') }}"
            x-model="$store.form_data.car.model_id"
        >
            <template
                x-for="option in options"
                :key="option.id"
            >
                <option
                    :value="option.id"
                    x-text="option.name"
                ></option>
            </template>
        </select>
    </div>
</section>

<section x-data="{
    options: [],
    async setOptions() {
        const response = await fetch('/car/makes/' + $store.form_data.car.make_id + '/models/' + $store.form_data.car.model_id + '/data');
        this.options = await response.json();
    }
}">
    <label class="{{ $class_label }}">Car data</label>

    <div class="grid grid-cols-[auto_1fr] gap-2">
        <x-button
            type="button"
            @click="setOptions()"
            ::disabled="$store.form_data.car.model_id === null"
        >
            fetch
        </x-button>

        <select
            class="{{ $class_select }}"
            id="{{ $name_data }}"
            name="{{ $name_data }}"
            data-test="{{ $helper_data->get('testName') }}"
            x-model="$store.form_data.car.data_id"
        >
            <template
                x-for="option in options"
                :key="option.id"
            >
                <option
                    :value="option.id"
                    x-text="option.name"
                ></option>
            </template>
        </select>
    </div>
</section>
