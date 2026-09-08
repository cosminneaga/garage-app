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
                    }
                }"
            >
                <x-form.field
                    name="company_id"
                    type="select"
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
                >
                    Show clients & vehicles
                </x-button>

                {{-- !!! WORK LEFT HERE --}}
                <x-modal.wrapper
                    id="create-booking-reveal-company-relations-modal"
                    title="Company's clients & vehicles"
                    size="7xl"
                >

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-2xl">CLIENTS</h3>
                            <ul>
                                <template
                                    x-for="client in resource?.clients"
                                    :key="client.id"
                                >
                                    <li x-text="client.name"></li>
                                </template>
                            </ul>
                        </div>

                        <div>
                            <h3 class="text-2xl">VEHICLES</h3>
                            <ul>
                                <template
                                    x-for="vehicle in resource?.vehicles"
                                    :key="vehicle.id"
                                >
                                    <li x-text="vehicle.registration"></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                </x-modal.wrapper>


                <x-form.field
                    name="client_id"
                    label="Selected client"
                    disabled
                />
                <x-form.field
                    name="vehicle_id"
                    label="Selected vehicle"
                    disabled
                />
            </section>
            <section class="space-y-2">
                <x-form.field
                    name="status"
                    type="select"
                    label="Status"
                    select_map_value="value"
                    select_map_label="label"
                    :options="BookingStatus::tableUI()"
                />
                <x-form.field
                    name="service_type"
                    type="select"
                    label="Service Type"
                    select_map_value="value"
                    select_map_label="label"
                    :options="ServiceType::tableUI()"
                />
                <x-form.field
                    name="priority"
                    type="select"
                    label="Priority"
                    select_map_value="value"
                    select_map_label="label"
                    :options="Priority::tableUI()"
                />
                <div class="grid grid-cols-2">
                    <x-form.field
                        name="appointment_start"
                        type="datetime"
                        label="Appointment start"
                    />
                    <x-form.field
                        name="appointment_finish"
                        type="datetime"
                        label="Appointment finish"
                    />
                </div>
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
                const response = await fetch(`/companies/${id}/load_relations`);

                this.resource = await response.json();

                console.log(this.resource);
            }
        }
    }
</script>
