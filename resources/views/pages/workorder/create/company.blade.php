<x-layout::index title="Workorder Create">
    <x-card title="Workorder create">
        <x-card.company :company="$parent" />
        <br>

        <form
            class="grid gap-4 grid-rows-1 md:grid-cols-2"
            action="{{ route('workorders.companies.store', $parent) }}"
            method="POST"
            x-data="{ company_id: {{ $parent->id }} }"
        >
            @csrf
            <section>
                <x-form.field.select
                    identifier="company"
                    name="company_id"
                    value="{{ $parent->id }}"
                    label="Company"
                    :options="Auth::user()->companies"
                    map_value="id"
                    map_label="name"
                    x-model="company_id"
                    @change="location.href = `/workorders/companies/${company_id}/create`"
                />

                <x-form.field.wrapper>
                    <x-form.field.search-query
                        identifier="company"
                        name="client_id"
                        label="Client"
                        route="{{ route('clients.companies.search', $parent) }}"
                        map_value="id"
                        :map_labels="['name', 'email']"
                    />

                    <!-- CLIENT CREATE MODAL TRIGGER -->
                    <x-button.resource-create
                        id="client_create_trigger"
                        data-modal-target="client_create_modal"
                        data-modal-toggle="client_create_modal"
                    >
                        <x-icon-o-document-plus />
                    </x-button.resource-create>
                </x-form.field.wrapper>

                <x-form.field.wrapper>
                    <x-form.field.search-query
                        identifier="company"
                        name="vehicle_id"
                        label="Vehicle"
                        route="{{ route('vehicles.companies.search', $parent) }}"
                        map_value="id"
                        :map_labels="['registration', 'vin']"
                    />

                    <!-- VEHICLE CREATE MODAL TRIGGER -->
                    <x-button.resource-create
                        id="vehicle_create_trigger"
                        data-modal-target="vehicle_create_modal"
                        data-modal-toggle="vehicle_create_modal"
                    >
                        <x-icon-o-document-plus />
                    </x-button.resource-create>
                </x-form.field.wrapper>

                <x-form.field.select
                    identifier="company"
                    name="title"
                    label="Title"
                    :options="JobName::selectOptions()"
                />
                <x-form.field.text
                    identifier="company"
                    name="labour_rate"
                    type="number"
                    value="{{ $parent->labour_rate_hourly }}"
                    label="Labour Rate (hourly)"
                    step="0.01"
                />
                <x-form.field.select
                    identifier="company"
                    name="technician_id"
                    label="Assign technician"
                    :options="$technicians"
                    map_value="id"
                    :map_label="['name', 'email']"
                />
            </section>
            <section>
                <x-form.field.textarea
                    identifier="company"
                    name="notes"
                    label="General notes"
                    rows="5"
                />
                <x-form.field.textarea
                    identifier="company"
                    name="part_notes"
                    label="Part notes"
                    rows="5"
                />
            </section>

            <section>
                <x-button
                    id="company_workorder_create"
                    type="submit"
                >Submit</x-button>
            </section>
        </form>
    </x-card>
</x-layout::index>
