@php
    Session::flashInput($resource->toArray());
@endphp
{{-- @dd(BookingStatus::selectOptions()) --}}
<x-layout::index title="{{ $resource->number }}">
    <x-card description="Edit booking details">
        <div class="grid grid-rows-1 md:grid-cols-3">
            <section class="space-y-2">
                <x-form.field.text
                    name="id"
                    label="ID"
                    disabled
                />
                <x-form.field.text
                    name="number"
                    label="Number"
                    disabled
                />
                <x-form.field.select
                    name="status"
                    label="Status"
                    select_map_value="value"
                    select_map_label="label"
                    :options="BookingStatus::selectOptions()"
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
                <x-form.field.datetime
                    name="start"
                    label="Start Date & Time"
                />
                <x-form.field.datetime
                    name="finish"
                    label="Finish Date & Time"
                />
            </section>
        </div>
    </x-card>
</x-layout::index>
