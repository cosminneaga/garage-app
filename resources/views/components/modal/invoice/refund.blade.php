@props(['id', 'invoice'])

@php
    $ids = BladeModalHelper::ids($id);
@endphp

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Make a refund"
    size="2xl"
>
    <form action="{{ route('invoices.refund.update', $invoice) }}" method="POST">
        @csrf

        <section>
            <p><span class="font-bold">Number: </span>{{ $invoice->number }}</p>
            <p><span class="font-bold">Total: </span>{{ $invoice->total }}</p>
            <p><span class="font-bold">Amount Due: </span>{{ $invoice->amount_due }}</p>
            <p><span class="font-bold">Amount Paid: </span>{{ $invoice->amount_paid }}</p>
        </section>

        <section>
            <x-form.field.select
                identifier="refund"
                name="invoice[payment_method]"
                label="Method"
                map_value="value"
                map_label="label"
                :options="PaymentMethod::selectOptions()"
            />

            <x-form.field.text
                identifier="refund"
                name="invoice[payment_value]"
                label="Value"
                type="number"
                step="0.01"
            />
        </section>

        <section>
            <x-button type="submit">Refund</x-button>
        </section>
    </form>
</x-modal.wrapper>
