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
                    <x-form.field.wrapper>
                        <x-form.field.search-request
                            name="part_id"
                            label="Part"
                            route="{{ route('parts.search') }}"
                            map_value="id"
                            :map_labels="['name', 'manufacturer', 'code']"
                            :value="\App\Models\Part::find(old('part_id'))"
                        />
                        @permitted(UserPermission::PART, 'store')
                            <x-button.resource-create
                                id="part_create_button"
                                data-modal-target="part_create_modal"
                                data-modal-toggle="part_create_modal"
                            />
                        @endpermitted
                    </x-form.field.wrapper>
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
                            :options="$technicians"
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

<x-modal.part.create id="part_create" />
