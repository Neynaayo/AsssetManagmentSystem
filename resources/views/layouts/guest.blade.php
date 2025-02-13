<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
<body class="font-sans text-gray-900 antialiased  m-0 p-0 overflow-hidden">
    {{-- <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
        <div class="w-full max-w-lg px-8 py-6 bg-white dark:bg-gray-800 shadow-md rounded-lg">
            {{ $slot }}
        </div>
    </div> --}}
    <div class="flex items-center justify-center min-h-screen w-full bg-blue-600"> 
        <div class="w-full max-w-screen-lg flex items-center justify-center">
            {{ $slot }}
        </div>
    </div>    
</body>
</html>
