@php
    Session::flashInput($booking->toArray());
@endphp
{{-- @dump($booking->toArray()) --}}
<x-layout::index title="{{ $booking->number }}">
    <x-card>
        <x-card.booking :booking="$booking" />

        @if (count($workorders))
            <br>
            <h4 class="mb-1 text-xl font-bold">Workorders</h4>
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
                        value="{{ old('current_status_info', '') }}"
                        label="Current Status info"
                    />
                    <x-form.field.select
                        name="service_type"
                        value="{{ old('service_type') }}"
                        label="Service Type"
                        select_map_value="value"
                        select_map_label="label"
                        :options="ServiceType::selectOptions()"
                    />
                    <x-form.field.select
                        name="priority"
                        value="{{ old('priority') }}"
                        label="Priority"
                        select_map_value="value"
                        select_map_label="label"
                        :options="Priority::selectOptions()"
                    />
                    <x-form.field.datetime
                        name="confirmed_at"
                        value="{{ old('confirmed_at', '') }}"
                        label="Confirmed At"
                    />
                    <x-form.field.datetime
                        name="checked_in_at"
                        value="{{ old('checked_in_at', '') }}"
                        label="Checked In At"
                    />
                    <x-form.field.datetime
                        name="cancelled_at"
                        value="{{ old('cancelled_at', '') }}"
                        label="Cancelled At"
                    />
                    <div class="grid grid-cols-2 gap-2">
                        <x-form.field.text
                            name="estimated_duration_hours"
                            type="number"
                            value="{{ old('estimated_duration_hours', '') }}"
                            label="Estimated duration (hours)"
                        />
                        <x-form.field.text
                            name="estimated_cost"
                            label="Estimated cost"
                        />
                    </div>
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

            @permitted(UserPermission::BOOKING, 'update')
                <div class="mt-4 flex gap-2">
                    <x-button type="submit">Update Booking</x-button>

                    @if (!count($workorders) && $booking->checked_in_at !== null && $booking->cancelled_at === null)
                        <x-button
                            id="booking_create_workorder_button"
                            link="{{ route('workorders.bookings.create', $booking) }}"
                        >Create Workorder</x-button>
                    @endif
                </div>
            @endpermitted
        </form>
    </x-card>
</x-layout::index>
