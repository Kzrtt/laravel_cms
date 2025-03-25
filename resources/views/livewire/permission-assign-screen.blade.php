@php
    $startingTab = array_key_first($permissionsConfig);
@endphp

<div class="flex flex-row justify-center mt-6 space-x-10 w-full min-h-screen" x-data="{ selectedTab: '{{ $startingTab }}' }">

    <!-- MANTIDA: Sua parte esquerda original -->
    <div class="w-100 rounded-md bg-white shadow-sm p-6">
        <!-- Informações resumidas do usuário -->
        <div class="flex flex-row mb-6">
            <div class="flex justify-center items-center w-20 h-20 rounded-lg bg-primary-200/55">
                <img src="{{ url('images/laravel_logo.png') }}" class="h-14 w-22">
            </div>

            <div class="flex flex-col justify-center ml-4 space-y-1">
                <p class="font-semibold text-black/55 text-xl">Atribuição de Permissões</p>
                <div class="inline-block self-start p-1 px-2 mt-1 rounded-md bg-primary-200/55 text-primary-600 text-xs">
                    {{ $profileName }}
                </div>
            </div>          
        </div>

        <hr class="border-t-2 border-dashed border-primary-300/30 my-4">

        <div class="p-2 rounded max-w-md">
            <div class="flex flex-col gap-y-2 text-sm">
                <div class="flex justify-between font-semibold text-gray-700">
                    <span>Total Áreas</span>
                    <span class="text-gray-400 font-normal">{{ $totalAreas }}</span>
                </div>
        
                <div class="flex justify-between font-semibold text-gray-700">
                    <span>Total SubÁreas</span>
                    <span class="text-gray-400 font-normal">{{ $totalSubAreas }}</span>
                </div>
        
                <div class="flex justify-between font-semibold text-gray-700">
                    <span>Permissões Concedidas</span>
                    <span class="text-gray-400 font-normal">{{ $permissionsAssigned }}</span>
                </div>
        
                <div class="flex justify-between font-semibold text-gray-700">
                    <span>Quantidade Usuários</span>
                    <span class="text-gray-400 font-normal">{{ $totalUsers }}</span>
                </div>
            </div>
        </div>

        <hr class="border-t-2 border-dashed border-primary-300/30 my-4">
        
        <p class="mb-4 text-black/35 text-lg font-semibold">Áreas</p>

        <!-- Menu de Navegação -->
        <nav class="space-y-3">
            @foreach ($permissionsConfig as $group => $groupData)
                <button 
                    @click="selectedTab = '{{ $group }}'" 
                    :class="selectedTab === '{{ $group }}' 
                        ? 'bg-primary-200/30 text-primary-600 w-full text-left font-semibold px-3 py-2 rounded-lg' 
                        : 'w-full text-left px-3 py-2 text-black/55 rounded hover:cursor-pointer hover:text-primary-600 hover:bg-primary-200/15'"
                >
                    <i class="{{ $groupData['icon'] }} mr-1"></i> {{ $groupData['name'] }}
                </button>
            @endforeach
        </nav>
    </div>

    <!-- REFATORADO: Parte direita com exibição de subáreas e permissões -->
    <main class="flex w-250 p-6 rounded-md bg-white">
        <form class="w-full" wire:loading.remove wire:submit.prevent="submitForm">
            <div class="w-full" x-transition>
                @foreach ($permissionsConfig as $group => $groupData)
                    <div x-show="selectedTab === '{{ $group }}'" x-transition>
                        <div class="flex flex-row justify-between items-center">
                            <div>
                                <h1 class="text-xl font-semibold mb-1 text-black/75">{{ $groupData['name'] }}</h1>
                                <p class="text-md text-black/45 mb-4">Gerencie as permissões das subáreas abaixo:</p>
                            </div>

                            <button 
                                type="button"
                                class="p-2 mr-3 rounded-lg text-primary-400 bg-primary-300/20 hover:text-white hover:bg-primary-500 hover:cursor-pointer hover:shadow-sm">
                                <i class="fad fa-user-shield text-xl p-1"></i>
                            </button>
                        </div>

                        <hr class="border-t-2 border-dashed border-primary-300/30 my-4">

                        <div class="w-full rounded-lg bg-amber-200/40 p-4 my-6 text-amber-400 font-semibold">
                            <i class="fad fa-exclamation-triangle text-xl ml-1 mr-2"></i>
                            Ao manipular essas permissões você pode acabar restringindo as funcionalidades do sistema para certos usuários.
                        </div>

                        <div class="grid grid-cols-3 gap-6">
                            @foreach ($groupData['subItens'] as $subItem)
                                <div class="bg-white shadow-xl rounded-md border border-primary-100/20 flex flex-col justify-between">
                                    <div class="p-4">
                                        <h3 class="text-md font-semibold text-gray-600/70 mb-4">{{ $subItem['name'] }}</h3>
                                        <ul class="space-y-4">
                                            @foreach ($subItem['permissions'] as $permission)
                                                <x-checkbox
                                                    id="permission-{{ $subItem['area'] }}-{{ $permission }}"
                                                    wire:model="permissionData.{{ $subItem['area'] }}.{{ $permission }}"
                                                    label="{{ getFriendlyPermission($permission) }}"
                                                    md
                                                />
                                            @endforeach
                                        </ul>
                                    </div>
                        
                                    <!-- Faixa inferior colada na base -->
                                    <div class="bg-secondary-300 py-1 pb-0.5 rounded-bl-md rounded-br-md"></div>
                                </div>
                            @endforeach
                        </div>

                        <hr class="border-t-2 border-dashed mt-8 border-primary-300/30 my-4">

                        <div class="flex flex-row justify-end w-full mt-3">
                            <div class="space-x-2">
                                <button
                                    type="button"
                                    @click="window.history.back()"
                                    class="bg-primary-200/55 text-primary-600 p-2 rounded-lg hover:bg-primary-300 hover:text-white transition hover:cursor-pointer">
                                    <i class="fad fa-times-circle p-1"></i>
                                    &nbsp;<span class="font-semibold">Voltar</span>&nbsp;
                                </button>

                                <button type="submit" class="bg-primary-300 text-white p-2 px-4 rounded-lg hover:cursor-pointer hover:shadow-lg">
                                    <i class="fad fa-check-circle p-1"></i>
                                    &nbsp;<span class="font-semibold">Conceder Permissões</span>&nbsp;
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </form>
    </main>
</div>
