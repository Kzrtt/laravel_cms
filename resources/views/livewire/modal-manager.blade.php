<div>
    <x-ts-modal 
        title="Detalhes da Receita" 
        wire="modalArray.recipeDetailsModal" 
        center
        size="xl"
    >
        @if($params['recipe']) 
            @php $recipe = $params['recipe']; @endphp

            <p class="text-primary-300 text-xl mt-0 mb-2">Ingredientes da Receita</p>
            <div class="p-2 rounded max-w">
                <div class="flex flex-col gap-y-2 text-sm">
                    @foreach ($recipe->recipeIngredients as $rei)
                        <div class="flex justify-between font-semibold text-gray-700">
                            <span class="text-secondary-300">{{ $rei->ingredient->ing_name }}</span>
                            <span class="text-gray-600/65 font-normal"> {{ $rei->rei_quantity }}{{ $rei->measurementUnit->msu_unit }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <hr class="border-t-2 border-dashed border-primary-300/30 my-4">

            <p class="text-primary-300 text-xl mt-0 mb-0">Modo de Preparo</p>
            <div class="p-2 rounded max-w">
                <x-markdown>
                    {!! $recipe->rec_preparation !!}
                </x-markdown>
            </div>
        @endif
    </x-ts-modal>

    <x-ts-modal 
        title="Selecione o Estabelecimento" 
        wire="modalArray.selectEstablishmentModal" 
        center
        size="2xl"
    >
        @if($params['selectEstablishmentModal']) 
            @php $establishments = $params['selectEstablishmentModal']['establishments']; @endphp

            <label class="block mb-2 text-sm font-medium text-gray-700/60"> 
                Estabelecimento
            </label>
            <select 
                wire:model.lazy="selectedEstablishment"
                placeholder="Selecione o Estabelecimento"
                class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-primary-500/30 focus:border-primary-500/30"
            >
                <option value="">Selecione...</option>
                @foreach ($establishments as $est)
                    <option value="{{ $est->est_id }}">{{ $est->est_fantasy }}</option>
                @endforeach
            </select>

            <div class="flex flex-row justify-end w-full mt-5">
                <div class="space-x-2">
                    <button 
                        wire:click="redirectTo"
                        type="button" 
                        class="bg-primary-300 text-white p-2 px-4 rounded-lg hover:cursor-pointer">
                        &nbsp;<span class="font-semibold">Avançar</span>&nbsp;
                        <i class="fad fa-arrow-circle-right p-1"></i>
                    </button>
                </div>
            </div>
        @endif
    </x-ts-modal>
</div>
