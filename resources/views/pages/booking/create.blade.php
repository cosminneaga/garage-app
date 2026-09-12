<x-layout::index title="Booking">
    <h1>Booking create</h1>

    <x-card description="Edit booking details">
        <div class="grid grid-rows-1 gap-4 md:grid-cols-3">
            <section
                class="space-y-2"
                x-data="{
                    resource: null,
                    id: {{ $companies[0]->id }},
                
                    async fetchResource() {
                        const response = await fetch(`/companies/${this.id}/load_relations`);
                
                        if (!response.ok) {
                            throw new Error('Failed to fetch resource');
                        }
                
                        this.resource = await response.json();
                        $store.form_data.setCompany(this.resource.company);
                    }
                }"
            >
                <x-form.field.select
                    name="company_id"
                    label="Selected company"
                    select_map_value="id"
                    select_map_label="name"
                    :options="$companies"
                    x-model="id"
                    @change="fetchResource"
                />

                <x-button
                    class="w-fit"
                    id="create-booking-reveal-company-relations-button"
                    data-modal-target="create-booking-reveal-company-relations-modal"
                    data-modal-toggle="create-booking-reveal-company-relations-modal"
                    type="button"
                    variant="primary"
                    @click="fetchResource"
                >
                    Show clients & vehicles
                </x-button>

                <x-modal.wrapper
                    id="create-booking-reveal-company-relations-modal"
                    title="Company's clients & vehicles"
                    size="7xl"
                >

                    <div class="grid grid-cols-2 gap-4 p-2">
                        <div class="grid grid-cols-2 items-center">
                            <h3 class="text-lg">CLIENTS</h3>
                            <x-modal.client.create :countries="$countries" />
                        </div>
                        <div class="grid grid-cols-2 items-center">
                            <h3 class="text-lg">VEHICLES</h3>
                            <x-button
                                id="vehicle-create-button"
                                data-modal-target="vehicle_create_modal"
                                data-modal-toggle="vehicle_create_modal"
                                type="button"
                                @click="$refs.vehicle_create_form.action = `/vehicles/companies/${$store.form_data.company.id}`"
                            >
                                Create
                            </x-button>
                            <x-modal.vehicle.create
                                id="vehicle_create"
                                :makes="$makes"
                                {{-- :models="$models" --}}
                                {{-- :data="$data" --}}
                                {{-- :years="$years" --}}
                            />
                        </div>
                    </div>
                    <div class="h-175 grid grid-cols-2 gap-4 pt-3">

                        <div class="overflow-y-auto">
                            <template
                                x-for="client in resource?.company?.clients"
                                :key="client.id"
                            >
                                <x-form.field.radio
                                    id="`client-${client.id}`"
                                    name="client_id"
                                    ::value="client.id"
                                    label="client.name"
                                />
                            </template>
                        </div>

                        <div class="overflow-y-auto">
                            <template
                                x-for="vehicle in resource?.company?.vehicles"
                                :key="vehicle.id"
                            >
                                <x-form.field.radio
                                    id="`vehicle-${vehicle.id}`"
                                    name="vehicle_id"
                                    ::value="vehicle.id"
                                    label="vehicle.registration"
                                />
                            </template>
                        </div>
                    </div>
                </x-modal.wrapper>

                <x-form.field.text
                    name="client_id"
                    label="Selected client"
                    disabled
                />
                <x-form.field.text
                    name="vehicle_id"
                    label="Selected vehicle"
                    disabled
                />
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
                <div class="grid grid-cols-2 gap-2">
                    <x-form.field.datetime
                        name="appointment_start"
                        label="Appointment start"
                    />
                    <x-form.field.datetime
                        name="appointment_finish"
                        label="Appointment finish"
                    />
                </div>
            </section>

            <section class="space-y-2">
                <x-form.field.text
                    name="estimated_cost"
                    label="Estimated cost"
                />
                <x-form.field.text
                    name="estimated_duration_minutes"
                    label="Estimated duration (minutes)"
                    type="number"
                />
                <x-form.field.textarea
                    name="notes"
                    label="General notes"
                />
                <x-form.field.datetime
                    name="checked_in_at"
                    label="Checked in"
                />
            </section>
        </div>
    </x-card>
</x-layout::index>

<script>
    function resourceComponent(id) {
        console.log(id)
        return {
            resource: null,

            async fetchResource() {
                const response = await fetch(
                    `/companies/${id}/load_relations`);

                this.resource = await response.json();

                console.log(this.resource);
            }
        }
    }

    function submitForm(company_id) {
        console.log(company_id);
    }
</script>
