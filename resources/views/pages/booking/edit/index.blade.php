@php
    Session::flashInput($booking->toArray());
@endphp
{{-- @dump($booking->toArray()) --}}
<x-layout::index title="{{ $booking->number }}">
    <x-card>
        <x-card.booking :booking="$booking" />

        @if (count($workorders))
            <br>
            <h4 class="text-xl font-bold mb-1">Workorders</h4>
            <x-table.related.workorders
                :data="$workorders"
                :resource="$booking"
                :edit="Permission::can(UserPermission::WORKORDER, 'update')"
            />
            <br>
        @endif

        <form
            method="POST"
            action="{{ route('bookings.companies.update', [$booking, $booking->company]) }}"
        >
            @csrf
            @method('PUT')


            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <section>
                    <x-form.field.text
                        name="current_status_info"
                        value="Booking has been updated"
                        label="Current Status info"
                    />
                    <x-form.field.select
                        name="service_type"
                        label="Service Type"
                        select_map_value="value"
                        select_map_label="label"
                        :options="ServiceType::selectOptions()"
                        :value="old('service_type')"
                    />
                    <x-form.field.select
                        name="priority"
                        label="Priority"
                        select_map_value="value"
                        select_map_label="label"
                        :options="Priority::selectOptions()"
                        :value="old('priority')"
                    />
                    <x-form.field.datetime
                        name="confirmed_at"
                        label="Confirmed At"
                    />
                    <x-form.field.datetime
                        name="checked_in_at"
                        label="Checked In At"
                    />
                    <x-form.field.datetime
                        name="cancelled_at"
                        label="Cancelled At"
                    />
                    <x-form.field.text
                        name="estimated_duration_minutes"
                        type="number"
                        label="Estimated duration (minutes)"
                    />
                    <x-form.field.text
                        name="estimated_cost"
                        label="Estimated cost"
                    />
                </section>
                <section>
                    <x-form.field.textarea
                        name="notes"
                        label="General notes"
                        rows="5"
                    />
                    <x-form.field.textarea
                        name="client_notes"
                        label="Client Notes"
                        rows="5"
                    />
                    <x-form.field.textarea
                        name="complaint"
                        label="Complaint"
                        rows="5"
                    />
                </section>
            </div>

            <div class="mt-4 flex gap-2">
                <x-button type="submit">Update Booking</x-button>

                @unless (count($workorders) && $booking->checked_in_at === null)
                    <x-button
                        id="booking_create_workorder_button"
                        link="{{ route('workorders.bookings.create', $booking) }}"
                    >Create Workorder</x-button>
                @endunless
            </div>
        </form>
    </x-card>
</x-layout::index>
