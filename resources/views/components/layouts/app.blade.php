<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Page Title' }}</title>

        <!-- Tom Select -->
        <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>


        @livewireStyles
        @vite(['resources/css/app.css', 'public/css/font-awesome-pro-master.min.css?v=0.0.1'])
    </head>
    <body class="bg-gray-200 m-0 p-0">
        @livewire('header')

        {{ $slot }}

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @livewireScripts
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/cdn.min.js"></script>
        @vite('resources/js/app.js')
        <x-livewire-alert::scripts />
    </body>
</html>
