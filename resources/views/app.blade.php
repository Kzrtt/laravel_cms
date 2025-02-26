<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaravelCMS</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font-awesome-pro-master.min.css?v=0.0.1') }}" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-200 m-0 p-0">
    <div class="w-full">
        <div class="w-full bg-blue-600">
            <div class="container mx-auto px-4 py-1 pb-0">
                <!-- Conteúdo centralizado -->
                <div class="flex items-center justify-between pb-0">
                    
                    <!-- Logo -->
                    <div x-data="{ selected: '1' }" class="flex items-center space-x-10 mt-1">
                        <span class="text-xl font-bold text-white mt-1">LaravelCMS</span>

                        <div class="flex mt-4">
                            <div @click="selected = '1'" :class="selected === '1' ? 'bg-white text-black' : 'text-white'" class="rounded-t-lg px-8 pb-4 pt-3">
                                <a href="#" class="font-semibold">Item1</a>
                            </div>
                            <div @click="selected = '2'" :class="selected === '2' ? 'bg-white text-black' : 'text-white'" class="rounded-t-lg px-8 pb-4 pt-3">
                                <a href="#" class="border-transparent font-bold">Item2</a>
                            </div>
                            <div @click="selected = '3'" :class="selected === '3' ? 'bg-white text-black' : 'text-white'" class="rounded-t-lg px-8 pb-4 pt-3">
                                <a href="#" class="border-transparent font-bold">Item3</a>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-1 py-2">
                        <button class="relative p-2 rounded-lg transition duration-300 hover:bg-blue-500 hover:shadow-sm">
                            <i class="fad fa-cog text-white text-2xl p-1"></i>
                        </button>

                        <button class="relative p-2 rounded-lg transition duration-300 hover:bg-blue-500 hover:shadow-sm">
                            <i class="fad fa-bell text-white text-2xl p-1"></i>
                        </button>

                        <div class="flex items-center space-x-2 text-white ml-2 p-2 pl-3 hover:bg-blue-500 hover:shadow-sm rounded-lg">
                            <div class="flex flex-col text-right">
                                <p class="text-xs font-semibold text-gray-300 mb-1">Administrador</p>
                                <p class="font-bold text-sm">Felipe Kurt Pohling</p>
                            </div>
                            <div class="w-10 h-10 flex items-center justify-center bg-blue-700 rounded-lg font-bold text-white">
                                F
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white py-3">
            <div class="container mx-auto space-x-4">
                <a href="#" class="inline-block py-2">SubItem1</a>
                <a href="#" class="inline-block py-2">SubItem2</a>
                <a href="#" class="inline-block py-2">SubItem3</a>
                <a href="#" class="inline-block py-2">SubItem4</a>
            </div>
        </div>
    </div>
</body>
</html>