<!DOCTYPE html>
<html
    class="dark"
    lang="en"
>

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
    <meta
        name="description"
        content="Garage App"
    >
    <title>{{ config('app.name') }} | Garage Application</title>
    <link
        href="{{ config('app.url') }}"
        rel="canonical"
    >
    <link
        href="{{ asset('favicon.ico') }}"
        rel="icon"
    >

    @vite (['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-neutral-200 text-black dark:bg-gray-800 dark:text-white">

    <main class="p-2 lg:px-4">
        <x-navigation::client.index />
        <br>
        <div class="max-w-500 mx-auto">
            {{ $slot }}
        </div>
    </main>

</body>

</html>
