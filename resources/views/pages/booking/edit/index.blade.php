@php
    Session::flashInput($booking->toArray());
@endphp
{{-- @dump($booking->toArray()) --}}
<x-layout::index title="{{ $booking->number }}">
    <x-card description="Edit booking details">
        <form
            method="POST"
            action="{{ route('bookings.companies.update', [$booking, $booking->company]) }}"
        >
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5">
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
                    :value="old('status', 'pending')"
                    disabled
                />
                <x-form.field.text
                    name="current_status_info"
                    value="The booking is being updated"
                    label="Status info"
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
                <x-form.field.text
                    name="client_url_token"
                    label="Client Token"
                    disabled
                />
                <x-form.field.datetime
                    name="start"
                    label="Start At"
                />
                <x-form.field.datetime
                    name="finish"
                    label="Finish At"
                />
                <x-form.field.datetime
                    name="checked_in_at"
                    label="Checked In At"
                />
                <x-form.field.datetime
                    name="cancelled_at"
                    label="Cancelled At"
                />
                <x-form.field.datetime
                    name="completed_at"
                    label="Completed At"
                    disabled
                />
                <x-form.field.datetime
                    name="in_review_at"
                    label="In Review At"
                    disabled
                />
                <x-form.field.datetime
                    name="in_progress_at"
                    label="In Progress At"
                    disabled
                />
                <x-form.field.datetime
                    name="remainder_sent_at"
                    label="Remainder Sent At"
                    disabled
                />
                <div>
                    <x-form.field.text
                        name="estimated_duration_minutes"
                        type="number"
                        label="Estimated duration (minutes)"
                    />
                    <x-form.field.text
                        name="estimated_cost"
                        label="Estimated cost"
                    />
                </div>
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
            </div>

            <div class="mt-4">
                <x-button type="submit">Update</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
