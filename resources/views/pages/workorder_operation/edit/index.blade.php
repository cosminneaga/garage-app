@php
    Session::flashInput($operation->toArray());
@endphp

<x-layout::index title="Operation">
    <x-card>
        <x-card.workorder :workorder="$workorder" :resource="$workorder_parent" />

        @if ($operation->times->last() && !$operation->times->last()->end)
            <br>
            <x-time.active :start="$operation->times->last()->start" />
        @endif

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
                        map_value="value"
                        map_label="label"
                        value="{{ $operation->type->value }}"
                    />
                    <x-form.field.wrapper>
                        <x-form.field.search-query
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
                        label="Expected life (KM)"
                        value="{{ old('expected_life_km') }}"
                    />
                    <x-form.field.text
                        name="expected_life_months"
                        type="number"
                        label="Expected life (Months)"
                        value="{{ old('expected_life_months') }}"
                    />
                    <x-form.field.text
                        name="part_installed_odometer"
                        type="number"
                        label="Part installed odometer (KM)"
                        value="{{ old('part_installed_odometer') }}"
                    />

                    @hasanyrole([UserRole::ADMINISTRATOR, UserRole::MANAGER])
                        <x-form.field.select
                            name="performed_by"
                            label="Performed By (administration only)"
                            :options="$technicians"
                            map_value="id"
                            :map_label="['name', 'email']"
                            value="{{ $operation->performed_by }}"
                        />
                    @endhasanyrole
                </section>

                <section>
                    <x-form.field.textarea
                        name="notes"
                        label="General notes"
                        value="{{ old('notes', '') }}"
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
                    >Start Work</x-button>

                </form>
            @endunless
        </div>
    </x-card>
</x-layout::index>

<x-modal.part.create id="part_create" />
