<x-layout::index>
    <x-form.wrapper
        class="mx-auto max-w-md"
        title="Login"
        description="Client Portal"
    >
        <div>
            <form
                class="mt-10 space-y-4 text-start"
                action="{{ route('clients.login.authenticate') }}"
                method="POST"
            >
                @csrf

                <x-form.field.text
                    name="email"
                    type="email"
                    label="E-Mail"
                    required
                />
                <x-form.field.text
                    name="password"
                    type="password"
                    label="Password"
                    required
                />

                <x-button
                    id="login-button"
                    type="submit"
                >Login</x-button>
            </form>
        </div>
    </x-form.wrapper>
</x-layout::index>
