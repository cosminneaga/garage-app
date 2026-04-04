<x-layout>
    <x-form.form-wrapper
        class="max-w-md mx-auto"
        title="Login"
        description="Login into your account"
    >
        <form
            class="mt-10 space-y-4 text-start"
            action="/login"
            method="POST"
        >
            @csrf

            <x-bladewind::input
                name="email"
                type="text"
                value="admin@garage.com"
                label="Email"
            />
            <x-bladewind::input
                name="password"
                type="password"
                value="password"
                label="Password"
            />

            <x-bladewind::button
                class="btn mt-2 h-10 w-full"
                type="primary"
                can_submit
            >Login</x-bladewind::button>
        </form>
    </x-form.form-wrapper>
</x-layout>
