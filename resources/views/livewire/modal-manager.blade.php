<div>
    <x-ts-modal 
        title="Detalhes da Receita" 
        wire="modalArray.recipeDetailsModal" 
        center
        size="5xl"
    >
        @if($params['recipe']) 
            teste modal receita: {{ $params['recipe']->rec_name }} 
        @endif
    </x-ts-modal>
</div>
