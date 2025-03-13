<div class="flex justify-center w-full">  
    <div class="w-4/5 flex flex-col justify-center p-5">
        <p wire:loading>Carregando...</p>
        <form wire:loading.remove wire:submit.prevent="submitForm">

            <!-- Alerta para Preenchimento dos Campos -->
            <div class="flex flex-row items-center bg-white w-full container px-5 py-4 mt-2 rounded-lg">
                <i class="fad fa-exclamation-triangle ml-2 text-warning-600 text-2xl"></i>
                <div class="ml-3">
                    <p class="text-gray-500 ml-3 text-lg p-0 m-0">Atente para os campos em <span class="text-red-400">*negrito</span>, eles são obrigatórios</p>
                </div>
            </div> 

            <!-- Card do Formulário -->
            <div class="w-full mt-6 bg-white p-5 rounded-lg">
                <div class="flex flex-row items-center justify-between">
                    <p class="text-black/75 ml-3 font-semibold text-xl p-0 m-0">Formuário para criação de {{$params['_title']}}</p>

                    <button 
                        type="button"
                        @click="window.history.back()"
                        class="relative p-2 mr-3 rounded-lg transition duration-300 text-primary-400 bg-primary-300/20 hover:text-white hover:bg-primary-500 hover:cursor-pointer hover:shadow-sm">
                        <i class="fad fa-undo text-xl p-1"></i>
                    </button>
                </div>

                <div class="border-[0.3px] mx-3 my-6 border-primary-300"></div>

                <x-dynamic-form :formConfig="$formConfig" :selectsPopulate="$selectsPopulate" />
                
                <div>
                    <p class="text-black/75 ml-3 font-semibold text-xl p-0 mb-5">Vínculo</p>
                    <div class="flex flex-row space-x-4 mx-3"> 
                        <div x-data class="mb-4 w-full">
                            <label for="representedAgent" class="block mb-2 text-sm font-medium text-gray-700"> 
                                Entidade Representada <span class="text-red-500">*</span> 
                            </label>

                            <select 
                                wire:model.lazy="formData.representedAgent"

                                placeholder="Selecione o Agente Representado"
                                id="representedAgent"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-primary-500/30 focus:border-primary-500/30"
                            >
                                <option value="">Selecionar...</option>
                                @foreach ($selectsPopulate['representedAgent'] as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>

                            @error('formData.name')
                                <p class="mt-2 text-xs text-red-500 font-semibold">{{ $message }}</p>
                            @else
                                <p class="mt-2 text-xs text-secondary-500/60 font-semibold">Selecione o agente representado</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="isEdit" class="w-full mt-6 bg-white p-5 rounded-lg">
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

            <div class="flex flex-row justify-end w-full mt-6 bg-white p-5 rounded-lg">
                <div class="space-x-2">
                    <button
                        type="button"
                        @click="$dispatch('back')"
                        class="bg-primary-200/55 text-primary-600 p-2 rounded-lg hover:bg-primary-300 hover:text-white transition hover:cursor-pointer">
                        <i class="fad fa-times-circle p-1"></i>
                        &nbsp;<span class="font-semibold">Cancelar</span>&nbsp;
                    </button>

                    <button type="submit" class="bg-primary-300 text-white p-2 px-4 rounded-lg hover:cursor-pointer">
                        <i class="fad fa-check-circle p-1"></i>
                        &nbsp;<span class="font-semibold">Salvar</span>&nbsp;
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>