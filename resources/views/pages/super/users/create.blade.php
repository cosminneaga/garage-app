<x-layout::index title="Add User">
    <x-card
        title="Create administrator"
        description="Create an application administrator details, address & contact"
    >
        <form
            class="flex flex-col gap-4 text-start"
            action="{{ route('administrators.store') }}"
            method="POST"
            enctype="@enctype"
        >
            @csrf

            <div class="grid grid-rows-1 gap-1 md:grid-cols-2 lg:grid-cols-3">
                <div class="p-2">
                    <x-form.content.user identifier="administrator" />
                </div>

                <div class="p-2">
                    <x-form.content.address
                        :countries="$countries"
                        identifier="administrator"
                        nested_parent_name="address"
                    />
                </div>

                <div class="p-2">
                    <x-form.content.contact
                        identifier="administrator"
                        nested_parent_name="contact"
                    />
                </div>
            </div>

            <div class="flex gap-1">
                <x-button
                    id="form-administrators-create-submit"
                    type="submit"
                >Submit</x-button>
            </div>
        </form>
    </x-card>
</x-layout::index>
