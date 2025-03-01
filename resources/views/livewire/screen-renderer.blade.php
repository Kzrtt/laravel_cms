<?php 
    use App\Livewire\ScreenRenderer
?>

<div class="flex justify-center w-full">
    @if($_mode == ScreenRenderer::MODE_LIST) 
        @if ($_local == "dashboard")
            @livewire("dashboard")
        @else
            @livewire(
                "list-component", 
                ['local' => $_local, 'icon' => $_icon]
            )
        @endif
    @elseif ($_mode == ScreenRenderer::MODE_FORM)

    @endif
</div>