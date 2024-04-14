<?php

namespace App\Livewire;

use Livewire\Component;

class Nav extends Component
{
    public function switchTab(string $tab, string $oldTab): void
    {
        $this->dispatch('navigate')->to($tab);
        $this->dispatch('navigate-off')->to($oldTab);
    }

    public function render()
    {
        return view('livewire.nav');
    }
}
