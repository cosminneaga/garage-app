<x-layout>
    Hello, {{ Auth::user() ? Auth::user()->name : 'Guest' }}!

    @auth
        <br>
        @json(Auth::user()->getRoleNames())

        <br>

        <x-bladewind.card class="text-black h-150 overflow-y-scroll">
            <pre><code>@json(Auth::user()->getAllPermissions(), JSON_PRETTY_PRINT)</code></pre>
        </x-bladewind.card>
    @endauth
</x-layout>
