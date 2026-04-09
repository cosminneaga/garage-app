<x-layout title="Add User">
    <x-form.form-wrapper
        title="create team user"
        description="Create a new user details, address & contact"
    >
        <form
            class="flex flex-col gap-4"
            id="form-users-create"
            action="{{ route('users.store') }}"
            method="POST"
            x-data="{
                name: 'User',
                email: 'user@garage.com',
                password: 'password',
                active: true,
                address: {
                    number: 2566,
                    street: 'Subway Street',
                    postcode: 'B546BFN',
                    country_id: 1,
                },
                contact: {
                    mobile: '974837483',
                    landline: '974837483',
                    email: 'company@net.com',
                    url: '',
                    info: ''
                }
            }"
        >
            @csrf

            <div class="grid grid-rows-1 md:grid-cols-3 gap-1">

                <div class="border border-white px-3 py-6">
                    <h3 class="text-2xl font-bold underline">Details</h3>
                    <x-bladewind.input
                        name="name"
                        type="text"
                        label="Name"
                        x-model="name"
                    />
                    <x-bladewind.input
                        name="email"
                        type="email"
                        label="Email"
                        x-model="email"
                    />
                    <x-bladewind.input
                        name="password"
                        type="password"
                        label="Password"
                        viewable
                        x-model="password"
                    />

                    <x-bladewind.input
                        name="password_confirmed"
                        type="password"
                        label="Password Confirmation"
                        viewable
                        x-model="password"
                    />
                    <x-bladewind.select
                        id="role"
                        name="role"
                        value_key="name"
                        label="Select a role"
                        label_key="label"
                        :data="\App\Enums\UserRole::ui()"
                        selected_value="user_editor"
                    />
                    <x-bladewind.toggle
                        name="active"
                        color="orange"
                        label="Active"
                        :checked="true"
                    />
                </div>

                <div
                    class="border border-white px-3 py-6 flex-1 flex flex-col gap-3">
                    <h3 class="text-2xl font-bold underline">Address</h3>
                    <br>
                    {{-- <x-t-select
                            name="address"
                            label="Existing addresses"
                        >
                            @foreach ($addresses['user'] as $userAddress)
                                <option value="">
                                    {{ $userAddress['street'] }}
                                </option>
                            @endforeach
                            @foreach ($addresses['companies'] as $company)
                                <div>
                                    <option>
                                        <p style="font-weight: 800;">{{ $company['name'] }}</p>

                                        @foreach ($company['addresses'] as $companyAddresses)
                                            <option style="padding-left: 10px!important;">{{ $companyAddresses['street'] }}</option>
                                        @endforeach
                                    </option>
                                </div>
                            @endforeach
                        </x-t-select> --}}

                    <x-bladewind.input
                        id="address_number"
                        name="address[number]"
                        type="number"
                        label="Number"
                        x-model="address.number"
                    />
                    <x-bladewind.input
                        id="address_street"
                        name="address[street]"
                        type="text"
                        label="Number"
                        x-model="address.street"
                    />
                    <x-bladewind.input
                        id="address_postcode"
                        name="address[postcode]"
                        type="text"
                        label="Postcode"
                        x-model="address.postcode"
                    />
                    <x-bladewind.select
                        id="address_country_id"
                        name="address_country_id"
                        value_key="id"
                        label="Select a country"
                        label_key="name"
                        flag_key="code"
                        :data="\App\Models\Country::all()"
                        selected_value="1"
                    />
                </div>

                <div class="w-full flex">
                    <div
                        class="border border-white px-3 py-6 flex-1 flex flex-col gap-3">
                        <h3 class="text-2xl font-bold underline">Contact</h3>
                        <br>

                        <x-bladewind.input
                            id="contact_mobile"
                            name="contact[mobile]"
                            label="Mobile Phone"
                            x-model="contact.mobile"
                        />

                        <x-bladewind.input
                            id="contact_landline"
                            name="contact[landline]"
                            label="Landline Phone"
                            x-model="contact.landline"
                        />

                        <x-bladewind.input
                            id="contact_email"
                            name="contact[email]"
                            type="email"
                            label="Email"
                            x-model="contact.email"
                        />

                        <x-bladewind.input
                            id="contact_url"
                            name="contact[url]"
                            label="URL"
                            x-model="contact.url"
                        />

                        <x-bladewind.textarea
                            id="contact_info"
                            name="contact[info]"
                            label="More Information"
                            x-model="contact.info"
                        />
                    </div>
                </div>
            </div>

            <div class="flex gap-1">
                <x-bladewind.button
                    class="w-fit"
                    form="form-users-create"
                    can_submit
                    size="small"
                >Submit Details</x-bladewind.button>
            </div>
        </form>
    </x-form.form-wrapper>
</x-layout>
