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
    public $icon;

    /**
     * Create a new component instance.
     */
    public function __construct($color, $click, $clickType, $text, $icon = "fad fa-home")
    {   
        $this->color = $color;
        $this->click = $click;
        $this->clickType = $clickType;
        $this->text = $text;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.custom-button');
    }
}
