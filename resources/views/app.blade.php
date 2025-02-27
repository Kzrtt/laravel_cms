<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaravelCMS</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome-pro-master.min.css?v=0.0.1') }}" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/cdn.min.js"></script>
    @livewireStyles
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200 m-0 p-0">
    @livewire('header')

    <br><br><br>
    @livewire('minimal-component')
    
    @livewireScripts
</body>
</html> 