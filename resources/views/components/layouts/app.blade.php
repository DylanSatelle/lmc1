<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="theme-color" content="#c83e0a">
        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>
        <meta name="description" content="LMC Fencing & Gates designs and builds custom fencing, decking, pergolas, sheds and outdoor structures across Abergele and North Wales.">
        <link rel="manifest" href="/manifest.webmanifest">
        <link rel="apple-touch-icon" href="{{ asset('storage/lmc.svg') }}">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Barlow+Condensed:wght@300;400;500;600;700;900&family=Oswald:wght@400;500;600;700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-forge font-sans text-white antialiased selection:bg-rust selection:text-white">
        {{ $slot }}

        @livewireScripts
    </body>
</html>
