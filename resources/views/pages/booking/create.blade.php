<x-layout::index title="Booking">
    <h1>Booking create</h1>

    <x-card description="Edit booking details">
        <div
            class="grid grid-rows-1 gap-4 md:grid-cols-3"
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
            <section class="space-y-2">
                <x-form.field.select
                    name="company_id"
                    label="Selected company"
                    select_map_value="id"
                    select_map_label="name"
                    :options="$companies"
                    x-model="id"
                    @change="fetchResource"
                />

                <section
                    class="grid gap-2 grid-cols-[1fr_auto_auto]"
                    x-data="{
                        options: [],
                        async setOptions() {
                            const response = await fetch('/clients/companies/' + $store.form_data.company?.id);
                            this.options = await response.json();
                        }
                    }"
                >
                    <select
                        class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                        id="client_id"
                        name="client_id"
                    >
                        <template
                            x-for="option in options.data"
                            :key="option.id"
                        >
                            <option
                                :value="option.id"
                                x-text="option.name"
                            ></option>
                        </template>
                    </select>

                    <x-button
                        type="button"
                        @click="setOptions()"
                    >fetch</x-button>

                    <x-button
                        id="client-create-button"
                        data-modal-target="client_create_modal"
                        data-modal-toggle="client_create_modal"
                        type="button"
                        @click="$refs.client_create_form.action = `/clients/companies/${$store.form_data.company.id}`"
                    >
                        new
                    </x-button>
                    <x-modal.client.create
                        id="client_create"
                        :countries="$countries"
                    />
                </section>

                <section
                    class="grid gap-2 grid-cols-[1fr_auto_auto]"
                    x-data="{
                        options: [],
                        async setOptions() {
                            const response = await fetch('/vehicles/companies/' + $store.form_data.company?.id);
                            this.options = await response.json();
                        }
                    }"
                >
                    <select
                        class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                        id="vehicle_id"
                        name="vehicle_id"
                    >
                        <template
                            x-for="option in options.data"
                            :key="option.id"
                        >
                            <option
                                :value="option.id"
                                x-text="option.registration"
                            ></option>
                        </template>
                    </select>

                    <x-button
                        type="button"
                        @click="setOptions()"
                    >fetch</x-button>

                    <x-button
                        id="vehicle-create-button"
                        data-modal-target="vehicle_create_modal"
                        data-modal-toggle="vehicle_create_modal"
                        type="button"
                        @click="$refs.vehicle_create_form.action = `/vehicles/companies/${$store.form_data.company.id}`"
                    >
                        new
                    </x-button>
                    <x-modal.vehicle.create id="vehicle_create" />
                </section>
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
                    type="number"
                    label="Estimated duration (minutes)"
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
