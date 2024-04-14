<?php

namespace App\Livewire;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SearchByWord extends Component
{
    public int $matchCount;
    public string $word = '';
    public string $text = '';
    public string $error;

    public function search(): void
    {
        $this->reset('text', 'error');

        if ($this->word) {
            if ($this->results) {
                $this->matchCount = $this->results->sum('pivot.count');
            } else {
                $this->error = 'Совпадений не найдено';
            }
        } else {
            $this->error = 'Введите слово для поиска';
        }
    }

    /**
     * "Вычисляемое" свойство для сохранения между состояниями
     * (чтобы Livewire не терял некоторые данные из связи при обновлении состояния)
     * @return Collection|null
     */
    #[Computed]
    public function results(): ?Collection
    {
        return Article::searchByWord($this->word);
    }

    public function render()
    {
        return view('livewire.search-by-word');
    }
}
