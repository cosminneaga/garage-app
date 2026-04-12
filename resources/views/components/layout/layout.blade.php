@props([
    'title' => 'Garage Application',
])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    >
    <title>{{ $title }} | Garage Application</title>
    <link
        href="{{ asset('favicon.ico') }}"
        rel="icon"
    />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link
        href="{{ asset('vendor/bladewind/css/animate.min.css') }}"
        rel="stylesheet"
    />
    <link
        href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}"
        rel="stylesheet"
    />
    <link
        href="{{ asset('vendor/bladewind/css/flags.css') }}"
        rel="stylesheet"
    />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

    {{-- <script
        src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1"
        type="module"
    ></script> --}}
</head>

<body class="bg-background text-foreground">
    <x-layout.nav />

    <main class="max-w-7xl mx-auto py-6">
        {{ $slot }}
    </main>

    <!-- ALERT AREA -->
    <div class="fixed top-5 right-5 z-50 max-w-md space-y-2">
        @session('message')
            <div
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                x.transition.opacity.duration.500ms
            >
                <x-bladewind.alert :type="$value->type">
                    {{ $value->text }}
                </x-bladewind.alert>
            </div>
        @endsession

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    x.transition.opacity.duration.500ms
                >
                    <x-bladewind.alert type="error">
                        {{ $error }}
                    </x-bladewind.alert>
                </div>
            @endforeach
        @endif
        <!-- ALERT AREA -->
    </div>
</body>

</html>
