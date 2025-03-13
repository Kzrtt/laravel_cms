<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CustomButton extends Component
{
    public $color;
    public $click;
    public $clickType;
    public $text;

    /**
     * Create a new component instance.
     */
    public function __construct($color, $click, $clickType, $text)
    {   
        $this->color = $color;
        $this->click = $click;
        $this->clickType = $clickType;
        $this->text = $text;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.custom-button');
    }
}
