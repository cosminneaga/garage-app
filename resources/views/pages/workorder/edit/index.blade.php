@php
    Session::flashInput($workorder->toArray());
@endphp

<x-layout::index title="Workorder updated">
    <x-card>
        <div class="grid gap-2 grid-cols-1 md:grid-cols-2">
            <x-card.booking :booking="$booking" />
            <x-card.workorder :workorder="$workorder" />
        </div>

        <form action="{{ route('workorders.bookings.update', [$workorder, $booking]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <section>
                    <x-form.field.text
                        name="title"
                        label="Title"
                        :value="old('title')"
                    />
                    <x-form.field.select
                        name="technician_id"
                        label="Assigned technician"
                        :options="$technicians"
                        select_map_value="id"
                        :select_map_label="['name', 'email']"
                        :value="old('technician_id')"
                    />
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
                        name="labour_price_hourly"
                        label="Labour Price Hourly"
                        :value="old('labour_price_hourly')"
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
                <x-button
                    type="submit"
                >Update</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
