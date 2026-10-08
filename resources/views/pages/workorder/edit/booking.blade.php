@php
    Session::flashInput($workorder->toArray());
@endphp

<x-layout::index title="Workorder updated">
    <x-card>
        <div class="grid grid-flow-row lg:grid-flow-col gap-2">
            <x-card.company :company="$workorder->company" />
            <x-card.booking :booking="$workorder->booking" />
            <x-card.workorder
                :workorder="$workorder"
                :resource="$workorder->company"
            />
        </div>

        <br>
        <x-modal.file.create
            id="files"
            action="{{ route('files.workorders.store', $workorder) }}"
            max_files="5"
            accepted_files="{{ FileFormatType::mergeForm([FileFormatType::IMAGE, FileFormatType::DOCUMENT, FileFormatType::VIDEO]) }}"
        />
        <br>

        @if (count($workorder->files))
            <br>
            <x-gallery.files :files="$workorder->files" />
            <br>
        @endif

        @if (count($workorder->operations))
            <br>
            <h4 class="text-xl font-bold mb-1">Operations</h4>
            <x-table.related.workorder_operations
                :data="$workorder->operations"
                :resource="$workorder"
                :edit="Permission::can(UserPermission::WORKORDER_OPERATION, 'update')"
            />
            <br>
        @endif

        <form action="{{ route('workorders.bookings.update', [$workorder, $workorder->booking]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <section>
                    <x-form.field.select
                        identifier="workorder"
                        name="title"
                        label="Title"
                        :options="JobName::selectOptions()"
                        :value="old('title')"
                    />
                    @hasanyrole([UserRole::ADMINISTRATOR, UserRole::MANAGER])
                        <x-form.field.select
                            name="technician_id"
                            label="Assigned technician"
                            :options="$technicians"
                            map_value="id"
                            :map_label="['name', 'email']"
                            :value="old('technician_id')"
                        />
                    @endhasanyrole
                    <x-form.field.datetime
                        name="cancelled_at"
                        label="Cancelled At"
                    />
                    <x-form.field.text
                        name="odometer_on_start"
                        label="Start odometer"
                        :value="old('odometer_on_start')"
                        type="number"
                    />
                    <x-form.field.text
                        name="odometer_on_finish"
                        label="Finish odometer"
                        :value="old('odometer_on_finish')"
                        type="number"
                    />
                    <x-form.field.text
                        name="labour_rate"
                        label="Labour Rate (hourly)"
                        :value="old('labour_rate')"
                        type="number"
                        step="0.01"
                    />
                    <x-form.field.text
                        name="labour_total_cost"
                        label="Labour Total Cost"
                        :value="old('labour_total_cost')"
                        type="number"
                        step="0.01"
                    />
                    <x-form.field.text
                        name="part_total_cost"
                        label="Part Total Cost"
                        :value="old('part_total_cost')"
                        type="number"
                        step="0.01"
                    />
                </section>

                <section>
                    <x-form.field.textarea
                        name="notes"
                        label="General notes"
                        :value="old('notes')"
                        :rows="5"
                    />
                    <x-form.field.textarea
                        name="initial_inspection_notes"
                        label="Initial inspection notes"
                        :value="old('initial_inspection_notes')"
                        :rows="5"
                    />
                    <x-form.field.textarea
                        name="part_notes"
                        label="Part notes"
                        :value="old('part_notes')"
                        :rows="5"
                    />
                    <x-form.field.textarea
                        name="complaint"
                        label="Complaint"
                        :value="old('complaint')"
                        :rows="5"
                    />
                </section>
            </div>

            <div class="mt-4">
                <x-button type="submit">Update</x-button>

                @if ($workorder->odometer_on_start)
                    <x-button
                        id="workorder_create_operation_button"
                        link="{{ route('operations.workorders.create', $workorder) }}"
                    >Create Operation</x-button>
                @endif
            </div>
        </form>
    </x-card>
</x-layout::index>
