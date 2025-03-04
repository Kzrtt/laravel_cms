<?php 
    use App\Livewire\ScreenRenderer
?>


<div class="flex justify-center w-full">  
    @if($params['_view'] != "form-component" && $params['_view'] != "list-component")
        @livewire(
            $params['_view'],
            $params,
        )
    @else
        @if ($params['_mode'] != ScreenRenderer::MODE_FORM)
            @livewire(
                'list-component',
                ["data" => $params]
            )
        @else
            @livewire(
                'form-component',
                ["data" => $params]
            )
        @endif 
    @endif
</div>
