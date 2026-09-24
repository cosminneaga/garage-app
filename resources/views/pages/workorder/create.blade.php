<x-layout::index title="Workorder Create">
    <x-card>
        <x-card.booking :booking="$booking" />

        <form action="{{ route('workorders.bookings.store', $booking) }}" method="post">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <section>
                    <x-form.field.text
                        name="title"
                        value="Oil Change (JobName Enum)"
                        label="Title"
                    />
                    <x-form.field.text
                        name="labour_price_hourly"
                        label="Labour Price Hourly"
                        type="number"
                        step="0.01"
                    />
                    <x-form.field.select
                        name="technician_id"
                        label="Assign technician"
                        :options="$technicians"
                        select_map_value="id"
                        :select_map_label="['name', 'email']"
                    />
                </section>
                <section>
                    <x-form.field.textarea
                        name="notes"
                        label="General notes"
                        rows="5"
                    />
                    <x-form.field.textarea
                        name="part_notes"
                        label="Part notes"
                        rows="5"
                    />
                </section>
            </div>

            <div class="mt-4">
                <x-button type="submit">Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
