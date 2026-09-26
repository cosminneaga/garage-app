<x-layout::index title="Workorder Operation">
    <x-card>
        <x-card.workorder :workorder="$workorder" />

        <form
            action="{{ route('operations.workorders.store', $workorder) }}"
            method="POST"
        >
            @csrf
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <section>
                    <x-form.field.select
                        name="type"
                        label="Operation Type"
                        :options="WorkorderOperationType::selectOptions()"
                        select_map_value="value"
                        select_map_label="label"
                    />
                    <x-form.field.select
                        name="part_id"
                        label="Select part"
                        :options="$available_parts"
                        select_map_value="id"
                        :select_map_label="['name', 'manufacturer', 'serial_number', 'item_price']"
                    />
                    <x-form.field.text
                        name="expected_life_km"
                        type="number"
                        label="Excepted life (KM)"
                    />
                    <x-form.field.text
                        name="expected_life_months"
                        type="number"
                        label="Expected life (Months)"
                    />
                    @hasanyrole([UserRole::ADMINISTRATOR, UserRole::MANAGER])
                        <x-form.field.select
                            name="performed_by"
                            label="Performed By (administration only)"
                            :options="$workorder->booking->company->users"
                            select_map_value="id"
                            :select_map_label="['name', 'email']"
                        />
                    @endhasanyrole
                </section>

                <section>
                    <x-form.field.textarea
                        name="notes"
                        label="General notes"
                    />
                </section>
            </div>

            <div class="mt-4">
                <x-button type="submit">Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
