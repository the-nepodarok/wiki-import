<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ArticleInfo extends Component
{
    public Article $article;

    public float $time;

    public function mount(Article $article, float $time)
    {
        $this->article = $article;
        $this->time = $time;
    }

    public function render()
    {
        return view('livewire.article-info');
    }
}
