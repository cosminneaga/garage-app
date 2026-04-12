<x-layout>
    <x-form.wrapper
        title="update company details"
        description=""
    >
        <form
            class="space-y-4 text-start"
            action="{{ route('companies.update', $company) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <h2>{{ $company->name }}</h2>

            <x-form.field
                name="name"
                type="text"
                value="Updated Wurst TTD"
                label="Name"
            />
            <x-form.field
                name="tax_id"
                type="text"
                value="updated-432423423"
                label="Tax ID"
            />
            <x-form.field
                name="registration_number"
                type="text"
                value="updated-432423423"
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
                value="UPDATED-INV"
                label="Invoice Prefix"
            />

            <button type="submit" class="btn mt-2 h-10 w-full">Submit</button>
        </form>
    </x-form.wrapper>
</x-layout>
