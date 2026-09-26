<x-layout::index title="Operation">
    <x-card>
        <x-card.workorder :workorder="$workorder" />

        @if (count($times))
            <br>
            <h4 class="mb-1 text-xl font-bold">Window Times</h4>
            <x-table.related.workorder_operation_times
                :data="$times"
                :resource="$operation"
                :edit="Permission::can(UserPermission::WORKORDER_OPERATION_LABOUR_TIME, 'update')"
            />
            <br>
        @endif

        <form
            id="operation_update_form"
            action="{{ route('operations.workorders.update', [$operation, $workorder]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <section>
                    <x-form.field.select
                        name="type"
                        label="Operation Type"
                        :options="WorkorderOperationType::selectOptions()"
                        select_map_value="value"
                        select_map_label="label"
                        :value="$operation->type->value"
                    />
                    <x-form.field.select
                        name="part_id"
                        label="Part"
                        :options="$available_parts"
                        select_map_value="id"
                        :select_map_label="['name', 'manufacturer', 'part_number']"
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
                    <x-form.field.text
                        name="part_installed_odometer"
                        type="number"
                        label="Part installed odometer (KM)"
                    />

                    @hasanyrole([UserRole::ADMINISTRATOR, UserRole::MANAGER])
                        <x-form.field.select
                            name="performed_by"
                            label="Performed By (administration only)"
                            :options="$workorder->booking->company->users"
                            select_map_value="id"
                            :select_map_label="['name', 'email']"
                            :value="$operation->performed_by"
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
        </form>

        <div class="mt-4 flex gap-2">
            <x-button
                form="operation_update_form"
                type="submit"
            >Submit</x-button>

            @unless ($operation->hasActiveTime())
                <form
                    action="{{ route('times.operations.store', $operation) }}"
                    method="POST"
                >
                    @csrf
                    <x-button
                        id="workorder_create_operation_button"
                        type="submit"
                    >Create Time Window</x-button>

                </form>
            @endunless
        </div>
    </x-card>
</x-layout::index>
