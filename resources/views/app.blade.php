<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaravelCMS</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome-pro-master.min.css?v=0.0.1') }}" />
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200 m-0 p-0">
    <div class="w-full">
        <div class="w-full bg-blue-600">
            <div class="container mx-auto px-4 text-white py-1">
                <!-- Conteúdo centralizado -->
                <div class="flex items-center justify-between py-3">
                    
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <span class="text-xl font-bold">LaravelCMS</span>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-1">
                    <button class="relative p-2 rounded-lg transition duration-300 hover:bg-blue-500 hover:shadow-sm">
                        <i class="fad fa-cog text-2xl p-1"></i>
                    </button>

                    <button class="relative p-2 rounded-lg transition duration-300 hover:bg-blue-500 hover:shadow-sm">
                        <i class="fad fa-bell text-2xl p-1"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="bg-white py-3">
            <div class="container mx-auto space-x-4">
                <a href="#" class="inline-block py-2 border-b-4 border-white font-semibold hover:text-gray-200">Organização</a>
                <a href="#" class="inline-block py-2 border-b-4 border-transparent hover:border-white hover:text-gray-200">Plataformas</a>
                <a href="#" class="inline-block py-2 border-b-4 border-transparent hover:border-white hover:text-gray-200">Padrões</a>
                <a href="#" class="inline-block py-2 border-b-4 border-transparent hover:border-white hover:text-gray-200">Estatísticas</a>
            </div>
        </div>
    </div>
</body>
</html>