<x-layout::index title="Add company">
    <x-card
        title="Create a new company"
        description="Create a company, address & contact"
    >
        <form
            class="flex flex-col gap-4 text-start"
            action="{{ route('companies.store') }}"
            method="POST"
            enctype="@enctype"
        >
            @csrf

            <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">
                <div class="p-2">
                    <x-form.content.company identifier="company" />
                </div>

                <div class="p-2">
                    <x-form.content.address
                        :countries="$countries"
                        identifier="company"
                        nested_parent_name="address"
                    />
                </div>

                <div class="p-2">
                    <x-form.content.contact
                        identifier="company"
                        nested_parent_name="contact"
                    />
                </div>
            </div>

            <div class="flex gap-1">
                <x-button
                    data-test="form-companies-create-submit"
                    type="submit"
                >Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
