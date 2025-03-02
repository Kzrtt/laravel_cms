<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome-pro-master.min.css?v=0.0.1') }}" />

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/cdn.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @livewireStyles
        @vite('resources/css/app.css')
    </head>
    <body class="bg-gray-200 m-0 p-0">
        @livewire('header')

        {{ $slot }}

        @livewireScripts
        <x-livewire-alert::scripts />
    </body>
</html>
