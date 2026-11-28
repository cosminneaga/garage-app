@props(['identifier'])

@php
    $helper_country = BladeFormHelper::names($identifier, 'country_id');
    $helper_state = BladeFormHelper::names($identifier, 'state_id');
    $helper_city = BladeFormHelper::names($identifier, 'city_id');

    $name_country = 'address[country_id]';
    $name_state = 'address[state_id]';
    $name_city = 'address[city_id]';

    $modal = BladeModalHelper::ids($name_country);
@endphp

<div
    class="relative"
    x-data="{
        countries: [],
        states: [],
        cities: [],
        country_id: @js(old('address.country_id', null)),
        state_id: @js(old('address.state_id', null)),
        city_id: @js(old('address.city_id', null)),
        dropdownInstance: null,

        async search(event) {
            this.countries = await ServerRequest.query('{{ route('search.countries') }}', { search: event.target.value });
        },
        setCountry(country_id) {
            this.country_id = country_id;
            const country = this.countries.find(country => country.id === country_id);
            this.states = country.states;
            this.cities = this.states.find(state => state.id === 1)?.cities;
            $refs.make_search.value = country.name;
            this.dropdownInstance.hide();
        },
        setState(id) {
            this.state_id = id;
            const state = this.states.find(state => state.id == id);
            this.cities = state.cities;
        },
        setCity(id) {
            this.city_id = id;
            const city = this.cities.find(city => city.id == id);
        },
        async clear(event) {
            event.target.value = '';
            await this.search(event);
        },
    }"
    x-init="async function() {
        const target = document.getElementById(@js($modal->get('modal')));
        const trigger = document.getElementById('address[country_search]');
        const dropdown = new Dropdown(target, trigger);
        dropdownInstance = dropdown;

        if (this.country_id) {
            const response = await window.ServerRequest.get(`/country/${this.country_id}`);
            this.countries.push(response);
            this.setCountry(this.country_id);
        }

        if (this.state_id) {
            this.setState(this.state_id);
        }

        if (this.city_id) {
            this.setCity(this.city_id);
        }
    }"
>
    <section class="my-2">
        <input
            class="hidden"
            id="{{ $name_country }}"
            name="{{ $name_country }}"
            data-test="{{ $helper_country->get('testName') }}"
            type="text"
            x-model="country_id"
        >
        <x-form.field.text
            identifier="{{ $identifier }}"
            name="address[country_search]"
            label="Country"
            x-ref="make_search"
            @keyup.debounce.700ms="search"
            @focus="clear"
        />
        <div
            class="bg-neutral-primary-medium border-default-medium rounded-base z-10 hidden w-full border shadow-lg"
            id="{{ $modal->get('modal') }}"
        >
            <ul class="text-body h-auto max-h-80 overflow-y-auto p-2 text-sm font-medium">
                <template
                    x-for="option in countries"
                    :key="option['id']"
                >
                    <li
                        class="my-1 border p-3 hover:cursor-pointer hover:border-white"
                        x-text="option['name']"
                        @click="setCountry(option['id']);"
                    ></li>
                </template>
            </ul>
        </div>
    </section>

    <section class="my-2">
        <label
            class="form-label"
            for="{{ $name_state }}"
        >State</label>
        <select
            class="form-item"
            id="{{ $name_state }}"
            name="{{ $name_state }}"
            data-test="{{ $helper_state->get('testName') }}"
            x-model="state_id"
            @change="setState(state_id)"
        >
            <template
                x-for="state in states"
                :key="state.id"
            >
                <option
                    :value="state.id"
                    x-text="state.name"
                    :selected="state.id == state_id"
                ></option>
            </template>
        </select>
    </section>

    <section class="my-2">
        <label
            class="form-label"
            for="{{ $name_city }}"
        >City</label>
        <select
            class="form-item"
            id="{{ $name_city }}"
            name="{{ $name_city }}"
            data-test="{{ $helper_city->get('testName') }}"
            x-model="city_id"
            @change="setCity(city_id)"
        >
            <template
                x-for="city in cities"
                :key="city.id"
            >
                <option
                    :value="city.id"
                    x-text="city.name"
                    :selected="city.id == city_id"
                ></option>
            </template>
        </select>
    </section>
</div>
