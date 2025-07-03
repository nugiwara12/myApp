<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class DashboardLayout extends Component
{
    public $title;

    public function __construct($title = 'Dashboard')
    {
        $this->title = $title;
    }

    public function render()
    {
        return view('components.dashboard-layout');
    }
}
