@props(['id', 'invoice'])

@php
    $ids = BladeModalHelper::ids($id);
@endphp

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Write a note"
    size="2xl"
>
    <form
        action="{{ route('invoices.notes.update', $invoice) }}"
        method="POST"
    >
        @csrf

        <section>
            <x-form.field.textarea
                identifier="notes"
                name="invoice[notes]"
                label="Notes"
                value="{{ $invoice->notes }}"
            />
        </section>

        <section>
            <x-button type="submit">Submit</x-button>
        </section>
    </form>
</x-modal.wrapper>
