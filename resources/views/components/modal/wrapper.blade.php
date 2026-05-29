@props(['id', 'title' => null, 'size' => 'lg'])

<div
    class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
    id="{{ $id }}"
    data-modal-backdrop="static"
    aria-hidden="true"
    tabindex="-1"
>
    <div class="bg-neutral-primary-soft border-default rounded-base relative w-full max-w-{{ $size }} border p-4 shadow-sm md:p-6">
        @if ($title)
            <div class="border-default grid grid-cols-[1fr_auto] border-b pb-4 md:pb-5">
                <div>
                    <h3 class="text-heading text-lg font-medium">
                        {{ $title }}
                    </h3>
                </div>

                <div class="w-10">
                    <button
                        class="text-body hover:bg-neutral-tertiary hover:text-heading rounded-base absolute end-2.5 top-3 ms-auto inline-flex h-9 w-9 items-center justify-center bg-transparent text-sm"
                        data-modal-hide="{{ $id }}"
                        type="button"
                    >
                        <x-fwb-o-close class="h-5 w-5" />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
            </div>
        @else
            <button
                class="text-body hover:bg-neutral-tertiary hover:text-heading rounded-base absolute end-2.5 top-3 ms-auto inline-flex h-9 w-9 items-center justify-center bg-transparent text-sm"
                data-modal-hide="{{ $id }}"
                type="button"
            >
                <x-fwb-o-close class="h-5 w-5" />
                <span class="sr-only">Close modal</span>
            </button>
        @endif
        <div class="">
            {{ $slot }}
        </div>
    </div>
</div>
