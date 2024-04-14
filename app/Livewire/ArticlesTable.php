<?php

namespace App\Livewire;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class ArticlesTable extends Component
{
    public Collection $entries;

    #[On('update')]
    public function render()
    {
        $this->entries = Article::query()->orderBy('header')->get();
        return view('livewire.articles-table');
    }
}
