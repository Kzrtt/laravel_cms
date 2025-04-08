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
                <span class="text-gray-400 font-normal">{{ $recipe->rec_preparation }}</span>
            </div>
        @endif
    </x-ts-modal>
</div>
