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
                    <section>
                        <x-form.field.select
                            identifier="booking"
                            name="company_id"
                            value="{{ $company->id }}"
                            label="Company"
                            :options="$available_companies"
                            select_map_value="id"
                            select_map_label="name"
                            x-model="company_id"
                            @change="location.href = `/bookings/companies/${company_id}/create`"
                        />
                    </section>

                    <section class="grid grid-cols-[1fr_auto] items-end gap-2">
                        <x-form.field.select
                            identifier="booking"
                            name="client_id"
                            label="Client"
                            :options="$company->clients"
                            select_map_value="id"
                            :select_map_label="['name', 'email']"
                        />

                        <!-- CLIENT CREATE MODAL TRIGGER -->
                        <x-button
                            id="client_create_trigger"
                            data-modal-target="client_create_modal"
                            data-modal-toggle="client_create_modal"
                            type="button"
                        >
                            <x-icon-o-document-plus />
                        </x-button>
                    </section>

                    <section class="grid grid-cols-[1fr_auto] items-end gap-2">
                        <x-form.field.select
                            identifier="booking"
                            name="vehicle_id"
                            label="Vehicle"
                            :options="$company->vehicles"
                            select_map_value="id"
                            :select_map_label="['registration', 'vin']"
                        />

                        <!-- VEHICLE CREATE MODAL TRIGGER -->
                        <x-button
                            id="vehicle_create_trigger"
                            data-modal-target="vehicle_create_modal"
                            data-modal-toggle="vehicle_create_modal"
                            type="button"
                        >
                            <x-icon-o-document-plus />
                        </x-button>

                    </section>

                    <section>
                        <x-form.field.datetime
                            name="start"
                            label="Start Date"
                            :schedule="$company->schedules"
                        />
                    </section>
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
                        select_map_value="value"
                        select_map_label="label"
                        :options="ServiceType::selectOptions()"
                    />
                    <x-form.field.select
                        name="priority"
                        label="Priority"
                        select_map_value="value"
                        select_map_label="label"
                        :options="Priority::selectOptions()"
                    />
                </section>

                <section class="space-y-2">
                    <x-form.field.text
                        name="estimated_cost"
                        label="Estimated cost"
                    />
                    <x-form.field.text
                        name="estimated_duration_minutes"
                        type="number"
                        label="Estimated duration (minutes)"
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
