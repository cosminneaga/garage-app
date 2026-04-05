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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script
        src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1"
        type="module"
    ></script>
</head>

<body class="bg-background text-foreground">
    <x-layout.nav />

    <main class="max-w-7xl mx-auto py-6">
        {{ $slot }}
    </main>

    <!-- ALERT AREA -->
    <div class="fixed top-5 right-5 z-50 max-w-md space-y-2">
        @session('success')
            <x-bladewind.alert
                type="success"
                shade="dark"
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                x.transition.opacity.duration.500ms
            >
                {{ $value }}
            </x-bladewind.alert>
        @endsession

        @session('error')
            <x-bladewind.alert
                type="error"
                shade="dark"
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                x.transition.opacity.duration.500ms
            >
                {{ $value }}
            </x-bladewind.alert>
        @endsession

        @session('warn')
            <x-bladewind.alert
                type="warning"
                shade="dark"
                x-data="{ show: true }"
                x-show="show"
                x-init="setTimeout(() => show = false, 3000)"
                x.transition.opacity.duration.500ms
            >
                {{ $value }}
            </x-bladewind.alert>
        @endsession

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <x-bladewind.alert
                    type="error"
                    shade="dark"
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 3000)"
                    x.transition.opacity.duration.500ms
                >
                    {{ $error }}
                </x-bladewind.alert>
            @endforeach
        @endif
    </div>
</body>

</html>
