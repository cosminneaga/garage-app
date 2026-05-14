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

    {{-- <body> --}}
    <x-layout.nav />

    <main class="max-w-400 mx-auto px-4 py-6">
        {{ $slot }}
    </main>

    <!-- ALERT AREA -->
    @session('message')
        <div
            class="text-fg-danger-strong rounded-base bg-danger-soft mb-4 flex p-4 text-sm sm:items-center fixed top-5 right-5"
            id="alert-2"
            role="alert"
        >
            <svg
                class="mt-0.5 h-4 w-4 shrink-0 md:mt-0"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                fill="none"
                viewBox="0 0 24 24"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10 11h2v5m-2 0h4m-2.592-8.5h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-2 text-sm">
                <p class="text-lg">{{ $value->title }}</p>
                <p>{{ $value->message }}</p>
                {{ $value->type }}
            </div>
            <button
                class="bg-danger-soft text-fg-danger-strong focus:ring-danger-medium hover:bg-danger-medium -mx-1.5 -my-1.5 ms-auto inline-flex h-8 w-8 shrink-0 items-center justify-center rounded p-1.5 focus:ring-2"
                data-dismiss-target="#alert-2"
                type="button"
                aria-label="Close"
            >
                <span class="sr-only">Close</span>
                <svg
                    class="h-4 w-4"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18 17.94 6M18 18 6.06 6"
                    />
                </svg>
            </button>
        </div>
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

    {{-- <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script> --}}
</body>

</html>
