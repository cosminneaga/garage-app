@props(['id', 'routeName', 'resourceId', 'message', 'trigger' => false, 'btnClass' => 'text-danger hover:cursor-pointer'])

@if ($trigger)
    <x-button
        class="{{ $btnClass }}"
        data-modal-target="{{ $id }}"
        data-modal-toggle="{{ $id }}"
        type="button"
        variant="danger"
    >Delete</x-button>
@endif

<x-modal.wrapper :id="$id">
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
</x-modal.wrapper>
