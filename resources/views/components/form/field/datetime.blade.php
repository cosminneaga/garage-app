@props(['name', 'label' => null])

{{-- !!! Need to create a main input to capture datetime on save, need to add JS, need to see what props should we pass to this children --}}
<button
    class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-neutral-tertiary shadow-xs rounded-base box-border inline-flex items-center justify-center border px-4 py-2.5 text-sm font-medium leading-5 focus:outline-none focus:ring-4"
    data-modal-target="timepicker-modal"
    data-modal-toggle="timepicker-modal"
    type="button"
>
    <x-fwb-o-clock class="w-5 h-5 mr-2"/>
    {{ $label }}
</button>


<div
    class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
    id="timepicker-modal"
    aria-hidden="true"
    tabindex="-1"
>
    <div class="relative max-h-full w-full max-w-160 p-4">
        <!-- Modal content -->
        <div class="bg-neutral-primary-soft rounded-base relative">
            <!-- Modal header -->
            <div class="border-default flex items-center justify-between rounded-t border-b p-4">
                <h3 class="text-heading font-medium">
                    Schedule an appointment
                </h3>
                <button
                    class="text-body hover:bg-neutral-tertiary hover:text-heading rounded-base ms-auto inline-flex h-9 w-9 items-center justify-center bg-transparent text-sm"
                    data-modal-toggle="timepicker-modal"
                    type="button"
                >
                    <x-fwb-o-close class="w-3 h-3"/>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 pt-0">
                <div
                    class="[&>div>div]:bg-neutral-secondary-soft [&_div>button]:bg-neutral-secondary-soft mx-auto my-5 flex justify-center sm:mx-0 [&>div>div]:shadow-none"
                    inline-datepicker
                    datepicker-autoselect-today
                ></div>
                <label class="text-heading mb-2 block text-sm font-medium">
                    Pick your time
                </label>
                <ul
                    class="mb-5 grid w-full grid-cols-3 gap-2"
                    id="timetable"
                >
                    <li>
                        <input
                            class="peer hidden"
                            id="10-am"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="10-am"
                        >
                            10:00 AM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="10-30-am"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="10-30-am"
                        >
                            10:30 AM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="11-am"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="11-am"
                        >
                            11:00 AM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="11-30-am"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="11-30-am"
                        >
                            11:30 AM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="12-am"
                            name="timetable"
                            type="radio"
                            value=""
                            checked
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="12-am"
                        >
                            12:00 AM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="12-30-pm"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="12-30-pm"
                        >
                            12:30 PM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="1-pm"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="1-pm"
                        >
                            01:00 PM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="1-30-pm"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="1-30-pm"
                        >
                            01:30 PM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="2-pm"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="2-pm"
                        >
                            02:00 PM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="2-30-pm"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="2-30-pm"
                        >
                            02:30 PM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="3-pm"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="3-pm"
                        >
                            03:00 PM
                        </label>
                    </li>
                    <li>
                        <input
                            class="peer hidden"
                            id="3-30-pm"
                            name="timetable"
                            type="radio"
                            value=""
                        >
                        <label
                            class="bg-neutral-primary-soft rounded-base text-fg-brand border-brand peer-checked:border-brand peer-checked:bg-brand hover:bg-brand-strong inline-flex w-full cursor-pointer items-center justify-center border p-2 text-center text-sm font-medium hover:text-white peer-checked:text-white"
                            for="3-30-pm"
                        >
                            03:30 PM
                        </label>
                    </li>
                </ul>
                <div class="grid grid-cols-2 gap-2">
                    <button
                        class="bg-brand hover:bg-brand-strong focus:ring-brand-medium shadow-xs rounded-base box-border border border-transparent px-4 py-2.5 text-sm font-medium leading-5 text-white focus:outline-none focus:ring-4"
                        type="button"
                    >Save</button>
                    <button
                        class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-neutral-tertiary shadow-xs rounded-base box-border border px-4 py-2.5 text-sm font-medium leading-5 focus:outline-none focus:ring-4"
                        data-modal-hide="timepicker-modal"
                        type="button"
                    >Discard</button>
                </div>
            </div>
        </div>
    </div>
</div>
