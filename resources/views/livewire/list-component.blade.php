@php
    use App\CMSFunctions;
    $functions = new CMSFunctions();
@endphp

<div class="flex flex-row justify-center mt-6 space-x-10 w-full min-h-screen" x-data="{ listingMode: '{{$startsOn}}' }">
    <!-- MANTIDA: Sua parte esquerda original -->
    <div class="w-100 rounded-md bg-white shadow-sm p-6">
        <!-- Informações resumidas do usuário -->
        <div class="flex flex-row mb-6">
            <div class="flex justify-center items-center w-20 h-20 rounded-lg bg-primary-200/55">
                <i class="{{ $params['_icon'] }} text-primary-500 text-3xl"></i>
            </div>

            <div class="flex flex-col justify-center ml-4 space-y-1">
                <p class="font-semibold text-black/55 text-xl">Listagem de Registros</p>
                <div class="inline-block self-start p-1 px-2 mt-1 rounded-md bg-primary-200/55 text-primary-600 text-xs">
                    {{ $params['_title'] }}
                </div>
            </div>          
        </div>

        <hr class="border-t-2 border-dashed border-primary-300/30 my-4">

        <div class="p-2 rounded max-w-md">
            <div class="flex flex-col gap-y-2 text-sm">
                <div class="flex justify-between font-semibold text-gray-700">
                    <span>Quantidade de Registros</span>
                    <span class="text-gray-400 font-normal">{{ $totalRegistries }}</span>
                </div>     
                
                <div class="flex justify-between font-semibold text-gray-700">
                    <span>Mostrando</span>
                    <span class="text-gray-400 font-normal">? de ?</span>
                </div>  
            </div>

            <div class="mt-2">
                <span class="font-semibold text-gray-700 text-sm">Filtros</span><br>
                <span class="text-gray-400 text-xs">Nenhum Filtro aplicado...</span>
            </div>
        </div>
        
        <hr class="border-t-2 border-dashed border-primary-300/30 my-4">
        
        <p class="mb-4 text-black/35 text-lg font-semibold">Listagem</p>

        <!-- Menu de Navegação -->
        <nav class="flex flex-row space-x-3">
            <button @click="listingMode = 'list'"
                :class="{
                    'bg-secondary-300/20 text-secondary-400': listingMode === 'list',
                    'hover:bg-gray-300/20 text-gray-400': listingMode !== 'list'
                }"
                class="relative p-2 rounded-lg transition duration-300 hover:shadow-sm hover:cursor-pointer">

                <i class="fad fa-th-list text-2xl p-1"></i>
            </button>

            <button @click="listingMode = 'grid'"
                :class="{
                    'bg-secondary-300/20 text-secondary-400': listingMode === 'grid',
                    'hover:bg-gray-300/20 text-gray-400': listingMode !== 'grid'
                }" 
                class="relative p-2 rounded-lg transition duration-300 hover:shadow-sm hover:cursor-pointer">
                <i class="fad fa-th-large text-2xl p-1"></i>
            </button>
        </nav>

        <hr class="border-t-2 border-dashed border-primary-300/30 my-4">
        
        <p class="mb-4 text-black/35 text-lg font-semibold">Ações</p>

        <!-- Menu de Navegação -->
        <nav class="space-y-3">
            @if($buttonsConfig['showInsertButton'] && @session('usr_permissions')[$params['_local']]['Insert'])
                <button 
                    wire:click="addNew"
                    class="w-full text-left px-3 py-2 rounded hover:cursor-pointer text-secondary-600 bg-secondary-200/20 hover:bg-secondary-400/40 hover:font-semibold"
                >
                    <i class="fad fa-plus-circle mr-1"></i> Adicionar Registro
                </button>
            @endif
            
            @if($buttonsConfig['showSearchButton'])
                <button 
                    class="w-full text-left px-3 py-2 rounded hover:cursor-pointer text-secondary-600 bg-secondary-200/20 hover:bg-secondary-400/40 hover:font-semibold"
                >
                    <i class="fad fa-search mr-1"></i> Buscar
                </button>
            @endif
        </nav>
    </div>

    <!-- REFATORADO: Parte direita com exibição da listagem -->
    <main class="flex w-250 p-6 mb rounded-md bg-white">
        <div class="w-full">
            <div>
                <h1 class="text-xl font-semibold mb-1 text-black/75" 
                    x-text="listingMode === 'list' ? 'Tabela de Registros' : 'Quadro de Registros'">
                </h1>
                <p class="text-md text-black/45 mb-4">Aplique filtros nos registros apresentados no painel esquerdo.</p>
            </div>

            <hr class="border-t-2 mb-6 border-dashed border-primary-300/30 my-4">

            <!-- TABELA -->
            <div x-show="listingMode === 'list'" class="grid gap-4 transition-all duration-300">
                @foreach($listingData as $object)
                    <div class="bg-white shadow-md rounded-xl p-4 border border-gray-100 hover:shadow-lg hover:scale-[1.01] transition-all duration-200">
                        <div class="flex justify-between items-center mb-2">
                            <div class="text-primary-300 text-lg font-semibold mt-0">
                                Registro #{{ $object->$identifier }}
                            </div>
            
                            <div class="flex space-x-2">
                                @if($buttonsConfig['showDetailsButton'])
                                    <button class="p-2 rounded-lg text-blue-400 bg-blue-300/20 hover:text-white hover:cursor-pointer hover:bg-blue-500 transition">
                                        <i class="fad fa-info-circle text-lg p-1"></i>
                                    </button>
                                @endif
            
                                @if($buttonsConfig['showEditButton'])
                                    <button wire:click="editRegistry({{ $object->$identifier }})"
                                        class="p-2 rounded-lg text-success-400 bg-success-300/20 hover:text-white hover:cursor-pointer hover:bg-success-500 transition">
                                        <i class="fad fa-edit text-g p-1"></i>
                                    </button>
                                @endif
            
                                @if($buttonsConfig['showDeleteButton'])
                                    <button wire:click="delete({{ $object->$identifier }})"
                                        class="p-2 rounded-lg text-red-400 bg-red-300/20 hover:text-white hover:cursor-pointer hover:bg-red-500 transition">
                                        <i class="fad fa-trash-alt text-lg p-1"></i>
                                    </button>
                                @endif
            
                                @if(isset($additionalSingleData))
                                    @foreach ($additionalSingleData as $name => $buttonData)
                                        <button 
                                            wire:click="{{ $buttonData['onTap']['function'] }}({{ $buttonData['onTap']['params'] }}, '{{ $object->$identifier }}')"
                                            class="p-2 rounded-lg text-blue-400 bg-blue-300/20 hover:text-white hover:cursor-pointer hover:bg-blue-500 transition">
                                            <i class="{{ $buttonData['icon'] }} text-lg p-1"></i>
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
            
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2 text-sm">
                            @foreach($tableConfig as $key => $data)
                                <div>
                                    <div class="font-semibold text-secondary-500/50 uppercase text-xs mb-0.5">{{ $data['name'] }}</div>
                                    <div class="mb-1 text-gray-700/75">
                                        @if(@$data['getRelation']) 
                                            @php
                                                $segments = explode('->', $data['getRelation']);
                                                $value = $object;
                                                foreach ($segments as $segment) {
                                                    $value = optional($value)->{$segment};
                                                }
                                            @endphp
                                            {{ $value }}
                                        @elseif(@$data['listingFunction'])
                                            {!! $functions->{$data['listingFunction']}($object->$key) !!}
                                        @else
                                            {{ $object->$key }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex flex-row justify-end">
                            <i class="{{ $params['_icon'] }} text-primary-500/30 text-3xl"></i>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- GRID -->
            <div x-show="listingMode === 'grid'" class="w-full rounded-lg transition-all duration-300">
                <div class="grid grid-cols-3 gap-6">
                    @foreach($listingData as $object)
                        <div class="bg-gray-100 relative rounded-lg shadow hover:shadow-lg hover:scale-[1.01] transition-all duration-200">
                            <div class="flex items-center justify-center w-20 h-20 bg-white rounded-full absolute top-6 right-3">
                                <div class="flex items-center justify-center w-17 h-17 bg-primary-300/20 rounded-full">
                                    <i class="{{ $params['_icon'] }} text-2xl text-primary-500"></i>
                                </div>
                            </div>
                            <div class="w-full h-16 rounded-t-lg bg-primary-300/30"></div>

                            <div class="px-4 pb-2 pt-0 mt-5 space-y-1">
                                <span class="font-semibold text-primary-300 text-xl">Registro #{{ $object->$identifier }}</span>

                                <div class="mt-6">
                                    @foreach($gridConfig as $key => $data)
                                        <{{$data['html']}} class="{{ @$data['tagStyle'] }} w-full truncate">
                                            <span class="{{ @$data['labelStyle'] }}">{{ $data['name'] }}</span>
                                            <span class="{{ @$data['fieldStyle'] }}">
                                                @if(@$data['getRelation']) 
                                                    @php
                                                        $segments = explode('->', $data['getRelation']);
                                                        $value = $object;
                                                        foreach ($segments as $segment) {
                                                            $value = optional($value)->{$segment};
                                                        }
                                                    @endphp
                                                    {{ $value }}
                                                @elseif(@$data['listingFunction'])
                                                    {!! $functions->{$data['listingFunction']}($object->$key) !!}
                                                @else
                                                    {{ $object->$key }}
                                                @endif
                                            </span>
                                        </{{$data['html']}}>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex gap-2 justify-end mt-4 mb-4 px-4">
                                @if($buttonsConfig['showDetailsButton'])
                                    <button class="relative p-2 rounded-lg transition duration-300 text-blue-400 bg-blue-300/20 hover:text-white hover:cursor-pointer hover:bg-blue-500 hover:shadow-sm">
                                        <i class="fad fa-info-circle text-lg p-1"></i>
                                    </button>
                                @endif

                                @if($buttonsConfig['showEditButton'])
                                    <button wire:click="editRegistry({{ $object->$identifier }})"
                                        class="p-2 rounded-lg transition duration-300 text-success-400 bg-success-300/20 hover:text-white hover:bg-success-500 hover:shadow-sm hover:cursor-pointer">
                                        <i class="fad fa-edit text-lg p-1"></i>
                                    </button>
                                @endif

                                @if($buttonsConfig['showDeleteButton'])
                                    <button wire:click="delete({{ $object->$identifier }})"
                                        class="p-2 rounded-lg transition duration-300 text-primary-400 bg-primary-300/20 hover:text-white hover:bg-primary-500 hover:shadow-sm hover:cursor-pointer">
                                        <i class="fad fa-trash-alt text-lg p-1"></i>
                                    </button>
                                @endif

                                @if(isset($additionalSingleData))
                                    @foreach ($additionalSingleData as $name => $buttonData)
                                        <button 
                                            wire:click="{{ $buttonData['onTap']['function'] }}({{ $buttonData['onTap']['params'] }}, '{{ $object->$identifier }}')"
                                            class="relative p-2 rounded-lg transition duration-300 text-blue-400 bg-blue-300/20 hover:cursor-pointer hover:text-white hover:bg-blue-500 hover:shadow-sm">
                                            <i class="{{ $buttonData['icon'] }} text-lg p-1"></i>
                                        </button>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </main>

</div>
