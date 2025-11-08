<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'La Rinascente Pet - Onoranze Funebri per Animali')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900">
    <x-navigation />

    <main>
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <x-footer />

    @livewireScripts
</body>
</html>
