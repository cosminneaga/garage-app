<x-layout::index title="Booking">
    <x-card title="Booking create for company {{ $company->name }}">
        <div x-data="{
            company_id: {{ $company->id }},
        }">
            <form
                class="grid grid-rows-1 gap-4 md:grid-cols-2 lg:grid-cols-3"
                method="POST"
                action="{{ route('bookings.companies.store', $company) }}"
            >
                @csrf

                <section class="space-y-2">
                    <x-form.field.select
                        identifier="booking"
                        name="company_id"
                        value="{{ $company->id }}"
                        label="Company"
                        :options="$available_companies"
                        map_value="id"
                        map_label="name"
                        x-model="company_id"
                        @change="location.href = `/bookings/companies/${company_id}/create`"
                    />

                    <x-form.field.wrapper>
                        <x-form.field.search-query
                            identifier="booking"
                            name="client_id"
                            label="Client"
                            route="{{ route('clients.companies.search', $company) }}"
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
                            route="{{ route('vehicles.companies.search', $company) }}"
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

                    <x-form.field.datetime
                        name="confirmed_at"
                        label="Confirmed At"
                        :schedule="$company->schedules"
                    />
                </section>

                <section class="space-y-2">
                    <x-form.field.textarea
                        name="current_status_info"
                        value="The booking was created recently"
                        label="Status info"
                    />
                    <x-form.field.select
                        name="service_type"
                        label="Service Type"
                        map_value="value"
                        map_label="label"
                        :options="ServiceType::selectOptions()"
                    />
                    <x-form.field.select
                        name="priority"
                        label="Priority"
                        map_value="value"
                        map_label="label"
                        :options="Priority::selectOptions()"
                    />
                </section>

                <section class="space-y-2">
                    <x-form.field.text
                        name="estimated_cost"
                        label="Estimated cost"
                    />
                    <x-form.field.text
                        name="estimated_duration_hours"
                        type="number"
                        label="Estimated duration (hours)"
                    />
                    <x-form.field.textarea
                        name="notes"
                        label="General notes"
                    />
                </section>

                <section class="space-y-2">
                    <x-button
                        id="booking_create_submit"
                        type="submit"
                    >Submit</x-button>
                </section>
            </form>

            <!-- MODALS -->
            <x-modal.client.create
                id="client_create"
                :countries="$countries"
                action="{{ route('clients.companies.store', $company) }}"
            />
            <x-modal.vehicle.create
                id="vehicle_create"
                action="{{ route('vehicles.companies.store', $company) }}"
            />
        </div>
    </x-card>
</x-layout::index>
