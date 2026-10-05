<x-layout::index title="Workorder Create">
    <x-card>
        <x-card.booking :booking="$parent" />

        <form action="{{ route('workorders.bookings.store', $parent) }}" method="post">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                <section>
                    <x-form.field.select
                        identifier="workorder"
                        name="title"
                        label="Title"
                        :options="JobName::selectOptions()"
                    />
                    <x-form.field.text
                        name="labour_rate"
                        label="Labour Rate (hourly)"
                        type="number"
                        step="0.01"
                        value="{{ $parent->company->labour_rate_hourly }}"
                    />
                    <x-form.field.select
                        name="technician_id"
                        label="Assign technician"
                        :options="$technicians"
                        map_value="id"
                        :map_label="['name', 'email']"
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

