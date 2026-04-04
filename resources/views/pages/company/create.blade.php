<x-layout>
    <x-form.form-wrapper
        title="Create a new company"
        description=""
    >
        <form
            class="space-y-4 text-start"
            action="/companies"
            method="POST"
        >
            @csrf

            <x-form.field
                name="name"
                type="text"
                value="Wurst TTD"
                label="Name"
            />
            <x-form.field
                name="tax_id"
                type="text"
                value="432423423"
                label="Tax ID"
            />
            <x-form.field
                name="registration_number"
                type="text"
                value="432423423"
                label="Registration Number"
            />
            <x-form.field
                name="tax_value"
                type="text"
                value="34.00"
                label="Tax Value"
            />
            <x-form.field
                name="invoice_prefix"
                type="text"
                value="INV"
                label="Invoice Prefix"
            />

            <button type="submit" class="btn mt-2 h-10 w-full">Submit</button>
        </form>
    </x-form.form-wrapper>
</x-layout>
