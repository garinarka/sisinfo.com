<!DOCTYPE html>
<html class="h-full bg-white scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full font-sans antialiased text-gray-900 dark:text-white">
    <div class="flex flex-col items-center justify-center min-h-screen dark:bg-gray-900">
        <div class="w-full px-6 py-4 overflow-hidden bg-white dark:bg-gray-900">
            {{ $slot }}
        </div>
    </div>
</body>

</html>