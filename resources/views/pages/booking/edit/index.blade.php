@php
    Session::flashInput($booking->toArray());
@endphp
{{-- @dump($booking->toArray()) --}}
<x-layout::index title="{{ $booking->number }}">
    <x-card>
        <form
            method="POST"
            action="{{ route('bookings.companies.update', [$booking, $booking->company]) }}"
        >
            @csrf
            @method('PUT')

            <x-card :description="'Booking number: ' . $booking->number . ', ID: ' . $booking->id">
                <p class="text-base font-bold"></p>
                <p class="text-sm">Status: {{ $booking->status->label() }}</p>
                <p class="text-sm">Client Token: {{ $booking->client_url_token }}</p>
                @if ($booking->completed_at)
                    <p class="text-sm">Completed At: {{ $booking->completed_at }}</p>
                @endif
                @if ($booking->in_progress_at)
                    <p class="text-sm">In Progress At: {{ $booking->in_progress_at }}</p>
                @endif
                @if ($booking->in_review_at)
                    <p class="text-sm">In Review At: {{ $booking->in_review_at }}</p>
                @endif
                @if ($booking->cancelled_at)
                    <p class="text-sm">Cancelled At: {{ $booking->cancelled_at }}</p>
                @endif
                @if ($booking->reminder_sent_at)
                    <p class="text-sm">Reminder Sent At: {{ $booking->reminder_sent_at }}</p>
                @endif
            </x-card>

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

                @if (!count($booking->workorders))
                    <x-button
                        id="booking_create_workorder_button"
                        link="{{ route('workorders.bookings.create', $booking) }}"
                    >Create Workorder</x-button>
                @endif
            </div>
        </form>

        @if (count($booking->workorders))
            <br>
            @foreach ($booking->workorders as $workorder)
                <x-card :description="'Workorder number: ' . $workorder->number . ', ID: ' . $workorder->id">
                    <p class="text-sm">Status: {{ $workorder->status->label() }}</p>
                </x-card>

                <form
                    action="{{ route('workorders.bookings.update', [$workorder, $booking]) }}"
                    method="post"
                >
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                        <section>
                            <x-form.field.text
                                name="title"
                                value="Oil Change (JobName Enum)"
                                label="Title"
                            />
                        </section>
                    </div>

                    <div class="mt-4">
                        <x-button type="submit">Update Workorder: {{ $workorder->number }}</x-button>
                    </div>
                </form>
            @endforeach
        @endif
    </x-card>
</x-layout::index>
