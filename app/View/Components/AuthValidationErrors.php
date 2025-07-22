<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class AuthValidationErrors extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct($errors)
    {
        //
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.auth-validation-errors');
    }
}
