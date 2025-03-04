<?php 
    use App\Livewire\ScreenRenderer
?>


<div class="flex justify-center w-full">   
    <!-- Caso seja uma Listagem ->>
    @if(isset($_mode) && $_mode == ScreenRenderer::MODE_LIST) 
        <!-- Verificando se existe uma View Customizada ->>
        @if(isset($_customView) && $_customView != null)
            @livewire(
                $_customView,
                ['local' => $_local, 'icon' => $_icon],
            )
        <!-- Renderizando Listagem Dinâmica --> 
        @elseif ($_local != "dashboard")
            @livewire(
                "list-component", 
                ['local' => $_local, 'icon' => $_icon]
            )
        <!-- Renderizando a Dashboard -->
        @else
            @livewire("dashboard")
        @endif
    <!-- Caso seja um Formulário ->>
    @elseif (isset($_mode) && $_mode == ScreenRenderer::MODE_FORM)
        @if(isset($_customView) && $_customView != null)
            @livewire(
                $_customView,
                ['local' => $_local, 'icon' => $_icon],
            )
        <!-- Renderizando Listagem Dinâmica --> 
        @elseif ($_local != "dashboard")
            @livewire(
                "form-component", 
                ['local' => $_local, 'icon' => $_icon]
            )
        <!-- Renderizando a Dashboard -->
        @else
            @livewire("dashboard")
        @endif
    @endif
</div>
