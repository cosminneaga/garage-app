@props(['id', 'resource', 'trigger' => false])

@if ($trigger)
    <x-button
        class="w-fit"
        data-modal-target="{{ $id }}"
        data-modal-toggle="{{ $id }}"
        type="button"
        variant="default"
    >Chat</x-button>
@endif

<x-modal.wrapper
    title="Send a quick message to {{ $resource->name }}"
    :id="$id"
    position="center"
>
    <form action="#">
        @csrf

        <x-form.field
            name="message"
            type="textarea"
            value="Hello, \n My dear co-worker!"
            label="Your message"
        />

        <div class="flex gap-1">
            <x-button data-test="form-address-create-submit">Send</x-button>
        </div>
    </form>
</x-modal.wrapper>
