<x-layout::index title="Workorder Create">
    <x-card>
        <x-card.company :company="$parent" />

        <form action="{{ route('workorders.companies.store', $parent) }}" method="post">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <section>
                    <x-form.field.wrapper>
                        <x-form.field.search-query
                            identifier="booking"
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
                            identifier="booking"
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
                        identifier="workorder"
                        name="title"
                        label="Title"
                        :options="JobName::selectOptions()"
                    />
                    <x-form.field.text
                        name="labour_rate"
                        label="Labour Rate (hourly)"
                        type="number"
                        step="0.01"
                        value="{{ $parent->labour_rate_hourly }}"
                    />
                    <x-form.field.select
                        name="technician_id"
                        label="Assign technician"
                        :options="$technicians"
                        map_value="id"
                        :map_label="['name', 'email']"
                    />
                </section>
                <section>
                    <x-form.field.textarea
                        name="notes"
                        label="General notes"
                        rows="5"
                    />
                    <x-form.field.textarea
                        name="part_notes"
                        label="Part notes"
                        rows="5"
                    />
                </section>
            </div>

            <div class="mt-4">
                <x-button type="submit">Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
