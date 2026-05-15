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
    @stack('scripts')
</head>

<body class="bg-gray-900 text-white">

    @datetime(now())

    {{-- <body> --}}
    <x-nav />

    <main class="max-w-400 mx-auto px-4 py-6">
        {{ $slot }}
    </main>

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

    <div class="fixed right-5 top-5 z-50 max-w-md space-y-2">
        @if ($errors->any())
            <x-alert
                type="error"
                :message_list="$errors->all()"
                :timeout="5000"
            />
        @endif
    </div>
    <!-- ALERT AREA -->

    <!-- MODAL AREA -->
    <x-bladewind.modal
        name="send-message"
        title=""
    >
        <div class="mb-6">
            The message will be delivered to their company
            inbox if they are not currently online
        </div>
        <x-bladewind.textarea
            placeholder="Type message here..."
            rows="5"
        />
    </x-bladewind.modal>
    <!-- MODAL AREA -->

</body>

</html>
