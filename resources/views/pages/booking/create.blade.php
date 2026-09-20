<x-layout::index title="Booking">
    <h1>Booking create</h1>

    <x-card description="Edit booking details">
        <div
            x-data="{
                companies: @js($companies),
                clients: [],
                vehicles: [],
                company_id: null,
                client_id: null,
                vehicle_id: null,
                client_create_url: null,
                vehicle_create_url: null,

                async setCompany(id) {
                    const response = await fetch(`/companies/${id}/load_relations`);
                    this.company_id = await response.json().id;

                    if (!this.company_id) {
                        this.company_id = this.companies[0].id;
                    }
                },
                async setClients(company_id) {
                    const response = await fetch('/clients/companies/' + company_id);
                    this.clients = await response.json();
                },
                async setVehicles(company_id) {
                    const response = await fetch('/vehicles/companies/' + company_id);
                    this.vehicles = await response.json();
                },
                setClientCreateFormAction() {
                    const form = document.getElementById('client_create_form');
                    form.action = `/clients/companies/${this.company_id}`;
                },
                setVehicleCreateFormAction() {
                    const form = document.getElementById('vehicle_create_form');
                    form.action = `/vehicles/companies/${this.company_id}`;
                }
            }"
            x-init="await setCompany(companies[0].id);
            await setClients(companies[0].id);
            await setVehicles(companies[0].id);"
        >
            <form
                class="grid grid-rows-1 gap-4 md:grid-cols-2 lg:grid-cols-3"
                method="POST"
                :action="`/bookings/companies/${company_id}`"
            >
                @csrf

                <section class="space-y-2">
                    <section>
                        <label class="form-label">Company</label>
                        <select
                            class="form-item"
                            name="company_id"
                            x-model="company_id"
                            @change="await setClients(company_id); await setVehicles(company_id);"
                        >
                            <template
                                x-for="company in companies"
                                :key="company.id"
                            >
                                <option
                                    :value="company.id"
                                    x-text="company.name"
                                ></option>
                            </template>
                        </select>
                    </section>

                    <section class="grid grid-cols-[1fr_auto] items-end gap-2">
                        <section>
                            <label
                                class="form-label"
                                for="vehicle_id"
                            >Client</label>
                            <select
                                class="form-item"
                                id="client_id"
                                name="client_id"
                                x-model="client_id"
                            >
                                <template
                                    x-for="client in clients.data"
                                    :key="client.id"
                                >
                                    <option
                                        :value="client.id"
                                        x-text="client.name + ' | ' + client.email"
                                    ></option>
                                </template>
                            </select>
                        </section>

                        <!-- CLIENT CREATE MODAL TRIGGER -->
                        <x-button
                            id="client-create-button"
                            data-modal-target="client_create_modal"
                            data-modal-toggle="client_create_modal"
                            type="button"
                            @click="setClientCreateFormAction()"
                        >
                            <x-icon-o-document-plus />
                        </x-button>

                    </section>

                    <section class="grid grid-cols-[1fr_auto] items-end gap-2">
                        <section>
                            <label
                                class="form-label"
                                for="vehicle_id"
                            >Vehicle</label>
                            <select
                                class="form-item"
                                id="vehicle_id"
                                name="vehicle_id"
                            >
                                <template
                                    x-for="vehicle in vehicles.data"
                                    :key="vehicle.id"
                                >
                                    <option
                                        :value="vehicle.id"
                                        x-text="vehicle.registration + ' | ' + vehicle.vin"
                                    ></option>
                                </template>
                            </select>
                        </section>

                        <!-- VEHICLE CREATE MODAL TRIGGER -->
                        <x-button
                            id="vehicle-create-button"
                            data-modal-target="vehicle_create_modal"
                            data-modal-toggle="vehicle_create_modal"
                            type="button"
                            @click="setVehicleCreateFormAction()"
                        >
                            <x-icon-o-document-plus />
                        </x-button>

                    </section>

                    <div class="grid grid-cols-2 gap-2">
                        <x-form.field.datetime
                            name="appointment_start"
                            label="Start"
                        />
                        <x-form.field.datetime
                            name="checked_in_at"
                            label="Checked in"
                        />
                    </div>
                </section>

                <section class="space-y-2">
                    <x-form.field.select
                        name="status"
                        label="Status"
                        select_map_value="value"
                        select_map_label="label"
                        :options="BookingStatus::selectOptions()"
                    />
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
        </div>
    </x-card>
</x-layout::index>

<x-modal.client.create
    id="client_create"
    :countries="$countries"
/>
<x-modal.vehicle.create id="vehicle_create" />
