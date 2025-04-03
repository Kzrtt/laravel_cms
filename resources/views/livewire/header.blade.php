<?php use App\Models\config\HeaderToggleParams; ?>

<div x-data="{ selectedTab: '{{$initialTab}}', selectedSubTab: '{{$initialSubTab}}', open: false }" class="w-full">
    <div class="w-full bg-primary-300">
        <div class="container mx-auto px-4 py-1 pb-0">
            <!-- Conteúdo centralizado -->
            <div class="flex items-center justify-between pb-0">
                
                <!-- Logo -->
                <div class="flex items-center space-x-10 mt-1 hover:cursor-pointer">
                    <div @click="window.location.href = '/admin'" class="flex items-center">
                        <img src="{{ url('images/laravel_logo.png') }}" class="h-15 w-23">
                        <span class="text-xl font-bold text-primary-900/50 mt-1">LaravelCMS</span>
                    </div>

                    <div class="flex mt-4">
                        @foreach($menuTabs as $tab => $tabData)
                            <div @click="selectedTab = '{{$tab}}'" 
                                :class="{
                                    'bg-white text-black/50': selectedTab === '{{$tab}}',
                                    'text-primary-900/50': selectedTab !== '{{$tab}}',
                                }"
                                class="rounded-t-lg px-8 pb-4 pt-3">
                                <a href="#" class="font-semibold">{{$tabData['name']}}</a>
                            </div>
                        @endforeach                        
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center space-x-1 py-2">
                    @if ($showConfig)
                        <button @click="open = ! open" class="relative p-2 rounded-lg transition duration-300 hover:bg-primary-500/20 hover:shadow-sm hover:cursor-pointer">
                            <i class="fad fa-cog text-white text-2xl p-1"></i>
                        </button>
                    @endif
                    
                    @if ($showNotification)
                        <button class="relative p-2 rounded-lg transition duration-300 hover:bg-primary-500/20 hover:shadow-sm hover:cursor-pointer">
                            <i class="fad fa-bell text-white text-2xl p-1"></i>
                        </button>
                    @endif

                    <div>
                        <div @click="$slideOpen('profile-slide')"
                            class="flex items-center space-x-2 text-white ml-2 p-2 pl-3 hover:bg-primary-500/20 hover:shadow-sm rounded-lg hover:cursor-pointer">
                            <div class="flex flex-col text-right">
                                <p class="text-xs font-semibold text-primary-900/60 mb-1">{{ getFriendlyAgentType(auth()->user()->usr_level) }}</p>
                                <p class="font-semibold text-sm text-white">{{ auth()->user()->getPerson->pes_name }}</p>
                            </div>
                            <div class="w-10 h-10 flex items-center justify-center bg-primary-500 rounded-lg font-bold text-white">
                                {{ mb_substr(auth()->user()->getPerson->pes_name, 0, 1) }}
                            </div>
                        </div>
    
                        <!-- Sidebar utilizando o componente slide -->
                        <x-ts-slide id="profile-slide">
                            <x-slot:title>
                                <p class="text-xl font-semibold text-secondary-300">Perfil do Usuário</p>
                            </x-slot:title>

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

                            <div class="self-start p-2 px-2 mt-1 mb-6 rounded-lg bg-secondary-200/30 text-secondary-600 text-md font-semibold">
                                <i class="fad fa-university m-1"></i> {{ getAgentName(auth()->user()->usr_level) }}
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

                            <div x-data="{ theme: 'light' }" class="flex flex-row items-center justify-between">
                                <p class="text-2md font-semibold text-black/55">Tema do Sistema: </p>
                                
                                <div class="flex rounded-md border border-secondary-200 overflow-hidden w-fit">
                                    <button
                                    @click="theme = 'dark'"
                                    :class="theme === 'dark' ? 'bg-secondary-200/30 text-secondary-300' : 'text-gray-400'"
                                    class="px-3 py-2 flex items-center justify-center hover:cursor-pointer"
                                    >
                                        <i class="fad fa-moon-stars"></i>
                                    </button>

                                    <!-- Divisória -->
                                    <div class="w-px bg-gray-300"></div>

                                    <button
                                        @click="theme = 'light'"
                                        :class="theme === 'light' ? 'bg-secondary-200/30 text-secondary-300' : 'text-gray-400'"
                                        class="px-3 py-2 flex items-center justify-center hover:cursor-pointer"
                                    >
                                        <i class="fad fa-sun"></i>
                                    </button>
                                </div>
                            </div>

                            <hr class="border-t-2 border-dashed border-primary-300/30 my-4">

                            <nav class="space-y-3">
                                <button 
                                    @click="window.location.href = '/admin/ProfileScreen'"
                                    class="w-full text-left px-3 py-2 text-black/55 rounded hover:cursor-pointer hover:text-secondary-600 hover:bg-secondary-200/15"
                                >
                                    <i class="fad fa-user-circle mr-1"></i> Perfil
                                </button>
                    
                                <div x-data="loggout">
                                    <button
                                        wire:click="confirmLoggout"
                                        class="w-full text-left px-3 py-2 rounded hover:cursor-pointer text-red-600 bg-red-200/15 hover:bg-primary-200/30 hover:font-semibold"
                                    >
                                        <i class="fad fa-sign-out mr-1"></i> Loggout
                                    </button>
                                </div>
                            </nav>
                        </x-ts-slide>  
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white py-3">
        <div class="container mx-auto space-x-4 ml-52">
            <button @click="selectedSubTab = ''; window.location.href = '/admin'" class="p-2 rounded-lg bg-primary-200/55 hover:cursor-pointer">
                <i class="fad fa-home text-primary-600 p-1"></i>&nbsp;<span class="text-primary-600 font-semibold">Home</span>&nbsp;
            </button>

            <template x-if="selectedTab && {{ json_encode($menuTabs) }}[selectedTab]">
                <template x-for="subTab in {{ json_encode($menuTabs) }}[selectedTab].subTabs" :key="subTab.id">
                    <button @click="selectedSubTab = subTab.id; $wire.changeScreen({ _local: subTab.name, _icon: subTab.icon, _title: subTab.name, _view: subTab.customView })"
                            :class="{
                                'bg-primary-200/55 text-primary-600': selectedSubTab === subTab.id || selectedSubTab == subTab.area,
                                'text-gray-400': selectedSubTab !== subTab.id,
                            }"
                            class="p-2 rounded-lg hover:text-primary-600 hover:cursor-pointer"
                    >
                        <i :class="subTab.icon" class=" p-1"></i>
                        &nbsp;<span x-text="subTab.name" class="font-semibold"></span>&nbsp;
                    </button>
                </template>
            </template>
        </div>
    </div>

    <!-- Dropdown -->
    <div
        x-show="open"
        @click.away="open = false"
        class="absolute right-70 top-20 mt-2 w-68 bg-white rounded-lg shadow-md z-50"
        x-transition
    >
        <!-- Título do menu -->
        <div class="px-4 py-4 bg-primary-300 rounded-t-lg text-center text-primary-900/60 font-bold">
            Áreas Administrativas
        </div>

        <!-- Links de configuração -->
        @foreach($configTabs as $item)
            <button 
                @click="open = false"
                wire:click='changeScreen(
                    {{ json_encode([
                        "_local" => $item["area"], 
                        "_icon" => $item["icon"], 
                        "_view" => $item["customView"], 
                        "_title" => $item["name"],
                    ]) }}
                )'
                class="flex items-center w-full px-4 py-2 text-gray-400 hover:bg-secondary-200/55 hover:text-secondary-600 hover:cursor-pointer"
            >
                <i class="{{ $item['icon'] }} mr-2"></i>
                {{ $item['name'] }}
            </button>
        @endforeach
    </div>
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