<?php 
    use App\CMSFunctions;

    $functions = new CMSFunctions();
?>

<div class="flex justify-center w-full">  
    <div class="w-4/5 flex flex-col justify-center p-5">
        <p wire:loading>CarregandoList...</p>
        <div wire:loading.remove x-data="{ listingMode: '{{$startsOn}}'}">
            <!-- Titulo da página -->
            <div class="flex flex-row items-center bg-white w-full container px-5 py-3 mt-4 rounded-lg">
                <i class="{{$params['_icon']}} ml-2 text-primary-500 text-3xl"></i>
                <div class="ml-3">
                    <p class="text-primary-500/55 ml-3 font-semibold text-xl p-0 m-0">{{$params['_title']}}</p>
                    <p class="text-gray-300 ml-3 text-md p-0 m-0">Listagem de Registros</p>
                </div>
            </div> 

            <!-- Container da tabela [ACTIONS] [BUTTONS] [PAGINATION] [TABLE] -->
            <div class="w-full mt-8 bg-white p-5 rounded-lg">
                <!-- BUTTONS -->
                <div class="flex flex-row justify-between w-full overflow-hidden mt-2 mb-8">
                    <div class="space-x-2">
                        <button @click="listingMode = 'list'"
                            :class="{
                                'bg-primary-300/20 text-primary-400': listingMode === 'list',
                                'hover:bg-gray-300/20 text-gray-400': listingMode !== 'list'
                            }"
                            class="relative p-2 rounded-lg transition duration-300 hover:shadow-sm hover:cursor-pointer">

                            <i class="fad fa-th-list  text-2xl p-1"></i>
                        </button>

                        <button @click="listingMode = 'grid'"
                            :class="{
                                'bg-primary-300/20 text-primary-400': listingMode === 'grid',
                                'hover:bg-gray-300/20 text-gray-400': listingMode !== 'grid'
                            }" 
                            class="relative p-2 rounded-lg transition duration-300 hover:shadow-sm hover:cursor-pointer">
                            <i class="fad fa-th-large text-2xl p-1"></i>
                        </button>
                    </div>

                    <div class="space-x-4">
                        @if($buttonsConfig['showSearchButton'])
                            <button class="bg-primary-300 text-white p-2 px-4 rounded-lg hover:cursor-pointer">
                                <i class="fad fa-search p-1"></i>
                                &nbsp;<span class="font-semibold">Buscar</span>&nbsp;
                            </button>
                        @endif

                        @if($buttonsConfig['showInsertButton'])
                            <button
                                wire:click="addNew"
                                class="bg-primary-200/55 text-primary-600 p-2 px-4 rounded-lg hover:bg-primary-300 hover:text-white transition hover:cursor-pointer">
                                <i class="fad fa-plus-circle p-1"></i>
                                <span class="font-semibold">Adicionar</span>&nbsp;
                            </button>
                        @endif
                    </div>
                </div>

                <!-- TABLE -->
                <div class="w-full overflow-hidden rounded-lg">
                    <table x-show="listingMode === 'list'" class="w-full divide-y divide-gray-200">
                        <thead class="bg-primary-300/80 h-15">
                            <tr>
                                @foreach($tableConfig as $key => $data)
                                    <th class="px-6 py-3 text-left text-sm font-big text-primary-900/50 uppercase tracking-wider">{{$data['name']}}</th>
                                @endforeach
                                <th class="px-6 py-3 text-right text-sm font-big text-primary-900/50 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($listingData as $object)    
                                <tr>
                                    @foreach($tableConfig as $key => $data)
                                        <td class="px-6 py-4 whitespace-nowrap {{$data['style']}}">
                                            @if(@$data['getRelation']) 
                                                @php
                                                    // Divide a string em segmentos
                                                    $segments = explode('->', $data['getRelation']); // ex: ['getPerson', 'getAddress', 'city']
                                                    $value = $object; // Inicia com o objeto principal

                                                    // Percorre cada segmento e atualiza o valor
                                                    foreach ($segments as $segment) {
                                                        // Se for método (começa com "get") ou propriedade, ambos funcionam da mesma forma
                                                        // Use "optional" para evitar erros se algum segmento for nulo
                                                        $value = optional($value)->{$segment};
                                                    }
                                                @endphp

                                                {{ $value }}
                                            @elseif(@$data['listingFunction'])
                                                {!! $functions->{$data['listingFunction']}($object->$key) !!}
                                            @else
                                                {{ $object->$key }}
                                            @endif
                                        </td>
                                    @endforeach

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="w-full flex justify-end space-x-2">
                                            @if($buttonsConfig['showDetailsButton'])
                                                <button class="p-2 rounded-lg transition duration-300 text-blue-400 bg-blue-300/20 hover:text-white hover:bg-blue-500 hover:shadow-sm hover:cursor-pointer">
                                                    <i class="fad fa-info-circle text-xl p-1"></i>
                                                </button>
                                            @endif

                                            @if($buttonsConfig['showEditButton'])
                                                <button
                                                    wire:click="editRegistry({{ $object->$identifier }})"
                                                    class="relative p-2 rounded-lg transition duration-300 text-success-400 bg-success-300/20 hover:text-white hover:bg-success-500 hover:shadow-sm hover:cursor-pointer">
                                                    <i class="fad fa-edit text-xl p-1"></i>
                                                </button>
                                            @endif

                                            @if($buttonsConfig['showDeleteButton'])
                                                <button 
                                                    wire:click="delete({{$object->$identifier}})"
                                                    class="relative p-2 rounded-lg transition duration-300 text-primary-400 bg-primary-300/20 hover:text-white hover:bg-primary-500 hover:shadow-sm hover:cursor-pointer">
                                                    <i class="fad fa-trash-alt text-xl p-1"></i>
                                                </button>
                                            @endif

                                            @if(isset($additionalSingleData))
                                                @foreach ($additionalSingleData as $name => $buttonData)
                                                    <button 
                                                        wire:click=""
                                                        class="{{ $buttonData['style'] }}">
                                                        <i class="{{ $buttonData['icon'] }} text-xl p-1"></i>
                                                    </button>
                                                @endforeach
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div x-show="listingMode === 'grid'" class="w-full rounded-lg">
                        <div class="grid grid-cols-5 gap-10">
                            <!-- Exemplo de card em grid -->
                            @foreach($listingData as $object)
                                <div class="bg-gray-100 relative rounded-lg shadow">
                                    <div class="flex items-center justify-center w-22 h-22 bg-white rounded-full absolute top-6 left-1/2 transform -translate-x-1/2">
                                        <div class="flex items-center justify-center w-20 h-20 bg-primary-300/20 rounded-full">
                                            <i class="{{$params['_icon']}} text-3xl text-primary-500"></i>
                                        </div>
                                    </div>
                                    <div class="w-full h-18 rounded-t-lg bg-primary-300/30"></div>
                                    
                                    <div class="px-4 py-2 mt-8 space-y-1">
                                        @foreach($gridConfig as $key => $data)
                                            <{{$data['html']}} class="{{@$data['tagStyle']}} w-full truncate">
                                                <span class="{{@$data['labelStyle']}}">{{$data['name']}}:</span> 
                                                <span class="{{@$data['fieldStyle']}}">
                                                    @if(@$data['getRelation']) 
                                                        @php
                                                            // Divide a string em segmentos
                                                            $segments = explode('->', $data['getRelation']); // ex: ['getPerson', 'getAddress', 'city']
                                                            $value = $object; // Inicia com o objeto principal

                                                            // Percorre cada segmento e atualiza o valor
                                                            foreach ($segments as $segment) {
                                                                // Se for método (começa com "get") ou propriedade, ambos funcionam da mesma forma
                                                                // Use "optional" para evitar erros se algum segmento for nulo
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

                                    <div class="flex flex-wrap gap-2 justify-end mt-8 mb-4 mr-4">
                                        @if($buttonsConfig['showDetailsButton'])
                                            <button class="relative p-2 rounded-lg transition duration-300 text-blue-400 bg-blue-300/20 hover:text-white hover:cursor-pointer hover:bg-blue-500 hover:shadow-sm">
                                                <i class="fad fa-info-circle text-xl p-1"></i>
                                            </button>
                                        @endif

                                        @if($buttonsConfig['showEditButton'])
                                            <button
                                                wire:click="editRegistry({{ $object->$identifier }})"
                                                class="relative p-2 rounded-lg transition duration-300 text-success-400 bg-success-300/20 hover:cursor-pointer hover:text-white hover:bg-success-500 hover:shadow-sm">
                                                <i class="fad fa-edit  text-xl p-1"></i>
                                            </button>
                                        @endif

                                        @if($buttonsConfig['showDeleteButton'])
                                            <button 
                                                wire:click="delete({{$object->$identifier}})"
                                                class="relative p-2 rounded-lg transition duration-300 text-primary-400 bg-primary-300/20 hover:cursor-pointer hover:text-white hover:bg-primary-500 hover:shadow-sm">
                                                <i class="fad fa-trash-alt text-xl p-1"></i>
                                            </button>
                                        @endif

                                        @if(isset($additionalSingleData))
                                            @foreach ($additionalSingleData as $name => $buttonData)
                                                <button 
                                                    wire:click="{{ $buttonData['onTap']['function'] }}({{ $buttonData['onTap']['params'] }}, '{{ $object->$identifier }}')"
                                                    class="relative p-2 rounded-lg transition duration-300 text-blue-400 bg-blue-300/20 hover:cursor-pointer hover:text-white hover:bg-blue-500 hover:shadow-sm">
                                                    <i class="{{ $buttonData['icon'] }} text-xl p-1"></i>
                                                </button>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- PAGINATION -->
                <div class="flex flex-row justify-between w-full overflow-hidden mt-10 mb-2">
                    <!-- PAGES -->
                    <div class="space-x-1">
                        <button class="relative p-1 rounded-lg transition duration-300 bg-gray-300/20 hover:shadow-sm">
                            <i class="fad fa-angle-double-left text-gray-400 text-xl p-1"></i>
                        </button>

                        <button class="relative p-1 rounded-lg transition duration-300 bg-gray-300/20 hover:shadow-sm">
                            <i class="fad fa-angle-left text-gray-400 text-xl p-1"></i>
                        </button>

                        <button class="relative px-3 py-1 rounded-lg transition duration-300 bg-primary-300/20 hover:shadow-sm">
                            <span class="font-semibold text-primary-400 text-xl">1</span>
                        </button>

                        <button class="relative px-3 py-1 rounded-lg transition duration-300 text-gray-400 hover:bg-primary-300/20 hover:text-primary-400 hover:shadow-sm">
                            <span class="font-semibold text-xl">2</span>
                        </button>

                        <button class="relative p-1 rounded-lg transition duration-300 bg-gray-300/20 hover:shadow-sm">
                            <i class="fad fa-angle-double-right text-gray-400 text-xl p-1"></i>
                        </button>

                        <button class="relative p-1 rounded-lg transition duration-300 bg-gray-300/20 hover:shadow-sm">
                            <i class="fad fa-angle-right text-gray-400 text-xl p-1"></i>
                        </button>
                    </div>

                    <!-- REGISTRY COUNT -->
                    <div class="flex flex-row items-center space-x-4">
                        <select class="block w-24 p-0.5 border border-gray-300 rounded-md shadow-sm transition-colors duration-200 bg-gray-400/20 hover:bg-blue-100 focus:outline-none">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="15">20</option>
                            <option value="15">25</option>
                        </select>

                        <p class="text-sm font-semibold text-gray-400 mr-1">Exibindo 2 de 2 Registros</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>