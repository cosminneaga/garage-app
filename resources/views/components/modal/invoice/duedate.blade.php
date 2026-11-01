@props(['id', 'invoice'])

@php
    $ids = BladeModalHelper::ids($id);
@endphp

<x-modal.wrapper
    id="{{ $ids->get('modal') }}"
    title="Set invoice Due Date"
    size="2xl"
>
    <form
        action="{{ route('invoices.duedate.update', $invoice) }}"
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
            <x-form.field.datetime
                identifier="due_date"
                name="invoice[due_date]"
                label="Due Date"
                value="{{ $invoice->due_date }}"
            />
        </section>

        <section>
            <x-button type="submit">Set</x-button>
        </section>
    </form>
</x-modal.wrapper>
