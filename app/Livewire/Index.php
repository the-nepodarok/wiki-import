<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    #[Locked]
    public $articles;

    public function render(): View
    {
        return view('livewire.index');
    }
}
