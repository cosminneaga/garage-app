<x-layout::index title="{{ $invoice->number }}">
    <x-card>
        <div class="mb-2 grid grid-cols-2">
            <div>
                <h2 class="text-2xl font-bold">{{ $invoice->status->label() }}</h2>
            </div>
            <div class="text-end">
                <h2 class="text-2xl font-bold">{{ $invoice->number }}</h2>
            </div>
        </div>

        <form
            action="{{ route('invoices.companies.update', [$invoice, $invoice->company]) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <section class="mb-2 grid grid-cols-1 gap-2 md:grid-cols-3">
                <x-card.company :company="$invoice->company" />
                <x-card.client :client="$invoice->client" :company="$invoice->company"  />
                <x-card.vehicle :vehicle="$invoice->vehicle" :company="$invoice->company" />
            </section>

            <section class="grid grid-cols-1 gap-2 lg:grid-cols-2">
                <div>
                    <h4 class="text-xl font-bold">General</h4>
                    <hr class="bg-neutral-quaternary my-2 h-px border-0">

                    <x-form.field.select
                        identifier="invoice"
                        name="status"
                        value="{{ $invoice->status }}"
                        label="Status"
                        map_value="value"
                        map_label="label"
                        :options="InvoiceStatus::selectOptions()"
                    />
                    <x-form.field.text
                        identifier="invoice"
                        name="number"
                        value="{{ $invoice->number }}"
                        label="Number"
                        disabled
                    />
                    <x-form.field.text
                        identifier="invoice"
                        name="due_date"
                        value="{{ $invoice->due_date }}"
                        label="Due Date"
                    />
                    <x-form.field.select
                        identifier="invoice"
                        name="payment_method"
                        label="Payment Method"
                        map_value="value"
                        map_label="label"
                        :options="PaymentMethod::selectOptions()"
                        value="{{ $invoice->payment_method }}"
                    />
                    <x-form.field.textarea
                        identifier="invoice"
                        name="notes"
                        label="Notes"
                        value="{{ $invoice->notes }}"
                        rows="5"
                    />
                </div>

                <div>
                    <h4 class="text-xl font-bold">Payment</h4>
                    <hr class="bg-neutral-quaternary my-2 h-px border-0">

                    <x-form.field.text
                        identifier="invoice"
                        name="subtotal"
                        type="number"
                        value="{{ $invoice->subtotal }}"
                        label="Subtotal"
                        step="0.01"
                    />
                    <x-form.field.text
                        identifier="invoice"
                        name="tax_amount"
                        type="number"
                        value="{{ $invoice->tax_amount }}"
                        label="Tax (%)"
                        step="0.01"
                    />
                    <x-form.field.text
                        identifier="invoice"
                        name="discount"
                        type="number"
                        value="{{ $invoice->discount }}"
                        label="Discount (%)"
                        step="0.01"
                    />
                    <x-form.field.text
                        identifier="invoice"
                        name="total"
                        type="number"
                        value="{{ $invoice->total }}"
                        label="Total"
                        step="0.01"
                    />

                    <div class="grid grid-cols-2 gap-2">
                        <x-form.field.text
                            identifier="invoice"
                            name="amount_due"
                            type="number"
                            value="{{ $invoice->amount_due }}"
                            label="Amount Due"
                            step="0.01"
                        />
                        <x-form.field.text
                            identifier="invoice"
                            name="amount_paid"
                            type="number"
                            value="{{ $invoice->amount_paid }}"
                            label="Amount Paid"
                            step="0.01"
                        />
                    </div>
                </div>
            </section>

            <section class="mt-3">
                <x-button
                    id="invoice-update-btn"
                    type="submit"
                >Update</x-button>
            </section>
        </form>
    </x-card>
</x-layout::index>
