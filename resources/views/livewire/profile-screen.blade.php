<!-- Componente/Trecho de layout para Configurações de Conta -->
<div class="flex flex-row justify-center mt-6 space-x-10 w-full min-h-screen" x-data="{ selectedTab: 'personal' }">

    <!-- Menu Lateral -->
    <div class="w-100 rounded-md bg-white shadow-sm p-6">
        <!-- Informações resumidas do usuário, se quiser -->
        <div class="flex flex-row mb-6">
            <div class="flex justify-center items-center w-20 h-20 rounded-lg bg-primary-200/55">
                <img src="{{ url('images/laravel_logo.png') }}" class="h-14 w-22">
            </div>

            <div class="flex flex-col justify-center ml-4 space-y-1">
                <p class="font-semibold text-black/55 text-xl">{{ auth()->user()->getPerson->pes_name }}</p>
                <div class="inline-block self-start p-1 px-2 mt-1 rounded-md bg-primary-200/55 text-primary-600 text-xs">
                    {{ getFriendlyAgentType(auth()->user()->usr_level) }}
                </div>
            </div>          
        </div>

        <div class="self-start p-2 px-2 mt-1 mb-6 rounded-lg bg-primary-200/30 text-primary-600 text-md font-semibold">
            <i class="fad fa-university m-1"></i> {{ auth()->user()->getRepresentedAgent->getAgent->est_fantasy }}
        </div>

        <hr class="border-t-2 border-dashed border-primary-300/30 my-4">

        <div class="p-2 rounded max-w-md">
            <!-- Grid de 2 colunas, cada par label/valor ocupa uma linha -->
            <div class="grid grid-cols-2 gap-y-2 text-sm">
                <!-- Nome Usuário -->
                <div class="font-semibold text-gray-700">Nome Usuário</div>
                <div class="text-gray-400">{{ auth()->user()->getPerson->pes_name }}</div>
                
                <!-- E-mail Institucional -->
                <div class="font-semibold text-gray-700">E-mail Institucional</div>
                <div class="text-gray-400">{{ auth()->user()->usr_email }}</div>
                
                <!-- Telefone -->
                <div class="font-semibold text-gray-700">Telefone</div>
                <div class="text-gray-400">{{ auth()->user()->getPerson->pes_phone }}</div>
                
                <!-- CPF -->
                <div class="font-semibold text-gray-700">CPF</div>
                <div class="text-gray-400">{{ auth()->user()->getPerson->pes_cpf }}</div>
            </div>
        </div>

        <hr class="border-t-2 border-dashed border-primary-300/30 my-4">
        
        <p class="mb-4 text-black/35 text-lg font-semibold">Menu</p>

        <!-- Menu de Navegação -->
        <nav class="space-y-3">
            <button 
                @click="selectedTab = 'personal'" 
                :class="selectedTab === 'personal' 
                    ? 'bg-primary-200/30 text-primary-600 w-full text-left font-semibold px-3 py-2 rounded-lg' 
                    : 'w-full text-left px-3 py-2 text-black/55 rounded hover:cursor-pointer hover:text-primary-600 hover:bg-primary-200/15'
                "
            >
                <i class="fad fa-user-circle mr-1"></i> Informações Pessoais
            </button>
        
            <button 
                @click="selectedTab = 'password'" 
                :class="selectedTab === 'password' 
                    ? 'bg-primary-200/30 text-primary-600 w-full text-left font-semibold px-3 py-2 rounded-lg' 
                    : 'w-full text-left px-3 py-2 text-black/55 rounded hover:cursor-pointer hover:text-primary-600 hover:bg-primary-200/15'
                "
            >
                <i class="fad fa-key mr-1"></i> Dados de Acesso
            </button>

            <div x-data="loggout">
                <button
                    @click="confirmLoggout"
                    class="w-full text-left px-3 py-2 rounded hover:cursor-pointer text-red-600 bg-red-200/15 hover:bg-primary-200/30 hover:font-semibold"
                >
                    <i class="fad fa-sign-out mr-1"></i> Loggout
                </button>
            </div>
        </nav>
    </div>

    <!-- Conteúdo da Aba Selecionada -->
    <main class="flex w-250 p-6 rounded-md bg-white">
        <!-- Aba: Informações Pessoais -->
        <div x-show="selectedTab === 'personal'" 
            x-transition
            class="w-full">

            <h1 class="text-xl font-semibold mb-1 text-black/75">Informações Pessoais</h1>
            <p class="text-md text-black/45">Altere as informações pessoais do seu perfil.</p>

            <hr class="border-t-1 border border-primary-300/30 my-4">
            
            <form wire:loading.remove wire:submit.prevent="submitFormPersonalInfo">
                <x-dynamic-form :formConfig="$formConfig" :selectsPopulate="$selectsPopulate" :formData="$formData" :isEdit="$isEdit" />

                <div class="flex flex-row justify-end w-full mt-3 pr-3">
                    <div class="space-x-2">
                        <button type="submit" class="bg-primary-300 text-white p-2 px-4 rounded-lg hover:cursor-pointer">
                            <i class="fad fa-check-circle p-1"></i>
                            &nbsp;<span class="font-semibold">Salvar</span>&nbsp;
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Aba: Dados de Acesso -->
        <div 
            x-show="selectedTab === 'password'" 
            x-transition
            class="w-full">

            <h1 class="text-xl font-semibold mb-1 text-black/75">Dados de Acesso</h1>
            <p class="text-md text-black/45">Altere a senha para login no sistema.</p>

            <hr class="border-t-1 border border-primary-300/30 my-4">

            <div class="w-full rounded-lg bg-amber-200/40 p-4 my-6 text-amber-400 font-semibold">
                <i class="fad fa-exclamation-triangle text-xl ml-1 mr-2"></i>
                Caso precise resetar a senha, clique <span class="font-extrabold hover:cursor-pointer">aqui</span> para solicitar o email para a troca de senha.
            </div>

            <form wire:loading.remove wire:submit.prevent="submitFormPassword">
                <div x-data="{ showPassword1: false }">
                    <label for="senha" class="block text-sm font-medium text-gray-600/70 mb-2">Senha Atual</label>
                    <div class="flex rounded-md border border-gray-300 focus-within:ring-1 text-gray-700/50 focus-within:text-primary-500/50 focus-within:ring-primary-500/30">
                        <div class="flex items-center px-3 bg-gray-50 border-r border-gray-300 rounded-l-md">
                            <i class="fad fa-key"></i>
                        </div>
    
                        <input 
                            wire:model.lazy.debounce.500ms="passwordForm.current"
                            :type="showPassword1 ? 'text' : 'password'" placeholder="Sua senha"
                            class="w-full rounded-r-md px-3 py-2 text-gray-700 focus:outline-none"
                        >
    
                        <button 
                            @click="showPassword1 = !showPassword1"
                            type="button" 
                            class="flex items-center px-3 hover:text-primary-500/50 hover:cursor-pointer bg-gray-50 border-r border-gray-300 rounded-l-md">
                            <i :class="showPassword1 ? 'fad fa-eye' : 'fad fa-eye-slash'"></i>
                        </button>
                    </div>
                </div>
    
                <div class="mt-5" x-data="{ showPassword2: false }">
                    <label for="senha" class="block text-sm font-medium text-gray-600/70 mb-2">Nova Senha</label>
                    <div class="flex rounded-md border border-gray-300 focus-within:ring-1 text-gray-700/50 focus-within:text-primary-500/50 focus-within:ring-primary-500/30">
                        <div class="flex items-center px-3 bg-gray-50 border-r border-gray-300 rounded-l-md">
                            <i class="fad fa-key"></i>
                        </div>
    
                        <input 
                            wire:model.lazy.debounce.500ms="passwordForm.new"
                            :type="showPassword2 ? 'text' : 'password'" placeholder="Nova senha"
                            class="w-full rounded-r-md px-3 py-2 text-gray-700 focus:outline-none"
                        >
    
                        <button 
                            @click="showPassword2 = !showPassword2"
                            type="button" 
                            class="flex items-center px-3 hover:text-primary-500/50 hover:cursor-pointer bg-gray-50 border-r border-gray-300 rounded-l-md">
                            <i :class="showPassword2 ? 'fad fa-eye' : 'fad fa-eye-slash'"></i>
                        </button>
                    </div>
                </div>
    
                <div class="mt-5" x-data="{ showPassword3: false }">
                    <label for="senha" class="block text-sm font-medium text-gray-600/70 mb-2">Confirmar Nova Senha</label>
                    <div class="flex rounded-md border border-gray-300 focus-within:ring-1 text-gray-700/50 focus-within:text-primary-500/50 focus-within:ring-primary-500/30">
                        <div class="flex items-center px-3 bg-gray-50 border-r border-gray-300 rounded-l-md">
                            <i class="fad fa-key"></i>
                        </div>
    
                        <input 
                            wire:model.lazy.debounce.500ms="passwordForm.confirm"
                            :type="showPassword3 ? 'text' : 'password'" placeholder="Confirmar Senha"
                            class="w-full rounded-r-md px-3 py-2 text-gray-700 focus:outline-none"
                        >
    
                        <button 
                            @click="showPassword3 = !showPassword3"
                            type="button" 
                            class="flex items-center px-3 hover:text-primary-500/50 hover:cursor-pointer bg-gray-50 border-r border-gray-300 rounded-l-md">
                            <i :class="showPassword3 ? 'fad fa-eye' : 'fad fa-eye-slash'"></i>
                        </button>
                    </div>
                </div>
    
                <hr class="border-t-1 mt-8 border border-primary-300/30 my-4">
    
                <div class="flex flex-row justify-end w-full mt-4">
                    <div class="space-x-2">
                        <button type="submit" class="bg-primary-300 text-white p-2 px-4 rounded-lg hover:cursor-pointer">
                            <i class="fad fa-check-circle p-1"></i>
                            &nbsp;<span class="font-semibold">Salvar</span>&nbsp;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('loggout', () => ({
            confirmLoggout() {
                Swal.fire({
                    title: 'Deseja realmente sair?',
                    text: 'Você precisará se autenticar novamente.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, sair!',
                    cancelButtonText: 'Cancelar',
                    scrollbarPadding: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$wire.loggout();
                    }
                });
            }
        }));
    });
</script>