<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Form;

class FormDefault extends Form
{
    #[Validate('required|min:3')]
    public $title = '';

    #[Validate('required|min:3')]
    public $content = '';
}
