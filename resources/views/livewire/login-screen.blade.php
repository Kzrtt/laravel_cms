
<div class="flex w-full min-h-screen">
    <!-- Lado Esquerdo: Área com cor primária -->
    <div class="flex flex-col justify-between w-1/3 bg-primary-300 text-white p-8">
        <!-- Conteúdo Superior: Logo, nome do sistema e descrição -->
        <div class="flex flex-col mt-60 items-center">
            <!-- Logo: substitua a URL pela do seu logo -->
            <div class="mb-2">
                <img src="{{ url('images/laravel_logo.png') }}" alt="Logo" class="h-32">
            </div>

            <h1 class="text-3xl mb-3 text-primary-700/60 font-bold">LaravelCMS</h1>
            <p class="mx-10 text-center text-lg text-primary-900/60">Template para desenvolvímento ágil de soluções diversas usando arquivos de marcação e php.</p>
        </div>
        <!-- Conteúdo Inferior: Versão e link de contato -->
        <div class="flex justify-between items-center">
            <span class="text-sm font-bold text-primary-900/80">@2025 - Kvrt Dvlpmnt - 0.0.1</span>
            <a href="/contato" class="text-sm font-semibold text-primary-900/80 underline hover:text-gray-200">Contato</a>
        </div>
    </div>

    <!-- Lado Direito: Área de login -->
    <div class="w-2/3 bg-white flex flex-col justify-center p-12">
        <div class="max-w-md mx-auto">
            <div class="flex flex-col items-center mb-4">
                <h2 class="text-3xl font-bold text-primary-300 mb-4">Login</h2>
                <p class="mb-8 text-center text-gray-600/50 font-semibold">
                    Área de gestão do sistema, acesso exclusivo de estabelecimentos credenciados no sistema.
                </p>
            </div>

            <div class="space-y-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-600/70 mb-2">Email</label>
                    <div class="flex rounded-md border border-gray-300 focus-within:ring-1 text-gray-700/50 focus-within:text-primary-500/50 focus-within:ring-primary-500/30">
                        <!-- Ícone à esquerda (preprend) -->
                        <div class="flex items-center px-3 bg-gray-50 border-r border-gray-300 rounded-l-md">
                            <i class="fad fa-at"></i>
                        </div>
                        
                        <!-- Campo de input -->
                        <input 
                            wire:model.lazy.debounce.500ms="loginForm.email"
                            type="email" placeholder="Seu email"
                            class="w-full border-none rounded-r-md px-3 py-2 text-gray-700 !focus:outline-none focus:ring-0"
                        >
                    </div>
                </div>

                <div x-data="{ showPassword: false }">
                    <label for="senha" class="block text-sm font-medium text-gray-600/70 mb-2">Senha</label>
                    <div class="flex rounded-md border border-gray-300 focus-within:ring-1 text-gray-700/50 focus-within:text-primary-500/50 focus-within:ring-primary-500/30">
                        <div class="flex items-center px-3 bg-gray-50 border-r border-gray-300 rounded-l-md">
                            <i class="fad fa-key"></i>
                        </div>

                        <input 
                            wire:model.lazy.debounce.500ms="loginForm.password"
                            :type="showPassword ? 'text' : 'password'" placeholder="Sua senha"
                            class="w-full border-none rounded-r-md px-3 py-2 text-gray-700 !focus:outline-none focus:ring-0"
                        >

                        <button 
                            @click="showPassword = !showPassword"
                            type="button" 
                            class="flex items-center px-3 hover:text-primary-500/50 hover:cursor-pointer bg-gray-50 border-r border-gray-300 rounded-l-md">
                            <i :class="showPassword ? 'fad fa-eye' : 'fad fa-eye-slash'"></i>
                        </button>
                    </div>
                </div>

                <!-- Linha com o link "Esqueceu a senha?" e o botão "Entrar" -->
                <div class="flex items-center justify-between mt-10">
                    <a href="/esqueceu-senha" class="text-sm text-primary-300 hover:text-primary-500 hover:underline">Esqueceu a senha?</a>
                    <button 
                        wire:click="submitLogin"
                        class="p-2 rounded-lg px-4 text-primary-600 bg-primary-200/55 hover:bg-primary-600 hover:text-white hover:cursor-pointer">
                        <i class="fad fa-sign-in p-1"></i>&nbsp;<span class="font-semibold">Entrar</span>&nbsp;
                    </button>        
                </div>
            </div>
            
            <!-- Link para cadastro -->
            <div class="mt-6 text-center">
                <span class="text-sm text-gray-600/50 font-semibold">Não Possui Cadastro?</span>
                <a href="/cadastro" class="text-sm text-primary-300 font-semibold underline hover:text-primary-500"> Cadastre-se</a>
            </div>
        </div>
    </div>
</div>

