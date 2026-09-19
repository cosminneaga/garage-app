@props(['identifier', 'parent_name' => ''])

@php
    $helper_make = BladeFormHelper::names($identifier, 'make_id');
    $helper_model = BladeFormHelper::names($identifier, 'model_id');
    $helper_data = BladeFormHelper::names($identifier, 'data_id');

    $name_make = Str::generateFormFieldName('make_id', $parent_name);
    $name_model = Str::generateFormFieldName('model_id', $parent_name);
    $name_data = Str::generateFormFieldName('data_id', $parent_name);
@endphp

<div
    x-data="{
        makes: [],
        models: [],
        data: [],
        make_id: null,
        model_id: null,
        data_id: null,
    
        async setMakes() {
            const response = await fetch('/car/makes');
            this.makes = await response.json();
        },
        async setModels(make_id) {
            const response = await fetch('/car/makes/' + make_id + '/models');
            this.models = await response.json();
        },
        async setData(make_id, model_id) {
            const response = await fetch('/car/makes/' + make_id + '/models/' + model_id + '/data');
            this.data = await response.json();
        }
    }"
    x-init="await setMakes();
    await setModels(makes[0].id);
    await setData(makes[0].id, models[0].id);"
>
    <section>
        <label class="form-label">Car make</label>
        <select
            class="form-item"
            id="{{ $name_make }}"
            name="{{ $name_make }}"
            data-test="{{ $helper_make->get('testName') }}"
            x-model="make_id"
            @change="await setModels(make_id ?? makes[0].id); await setData(make_id ?? makes[0].id, model_id ?? models[0].id);"
        >
            <template
                x-for="make in makes"
                :key="make.id"
            >
                <option
                    :value="make.id"
                    x-text="make.name"
                ></option>
            </template>
        </select>
    </section>

    <section>
        <label class="form-label">Car model</label>
        <select
            class="form-item"
            id="{{ $name_model }}"
            name="{{ $name_model }}"
            data-test="{{ $helper_model->get('testName') }}"
            x-model="model_id"
            @change="await setData(make_id, model_id ?? models[0].id);"
        >
            <template
                x-for="model in models"
                :key="model.id"
            >
                <option
                    :value="model.id"
                    x-text="model.name"
                ></option>
            </template>
        </select>
    </section>

    <section>
        <label class="form-label">Car data</label>
        <select
            class="form-item"
            id="{{ $name_data }}"
            name="{{ $name_data }}"
            data-test="{{ $helper_data->get('testName') }}"
            x-model="data_id"
        >
            <template
                x-for="option in data"
                :key="option.id"
            >
                <option
                    :value="option.id"
                    x-text="option.name"
                ></option>
            </template>
        </select>
    </section>
</div>
