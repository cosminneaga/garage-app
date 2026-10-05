@php
    Session::flashInput($workorder->toArray());
@endphp

<x-layout::index title="Workorder updated">
    <x-card>
        <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
            <x-card.company :company="$parent" />
            <x-card.workorder
                :workorder="$workorder"
                :resource="$parent"
            />
        </div>

        <br>
        <x-modal.file.create
            id="images"
            action="{{ route('files.workorders.store', $workorder) }}"
            max_files="2"
        />
        <br>
        {{-- @json($workorder->files) --}}

        @if (count($workorder->files))
            <br>
            <h3 class="text-lg font-bold">Gallery</h3>
            <div class="grid grid-cols-4 gap-2">
                @foreach ($workorder->files as $file)
                    <div>
                        <div class="h-auto w-auto">
                            <img
                                src="{{ route('files.preview', $file) }}"
                                alt=""
                            >
                        </div>
                        <p class="font-bold">{{ $file->type->label() }}</p>
                        <p class="text-sm">{{ $file->description }}</p>
                    </div>
                @endforeach
            </div>
            <br>
        @endif

        @if (count($operations))
            <br>
            <h4 class="mb-1 text-xl font-bold">Operations</h4>
            <x-table.related.workorder_operations
                :data="$operations"
                :resource="$workorder"
                :edit="Permission::can(UserPermission::WORKORDER_OPERATION, 'update')"
            />
            <br>
        @endif

        <form
            action="{{ route('workorders.companies.update', [$workorder, $parent]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
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
                        type="number"
                        label="Start odometer"
                        :value="old('odometer_on_start')"
                    />
                    <x-form.field.text
                        name="odometer_on_finish"
                        type="number"
                        label="Finish odometer"
                        :value="old('odometer_on_finish')"
                    />
                    <x-form.field.text
                        name="labour_rate"
                        type="number"
                        label="Labour Rate (hourly)"
                        :value="old('labour_rate')"
                        step="0.01"
                    />
                    <x-form.field.text
                        name="labour_total_cost"
                        type="number"
                        label="Labour Total Cost"
                        :value="old('labour_total_cost')"
                        step="0.01"
                    />
                    <x-form.field.text
                        name="part_total_cost"
                        type="number"
                        label="Part Total Cost"
                        :value="old('part_total_cost')"
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

{{-- <script type="module">
    (async () => {
        const workorder = @js($workorder);
        const res = await fetch('/files/workorders/' + workorder.id);
        const data = await res.json();
        console.log(data)
    })();
</script> --}}
