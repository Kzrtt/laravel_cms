<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - LaravelCMS</title>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

        @livewireStyles
        @vite(['resources/css/app.css', 'public/css/font-awesome-pro-master.min.css?v=0.0.1'])
    </head>
    <body class="h-screen">
        {{ $slot }}

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @livewireScripts
        @wireUiScripts
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/cdn.min.js"></script>

        @wireUiScripts(['nonce' => 'csp-token'])
        @wireUiScripts(['nonce' => 'csp-token', 'foo' => true])
        @vite('resources/js/app.js')
        <x-livewire-alert::scripts />
    </body>
</html>