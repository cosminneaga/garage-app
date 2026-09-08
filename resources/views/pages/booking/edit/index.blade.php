@php
    Session::flashInput($resource->toArray());
@endphp
{{-- @dd(BookingStatus::tableUI()) --}}
<x-layout::index title="{{ $resource->number }}">
    <x-card description="Edit booking details">
        <div class="grid grid-rows-1 md:grid-cols-3">
            <section class="space-y-2">
                <x-form.field
                    name="id"
                    label="ID"
                    disabled
                />
                <x-form.field
                    name="number"
                    label="Number"
                    disabled
                />
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
