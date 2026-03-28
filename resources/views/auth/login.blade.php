<x-layout>
    <x-form.form-wrapper
        title="Login"
        description="Login into your account"
    >
        <form
            class="mt-10 space-y-4 text-start"
            action="/login"
            method="POST"
        >
            @csrf

            <x-form.field
                name="email"
                type="text"
                value="admin@garage.com"
                label="Email"
            />
            <x-form.field
                name="password"
                type="password"
                value="password"
                label="Password"
            />

            <button type="submit" class="btn mt-2 h-10 w-full">Login</button>
        </form>
    </x-form.form-wrapper>
</x-layout>
