<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Page Title' }}</title>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

        <!-- Campo Markdown -->
        <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
        <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

        <tallstackui:script /> 
        @livewireStyles
        @vite(['resources/css/app.css', 'public/css/font-awesome-pro-master.min.css?v=0.0.1'])

        <style>
            ul {
                list-style-type: disc;
                margin-left: 20px;
            }

            ol {
                list-style-type: decimal;
                margin-left: 20px;
            }
        </style>
    </head>
    <body class="bg-gray-200 m-0 p-0">
        @livewire('header')
        
        <x-ts-dialog /> 
        <x-ts-toast /> 

        {{ $slot }}

        <livewire:modal-manager />

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
