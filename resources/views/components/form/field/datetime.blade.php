@props([
    'name',
    'identifier' => '',
    'label' => false,
    'value' => null,
    'schedule' => [
        (object) [
            'name' => 'monday',
            'start' => '08:00',
            'end' => '16:00',
        ],
    ],
])

@php
    $helper = BladeFormHelper::names($identifier, $name);
    $ids = BladeModalHelper::ids($name);

    $monday =
        $schedule[0] ??
        (object) [
            'name' => 'monday',
            'start' => '08:00',
            'end' => '16:00',
        ];
    $slots = Carbon::generateTimeSlots($monday->start, $monday->end);
@endphp

<script type="module">
    const picker = document.getElementById(@js($ids->get('picker')));
    const dateinput = document.getElementById(@js($ids->get('picker_date')));
    const timeinput = document.getElementById(@js($ids->get('picker_time')));
    const input = document.getElementById(@js($name));

    const datepicker = new DatePicker(picker, {
        autohide: false,
        buttons: true,
        autoSelectToday: 1
    });

    picker.addEventListener('changeDate', () => {
        const date = moment(datepicker.getDate()).format('DD-MM-YYYY')
        dateinput.value = date;
    });

    document.querySelectorAll('button[time-slot="' +
            @js($name) + '"')
        .forEach((button) => button.addEventListener('click', function(event) {
            timeinput.value = event.target.innerText;
        }));

    document.querySelector('button[datetime-save="' +
            @js($name) + '"')
        .addEventListener('click', function(event) {
            input.value = dateinput.value + ' ' + timeinput.value;
        });
</script>

<div class="my-2 text-start">
    <label
        class="form-label"
        for="{{ $name }}"
    >{{ $label }}</label>
    <div class="flex">
        <input
            class="form-item"
            {{ $attributes->merge([
                'value' => old($helper->get('errorName'), $value),
                'name' => $name,
                'id' => $name,
                'data-test' => $helper->get('testName'),
            ]) }}>
        <button
            class="text-heading bg-neutral-secondary-medium rounded-s-0 border-default-medium inline-flex items-center rounded-e-md border border-s-0 px-3 text-sm"
            data-modal-target="{{ $ids->get('modal') }}"
            data-modal-toggle="{{ $ids->get('modal') }}"
            type="button"
            @if ($attributes->has('disabled')) disabled @endif
        >
            <x-icon-o-clock />
        </button>
    </div>
    @error($helper->get('errorName'))
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Pick Date & Time"
    size="2xl"
>
    <div class="max-w-160 relative max-h-full w-full p-2">

        <div class="grid grid-cols-2 gap-2">
            <x-form.field.text
                name="{{ $ids->get('picker_date') }}"
                disabled
            />
            <x-form.field.text
                name="{{ $ids->get('picker_time') }}"
                disabled
            />
        </div>

        <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
            <!-- DATE PICKER -->
            <div
                class="[&>div>div]:bg-neutral-secondary-soft [&_div>button]:bg-neutral-secondary-soft mx-auto mb-2 flex justify-center sm:mx-0 [&>div>div]:shadow-none"
                id="{{ $ids->get('picker') }}"
            ></div>

            <!-- TIME SLOTS -->
            <div class="mb-5 grid w-full grid-cols-3 gap-2">
                @foreach ($slots as $slot)
                    <button
                        class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                        type="button"
                        time-slot="{{ $name }}"
                    >
                        {{ $slot }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="grid grid-cols-2 gap-2">
            <button
                class="bg-brand hover:bg-brand-strong focus:ring-brand-medium shadow-xs rounded-base box-border border border-transparent px-4 py-2.5 text-sm font-medium leading-5 text-white focus:outline-none focus:ring-4"
                data-modal-hide="{{ $ids->get('modal') }}"
                type="button"
                datetime-save="{{ $name }}"
            >Save</button>
            <button
                class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-neutral-tertiary shadow-xs rounded-base box-border border px-4 py-2.5 text-sm font-medium leading-5 focus:outline-none focus:ring-4"
                data-modal-hide="{{ $ids->get('modal') }}"
                type="button"
            >Discard</button>
        </div>

    </div>
</x-modal.wrapper>
