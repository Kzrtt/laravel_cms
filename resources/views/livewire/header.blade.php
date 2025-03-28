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

                    <div x-data="{ openProfileDrawer: false}">
                        <div @click="openProfileDrawer = true"
                            class="flex items-center space-x-2 text-white ml-2 p-2 pl-3 hover:bg-primary-500/20 hover:shadow-sm rounded-lg hover:cursor-pointer">
                            <div class="flex flex-col text-right">
                                <p class="text-xs font-semibold text-primary-900/60 mb-1">{{ getFriendlyAgentType(auth()->user()->usr_level) }}</p>
                                <p class="font-semibold text-sm text-white">{{ auth()->user()->getPerson->pes_name }}</p>
                            </div>
                            <div class="w-10 h-10 flex items-center justify-center bg-primary-500 rounded-lg font-bold text-white">
                                {{ mb_substr(auth()->user()->getPerson->pes_name, 0, 1) }}
                            </div>
                        </div>
    
                        <!-- Sidebar utilizando o componente Drawer -->
                        
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
                class="flex items-center w-full px-4 py-2 text-gray-400 hover:bg-primary-200/55 hover:text-primary-600 hover:cursor-pointer"
            >
                <i class="{{ $item['icon'] }} mr-2"></i>
                {{ $item['name'] }}
            </button>
        @endforeach
    </div>
</div> 