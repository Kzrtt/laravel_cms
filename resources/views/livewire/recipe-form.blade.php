<!-- Componente/Trecho de layout para Configurações de Conta -->
<div class="flex flex-row justify-center mt-6 space-x-10 w-full min-h-screen" 
    x-data="{ 
        selectedTab: 'basic',
        selectedIcon: 'fad fa-info'
    }">

    <!-- Menu Lateral -->
    <div class="w-100 rounded-md bg-white shadow-sm p-6">
        <!-- Informações resumidas do usuário, se quiser -->
        <div class="flex flex-row mb-6">
            <div class="flex justify-center items-center w-20 h-20 rounded-lg bg-primary-200/55">
                <i class="{{ $params['_icon'] }} text-primary-500 text-3xl"></i>
            </div>

            <div class="flex flex-col justify-center ml-4 space-y-1">
                <p class="font-semibold text-black/55 text-xl">Inclusão de Registro</p>
                <div class="inline-block self-start p-1 px-2 mt-1 rounded-md bg-primary-200/55 text-primary-600 text-xs">
                    Receita
                </div>
            </div>          
        </div>

        <div class="self-start p-2 px-2 mt-1 mb-6 rounded-lg bg-secondary-200/30 text-secondary-600 text-md font-semibold">
            <i class="fad fa-university m-1"></i> Nome do Estabelecimento
        </div>

        <hr class="border-t-2 border-dashed border-primary-300/30 my-4">
        
        <p class="mb-4 text-black/35 text-lg font-semibold">Menu</p>

        <!-- Menu de Navegação -->
        <nav class="space-y-3">
            <button 
                @click="selectedTab = 'basic'; selectedIcon = 'fad fa-info'" 
                :class="selectedTab === 'basic' 
                    ? 'bg-secondary-200/30 text-secondary-600 w-full text-left font-semibold px-3 py-2 rounded-lg' 
                    : 'w-full text-left px-3 py-2 text-black/55 rounded hover:cursor-pointer hover:text-secondary-600 hover:bg-secondary-200/15'
                "
            >
                <i class="fad fa-info mr-1"></i> Informações Básicas
            </button>
        
            <button 
                @click="selectedTab = 'ingredients'; selectedIcon = 'fad fa-utensils'"
                class="{{ !$isEdit ? 'hover:cursor-not-allowed opacity-50' : 'hover:cursor-pointer' }}"
                :class="selectedTab === 'ingredients' 
                    ? 'bg-secondary-200/30 text-secondary-600 w-full text-left font-semibold px-3 py-2 rounded-lg' 
                    : 'w-full text-left px-3 py-2 text-black/55 rounded hover:text-secondary-600 hover:bg-secondary-200/15'"
                {{ !$isEdit ? 'disabled' : '' }}
            >
                <i class="fad fa-utensils mr-1"></i> Ingredientes
            </button>
        </nav>
    </div>

    <!-- Conteúdo da Aba Selecionada -->
    <main class="flex w-250 p-6 rounded-md bg-white">
        <!-- Aba: Informações Pessoais -->
        <div x-show="selectedTab === 'basic'" 
            x-transition
            class="w-full">

            <div class="flex flex-row justify-between items-center">
                <div>
                    <h1 class="text-xl font-semibold mb-1 text-black/75">Informações Básicas</h1>
                    <p class="text-md text-black/45">Dados relacionados a receita</p>
                </div>
                <i :class="selectedIcon" class="text-primary-500 text-3xl mr-2"></i>
            </div>

            <hr class="border-t-1 border border-primary-300/30 my-4">
            
            <form wire:loading.remove wire:submit.prevent="submitForm">
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
            x-show="selectedTab === 'ingredients'" 
            x-transition
            class="w-full">

            <div class="flex flex-row justify-between items-center">
                <div>
                    <h1 class="text-xl font-semibold mb-1 text-black/75">Ingredientes</h1>
                    <p class="text-md text-black/45">Ingredientes e suas quantidades usadas na receita.</p>
                </div>
                <i :class="selectedIcon" class="text-primary-500 text-3xl mr-2"></i>
            </div>

            <hr class="border-t-1 border border-primary-300/30 my-4">

            <div class="w-full rounded-lg bg-amber-200/40 p-4 my-6 text-amber-400 font-semibold">
                <i class="fad fa-exclamation-triangle text-xl ml-1 mr-2"></i>
                Ingredientes são cadastrados em Gestão/Ingredientes, clique <span class="font-extrabold hover:cursor-pointer">aqui</span> para ser redirecionado.
            </div>  
            
            <form wire:loading.remove wire:submit.prevent="submitFormIngredients">
                <div id="ingredientsContainer">
                    @foreach ($formIngredients as $key => $frmIng)
                        @php 
                            $disabled = isset($frmIng['id']) && $frmIng['id'] != 0;
                            $disabledClasses = $disabled ? 'opacity-50 cursor-not-allowed' : '';
                        @endphp

                        <div class="p-4 bg-primary-300/10 rounded-lg mt-6">
                            <div class="flex flex-row justify-between items-center">
                                <p class="mb-4 text-secondary-500/65 text-lg font-semibold">Ingrediente #{{ $key + 1 }}</p>
                                <button type="button" wire:click="removeIngredient({{ $frmIng['id'] }}, {{ $key }})"
                                    class="p-2 rounded-lg text-red-400 bg-red-300/20 hover:text-white hover:cursor-pointer hover:bg-red-500 transition">
                                    <i class="fad fa-trash-alt text-lg p-1"></i>
                                </button>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-700/60"> 
                                    Ingrediente <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    wire:model.lazy="formIngredients.{{ $key }}.ingredient"
                                    placeholder="Selecione o Ingrediente"
                                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-primary-500/30 focus:border-primary-500/30 {{ $disabledClasses }}"
                                    @if(isset($frmIng['id']) && $frmIng['id'] != 0) disabled @endif
                                >
                                    <option value="">Selecione...</option>
                                    @foreach ($ingredients as $ing)
                                        <option value="{{ $ing['ing_id'] }}">{{ $ing['ing_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex flex-row mt-4">
                                <div class="w-full mr-5">
                                    <label class="block mb-2 text-sm font-medium text-gray-700/60"> 
                                        Quantidade <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        wire:model.lazy="formIngredients.{{ $key }}.quantity"
                                        type="text"
                                        placeholder="Quantidade na Receita"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-primary-500/30 focus:border-primary-500/30"
                                    />
                                </div>
                                <div class="w-2/5">
                                    <label class="block mb-2 text-sm font-medium text-gray-700/60"> 
                                        Unidade de Medida <span class="text-red-500">*</span>
                                    </label>
                                    <select 
                                        wire:model.lazy="formIngredients.{{ $key }}.measurement_unit"
                                        placeholder="Selecione a Unidade de Medida"
                                        class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-primary-500/30 focus:border-primary-500/30"
                                    >
                                        <option value="">Selecione...</option>
                                        @foreach ($measurementUnits as $msu)
                                            <option value="{{ $msu['msu_id'] }}">{{ $msu['msu_name'] }} ({{ $msu['msu_unit'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="flex flex-row justify-end w-full mt-5">
                    <div class="space-x-2">
                        <button 
                                wire:click="addIngredient"
                                type="button" 
                                class="bg-primary-300 text-white p-2 px-4 rounded-lg hover:cursor-pointer">
                            <i class="fad fa-plus-circle p-1"></i>
                            &nbsp;<span class="font-semibold">Adicionar Ingrediente</span>&nbsp;
                        </button>
                    </div>
                </div>

                <hr class="border-t-2 border-dashed border-primary-300/30 my-4">

                <div class="flex flex-row justify-end w-full mt-3">
                    <div class="space-x-2">
                        <button type="submit" class="bg-primary-300 text-white p-2 px-4 rounded-lg hover:cursor-pointer">
                            <i class="fad fa-check-circle p-1"></i>
                            &nbsp;<span class="font-semibold">Salvar Ingredientes</span>&nbsp;
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>