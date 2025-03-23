<!-- Componente/Trecho de layout para Configurações de Conta -->
<div class="flex flex-row justify-center mt-6 space-x-10 w-full min-h-screen" x-data="{ selectedTab: 'pessoal' }">

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
                    {{ auth()->user()->usr_level }}
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
                @click="selectedTab = 'pessoal'" 
                :class="selectedTab === 'pessoal' 
                    ? 'bg-primary-200/30 text-primary-600 w-full text-left font-semibold px-3 py-2 rounded-lg' 
                    : 'w-full text-left px-3 py-2 text-black/55 rounded hover:cursor-pointer hover:text-primary-600 hover:bg-primary-200/15'
                "
            >
                <i class="fad fa-user-circle mr-1"></i> Informações Pessoais
            </button>
        
            <button 
                @click="selectedTab = 'acesso'" 
                :class="selectedTab === 'acesso' 
                    ? 'bg-primary-200/30 text-primary-600 w-full text-left font-semibold px-3 py-2 rounded-lg' 
                    : 'w-full text-left px-3 py-2 text-black/55 rounded hover:cursor-pointer hover:text-primary-600 hover:bg-primary-200/15'
                "
            >
                <i class="fad fa-key mr-1"></i> Dados de Acesso
            </button>

            <button 
                wire:click="loggout"
                class="w-full text-left px-3 py-2 rounded hover:cursor-pointer text-red-600 bg-red-200/15 hover:bg-primary-200/30 hover:font-semibold"
            >
                <i class="fad fa-sign-out mr-1"></i> Loggout
            </button>
        </nav>
    </div>

    <!-- Conteúdo da Aba Selecionada -->
    <main class="flex w-250 p-6 rounded-md bg-white">
        <!-- Aba: Informações Pessoais -->
        <div x-show="selectedTab === 'pessoal'" x-transition>
            <h1 class="text-2xl font-semibold mb-4">Informações Pessoais</h1>
            <p>Texto Pessoal...</p>
        </div>

        <!-- Aba: Dados de Acesso -->
        <div x-show="selectedTab === 'acesso'" x-transition>
            <h1 class="text-2xl font-semibold mb-4">Dados de Acesso</h1>
            <p>Texto de Acesso...</p>
        </div>
    </main>
</div>

