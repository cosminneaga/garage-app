<x-layout::index>
    <x-form.wrapper
        class="mx-auto max-w-md"
        title="Login"
        description="Login into your account"
    >
        <x-bladewind.card>
            <form
                class="mt-10 space-y-4 text-start"
                action="/login"
                method="POST"
            >
                @csrf

                <div class="mb-5">
                    <label
                        class="text-heading mb-2.5 block text-sm font-medium"
                        for="email"
                    >Your email</label>
                    <input
                        class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                        id="email"
                        name="email"
                        type="email"
                        placeholder="name@flowbite.com"
                        required
                    />
                </div>
                <div class="mb-5">
                    <label
                        class="text-heading mb-2.5 block text-sm font-medium"
                        for="password"
                    >Your password</label>
                    <input
                        class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body block w-full border px-3 py-2.5 text-sm"
                        id="password"
                        type="password"
                        name="password"
                        placeholder="••••••••"
                        required
                    />
                </div>

                <button
                    class="bg-brand hover:bg-brand-strong focus:ring-brand-medium shadow-xs rounded-base box-border border border-transparent px-4 py-2.5 text-sm font-medium leading-5 text-white focus:outline-none focus:ring-4"
                    id="login-btn"
                    type="submit"
                >Login</button>
            </form>
        </x-bladewind.card>
    </x-form.wrapper>
</x-layout::index>
