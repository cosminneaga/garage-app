<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Garage App">
    <title>{{ config('app.name') }} | Garage Application</title>
    <link rel="canonical" href="{{ config('app.url') }}">
    <link href="{{ asset('favicon.ico') }}" rel="icon">

    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-neutral-200 text-black dark:bg-gray-800 dark:text-white">

    <div @class([
            'grid grid-cols-1',
            'lg:grid-cols-[280px_1fr]' => Auth::check()
        ])>
        @auth
            <x-navigation::drawer
                class="lg:translate-none fixed -translate-x-full lg:relative lg:transform-none"
            />
        @endauth
        <main class="p-2 lg:px-4">
            <x-navigation::index />
            <br>
            <div class="max-w-500 mx-auto">
                {{ $slot }}
            </div>
        </main>
    </div>

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

    {{-- <script type="module">
        (async function () {
            const response = await fetch('/clients/companies/1');
            const data = await response.json();
            console.log(data);
        })();
    </script> --}}
</body>

</html>
