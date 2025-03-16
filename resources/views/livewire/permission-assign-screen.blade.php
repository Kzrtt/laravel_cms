<div class="w-full mt-6 bg-white p-5 rounded-lg">
    <div class="flex flex-row items-center justify-between">
        <p class="text-black/75 ml-3 font-semibold text-xl p-0 m-0">Permissões do Usuário no Sistema</p>

        <button 
            type="button"
            @click="window.history.back()"
            class="relative p-2 mr-3 rounded-lg transition duration-300 text-primary-400 bg-primary-300/20 hover:text-white hover:bg-primary-500 hover:cursor-pointer hover:shadow-sm">
            <i class="fad fa-check text-xl p-1"></i>
        </button>
    </div>

    @php
        $startingTab = array_key_first($permissionsConfig);
    @endphp

    <div x-data="{ abaAtiva: '{{ $startingTab }}' }" class="w-ful mx-3 mb-10 mt-3">
        <!-- Tabs -->
        <div class="flex border-b border-primary-200 w-full space-x-4" >
            @foreach ($permissionsConfig as $group => $groupData)
            <button type="button" @click="abaAtiva = '{{ $group }}'" 
                    class="flex items-center px-4 py-2 font-medium hover:border-primary-600/50 hover:text-primary-600 hover:border-b-2"
                    :class="{
                        'text-primary-600 border-b-2 border-primary-600/50': abaAtiva === '{{ $group }}',
                        'text-gray-400': abaAtiva !== '{{ $group }}'
                    }"
                    >
                {{ $groupData['name'] }}
            </button>
            @endforeach                       
        </div>
    
        <!-- Permissões Organizacional -->
        @foreach ($permissionsConfig as $group => $groupData)
            <div x-show="abaAtiva === '{{ $group }}'" class="mt-4 flex flex-row space-x-15">
                @foreach ($groupData['subItens'] as $subItem)
                    <div>
                        <h3 class="text-md mt-2 font-semibold text-gray-600/70">{{ $subItem['name'] }}</h3>
                        <ul class="mt-2 space-y-2">
                            @foreach ($subItem['permissions'] as $permission)
                                <li class="flex items-center space-x-2">
                                    <input type="checkbox" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500">
                                    <span class="text-gray-700">{{ getFriendlyPermission($permission) }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>   

    <div class="border-[0.3px] mx-3 my-4 border-primary-300"></div>                                     
</div>