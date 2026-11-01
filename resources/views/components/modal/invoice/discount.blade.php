@props(['id', 'invoice'])

@php
    $ids = BladeModalHelper::ids($id);
@endphp

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Apply a discount"
    size="2xl"
>
    <form
        action="{{ route('invoices.discount.update', $invoice) }}"
        method="POST"
    >
        @csrf

        <section>
            <p><span class="font-bold">Number: </span>{{ $invoice->number }}</p>
            <p><span class="font-bold">Total: </span>{{ $invoice->total }}</p>
            <p><span class="font-bold">Amount Due: </span>{{ $invoice->amount_due }}</p>
            <p><span class="font-bold">Amount Paid: </span>{{ $invoice->amount_paid }}</p>
        </section>

        <section>
            <x-form.field.text
                identifier="discount"
                name="invoice[discount]"
                label="Discount %"
                value="{{ $invoice->discount }}"
                type="number"
                step="0.01"
            />
        </section>

        <section>
            <x-button type="submit">Discount It</x-button>
        </section>
    </form>
</x-modal.wrapper>
