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
    @stack('scripts')
</head>

<body class="bg-background text-foreground">
    <x-layout.nav />

    <main class="max-w-400 mx-auto px-4 py-6">
        {{ $slot }}
    </main>

    <!-- ALERT AREA -->
    @session('message')
        <x-bladewind.notification
            :setup="[
                'title' => $value->title,
                'message' => $value->message,
                'type' => $value->type,
                'dismiss_in' => 5,
                'size' => 'regular',
                'name' => 'central_notification_component',
            ]"
            position="top-right"
        />
    @endsession


    <div class="fixed right-5 top-5 z-50 max-w-md space-y-2">
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
    </div>
    <!-- ALERT AREA -->
</body>

</html>
