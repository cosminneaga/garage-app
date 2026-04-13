@props(['name', 'company'])

<x-bladewind.modal
    title="Create new contact for {{ $company->name }}"
    :name="$name"
    showActionButtons="false"
>
    <form
        id="{{ $name }}"
        action="{{ route('companies.contact.store', $company) }}"
        method="POST"
    >
        @csrf

        <x-bladewind.input
            name="mobile"
            type="text"
            value="7777777777"
            label="Mobile"
        />
        <x-bladewind.input
            name="landline"
            type="text"
            value="8888888888"
            label="Landline"
        />
        <x-bladewind.input
            name="email"
            type="email"
            value="contact@email.com"
            label="Email"
        />
        <x-bladewind.input
            name="url"
            type="text"
            value="https://cosminneaga.dev"
            label="URL"
        />
        <x-bladewind.textarea
            name="info"
            label="Extra information"
            toolbar
            rows="10"
            selected_value="<h1>Hello World</h1><br><p>How are you today?</p>"
        />

        <x-bladewind.button
            can_submit
        >create</x-bladewind.button>
    </form>
</x-bladewind.modal>
