@props(['id', 'routeName', 'resourceId', 'message'])

<script>
    console.log(@json($id))
</script>

<div
    class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0"
    id="{{ $id }}"
    data-modal-backdrop="static"
    aria-hidden="true"
    tabindex="-1"
>
    <div class="relative max-h-full w-full max-w-md p-4">
        <div class="bg-neutral-primary-soft border-default rounded-base relative border p-4 shadow-sm md:p-6">
            <button
                class="text-body hover:bg-neutral-tertiary hover:text-heading rounded-base absolute end-2.5 top-3 ms-auto inline-flex h-9 w-9 items-center justify-center bg-transparent text-sm"
                data-modal-hide="{{ $id }}"
                type="button"
            >
                <x-fwb-o-close class="h-5 w-5" />
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 text-center md:p-5">
                <x-fwb-o-info-circle class="text-fg-disabled mx-auto mb-4 h-12 w-12" />
                <h3 class="text-body mb-6">{{ $message }}</h3>
                <div class="flex items-center justify-center space-x-4">
                    <form
                        action="{{ route($routeName, $resourceId) }}"
                        method="POST"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            class="bg-danger hover:bg-danger-strong focus:ring-danger-medium shadow-xs rounded-base box-border border border-transparent px-4 py-2.5 text-sm font-medium leading-5 text-white focus:outline-none focus:ring-4"
                            data-modal-hide="{{ $id }}"
                            type="submit"
                        >
                            Yes, I'm sure
                        </button>

                    </form>
                    <button
                        class="text-body bg-neutral-secondary-medium border-default-medium hover:bg-neutral-tertiary-medium hover:text-heading focus:ring-neutral-tertiary shadow-xs rounded-base box-border border px-4 py-2.5 text-sm font-medium leading-5 focus:outline-none focus:ring-4"
                        data-modal-hide="{{ $id }}"
                        type="button"
                    >No, cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>
