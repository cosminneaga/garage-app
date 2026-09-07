@php
    Session::flashInput($resource->toArray());
@endphp
{{-- @dd(BookingStatus::tableUI()) --}}
<x-layout::index title="{{ $resource->number }}">
    <x-card description="Edit booking details">
        <div class="grid grid-rows-1 md:grid-cols-3">
            <section class="space-y-2">
                <x-form.field
                    label="ID"
                    name="id"
                    disabled
                />
                <x-form.field
                    label="Number"
                    name="number"
                    disabled
                />
                <x-form.field
                    label="Status"
                    name="status"
                    type="select"
                    select_map_value="value"
                    select_map_label="label"
                    :options="BookingStatus::tableUI()"
                />
                <x-form.field
                    label="Service Type"
                    name="service_type"
                    type="select"
                    select_map_value="value"
                    select_map_label="label"
                    :options="ServiceType::tableUI()"
                />
                <x-form.field
                    label="Priority"
                    name="priority"
                    type="select"
                    select_map_value="value"
                    select_map_label="label"
                    :options="Priority::tableUI()"
                />
                <div class="grid grid-cols-2">
                    <x-form.field
                        label="Appointment start"
                        name="appointment_start"
                        type="datetime"
                    />
                    <x-form.field
                        label="Appointment finish"
                        name="appointment_finish"
                        type="datetime"
                    />
                </div>
            </section>
        </div>
    </x-card>
</x-layout::index>
