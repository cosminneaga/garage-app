@php
    Session::flashInput($operation->toArray());
@endphp

<x-layout::index title="Operation">
    <x-card>
        <x-card.workorder
            :workorder="$workorder"
            :resource="$workorder_parent"
        />

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

        <br>
        <x-modal.file.create
            id="files"
            action="{{ route('files.operations.store', $operation) }}"
            max_files="5"
            accepted_files="{{ FileFormatType::mergeForm([FileFormatType::IMAGE, FileFormatType::DOCUMENT, FileFormatType::VIDEO]) }}"
        />
        <br>

        @if (count($operation->files))
            <br>
            <x-gallery.files :files="$operation->files" />
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
                        value="{{ $operation->type->value }}"
                        label="Operation Type"
                        :options="WorkorderOperationType::selectOptions()"
                        map_value="value"
                        map_label="label"
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
                        value="{{ old('expected_life_km') }}"
                        label="Expected life (KM)"
                    />
                    <x-form.field.text
                        name="expected_life_months"
                        type="number"
                        value="{{ old('expected_life_months') }}"
                        label="Expected life (Months)"
                    />
                    <x-form.field.text
                        name="part_installed_odometer"
                        type="number"
                        value="{{ old('part_installed_odometer') }}"
                        label="Part installed odometer (KM)"
                    />

                    @hasanyrole([UserRole::ADMINISTRATOR, UserRole::MANAGER])
                        <x-form.field.select
                            name="performed_by"
                            value="{{ $operation->performed_by }}"
                            label="Performed By (administration only)"
                            :options="$technicians"
                            map_value="id"
                            :map_label="['name', 'email']"
                        />
                    @endhasanyrole
                </section>

                <section>
                    <x-form.field.textarea
                        name="notes"
                        value="{{ old('notes', '') }}"
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
                    >Start Work</x-button>

                </form>
            @endunless
        </div>
    </x-card>
</x-layout::index>

<x-modal.part.create id="part_create" />
