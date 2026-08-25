@props([
    'title' => 'Garage Application',
])

<!DOCTYPE html>
<html
    lang="en"
    class="dark"
>

<head>
    <meta charset="UTF-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    />
    <meta
        http-equiv="X-UA-Compatible"
        content="ie=edge"
    />
    <title>{{ $title }} | Garage Application</title>
    <link
        href="{{ asset('favicon.ico') }}"
        rel="icon"
    />

    @vite (['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="dark:bg-gray-800 dark:text-white">
    {{-- <body> --}}
    <x-navigation::index />

    <main class="max-w-400 mx-auto px-4 py-6">{{ $slot }}</main>

    <!-- ALERT AREA -->
    @session('message')
        <div class="fixed right-5 top-5 z-50">
            <x-alert
                :title="$value->title"
                :message="$value->message"
                :type="$value->type"
            />
        </div>
    @endsession

    <div class="fixed right-5 top-5 z-50 max-w-full space-y-2">
        @if ($errors->any())
            <x-alert
                type="error"
                :message_list="$errors->all()"
                :timeout="8000"
            />
        @endif
    </div>
    <!-- ALERT AREA -->

    @stack ('scripts')
</body>

</html>
